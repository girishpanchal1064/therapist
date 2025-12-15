@extends('layouts/contentNavbarLayout')

@section('title', 'Join Session - ' . $appointment->id)

@section('page-style')
<style>
:root {
    --theme-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

/* Page Header */
.page-header {
    background: var(--theme-gradient);
    border-radius: 14px;
    padding: 1.25rem 1.75rem;
    margin-bottom: 1.25rem;
    position: relative;
    overflow: hidden;
}

.page-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 300px;
    height: 300px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}

.page-header::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -10%;
    width: 150px;
    height: 150px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 50%;
}

.page-header h4 {
    color: white;
    font-weight: 700;
    margin-bottom: 0.25rem;
    position: relative;
    z-index: 1;
    font-size: 1.35rem;
}

.page-header p {
    color: rgba(255, 255, 255, 0.85);
    margin-bottom: 0;
    position: relative;
    z-index: 1;
    font-size: 0.875rem;
}

.connection-status {
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    padding: 6px 14px;
    border-radius: 20px;
    color: white;
    font-size: 0.875rem;
    font-weight: 600;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

/* Video Container */
.video-container {
    background: #000;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    position: relative;
    min-height: 600px;
    transition: all 0.3s ease;
}

.video-container.maximized {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    width: 100vw;
    height: 100vh;
    z-index: 9999;
    border-radius: 0;
    min-height: 100vh;
}

.video-content {
    position: relative;
    width: 100%;
    height: 100%;
    min-height: 600px;
}

.video-container.maximized .video-content {
    min-height: 100vh;
}

.video-container.maximized .remote-video {
    min-height: 100vh;
}

.video-header-controls {
    position: absolute;
    top: 20px;
    right: 20px;
    z-index: 100;
    display: flex;
    gap: 10px;
}

.video-control-btn {
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 1.25rem;
}

.video-control-btn:hover {
    background: rgba(0, 0, 0, 0.8);
    border-color: rgba(255, 255, 255, 0.4);
    transform: scale(1.1);
}

.local-video {
    position: absolute;
    bottom: 20px;
    right: 20px;
    width: 240px;
    height: 180px;
    background: #1a1a1a;
    border-radius: 12px;
    overflow: hidden;
    z-index: 10;
    border: 3px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
    transition: all 0.3s ease;
}

.video-container.maximized .local-video {
    width: 320px;
    height: 240px;
    bottom: 30px;
    right: 30px;
}

.local-video video {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.remote-video {
    width: 100%;
    height: 100%;
    min-height: 600px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.waiting-state {
    text-align: center;
    color: white;
    padding: 40px 20px;
}

.waiting-state i {
    font-size: 5rem;
    opacity: 0.7;
    margin-bottom: 20px;
    display: block;
    animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 0.7; transform: scale(1); }
    50% { opacity: 1; transform: scale(1.05); }
}

.waiting-state h4 {
    color: white;
    margin-bottom: 10px;
    font-weight: 600;
    font-size: 1.5rem;
}

.waiting-state p {
    color: rgba(255, 255, 255, 0.8);
    font-size: 1.1rem;
    margin: 0;
}

/* Controls */
.controls-card {
    background: white;
    border-radius: 14px;
    padding: 1.5rem;
    margin-top: 1.25rem;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    border: 1px solid #e5e7eb;
}

.controls-grid {
    display: flex;
    justify-content: center;
    gap: 12px;
    flex-wrap: wrap;
}

.control-btn {
    padding: 12px 24px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 1rem;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
    min-width: 150px;
    justify-content: center;
}

.control-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.control-btn.video-btn {
    background: var(--theme-gradient);
    color: white;
}

.control-btn.video-btn.off {
    background: #6c757d;
}

.control-btn.audio-btn {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
}

.control-btn.audio-btn.off {
    background: #6c757d;
}

.control-btn.end-btn {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
}

/* Info Cards */
.info-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 1.5rem;
    margin-bottom: 1.25rem;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
}

.info-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 1.25rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f0f0f0;
}

