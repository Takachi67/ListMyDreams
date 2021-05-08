<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function create(): View
    {
        return view('wishlists.create');
    }
}
