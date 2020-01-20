<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use JavaScript;
use Auth;
use App\Message;
use App\Events\MessageSent;

class ChatController extends Controller
{
    public function main_chat()
    {
        return view("chat/public_chat");
    }

    public function fetchMessages()
    {
        return Message::with('user')->get();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function sendMessages(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        /** @var Message $message */
        $message = $user->messages()->create([
            'message' => $request->input('message')
        ]);

        broadcast(new MessageSent($user, $message))->toOthers();

        return ['status' => 'Message Sent!'];
    }
}
