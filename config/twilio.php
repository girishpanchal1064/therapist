<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Twilio Account SID
    |--------------------------------------------------------------------------
    |
    | Your Twilio Account SID. You can find this in your Twilio Console.
    |
    */
    'account_sid' => env('TWILIO_ACCOUNT_SID', 'ACb555a00de306594fd2107f6058a0df12'),

    /*
    |--------------------------------------------------------------------------
    | Twilio Auth Token
    |--------------------------------------------------------------------------
    |
    | Your Twilio Auth Token. You can find this in your Twilio Console.
    |
    */
    'auth_token' => env('TWILIO_AUTH_TOKEN', 'ff55d5dd6ba063ad46185248a6c5e232'),

    /*
    |--------------------------------------------------------------------------
    | Twilio API Key SID
    |--------------------------------------------------------------------------
    |
    | Your Twilio API Key SID for Video. Create one in Twilio Console > Video > API Keys.
    |
    */
    'api_key_sid' => env('TWILIO_API_KEY_SID', ''),

    /*
    |--------------------------------------------------------------------------
    | Twilio API Key Secret
    |--------------------------------------------------------------------------
    |
    | Your Twilio API Key Secret for Video. This is shown only once when you create the key.
    |
    */
    'api_key_secret' => env('TWILIO_API_KEY_SECRET', ''),

    /*
    |--------------------------------------------------------------------------
    | Twilio Video Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Twilio Video rooms and participants.
    |
    */
    'video' => [
        'room_type' => 'group', // 'go' for peer-to-peer, 'group' for group rooms, 'group-small' for small group rooms
        'max_participants' => 2, // Maximum participants in a room
        'enable_recording' => env('TWILIO_ENABLE_RECORDING', false),
    ],
];
