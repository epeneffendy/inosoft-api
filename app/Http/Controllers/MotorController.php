<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Motor;
use Illuminate\Http\Request;
use League\Flysystem\Exception;

class MotorController extends Controller
{
    public function index()
    {
        $post = Motor::all();
        if (count($post) > 0) {
            $response = [
                'responseCode' => http_response_code(),
                'responseMessage' => 'Successful',
                'data' => $post,
            ];
        } else {
            $response = [
                'responseCode' => http_response_code(),
                'responseMessage' => 'Data Motor Tidak Ditemukan!',
                'data' => [],
            ];
        }

        return response()->json($response, 200);
    }

    public function store(Request $request)
    {
        try {
            $motor = New Motor();
            $motor->mesin = $request->mesin;
            $motor->kapasitas_penumpang = $request->kapasitas_penumpang;
            $motor->tipe = $request->tipe;
            $motor->save();

            $response = [
                'responseCode' => http_response_code(),
                'responseMessage' => 'Successful',
                'data' => $motor,
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            $response = [
                'responseCode' => http_response_code(),
                'responseMessage' => 'Internal Server Error',
                'data' => [],
            ];

            return response()->json($response, 400);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $motor = Motor::where('_id', '=', $id)->first();

            $motor->mesin = $request->mesin;
            $motor->kapasitas_penumpang = $request->kapasitas_penumpang;
            $motor->tipe = $request->tipe;
            $motor->save();

            $response = [
                'responseCode' => http_response_code(),
                'responseMessage' => 'Successful',
                'data' => $motor,
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            $response = [
                'responseCode' => http_response_code(),
                'responseMessage' => 'Internal Server Error',
                'data' => [],
            ];

            return response()->json($response, 400);
        }
    }

    public function destroy($id){
        try {
            $motor = Motor::where('_id', '=', $id)->first();
            $motor->delete();

            $response = [
                'responseCode' => http_response_code(),
                'responseMessage' => 'Successful',
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            $response = [
                'responseCode' => http_response_code(),
                'responseMessage' => 'Internal Server Error',
                'data' => [],
            ];

            return response()->json($response, 400);
        }

    }

}
