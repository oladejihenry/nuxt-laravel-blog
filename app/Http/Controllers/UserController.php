<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __invoke()
    {
        return UserResource::make(
            auth()->user()
        );
    }

    public function index()
    {

        $user = User::orderBy('created_at', 'desc')->paginate(10)->through(fn($user) =>[
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'username' => $user->username,
            'created_at' => $user->created_at->format('Y/m/d H:i'),
            'updated_at' => $user->updated_at->format('Y/m/d h:i A'),
        ]);

        return response()->json($user);
    }

    public function store(UserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'Registration successful',
        ], 200);
    }

    public function edit($id)
    {
        $user = User::find($id);
        return response()->json([
            'user' => $user, 
            'password' => $user->password,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        // $user = User::find($auth->id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|'.Rule::unique('users')->ignore($user->id),
            'email' => 'required|string|email|max:255|'. Rule::unique('users')->ignore($user->id),
            'password' => 'required|string|min:8|confirmed',
        ]);


        $currentPhoto = $user->profile_image;
    
        if($request->profile_image != $currentPhoto)
        {   
 
            $name = time().'.' . explode('/', explode(':', substr($request->profile_image, 0, strpos($request->profile_image, ';')))[1])[1];
            $img = Image::make($request->profile_image)->resize(360, 358)->encode('jpg');
            Storage::disk('profile')->put($name,(string) $img);
            $request->merge(['profile_image' => $name]);

            $userPhoto = public_path('storage/img/profile/').$currentPhoto;

            if(file_exists($userPhoto)){

                @unlink($userPhoto);
                
            }
        }

        $user->update($request->all());

        return response()->json([
            'user' => $user, 
        ]);
    }

}