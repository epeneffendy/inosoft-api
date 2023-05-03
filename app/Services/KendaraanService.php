<?php
namespace App\Services;

use App\Models\Kendaraan;

class KendaraanService
{
    public function findById($id)
    {
        $data = Kendaraan::where('_id', '=', $id)->first();
        return $data;
    }

    public function delete($id)
    {
        $data = $this->findById($id);
        $data->delete();
    }
}