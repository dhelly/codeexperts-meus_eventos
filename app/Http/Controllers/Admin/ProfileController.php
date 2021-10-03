<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function edit()
    {
        $user = auth()->user();

        return view('admin.profile', compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        $user = auth()->user();

        $userData = $request->get('user');
        $profileData = $request->get('profile');

        if ($userData['password']) {
            $userData['password'] = bcrypt($userData['password']);
        } else {
            unset($userData['password']);
        }

        $user->update($userData);

        $user->profile()->update($profileData);

        return redirect()->route('admin.profile.edit');
    }
}
