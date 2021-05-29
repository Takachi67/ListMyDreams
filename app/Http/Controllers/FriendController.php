<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;

class FriendController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $friends = Auth::user()->getFriends()->map(function ($friend) {
            $friend->wishlists = $friend->wishlists()->where('status', '<>', 'created')->get();
            return $friend;
        });
        $requests = Auth::user()->getFriendRequests()->map(function ($request) {
            $request->sender = $request->sender;
            return $request;
        });

        return view('friends.index', compact('friends', 'requests'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function request(Request $request): JsonResponse
    {
        try {
            $recipient = User::query()
                ->where('email', $request->input('email'))
                ->firstOrFail();
        } catch (Exception $e) {
            return Response::json([
                'message' => __('friends.no_user_found')
            ], 500);
        }

        if (Auth::user()->isFriendWith($recipient)) {
            return Response::json([
                'message' => __('friends.is_already_accepted')
            ], 500);
        }

        Auth::user()->befriend($recipient);

        Notification::query()
            ->create([
                'user_id' => $recipient->id,
                'type' => 'friend_request',
                'message' => str_replace(':nickname:', Auth::user()->nickname, __('notifications.messages.friend_request')),
                'has_seen' => false,
                'link' => route('friends.index')
            ]);

        return Response::json([
            'message' => __('friends.request_sent')
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function accept(Request $request): JsonResponse
    {
        try {
            $sender = User::query()
                ->find($request->input('sender_id'));

            Auth::user()->acceptFriendRequest($sender);
        } catch (Exception $e) {
            return Response::json([
                'message' => __('friends.no_user_found')
            ]);
        }

        return Response::json([
            'message' => __('friends.request_accepted')
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function decline(Request $request): JsonResponse
    {
        try {
            $sender = User::query()
                ->find($request->input('sender_id'));

            Auth::user()->denyFriendRequest($sender);
        } catch (Exception $e) {
            return Response::json([
                'message' => __('friends.no_user_found')
            ]);
        }

        return Response::json([
            'message' => __('friends.request_declined')
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function remove(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $friend = User::findOrFail($request->input('friend_id'));

            Auth::user()->unfriend($friend);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json([
                'message' => __('default.an_error_occured')
            ], 500);
        }

        return Response::json([]);
    }
}
