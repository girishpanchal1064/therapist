<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get conversations for the user
        $conversations = $user->conversations()
            ->with(['participants.user.profile', 'appointment.therapist.profile', 'messages' => function($query) {
                $query->latest()->limit(1);
            }])
            ->orderBy('last_message_at', 'desc')
            ->get();

        return view('chat.index', compact('conversations'));
    }

    public function show($conversationId)
    {
        $conversation = Conversation::with([
            'participants.user.profile',
            'appointment.therapist.profile',
            'messages.sender.profile'
        ])->findOrFail($conversationId);

        // Check if user is part of this conversation
        $isParticipant = $conversation->participants()
            ->where('user_id', Auth::id())
            ->exists();

        if (!$isParticipant) {
            abort(403, 'Unauthorized');
        }

        // Mark messages as read
        $conversation->messages()
            ->where('sender_id', '!=', Auth::id())
            ->update(['is_read' => true, 'read_at' => now()]);

        return view('chat.show', compact('conversation'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'content' => 'required|string|max:1000',
            'message_type' => 'in:text,file,image,voice,video',
        ]);

        $conversation = Conversation::findOrFail($request->conversation_id);

        // Check if user is part of this conversation
        $isParticipant = $conversation->participants()
            ->where('user_id', Auth::id())
            ->exists();

        if (!$isParticipant) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Create message
        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => Auth::id(),
            'message_type' => $request->message_type ?? 'text',
            'content' => $request->content,
        ]);

        // Update conversation last message time
        $conversation->update(['last_message_at' => now()]);

        // Load sender profile for response
        $message->load('sender.profile');

        // Broadcast message (in real app, use Laravel WebSockets or Pusher)
        // broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }

    public function getMessages($conversationId)
    {
        $conversation = Conversation::findOrFail($conversationId);

        // Check if user is part of this conversation
        $isParticipant = $conversation->participants()
            ->where('user_id', Auth::id())
            ->exists();

        if (!$isParticipant) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $messages = $conversation->messages()
            ->with('sender.profile')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json(['messages' => $messages]);
    }

    public function createConversation(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
        ]);

        $appointment = Appointment::findOrFail($request->appointment_id);

        // Check if user is part of this appointment
        if ($appointment->client_id !== Auth::id() && $appointment->therapist_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Check if conversation already exists
        $conversation = Conversation::where('appointment_id', $appointment->id)->first();

        if (!$conversation) {
            // Create conversation
            $conversation = Conversation::create([
                'appointment_id' => $appointment->id,
                'type' => 'appointment',
                'last_message_at' => now(),
            ]);

            // Add participants
            $conversation->participants()->create([
                'user_id' => $appointment->client_id,
                'joined_at' => now(),
            ]);

            $conversation->participants()->create([
                'user_id' => $appointment->therapist_id,
                'joined_at' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'conversation_id' => $conversation->id,
        ]);
    }
}
