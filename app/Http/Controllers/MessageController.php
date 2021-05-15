<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class MessageController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function send(Request $request): JsonResponse
    {
        try {
            $message = Message::query()
                ->create([
                    'list_id' => $request->input('list_id'),
                    'user_id' => Auth::user()->getAuthIdentifier(),
                    'message' => $request->input('message'),
                ]);
        } catch (Exception $e) {
            return Response::json([
                'message' => __('default.an_error_occured')
            ], 500);
        }

        return Response::json([
            'message' => Message::query()->with('user')->find($message->id)
        ]);
    }
}
