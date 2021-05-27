<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class NotificationController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function see(Request $request): \Illuminate\Http\Response
    {
        Notification::query()
            ->where('id', $request->input('id'))
            ->update([
                'has_seen' => true
            ]);

        return Response::noContent();
    }
}
