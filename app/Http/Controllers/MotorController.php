<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use Illuminate\Http\Request;

class MotorController extends Controller
{
    public function index()
    {
        $post = Motor::all();
        $response = [
            'responseCode' => '2007300',
            'responseMessage' => 'Successful',
            'data' => $post,
            'expiresIn' => 900,
        ];
        return response()->json($response, 200);

//        return view('index', [
//            'post' => Post::all()
//        ]);
    }
}
