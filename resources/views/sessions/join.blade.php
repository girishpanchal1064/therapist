@extends('layouts.app')

@section('title', 'Join Session - ' . $appointment->id)

@section('content')
<div class="min-h-screen bg-gray-100">
    <div class="container-fluid py-4">
        <div class="row">
            <!-- Video/Audio Container -->
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="ri-{{ $appointment->session_mode === 'video' ? 'video' : 'mic' }}-line me-2"></i>
                            {{ ucfirst($appointment->session_mode) }} Session
                        </h5>
                    </div>
                    <div class="card-body p-0" style="background: #000; min-height: 500px; position: relative;">
                        <!-- Local Video -->
                        <div id="localVideo" style="position: absolute; bottom: 20px; right: 20px; width: 200px; height: 150px; background: #1a1a1a; border-radius: 8px; overflow: hidden; z-index: 10;">
                            <video id="localVideoElement" autoplay muted style="width: 100%; height: 100%; object-fit: cover;"></video>
                        </div>

                        <!-- Remote Video -->
                        <div id="remoteVideo" class="d-flex align-items-center justify-content-center" style="min-height: 500px;">
                            <div class="text-center text-white">
                                <i class="ri-{{ $appointment->session_mode === 'video' ? 'video' : 'mic' }}-line" style="font-size: 4rem;"></i>
                                <p class="mt-3">Waiting to connect...</p>
                                @if(!$canJoin)
                                    <p class="text-warning">Session will start at {{ \Carbon\Carbon::parse($appointment->appointment_date->format('Y-m-d') . ' ' . $appointment->appointment_time)->format('g:i A') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Session Controls -->
                <div class="card shadow-sm mt-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                            <button class="btn btn-primary btn-lg" id="toggleVideo" {{ $appointment->session_mode === 'audio' ? 'style=display:none;' : '' }}>
                                <i class="ri-video-line me-2"></i>
                                <span id="videoStatus">Video On</span>
                            </button>
                            <button class="btn btn-primary btn-lg" id="toggleAudio">
                                <i class="ri-mic-line me-2"></i>
                                <span id="audioStatus">Audio On</span>
                            </button>
                            <button class="btn btn-danger btn-lg" id="endSession">
                                <i class="ri-phone-line me-2"></i>End Session
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Session Info Sidebar -->
            <div class="col-lg-4">
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-white">
                        <h6 class="mb-0"><i class="ri-information-line me-2"></i>Session Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted d-block">Session ID</small>
                            <strong>S-{{ $appointment->id }}</strong>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">Date</small>
                            <strong>{{ $appointment->appointment_date->format('M d, Y') }}</strong>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">Time</small>
                            <strong>
                                @php
                                    $startTime = \Carbon\Carbon::parse($appointment->appointment_time);
                                    $endTime = $startTime->copy()->addMinutes($appointment->duration_minutes ?? 60);
                                @endphp
                                {{ $startTime->format('g:i A') }} - {{ $endTime->format('g:i A') }}
                            </strong>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">Duration</small>
                            <strong>{{ $appointment->duration_minutes ?? 60 }} minutes</strong>
                        </div>
                        <div class="mb-3" id="sessionTimer">
                            <small class="text-muted d-block">Session Time Remaining</small>
                            <strong id="timeRemaining" class="text-primary">Calculating...</strong>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">Mode</small>
                            <span class="badge bg-primary">{{ strtoupper($appointment->session_mode) }}</span>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">Your Role</small>
                            <span class="badge bg-{{ $role === 'therapist' ? 'success' : 'info' }}">
                                {{ ucfirst($role) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Participant Info -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h6 class="mb-0"><i class="ri-user-line me-2"></i>Participants</h6>
                    </div>
                    <div class="card-body">
                        @if($role === 'client')
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar-sm bg-success rounded-circle d-flex align-items-center justify-content-center me-2">
                                    <i class="ri-user-line text-white"></i>
                                </div>
                                <div>
                                    <strong>Therapist</strong>
                                    <br>
                                    <small class="text-muted">{{ $appointment->therapist->name ?? 'N/A' }}</small>
                                </div>
                            </div>
                        @else
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar-sm bg-info rounded-circle d-flex align-items-center justify-content-center me-2">
                                    <i class="ri-user-line text-white"></i>
                                </div>
                                <div>
                                    <strong>Client</strong>
                                    <br>
                                    <small class="text-muted">{{ $appointment->client->name ?? 'N/A' }}</small>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Twilio Video SDK -->
<script src="https://sdk.twilio.com/js/video/releases/2.26.0/twilio-video.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let room = null;
    let localVideoTrack = null;
    let localAudioTrack = null;
    let videoEnabled = true;
    let audioEnabled = true;
    const token = @json($token);
    const roomName = @json($roomName);
    const canJoin = @json($canJoin);
    
    // Session duration and auto-disconnect
    const sessionDuration = {{ $appointment->duration_minutes ?? 60 }}; // minutes
    @php
      // Calculate session end time
      $timeString = is_string($appointment->appointment_time) 
          ? $appointment->appointment_time 
          : (is_object($appointment->appointment_time) 
              ? $appointment->appointment_time->format('H:i:s') 
              : $appointment->appointment_time);
      if (strlen($timeString) > 8) {
          $timeString = \Carbon\Carbon::parse($timeString)->format('H:i:s');
      }
      $sessionStart = \Carbon\Carbon::parse($appointment->appointment_date->format('Y-m-d') . ' ' . $timeString);
      $sessionEnd = $sessionStart->copy()->addMinutes($appointment->duration_minutes ?? 60);
    @endphp
    const sessionStartTime = new Date('{{ $sessionStart->format("Y-m-d H:i:s") }}');
    const sessionEndTime = new Date('{{ $sessionEnd->format("Y-m-d H:i:s") }}');
    let sessionTimer = null;
    let disconnectTimer = null;

    const localVideoElement = document.getElementById('localVideoElement');
    const remoteVideoDiv = document.getElementById('remoteVideo');
    const toggleVideoBtn = document.getElementById('toggleVideo');
    const toggleAudioBtn = document.getElementById('toggleAudio');
    const endSessionBtn = document.getElementById('endSession');

    // Join room when page loads (if session time has arrived)
    if (canJoin && token) {
        connectToRoom();
        startSessionTimer();
    } else if (!canJoin) {
        // Show countdown or waiting message
        const appointmentTime = new Date('{{ $appointment->appointment_date->format("Y-m-d") }} {{ \Carbon\Carbon::parse($appointment->appointment_time)->format("H:i:s") }}');
        updateCountdown(appointmentTime);
    }
    
    // Start session timer and auto-disconnect
    function startSessionTimer() {
        // Update timer every second
        sessionTimer = setInterval(() => {
            const now = new Date();
            const remaining = sessionEndTime - now;
            
            if (remaining <= 0) {
                // Session time expired - auto disconnect
                clearInterval(sessionTimer);
                autoDisconnect('Session duration has ended. The session will now close.');
                return;
            }
            
            // Calculate remaining time
            const minutes = Math.floor(remaining / 60000);
            const seconds = Math.floor((remaining % 60000) / 1000);
            
            // Update display
            const timeRemainingEl = document.getElementById('timeRemaining');
            if (timeRemainingEl) {
                if (minutes < 1) {
                    timeRemainingEl.className = 'text-danger';
                    timeRemainingEl.textContent = `${seconds} seconds remaining`;
                } else {
                    timeRemainingEl.className = 'text-primary';
                    timeRemainingEl.textContent = `${minutes}:${String(seconds).padStart(2, '0')} remaining`;
                }
            }
        }, 1000);
    }
    
    // Auto disconnect function
    function autoDisconnect(message) {
        if (message) {
            alert(message);
        }
        
        // Disconnect from Twilio room
        cleanup();
        
        // Notify server
        fetch('{{ route("sessions.end", $appointment->id) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(() => {
            // Redirect to dashboard
            window.location.href = '{{ $role === "therapist" ? route("therapist.dashboard") : route("client.dashboard") }}';
        })
        .catch(error => {
            console.error('Error ending session:', error);
            // Redirect anyway
            window.location.href = '{{ $role === "therapist" ? route("therapist.dashboard") : route("client.dashboard") }}';
        });
    }

    async function connectToRoom() {
        try {
            // Get user media
            const tracks = await Twilio.Video.createLocalTracks({
                audio: true,
                video: {{ $appointment->session_mode === 'video' ? 'true' : 'false' }}
            });

            // Attach local video track
            tracks.forEach(track => {
                if (track.kind === 'video') {
                    localVideoTrack = track;
                    track.attach(localVideoElement);
                } else if (track.kind === 'audio') {
                    localAudioTrack = track;
                }
            });

            // Connect to room
            room = await Twilio.Video.connect(token, {
                name: roomName,
                tracks: tracks,
            });

            console.log('Connected to room:', room.name);

            // Handle remote participants
            room.on('participantConnected', participant => {
                console.log('Participant connected:', participant.identity);
                handleParticipant(participant);
            });

            // Handle existing participants
            room.participants.forEach(participant => {
                handleParticipant(participant);
            });

            // Handle participant disconnected
            room.on('participantDisconnected', participant => {
                console.log('Participant disconnected:', participant.identity);
                removeParticipant(participant);
            });

            // Handle room disconnect
            room.on('disconnected', () => {
                console.log('Disconnected from room');
                cleanup();
            });

        } catch (error) {
            console.error('Error connecting to room:', error);
            alert('Failed to connect to session. Please try again.');
        }
    }

    function handleParticipant(participant) {
        const participantDiv = document.createElement('div');
        participantDiv.id = participant.sid;
        participantDiv.style.cssText = 'width: 100%; height: 100%; position: absolute; top: 0; left: 0;';

        remoteVideoDiv.innerHTML = '';
        remoteVideoDiv.appendChild(participantDiv);

        participant.tracks.forEach(publication => {
            if (publication.isSubscribed) {
                attachTrack(publication.track, participantDiv);
            }
        });

        participant.on('trackSubscribed', track => {
            attachTrack(track, participantDiv);
        });

        participant.on('trackUnsubscribed', track => {
            track.detach();
        });
    }

    function attachTrack(track, container) {
        if (track.kind === 'video') {
            const videoElement = document.createElement('video');
            videoElement.autoplay = true;
            videoElement.playsInline = true;
            videoElement.style.cssText = 'width: 100%; height: 100%; object-fit: cover;';
            track.attach(videoElement);
            container.appendChild(videoElement);
        } else if (track.kind === 'audio') {
            const audioElement = document.createElement('audio');
            audioElement.autoplay = true;
            track.attach(audioElement);
            container.appendChild(audioElement);
        }
    }

    function removeParticipant(participant) {
        const participantDiv = document.getElementById(participant.sid);
        if (participantDiv) {
            participantDiv.remove();
        }
        remoteVideoDiv.innerHTML = '<div class="text-center text-white"><i class="ri-user-unfollow-line" style="font-size: 4rem;"></i><p class="mt-3">Participant left</p></div>';
    }

    function cleanup() {
        // Clear timers
        if (sessionTimer) {
            clearInterval(sessionTimer);
        }
        if (disconnectTimer) {
            clearTimeout(disconnectTimer);
        }
        
        // Stop tracks
        if (localVideoTrack) {
            localVideoTrack.stop();
            localVideoTrack.detach();
        }
        if (localAudioTrack) {
            localAudioTrack.stop();
        }
        if (room) {
            room.disconnect();
        }
    }

    // Toggle Video
    if (toggleVideoBtn) {
        toggleVideoBtn.addEventListener('click', function() {
            if (localVideoTrack) {
                videoEnabled = !videoEnabled;
                localVideoTrack.enable(videoEnabled);
                this.innerHTML = videoEnabled 
                    ? '<i class="ri-video-line me-2"></i><span id="videoStatus">Video On</span>' 
                    : '<i class="ri-video-off-line me-2"></i><span id="videoStatus">Video Off</span>';
                this.classList.toggle('btn-outline-primary', !videoEnabled);
                this.classList.toggle('btn-primary', videoEnabled);
            }
        });
    }

    // Toggle Audio
    toggleAudioBtn.addEventListener('click', function() {
        if (localAudioTrack) {
            audioEnabled = !audioEnabled;
            localAudioTrack.enable(audioEnabled);
            this.innerHTML = audioEnabled 
                ? '<i class="ri-mic-line me-2"></i><span id="audioStatus">Audio On</span>' 
                : '<i class="ri-mic-off-line me-2"></i><span id="audioStatus">Audio Off</span>';
            this.classList.toggle('btn-outline-primary', !audioEnabled);
            this.classList.toggle('btn-primary', audioEnabled);
        }
    });

    // End Session
    endSessionBtn.addEventListener('click', function() {
        if (confirm('Are you sure you want to end this session?')) {
            fetch('{{ route("sessions.end", $appointment->id) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(() => {
                cleanup();
                window.location.href = '{{ $role === "therapist" ? route("therapist.dashboard") : route("client.dashboard") }}';
            })
            .catch(error => {
                console.error('Error ending session:', error);
                cleanup();
                window.location.href = '{{ $role === "therapist" ? route("therapist.dashboard") : route("client.dashboard") }}';
            });
        }
    });

    // Countdown timer
    function updateCountdown(appointmentTime) {
        const interval = setInterval(() => {
            const now = new Date();
            const diff = appointmentTime - now;

            if (diff <= 0) {
                clearInterval(interval);
                if (token) {
                    connectToRoom();
                    startSessionTimer();
                } else {
                    // Refresh to get new token
                    location.reload();
                }
            } else {
                const minutes = Math.floor(diff / 60000);
                const seconds = Math.floor((diff % 60000) / 1000);
                // Display countdown
                const timeRemainingEl = document.getElementById('timeRemaining');
                if (timeRemainingEl) {
                    timeRemainingEl.textContent = `Starts in ${minutes}:${String(seconds).padStart(2, '0')}`;
                }
            }
        }, 1000);
    }

    // Cleanup on page unload
    window.addEventListener('beforeunload', cleanup);
});
</script>

<style>
.avatar-sm {
    width: 40px;
    height: 40px;
}
</style>
@endsection
