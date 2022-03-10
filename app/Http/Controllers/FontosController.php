<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;

class FontosController extends Controller
{
    function fontos(Request $request) {
        $u = new UserController();

        if ($u->loggedin($request)) {
            return response()->json("lorem ipsum dolor");
        } else {
            abort(500, "nincs jogod hozzá");
        }
        
    }
}
