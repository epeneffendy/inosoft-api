<?php

namespace App\Http\Controllers;

use App\Services\MobilSerivce;
use App\Services\MotorSerivce;
use Illuminate\Http\Request;

class StokKendaraanController extends Controller
{
    public function index(MobilSerivce $mobilSerivce, MotorSerivce $motorSerivce, $type)
    {
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

    }
}
