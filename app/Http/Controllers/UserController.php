<?php

namespace App\Http\Controllers;

use App\Mail\UserBlockedUnblocked;
use App\Mail\UserCreated;
use App\Mail\UserRoleChanged;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function store(Request $request){
        $data=$request->validate([
            'name'=> 'required|string',
            'email' => ['required', 'email', 'unique:users,email'],
            'is_admin'=> 'boolean'
        ]);
       $rawPassword = Str::random(8);
       // $rawPassword = '12345678';

        $data['password']=bcrypt($rawPassword);
        $data['email_verfied_at']= now();

        $user= User::create($data);

        Mail::to($user)->send(new UserCreated($user, $rawPassword));

        return redirect()->back();
    }

    public function changeRole(User $user){
        $user->update(['is_admin'=> !(bool) $user->is_admin]);
        $message = 'User role was change into '.($user->is_admin ? '"Admin"' : '"Regular Uers"');
        Mail::to($user)->send(new UserRoleChanged($user));

        return response()->json(['message'=> $message]);
    }

    public function blockUnblock(User $user)
    {
        logger()->info('Current blocked_at value: ' . $user->blocked_at);
        
        try {
            // Toggle blocked status
            $user->blocked_at = $user->blocked_at ? null : now();
            $user->save();
            
            // Log new blocked_at value
            logger()->info('New blocked_at value: ' . $user->blocked_at);
    
            // Return a JSON response with a success message
            $message = $user->blocked_at ? 'User has been blocked.' : 'User has been unblocked.';
            Mail::to($user)->send(new UserBlockedUnblocked($user));

            return response()->json(['message' => $message]);
    
        } catch (\Exception $e) {
            // Log the exception and return a generic error message
            logger()->error('Error in blockUnblock method: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }
    
    


}
