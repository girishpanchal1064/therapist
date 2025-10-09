@extends('layouts.app')

@section('title', 'Messages - TalkToAngel Clone')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900">Messages</h1>
            <p class="mt-1 text-sm text-gray-600">Communicate with your therapist and manage your conversations.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        @if($conversations->count() > 0)
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Your Conversations</h2>
                </div>
                <div class="divide-y divide-gray-200">
                    @foreach($conversations as $conversation)
                        <div class="p-6 hover:bg-gray-50 cursor-pointer" 
                             onclick="window.location.href='{{ route('chat.show', $conversation->id) }}'">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    @if($conversation->appointment)
                                        <img src="{{ $conversation->appointment->therapist->avatar }}" 
                                             alt="{{ $conversation->appointment->therapist->name }}" 
                                             class="h-12 w-12 rounded-full object-cover">
                                    @else
                                        <div class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center">
                                            <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="text-sm font-medium text-gray-900">
                                                @if($conversation->appointment)
                                                    {{ $conversation->appointment->therapist->name }}
                                                @else
                                                    Group Chat
                                                @endif
                                            </h3>
                                            <p class="text-sm text-gray-500">
                                                @if($conversation->appointment)
                                                    {{ $conversation->appointment->therapist->therapistProfile->qualification ?? 'Therapist' }}
                                                @else
                                                    {{ $conversation->participants->count() }} participants
                                                @endif
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            @if($conversation->last_message_at)
                                                <p class="text-xs text-gray-500">
                                                    {{ $conversation->last_message_at->diffForHumans() }}
                                                </p>
                                            @endif
                                            @if($conversation->messages->count() > 0)
                                                <p class="text-sm text-gray-900 mt-1">
                                                    {{ Str::limit($conversation->messages->first()->content, 50) }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No conversations yet</h3>
                <p class="mt-1 text-sm text-gray-500">Start a conversation by booking a session with a therapist.</p>
                <div class="mt-6">
                    <a href="{{ route('therapists.index') }}" class="btn-primary">Find a Therapist</a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
