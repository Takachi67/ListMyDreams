<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Reservation;
use App\Models\Wishlist;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ReservationController extends Controller
{
    /**
     * @return View|Factory|Application
     */
    public function index(): View|Factory|Application
    {
        $items = Item::with('wishlist.user', 'reservation')
            ->where('reserved_user_id', Auth::user()->getAuthIdentifier())
            ->get();

        $users = [];

        foreach ($items as $item) {
            $users[$item->wishlist->user->nickname][] = $item;
        }

        return view('reservations.index', compact('users'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function hasBought(Request $request): \Illuminate\Http\Response
    {
        $item = Item::with('reservation')
            ->where('id', $request->input('item_id'))
            ->first();

        $item->reservation()->update([
            'has_bought' => $request->input('has_bought')
        ]);

        return Response::noContent();
    }

    /**
     * @param Request $request
     * @return JsonResponse|\Illuminate\Http\Response
     */
    public function saveNotes(Request $request): \Illuminate\Http\Response|JsonResponse
    {
        try {
            Reservation::query()->where('id', $request->input('reservation_id'))->update([
                'notes' => $request->input('notes')
            ]);
        } catch (Exception $e) {
            return Response::json([
                'message' => __('default.an_error_occured')
            ], 500);
        }

        return Response::noContent();
    }
}
