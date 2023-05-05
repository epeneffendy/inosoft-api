<?php

namespace App\Http\Controllers;

use App\Services\MobilSerivce;
use App\Services\MotorSerivce;
use Illuminate\Http\Request;
use MongoDB\Driver\Exception\Exception;
use Tymon\JWTAuth\Exceptions\JWTException;

class StokKendaraanController extends Controller
{
    public function index(MobilSerivce $mobilSerivce, MotorSerivce $motorSerivce, $type)
    {
        try {
            $this->user = JWTAuth::parseToken()->authenticate();
            if ($type == 'mobil') {
                $datas = $mobilSerivce->fetchStok();
            } else {
                $datas = $motorSerivce->fetchStok();
            }

            if (count($datas) >= 1){
                $response = [
                    'responseCode' => 200,
                    'responseMessage' => 'Successful',
                    'responseReason' => [
                        "english" => "Success",
                        "indonesia" => "Sukses"
                    ],
                    'data' => $datas,
                ];
            }else{
                $response = [
                    'responseCode' => 200,
                    'responseMessage' => 'Failed',
                    'responseReason' => [
                        "english" => "Data Not Foundsss",
                        "indonesia" => "Data Tidak Ditemukan"
                    ],
                    'data' => [],
                ];
            }

            return response()->json($response, 200);
        }catch (JWTException $e) {
            $response = [
                'responseCode' => 401,
                'responseMessage' => 'Failed',
                'responseReason' => [
                    "english" => "Access Token Invalid",
                    "indonesia" => "Token Tidak Valid"
                ],
            ];
            return response()->json($response, 401);
        } catch (Exception $e) {
            $response = [
                'responseCode' => 400,
                'responseMessage' => 'Failed',
                'responseReason' => [
                    "english" => "Bad Request ",
                    "indonesia" => "Permintaan Tidak Valid"
                ],
                'error' => $e->getMessage()
            ];
            return response()->json($response, 400);
        }
    }
}
