<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AgriFarm;
use App\Models\DiseaseGroup;
use Illuminate\Http\Request;

class FormFarmIssueController extends Controller
{
    public function getAllAgriFarm()
    {
        $data = AgriFarm::orderBy('fv_agricode', 'ASC')->get();

        if ($data) {
            return response()->json([
                'status' => 200,
                'error' => false,
                'data' => count($data) == 0 ? "Data sedang kosong nih, skuy buat postingan" : $data
            ]);
        }

        return response()->json([
            'status' => 300,
            'error' => true,
            'message' => 'Wah ada error nih, kenapa Hayoo!'
        ]);
    }

    public function getDetailAgriFarm($id)
    {
        $agricode = base64_decode($id);
        $data = AgriFarm::where('fv_agricode', $agricode)->first();

        if (!empty($data)) {
            return response()->json([
                'status' => 200,
                'error' => false,
                'data' => $data
            ]);
        }

        return response()->json([
            'status' => 200,
            'error' => true,
            'message' => 'Ooops, Data tidak ditemukan nih'
        ]);
    }

    public function getQuestion($encodedAgriCode)
    {
        $AgriCode = base64_decode($encodedAgriCode);
        $data = DiseaseGroup::with([
            'listOptions' => function ($q) use ($AgriCode) {
                $q->where('fv_agricode', '=', $AgriCode);
            },
            'listOptions.agriFarm'
        ])
            ->orderBy('fv_qcode', 'ASC')
            ->get();

        if (count($data) >= 1) {
            return response()->json([
                'status' => 200,
                'error' => false,
                'data' => $data
            ]);
        }

        return response()->json([
            'status' => 200,
            'error' => true,
            'message' => 'Ooops, Data tidak ditemukan nih'
        ]);
    }
}
