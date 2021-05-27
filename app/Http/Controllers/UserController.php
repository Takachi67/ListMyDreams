<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function profile(): Application|Factory|View
    {
        return view('users/profile');
    }

    /**
     * @param UserRequest $request
     * @return Redirector|RedirectResponse|Application
     */
    public function update(UserRequest $request): Redirector|RedirectResponse|Application
    {
        $data = [
            'nickname' => $request->input('nickname')
        ];

        if ($request->file('picture')) {
            if (Auth::user()->picture) {
                Storage::delete('app/public/users/' . Auth::user()->picture);
            }

            $name = time() . '_' . sha1_file($request->file('picture')) . '.' . $request->file('picture')->extension();
            Image::make($request->file('picture'))
                ->fit(200, 200)
                ->save(storage_path('app/public/users') . '/' . $name);

            $data['picture'] = $name;
        }

        if ($request->input('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }

        User::query()
            ->where('id', Auth::user()->getAuthIdentifier())
            ->update($data);

        return redirect(route('users.profile'))->with('success', __('user.successfully_updated'));
    }
}
