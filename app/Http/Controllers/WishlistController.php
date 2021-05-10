<?php

namespace App\Http\Controllers;

use App\Http\Requests\WishlistRequest;
use App\Models\Item;
use App\Models\Wishlist;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class WishlistController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $lists = Wishlist::query()
            ->where('user_id', Auth::user()->getAuthIdentifier())
            ->get();

        return view('wishlists.index', compact('lists'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('wishlists.create');
    }

    /**
     * @param WishlistRequest $request
     * @return JsonResponse
     */
    public function store(WishlistRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['user_id'] = Auth::user()->getAuthIdentifier();
            $items = $data['items'];

            unset($data['items']);

            $wishlist = Wishlist::query()
                ->create($data);

            foreach ($items as $item) {
                Item::query()
                    ->create(array_merge($item, [
                        'list_id' => $wishlist->id
                    ]));
            }
            DB::commit();
        } catch (ValidationException $e) {
            DB::rollBack();
            return Response::json(array_values($e->errors())[0], 422);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            Log::debug($e->getTraceAsString());
            return Response::json([
                'message' => __('default.an_error_occured')
            ], 500);
        }

        return Response::json([]);
    }

    /**
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
        $wishlist = Wishlist::query()
            ->with('items')
            ->find($id);

        return view('wishlists.show', compact('wishlist'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function reserve(Request $request): JsonResponse
    {
        $data = $request->all();

        $item = Item::where('id', $data['id'])
            ->first();

        if ($item->is_reserved) {
            return Response::json([
                'message' => str_replace(':item:', $item->name, __('items.already_reserved'))
            ], 422);
        }

        $item->update([
            'is_reserved' => true,
            'reserved_user_id' => Auth::user()->getAuthIdentifier()
        ]);

        return Response::json($item);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function unreserve(Request $request): JsonResponse
    {
        $data = $request->all();

        $item = Item::where('id', $data['id'])
            ->first();

        if (!$item->is_reserved) {
            return Response::json([
                'message' => str_replace(':item:', $item->name, __('items.already_unreserved'))
            ], 422);
        }

        $item->update([
            'is_reserved' => false,
            'reserved_user_id' => null
        ]);

        return Response::json($item);
    }
}
