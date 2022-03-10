<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MyToken;
use App\Models\User;


class UserController extends Controller
{
    private $loggedin = false;

    public function __construct() {
        MyToken::where("updated_at",'<=', date('Y-m-d', strtotime("-2weeks")))->delete();

    }

    function loggedin(Request $request) {
        
        $this->check($request);

        return $this->loggedin;
    }

    function login( Request $request) {
        MyToken::where("email", $request->input('email'))->delete();

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $result = DB::select("SELECT * FROM `users` 
                        WHERE `email` = ?
                        AND `password` = ?", array(
                            $request->input('email'),
                            $request->input('password'),
                        )
                    );
        if (count($result) == 0) {
            abort(500, "nincs ilyen email");
            $this->loggedin = false;
        } else {
            $this->loggedin = true;
            MyToken::insert(
            array(
                "email" => $request->input('email'),
                "token" => session()->getId(),
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
            ));
            return array (
                "email" => $result[0]->email,
                "name" => $result[0]->name,
                "token" => session()->getId()
            );
        }

    }

    function check( Request $request) {
        $credentials = $request->validate([
            'token' => ['required']
        ]);

        $result = MyToken::where("token", $request->input("token"))->get();

        if (!$result || count($result) == 0) {
            $this->loggedin = false;
            abort(500, "nincs ilyen email");
        } else {
            $this->loggedin = true;
            MyToken::where("token", $request->input("token"))->update(array("updated_at"=> date("Y-m-d H:i:s")));

            $user = User::where("email", $result[0]->email)->get()[0];
            return array(
                "email" => $user->email,
                "name" => $user->name,
            );
        }
    }

    function logout( Request $request) {
        $credentials = $request->validate([
            'token' => ['required']
        ]);
        $result = MyToken::where("token", $request->input("token"))->get();
        if ($result && count($result) > 0) {
            MyToken::where("token", $result[0]->token)->delete();
        }
        $this->loggedin = false;
        return;
    }
}
