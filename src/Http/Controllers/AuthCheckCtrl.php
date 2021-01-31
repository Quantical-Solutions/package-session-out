<?php

namespace Quantic\SessionOut\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class AuthCheckCtrl extends Controller
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
}