<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection as NotificationCollection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Multicaret\Acquaintances\Traits\Friendable;

class User extends Authenticatable
{
    use Friendable, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nickname',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return HasMany
     */
    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * @return NotificationCollection|array
     */
    public function getNotifications(): NotificationCollection|array
    {
        return Notification::query()
            ->where('user_id', $this->id)
            ->where('has_seen', false)
            ->get();
    }

    /**
     * @return NotificationCollection|array
     */
    public function getQuestions(): NotificationCollection|array
    {
        return Question::query()
            ->with('wishlist', 'user', 'question')
            ->where('target_id', $this->id)
            ->where('has_answered', false)
            ->get();
    }
}
