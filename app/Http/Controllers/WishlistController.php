<?php

namespace App\Http\Controllers;

use App\Http\Requests\WishlistRequest;
use App\Models\Item;
use App\Models\User;
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

        $friends = Auth::user()->getFriends();

        return view('wishlists.index', compact('lists', 'friends'));
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
                Item::create(array_merge($item, [
                    'list_id' => $wishlist->id
                ]));
            }

            DB::commit();
        } catch (ValidationException $e) {
            DB::rollBack();
            return Response::json(array_values($e->errors())[0], 422);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json([
                'message' => __('default.an_error_occured')
            ], 500);
        }

        return Response::json([]);
    }

    /**
     * @param WishlistRequest $request
     * @return JsonResponse
     */
    public function update(WishlistRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['user_id'] = Auth::user()->getAuthIdentifier();
            $items = $data['items'];

            Log::debug($items);

            unset($data['items']);

            $wishlist = Wishlist::find($data['id']);

            if ($wishlist->status === 'created') {
                Item::where('list_id', $wishlist->id)
                    ->delete();
            }

            unset($data['id']);

            $wishlist->update($data);

            foreach ($items as $item) {
                if ($wishlist->status === 'created' || ($wishlist->status === 'published' && !isset($item['id']))) {
                    Item::create(array_merge([
                        'name' => $item['name'],
                        'link' => $item['link'],
                        'priority' => $item['priority'],
                        'comment' => $item['comment'],
                    ], [
                        'list_id' => $wishlist->id
                    ]));
                }
            }

            DB::commit();
        } catch (ValidationException $e) {
            DB::rollBack();
            return Response::json(array_values($e->errors())[0], 422);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json([
                'message' => __('default.an_error_occured')
            ], 500);
        }

        return Response::json([]);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function duplicate(int $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $wishlist = Wishlist::query()->find($id);

            if ($wishlist->user_id !== Auth::user()->getAuthIdentifier()) {
                abort(403);
            }

            $newWishlist = $wishlist->replicate();
            $newWishlist->push();

            foreach ($wishlist->items as $item) {
                $array = $item->toArray();
                unset($array['id']);
                $newWishlist->items()->create($array);
            }

            $newWishlist->status = 'created';
            $newWishlist->expire_at = null;

            $newWishlist->save();

            DB::commit();
        } catch (Exception $e) {
            Log::debug($e->getMessage());
            DB::rollBack();
            return Response::json([
                'message' => __('default.an_error_occured')
            ], 500);
        }

        return Response::json([
            'id' => $newWishlist->id
        ]);
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $wishlist = Wishlist::query()
            ->with('items', 'messages', 'messages.user')
            ->find($id);

        if ($wishlist->user_id !== Auth::user()->getAuthIdentifier()) {
            abort(403);
        }

        return view('wishlists.edit', compact('wishlist'));
    }

    /**
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
        $wishlist = Wishlist::query()
            ->with('items', 'messages', 'messages.user')
            ->find($id);

        if ($wishlist->status !== 'published' && $wishlist->status !== 'expired' && Auth::user() && Auth::user()->getAuthIdentifier() !== $wishlist->user_id) {
            abort(403);
        }

        if ((Auth::user() && Auth::user()->getAuthIdentifier() !== $wishlist->user_id) && ($wishlist->sharing_type === 'friends' && (Auth::guest() || !Auth::user()->isFriendWith(User::find($wishlist->user_id))))) {
            abort(403);
        }

        $canEdit = false;

        if ($wishlist->sharing_type === 'with_link' && Auth::user() && Auth::user()->getAuthIdentifier() !== $wishlist->user_id) {
            $canEdit = true;
        }

        if ($wishlist->sharing_type === 'friends' && Auth::user() && Auth::user()->isFriendWith(User::find($wishlist->user_id)) && Auth::user()->getAuthIdentifier() !== $wishlist->user_id) {
            $canEdit = true;
        }

        return view('wishlists.show', compact('wishlist', 'canEdit'));
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

    public function publish(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $wishlist = Wishlist::query()
                ->find($data['id']);

            $wishlist->update([
                'status' => 'published'
            ]);
        } catch (Exception $e) {
            return Response::json([
                'message' => __('default.an_error_occured')
            ], 500);
        }

        return Response::json([
            'message' => __('wishlists.published_successful'),
            'wishlist' => $wishlist
        ]);
    }
}
