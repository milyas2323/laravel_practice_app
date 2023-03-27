<?php

namespace App\Http\Controllers\AdminProfile;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAvatarRequest;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class AdminAvatarController extends Controller
{
    public function update(UpdateAvatarRequest $request){


       //$path = $request->file('avatar')->store('avatars','public');

       //Via Facades Storage
       $path = Storage::disk('public')->put('admin_avatars', $request->file('avatar'));

       //Remove old file
       if($old_avatar = $request->user()->avatar){

            Storage::disk('public')->delete($old_avatar);
       }

       auth()->user()->update(['avatar' => $path]);

        return Redirect::route('admin.profile.edit')->with('status', 'avatar-updated');
    }
}
