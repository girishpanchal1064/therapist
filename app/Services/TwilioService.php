<?php

namespace App\Services;

use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;
use Twilio\Jwt\Grants\VoiceGrant;
use Twilio\Rest\Client;
use Twilio\Http\CurlClient;
use Illuminate\Support\Facades\Log;

class TwilioService
{
    protected $accountSid;
    protected $authToken;
    protected $apiKeySid;
    protected $apiKeySecret;
    protected $client;

    public function __construct()
    {
        $this->accountSid = config('twilio.account_sid');
        $this->authToken = config('twilio.auth_token');
        $this->apiKeySid = config('twilio.api_key_sid');
        $this->apiKeySecret = config('twilio.api_key_secret');

        if ($this->accountSid && $this->authToken) {
            try {
                // For local dev without a trusted CA bundle, disable SSL verification.
                // Do NOT use this in production; configure proper CA certificates instead.
                $httpClient = new CurlClient([
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                ]);

                $this->client = new Client($this->accountSid, $this->authToken, null, null, $httpClient);
            } catch (\Exception $e) {
                Log::error('Error initializing Twilio client: ' . $e->getMessage());
            }
        }
    }

    /**
     * Generate access token for Twilio Video
     *
     * @param string $identity User identity (user ID or name)
     * @param string $roomName Room name (usually appointment ID)
     * @return string Access token
     */
    public function generateVideoToken($identity, $roomName)
    {
        try {
            // Create access token
            $token = new AccessToken(
                $this->accountSid,
                $this->apiKeySid,
                $this->apiKeySecret,
                3600, // Token expires in 1 hour
                $identity
            );

            // Grant video access
            $videoGrant = new VideoGrant();
            $videoGrant->setRoom($roomName);
            $token->addGrant($videoGrant);

            return $token->toJWT();
        } catch (\Exception $e) {
            Log::error('Error generating Twilio video token: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Generate access token for Twilio Voice (audio calls)
     *
     * @param string $identity User identity
     * @param string $roomName Room name
     * @return string Access token
     */
    public function generateVoiceToken($identity, $roomName)
    {
        try {
            $token = new AccessToken(
                $this->accountSid,
                $this->apiKeySid,
                $this->apiKeySecret,
                3600,
                $identity
            );

            // Grant voice access
            $voiceGrant = new VoiceGrant();
            $token->addGrant($voiceGrant);

            // Also grant video access for audio-only rooms (Twilio uses video for audio)
            $videoGrant = new VideoGrant();
            $videoGrant->setRoom($roomName);
            $token->addGrant($videoGrant);

            return $token->toJWT();
        } catch (\Exception $e) {
            Log::error('Error generating Twilio voice token: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Create a Twilio Video room
     *
     * @param string $roomName Unique room name
     * @param array $options Room options
     * @return \Twilio\Rest\Video\V1\RoomInstance
     */
    public function createRoom($roomName, $options = [])
    {
        try {
            $defaultOptions = [
                'uniqueName' => $roomName,
                'type' => config('twilio.video.room_type', 'group'),
                'maxParticipants' => config('twilio.video.max_participants', 2),
                'recordParticipantsOnConnect' => config('twilio.video.enable_recording', false),
            ];
            $roomOptions = array_merge($defaultOptions, $options);
            $room = $this->client->video->v1->rooms->create($roomOptions);

            return $room;
        } catch (\Exception $e) {
            // Room might already exist, try to fetch it
            if (strpos($e->getMessage(), 'already exists') !== false) {
                return $this->getRoom($roomName);
            }
            Log::error('Error creating Twilio room: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get an existing Twilio Video room
     *
     * @param string $roomName Room name
     * @return \Twilio\Rest\Video\V1\RoomInstance|null
     */
    public function getRoom($roomName)
    {
        try {
            $rooms = $this->client->video->v1->rooms->read([
                'uniqueName' => $roomName
            ], 1);

            return $rooms[0] ?? null;
        } catch (\Exception $e) {
            Log::error('Error fetching Twilio room: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Complete a room (end the session)
     *
     * @param string $roomName Room name
     * @return bool
     */
    public function completeRoom($roomName)
    {
        try {
            $room = $this->getRoom($roomName);
            if ($room && $room->status !== 'completed') {
                $this->client->video->v1->rooms($room->sid)->update('completed');
                return true;
            }
            return false;
        } catch (\Exception $e) {
            Log::error('Error completing Twilio room: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Generate room name from appointment
     *
     * @param int $appointmentId Appointment ID
     * @return string
     */
    public function generateRoomName($appointmentId)
    {
        return 'appointment-' . $appointmentId;
    }
}
