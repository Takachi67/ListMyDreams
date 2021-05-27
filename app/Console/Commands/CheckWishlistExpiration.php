<?php

namespace App\Console\Commands;

use App\Models\Notification;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckWishlistExpiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkWishlistExpiration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check wishlists expiration_date';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $wishlists = Wishlist::query()
            ->where('expire_at', '<', Carbon::now())
            ->where('status', '<>', 'expired')
            ->get();

        $notifications = [];

        Wishlist::query()
            ->where('expire_at', '<', Carbon::now())
            ->where('status', '<>', 'expired')
            ->update([
                'status' => 'expired'
            ]);

        foreach ($wishlists as $wishlist) {
            $notifications[] = [
                'user_id' => $wishlist->user_id,
                'type' => 'wishlist_expiration',
                'message' => str_replace(':name:', $wishlist->name, __('notifications.messages.wishlist_expiration')),
                'link' => route('wishlists.edit', $wishlist->id),
                'has_seen' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }

        Notification::query()
            ->insert($notifications);
    }
}
