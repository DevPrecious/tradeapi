<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::with('profile')->find(auth()->id());

        return [
            'user' => $user,
        ];
    }

    public function SaveProfileData(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'bank_account' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'user_bank_name' => 'required|string|max:255',
        ]);

        $dataToSave = [
            'user_id' => auth()->id(),
            'bank_account' => $request->bank_account,
            'bank_name' => $request->bank_name,
            'user_bank_name' => $request->user_bank_name,
        ];
        // Profile image upload
        if ($request->hasFile('profile_image')) {

            // validate the image
            $request->validate([
                'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $file = $request->file('profile_image');
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('images'), $fileName);
            $dataToSave['profile_image'] = $fileName;
        }

        Profile::updateOrCreate($dataToSave);

        // check if password is empty
        if(!empty($request->password)){
            // Validate password
            $request->validate([
                'password' => 'required|string|min:6',
            ]);

            // update user model with password
            User::where('id', auth()->id())->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
        }else{
            // update user model without password
            User::where('id', auth()->id())->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
        }

        // get user data with profile data
        $profile = User::with('profile')->find(auth()->id());

        return [
            'profile' => $profile,
        ];
    }
}
