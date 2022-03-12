<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

class LoginController extends Controller
{
    /**
     * Handle the incoming login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        request()->validate([
            'email' => ['required','string', 'email'],
            'password' => ['required'],
        ]);
    
        /**
         * Handle the incoming login request from frontend.   
         */
        if (EnsureFrontendRequestsAreStateful::fromFrontend(request())) {
            $this->authenticateFrontend();
        }

    }

    /**
     * Authenticate the user from frontend.
     *
     * @return \Illuminate\Http\Response
     */

     private function authenticateFrontend()
     {
        if(! Auth::guard('web')
            ->attempt(
                request()->only('email', 'password'),
                request()->boolean('remember')
            )){
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }
     }
}