.info-header i {
    font-size: 1.5rem;
    color: #667eea;
}

.info-header h6 {
    margin: 0;
    font-weight: 700;
    color: #2d3748;
    font-size: 1.1rem;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f0f0f0;
}

.info-item:last-child {
    border-bottom: none;
}

.info-label {
    color: #718096;
    font-size: 0.9rem;
    font-weight: 600;
}

.info-value {
    color: #2d3748;
    font-weight: 700;
    font-size: 1rem;
}

.timer-display {
    background: var(--theme-gradient);
    color: white;
    padding: 1.25rem;
    border-radius: 12px;
    text-align: center;
    margin-top: 1rem;
}

.timer-display small {
    display: block;
    opacity: 0.95;
    margin-bottom: 8px;
    font-size: 0.875rem;
    font-weight: 600;
}

.timer-display strong {
    font-size: 1.5rem;
    font-weight: 800;
    display: block;
}

.participant-card {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 1.25rem;
    background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
    border-radius: 12px;
    margin-top: 1rem;
}

.participant-avatar {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    font-weight: 700;
    overflow: hidden;
    border: 3px solid white;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.participant-avatar.therapist {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
}

.participant-avatar.client {
    background: var(--theme-gradient);
}

.participant-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.participant-info h6 {
    margin: 0;
    font-weight: 700;
    color: #2d3748;
    font-size: 1rem;
}

.participant-info small {
    color: #718096;
    font-size: 0.875rem;
}

/* Maximized state adjustments */
.video-container.maximized {
    z-index: 9998;
}

@media (max-width: 768px) {
    .local-video {
        width: 160px;
        height: 120px;
        bottom: 15px;
        right: 15px;
    }
    
    .video-container.maximized .local-video {
        width: 200px;
        height: 150px;
    }
    
    .video-header-controls {
        top: 15px;
        right: 15px;
    }
    
    .video-control-btn {
        width: 38px;
        height: 38px;
        font-size: 1.1rem;
    }
    
    .control-btn {
        min-width: 120px;
        padding: 10px 20px;
        font-size: 0.9rem;
    }
    
    .video-container {
        min-height: 500px;
    }
    
    .video-content {
        min-height: 500px;
    }
}
</style>
@endsection

@section('content')

<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4>
                <i class="ri-{{ $appointment->session_mode === 'video' ? 'video' : 'mic' }}-line me-2"></i>
                {{ ucfirst($appointment->session_mode) }} Session
            </h4>
            <p class="mb-0">Session ID: S-{{ $appointment->id }}</p>
        </div>
        <span class="connection-status" id="connectionStatus">Connecting...</span>
    </div>
</div>

<div class="row g-4">
    <!-- Video/Audio Container -->
    <div class="col-lg-8">
        <div class="card shadow-sm p-0">
            <div class="video-container" id="videoContainer">
                <!-- Video Controls -->
                <div class="video-header-controls">
                    <button class="video-control-btn" id="toggleMaximize" title="Maximize Video">
                        <i class="ri-fullscreen-line" id="maximizeIcon"></i>
                    </button>
                </div>
                
                <div class="video-content">
                    <!-- Local Video Preview -->
                    <div class="local-video" id="localVideo">
                        <video id="localVideoElement" autoplay muted></video>
                    </div>

                    <!-- Remote Video Container -->
                    <div id="remoteVideo" class="remote-video">
                        <div class="waiting-state">
                            <i class="ri-{{ $appointment->session_mode === 'video' ? 'video' : 'mic' }}-line"></i>
                            <h4>Waiting to connect...</h4>
                            <p id="waitingMessage">Please wait while we connect you to the session</p>
                            @if(!$canJoin)
                                @php
                                    $timeForDisplay = is_string($appointment->appointment_time)
                                        ? $appointment->appointment_time
                                        : (is_object($appointment->appointment_time)
                                            ? $appointment->appointment_time->format('H:i:s')
                                            : $appointment->appointment_time);

                                    if (strlen($timeForDisplay) > 8 || strpos($timeForDisplay, '-') !== false) {
                                        try {
                                            $parsedTime = \Carbon\Carbon::parse($timeForDisplay, 'Asia/Kolkata');
                                            $timeForDisplay = $parsedTime->format('H:i:s');
                                        } catch (\Exception $e) {
                                            if (preg_match('/(\d{2}:\d{2}:\d{2})/', $timeForDisplay, $matches)) {
                                                $timeForDisplay = $matches[1];
                                            } elseif (preg_match('/(\d{2}:\d{2})/', $timeForDisplay, $matches)) {
                                                $timeForDisplay = $matches[1] . ':00';
                                            }
                                        }
                                    }

                                    if (strlen($timeForDisplay) <= 5) {
                                        $timeForDisplay = $timeForDisplay . ':00';
                                    }

                                    $sessionStartTime = \Carbon\Carbon::parse($appointment->appointment_date->format('Y-m-d') . ' ' . $timeForDisplay, 'Asia/Kolkata')->setTimezone('Asia/Kolkata');
                                @endphp
                                <p class="text-warning mt-3" style="color: #ffc107 !important; font-size: 1rem;">
                                    <i class="ri-time-line"></i> Session will start at {{ $sessionStartTime->format('g:i A') }} IST
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Session Controls -->
        <div class="controls-card">
            <div class="controls-grid">
                <button class="control-btn video-btn" id="toggleVideo" {{ $appointment->session_mode === 'audio' ? 'style=display:none;' : '' }}>
                    <i class="ri-video-line"></i>
                    <span id="videoStatus">Video On</span>
                </button>
                <button class="control-btn audio-btn" id="toggleAudio">
                    <i class="ri-mic-line"></i>
                    <span id="audioStatus">Audio On</span>
                </button>
                <button class="control-btn end-btn" id="endSession">
                    <i class="ri-phone-line"></i>
                    End Session
                </button>
            </div>
        </div>
    </div>

    <!-- Session Info Sidebar -->
    <div class="col-lg-4">
        <!-- Session Information Card -->
        <div class="info-card">
            <div class="info-header">
                <i class="ri-information-line"></i>
                <h6>Session Information</h6>
            </div>
            <div class="info-item">
                <span class="info-label">Session ID</span>
                <span class="info-value">S-{{ $appointment->id }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Date</span>
                <span class="info-value">{{ $appointment->appointment_date->format('M d, Y') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Time</span>
                <span class="info-value">
                    @php
                        $startTime = \Carbon\Carbon::parse($appointment->appointment_time, 'Asia/Kolkata')->setTimezone('Asia/Kolkata');
                        $endTime = $startTime->copy()->addMinutes($appointment->duration_minutes ?? 60);
                    @endphp
                    {{ $startTime->format('g:i A') }} - {{ $endTime->format('g:i A') }} IST
                </span>
            </div>
            <div class="info-item">
                <span class="info-label">Duration</span>
                <span class="info-value">{{ $appointment->duration_minutes ?? 60 }} minutes</span>
            </div>
            <div class="info-item">
                <span class="info-label">Mode</span>
                <span class="badge bg-primary">{{ strtoupper($appointment->session_mode) }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Your Role</span>
                <span class="badge bg-{{ $role === 'therapist' ? 'success' : 'info' }}">
                    {{ ucfirst($role) }}
                </span>
            </div>

            <!-- Timer Display -->
            <div class="timer-display" id="sessionTimer">
                <small>Session Time Remaining</small>
                <strong id="timeRemaining">Calculating...</strong>
            </div>
        </div>

        <!-- Participant Info Card -->
        <div class="info-card">
            <div class="info-header">
                <i class="ri-user-line"></i>
                <h6>Participants</h6>
            </div>
            @if($role === 'client')
                <div class="participant-card">
                    <div class="participant-avatar therapist">
                        @if($appointment->therapist && $appointment->therapist->therapistProfile && $appointment->therapist->therapistProfile->profile_image)
                            <img src="{{ asset('storage/' . $appointment->therapist->therapistProfile->profile_image) }}"
                                 alt="{{ $appointment->therapist->name }}">
                        @elseif($appointment->therapist && $appointment->therapist->avatar)
                            <img src="{{ asset('storage/' . $appointment->therapist->avatar) }}"
                                 alt="{{ $appointment->therapist->name }}">
                        @else
                            <i class="ri-user-line"></i>
                        @endif
                    </div>
                    <div class="participant-info">
                        <h6>Therapist</h6>
                        <small>{{ $appointment->therapist->name ?? 'N/A' }}</small>
                    </div>
                </div>
            @else
                <div class="participant-card">
                    <div class="participant-avatar client">
                        @if($appointment->client && $appointment->client->avatar)
                            <img src="{{ asset('storage/' . $appointment->client->avatar) }}"
                                 alt="{{ $appointment->client->name }}">
                        @else
                            <i class="ri-user-line"></i>
                        @endif
                    </div>
                    <div class="participant-info">
                        <h6>Client</h6>
                        <small>{{ $appointment->client->name ?? 'N/A' }}</small>
                    </div>
                </div>
            @endif
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
    let token = @json($token);
    let roomName = @json($roomName);
    const canJoin = @json($canJoin);
    let isMaximized = false;
    
    // Maximize/Minimize Video Toggle
    const toggleMaximizeBtn = document.getElementById('toggleMaximize');
    const videoContainer = document.getElementById('videoContainer');
    const maximizeIcon = document.getElementById('maximizeIcon');
    
    if (toggleMaximizeBtn) {
        toggleMaximizeBtn.addEventListener('click', function() {
            isMaximized = !isMaximized;
            const sidebar = document.querySelector('.col-lg-4');
            const controls = document.querySelector('.controls-card');
            const pageHeader = document.querySelector('.page-header');
            
            if (isMaximized) {
                videoContainer.classList.add('maximized');
                maximizeIcon.className = 'ri-fullscreen-exit-line';
                toggleMaximizeBtn.title = 'Minimize Video';
                // Hide sidebar and page header when maximized
                if (sidebar) sidebar.style.display = 'none';
                if (pageHeader) pageHeader.style.display = 'none';
                // Make controls float at bottom
                if (controls) {
                    controls.style.position = 'fixed';
                    controls.style.bottom = '30px';
                    controls.style.left = '50%';
                    controls.style.transform = 'translateX(-50%)';
                    controls.style.zIndex = '10000';
                    controls.style.background = 'rgba(255, 255, 255, 0.95)';
                    controls.style.backdropFilter = 'blur(10px)';
                    controls.style.boxShadow = '0 8px 32px rgba(0, 0, 0, 0.3)';
                }
            } else {
                videoContainer.classList.remove('maximized');
                maximizeIcon.className = 'ri-fullscreen-line';
                toggleMaximizeBtn.title = 'Maximize Video';
                // Show sidebar and page header when minimized
                if (sidebar) sidebar.style.display = 'block';
                if (pageHeader) pageHeader.style.display = 'block';
                // Reset controls to normal position
                if (controls) {
                    controls.style.position = '';
                    controls.style.bottom = '';
                    controls.style.left = '';
                    controls.style.transform = '';
                    controls.style.zIndex = '';
                    controls.style.background = '';
                    controls.style.backdropFilter = '';
                    controls.style.boxShadow = '';
                }
            }
        });
    }
    
    // Exit fullscreen on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && isMaximized) {
            toggleMaximizeBtn.click();
        }
    });

    // Session duration and auto-disconnect
    const sessionDuration = {{ $appointment->duration_minutes ?? 60 }}; // minutes
    @php
      // Calculate session end time
      $timeString = is_string($appointment->appointment_time)
          ? $appointment->appointment_time
          : (is_object($appointment->appointment_time)
              ? $appointment->appointment_time->format('H:i:s')
              : $appointment->appointment_time);
      // Extract just time if it's a full datetime string (contains date part)
      if (strlen($timeString) > 8 || strpos($timeString, '-') !== false) {
          // If it contains a date (has dashes or is longer than time format), extract just time
          try {
              $parsedTime = \Carbon\Carbon::parse($timeString, 'Asia/Kolkata');
              $timeString = $parsedTime->format('H:i:s');
          } catch (\Exception $e) {
              // If parsing fails, try to extract time manually
              if (preg_match('/(\d{2}:\d{2}:\d{2})/', $timeString, $matches)) {
                  $timeString = $matches[1];
              } elseif (preg_match('/(\d{2}:\d{2})/', $timeString, $matches)) {
                  $timeString = $matches[1] . ':00';
              }
          }
      }

      // Ensure we have a valid time string (HH:MM:SS format)
      if (strlen($timeString) <= 5) {
          $timeString = $timeString . ':00'; // Add seconds if missing
      }

      $sessionStart = \Carbon\Carbon::parse($appointment->appointment_date->format('Y-m-d') . ' ' . $timeString, 'Asia/Kolkata')->setTimezone('Asia/Kolkata');
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
        console.log('Token exists, attempting to connect...');
        console.log('Room name:', roomName);
        connectToRoom();
        startSessionTimer();
    } else if (canJoin && !token) {
        // Token is missing
        updateConnectionStatus('Error', 'Access token missing');
        const waitingMsg = document.getElementById('waitingMessage');
        if (waitingMsg) {
            waitingMsg.innerHTML = '<span style="color: #ef4444;">⚠️ Error: Access token is missing. Please check Twilio API keys configuration.</span>';
        }
        console.error('Token is null or empty. Check server logs for Twilio API key errors.');
    } else if (!canJoin) {
        // Show countdown or waiting message
        @php
            // Extract time for JavaScript countdown
            $jsCountdownTime = is_string($appointment->appointment_time)
                ? $appointment->appointment_time
                : (is_object($appointment->appointment_time)
                    ? $appointment->appointment_time->format('H:i:s')
                    : $appointment->appointment_time);

            // If it contains a date, extract just time
            if (strlen($jsCountdownTime) > 8 || strpos($jsCountdownTime, '-') !== false) {
                try {
                    $parsedJsCountdownTime = \Carbon\Carbon::parse($jsCountdownTime, 'Asia/Kolkata');
                    $jsCountdownTime = $parsedJsCountdownTime->format('H:i:s');
                } catch (\Exception $e) {
                    if (preg_match('/(\d{2}:\d{2}:\d{2})/', $jsCountdownTime, $matches)) {
                        $jsCountdownTime = $matches[1];
                    } elseif (preg_match('/(\d{2}:\d{2})/', $jsCountdownTime, $matches)) {
                        $jsCountdownTime = $matches[1] . ':00';
                    }
                }
            }

            if (strlen($jsCountdownTime) <= 5) {
                $jsCountdownTime = $jsCountdownTime . ':00';
            }
        @endphp
        const appointmentTime = new Date('{{ $appointment->appointment_date->format("Y-m-d") }} {{ $jsCountdownTime }}');
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
                    timeRemainingEl.style.color = '#ef4444';
                    timeRemainingEl.textContent = `${seconds} seconds remaining`;
                } else {
                    timeRemainingEl.style.color = 'white';
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

            // Connect to room with timeout
            updateConnectionStatus('Connecting...', 'Connecting to session room...');

            const connectPromise = Twilio.Video.connect(token, {
                name: roomName,
                tracks: tracks,
            });

            // Add timeout for connection (30 seconds)
            const connectTimeoutPromise = new Promise((_, reject) =>
                setTimeout(() => reject(new Error('Connection timeout. Please check your internet connection and try again.')), 30000)
            );

            room = await Promise.race([connectPromise, connectTimeoutPromise]);

            console.log('Connected to room:', room.name);
            updateConnectionStatus('Connected', 'Successfully connected to session');

            // Handle remote participants
            room.on('participantConnected', participant => {
                console.log('Participant connected:', participant.identity);
                updateConnectionStatus('Participant Joined', 'Other participant has joined');
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
            console.error('Error details:', {
                name: error.name,
                message: error.message,
                code: error.code,
                token: token ? 'Token exists (' + token.substring(0, 20) + '...)' : 'Token is null/empty',
                roomName: roomName
            });

            updateConnectionStatus('Connection Failed', 'Failed to connect');
            const waitingMsg = document.getElementById('waitingMessage');

            let errorMessage = 'Failed to connect to session. ';
            if (error.message) {
                errorMessage += error.message;
            } else if (error.code) {
                errorMessage += 'Error code: ' + error.code;
            } else {
                errorMessage += 'Please check your internet connection and try again.';
            }

            if (waitingMsg) {
                waitingMsg.innerHTML = '<span style="color: #ef4444; font-size: 1.1rem;">⚠️ ' + errorMessage + '</span>';
            }

            // Show alert only for critical errors
            if (error.message && !error.message.includes('Permission') && !error.message.includes('timeout')) {
                alert(errorMessage);
            }
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

    // Update connection status
    function updateConnectionStatus(status, message) {
        const statusEl = document.getElementById('connectionStatus');
        const waitingMsg = document.getElementById('waitingMessage');
        if (statusEl) {
            statusEl.textContent = status;
        }
        if (waitingMsg && message) {
            waitingMsg.textContent = message;
        }
    }

    // Toggle Video
    if (toggleVideoBtn) {
        toggleVideoBtn.addEventListener('click', function() {
            if (localVideoTrack) {
                videoEnabled = !videoEnabled;
                localVideoTrack.enable(videoEnabled);
                const statusSpan = this.querySelector('#videoStatus');
                if (statusSpan) {
                    statusSpan.textContent = videoEnabled ? 'Video On' : 'Video Off';
                }
                const icon = this.querySelector('i');
                if (icon) {
                    icon.className = videoEnabled ? 'ri-video-line' : 'ri-video-off-line';
                }
                this.classList.toggle('off', !videoEnabled);
            }
        });
    }

    // Toggle Audio
    toggleAudioBtn.addEventListener('click', function() {
        if (localAudioTrack) {
            audioEnabled = !audioEnabled;
            localAudioTrack.enable(audioEnabled);
            const statusSpan = this.querySelector('#audioStatus');
            if (statusSpan) {
                statusSpan.textContent = audioEnabled ? 'Audio On' : 'Audio Off';
            }
            const icon = this.querySelector('i');
            if (icon) {
                icon.className = audioEnabled ? 'ri-mic-line' : 'ri-mic-off-line';
            }
            this.classList.toggle('off', !audioEnabled);
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
                    // Fetch token via AJAX instead of reloading page
                    fetchTokenAndConnect();
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

    // Fetch token via AJAX and connect to room
    async function fetchTokenAndConnect() {
        try {
            const timeRemainingEl = document.getElementById('timeRemaining');
            if (timeRemainingEl) {
                timeRemainingEl.textContent = 'Connecting...';
            }

            const response = await fetch('{{ route("sessions.token", $appointment->id) }}', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error('Failed to fetch token');
            }

            const data = await response.json();

            // Update token and roomName
            token = data.token;
            roomName = data.roomName;

            // Now connect to room
            connectToRoom();
            startSessionTimer();
        } catch (error) {
            console.error('Error fetching token:', error);
            updateConnectionStatus('Error', 'Failed to fetch token');
            const timeRemainingEl = document.getElementById('timeRemaining');
            const waitingMsg = document.getElementById('waitingMessage');
            if (timeRemainingEl) {
                timeRemainingEl.textContent = 'Error: Failed to fetch token';
            }
            if (waitingMsg) {
                waitingMsg.innerHTML = '<span style="color: #ef4444;">⚠️ Error fetching access token. Please check your internet connection and try refreshing manually if needed.</span>';
            }
            // Don't auto-reload - let user decide when to refresh
            // User can manually refresh if needed
        }
    }

    // Cleanup on page unload
    window.addEventListener('beforeunload', cleanup);
});
</script>

@endsection
