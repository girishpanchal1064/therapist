@extends('layouts.app')

@section('title', 'Chat - TalkToAngel Clone')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('chat.index') }}" class="mr-4">
                        <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    @if($conversation->appointment)
                        <img src="{{ $conversation->appointment->therapist->avatar }}" 
                             alt="{{ $conversation->appointment->therapist->name }}" 
                             class="h-10 w-10 rounded-full object-cover">
                        <div class="ml-3">
                            <h1 class="text-lg font-medium text-gray-900">{{ $conversation->appointment->therapist->name }}</h1>
                            <p class="text-sm text-gray-500">{{ $conversation->appointment->therapist->therapistProfile->qualification ?? 'Therapist' }}</p>
                        </div>
                    @else
                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                            <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h1 class="text-lg font-medium text-gray-900">Group Chat</h1>
                            <p class="text-sm text-gray-500">{{ $conversation->participants->count() }} participants</p>
                        </div>
                    @endif
                </div>
                <div class="flex items-center space-x-4">
                    @if($conversation->appointment)
                        <a href="{{ route('therapists.show', $conversation->appointment->therapist->id) }}" 
                           class="text-sm text-primary-600 hover:text-primary-500">View Profile</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg h-96 flex flex-col">
            <!-- Messages Area -->
            <div id="messagesContainer" class="flex-1 overflow-y-auto p-6 space-y-4">
                @foreach($conversation->messages as $message)
                    <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                        <div class="flex {{ $message->sender_id === auth()->id() ? 'flex-row-reverse' : 'flex-row' }} items-end space-x-2 max-w-xs lg:max-w-md">
                            <img src="{{ $message->sender->avatar }}" 
                                 alt="{{ $message->sender->name }}" 
                                 class="h-8 w-8 rounded-full object-cover flex-shrink-0">
                            <div class="chat-message {{ $message->sender_id === auth()->id() ? 'sent' : 'received' }}">
                                <p class="text-sm">{{ $message->content }}</p>
                                <p class="text-xs opacity-75 mt-1">
                                    {{ $message->created_at->format('g:i A') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Message Input -->
            <div class="border-t border-gray-200 p-4">
                <form id="messageForm" class="flex space-x-4">
                    @csrf
                    <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                    <div class="flex-1">
                        <input type="text" 
                               name="content" 
                               id="messageInput"
                               placeholder="Type your message..." 
                               class="form-input"
                               required>
                    </div>
                    <button type="submit" 
                            class="btn-primary">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const messageForm = document.getElementById('messageForm');
    const messageInput = document.getElementById('messageInput');
    const messagesContainer = document.getElementById('messagesContainer');
    const conversationId = {{ $conversation->id }};

    // Auto-scroll to bottom
    function scrollToBottom() {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    // Add message to UI
    function addMessage(message) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `flex ${message.sender_id === {{ auth()->id() }} ? 'justify-end' : 'justify-start'}`;
        
        const isOwnMessage = message.sender_id === {{ auth()->id() }};
        const flexDirection = isOwnMessage ? 'flex-row-reverse' : 'flex-row';
        const messageClass = isOwnMessage ? 'sent' : 'received';
        
        messageDiv.innerHTML = `
            <div class="flex ${flexDirection} items-end space-x-2 max-w-xs lg:max-w-md">
                <img src="${message.sender.avatar}" 
                     alt="${message.sender.name}" 
                     class="h-8 w-8 rounded-full object-cover flex-shrink-0">
                <div class="chat-message ${messageClass}">
                    <p class="text-sm">${message.content}</p>
                    <p class="text-xs opacity-75 mt-1">
                        ${new Date(message.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                    </p>
                </div>
            </div>
        `;
        
        messagesContainer.appendChild(messageDiv);
        scrollToBottom();
    }

    // Send message
    messageForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const content = messageInput.value.trim();
        if (!content) return;

        // Add message to UI immediately
        const tempMessage = {
            sender_id: {{ auth()->id() }},
            content: content,
            created_at: new Date().toISOString(),
            sender: {
                name: '{{ auth()->user()->name }}',
                avatar: '{{ auth()->user()->avatar }}'
            }
        };
        addMessage(tempMessage);

        // Clear input
        messageInput.value = '';

        // Send to server
        fetch('{{ route("chat.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                conversation_id: conversationId,
                content: content,
                message_type: 'text'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Message sent successfully
                console.log('Message sent');
            } else {
                console.error('Failed to send message:', data.error);
            }
        })
        .catch(error => {
            console.error('Error sending message:', error);
        });
    });

    // Auto-scroll to bottom on load
    scrollToBottom();

    // Poll for new messages (in a real app, use WebSockets)
    setInterval(function() {
        fetch(`{{ route('chat.messages', $conversation->id) }}`)
            .then(response => response.json())
            .then(data => {
                // In a real app, you'd compare with existing messages
                // and only add new ones
            })
            .catch(error => {
                console.error('Error fetching messages:', error);
            });
    }, 5000);
});
</script>
@endsection
