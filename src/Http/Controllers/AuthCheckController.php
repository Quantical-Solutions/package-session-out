<?php

namespace Quantic\SessionOut\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;

class AuthCheckController extends Controller
{
    /**
     * ping the server to check whether user is online
     */
    public function getStatus(Request $request)
    {
        $request->validate([
            'pinguser' => 'required|boolean'
        ]);

        if (Auth::check()) {

            echo json_encode(['auth' => 1], JSON_THROW_ON_ERROR);

        } else {

            echo json_encode(['auth' => 0], JSON_THROW_ON_ERROR);
        }
        exit();
    }

    /**
     * go to restart session form
     */
    public function setStatus(Request $request)
    {
        $id = $request->input('user_id');
        $user = User::select('email', 'name')->where('id', $id)->first();
        return view('vendor.session-out.session-expired', ['email' => $user->email, 'name' => $user->name]);
    }

    /**
     * restart session by XHR
     */
    public function rebirthStatus(Request $request)
    {
        if ($request->input('id') !== null) {

            $id = $request->input('id');
            $user = User::where('id', $id)->first();
            Auth::login($user);
            $request->session()->regenerate();
            return response()->json(['session' => 1]);
        }
    }
}
