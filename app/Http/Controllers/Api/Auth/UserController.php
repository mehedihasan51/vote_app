<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public $select;
    public function __construct()
    {
        $this->select = ['id', 'name', 'email', 'avatar'];   
    }

    public function me()
    {   
        $data = User::select($this->select)->with(['roles', 'profile'])->find(auth('api')->user()->id);     
        return Helper::jsonResponse(true, 'User details fetched successfully', 200, $data);
    }

    public function updateProfile(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'phone' => 'required|string|numeric|max_digits:20',
            'password' => 'nullable|string|min:6|confirmed',
            'address' => 'nullable|string|max:255',
        ]);

        if (!empty($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else if (array_key_exists('password', $validatedData)) {
            unset($validatedData['password']);
        }

        $user = auth('api')->user();

        if ($request->hasFile('avatar')) {
            if (!empty($user->avatar)) {
                Helper::fileDelete(public_path($user->getRawOriginal('avatar')));
            }
            $validatedData['avatar'] = Helper::fileUpload($request->file('avatar'), 'user/avatar', getFileName($request->file('avatar')));
        } else {
            $validatedData['avatar'] = $user->avatar;
        }

        $user->update($validatedData);

        $data = User::select($this->select)->with('roles')->find($user->id);
        return Helper::jsonResponse(true, 'Profile updated successfully', 200, $data);
    }

    public function updateAvatar(Request $request)
    {
        $validatedData = $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);
        $user = auth('api')->user();
        if (!empty($user->avatar)) {
            Helper::fileDelete(public_path($user->getRawOriginal('avatar')));
        }
        $validatedData['avatar'] = Helper::fileUpload($request->file('avatar'), 'user/avatar', getFileName($request->file('avatar')));
        $user->update($validatedData);
        $data = User::select($this->select)->with('roles')->find($user->id);
        return Helper::jsonResponse(true, 'Avatar updated successfully', 200, $data);
    }

    public function delete()
    {
        $user = User::findOrFail(auth('api')->id());
        if (!empty($user->avatar) && file_exists(public_path($user->avatar))) {
            Helper::fileDelete(public_path($user->avatar));
        }
        Auth::logout('api');
        $user->delete();
        return Helper::jsonResponse(true, 'Profile deleted successfully', 200);
    }

    public function destroy()
    {
        $user = User::findOrFail(auth('api')->id());
        if (!empty($user->avatar) && file_exists(public_path($user->avatar))) {
            Helper::fileDelete(public_path($user->avatar));
        }
        Auth::logout('api');
        $user->forceDelete();
        return Helper::jsonResponse(true, 'Profile deleted successfully', 200);
    }


    
}
