<?php

namespace App\Http\Controllers\WebAdmin;

use App\Http\Controllers\Controller;
use App\Models\AgriFarm;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AgriFarmController extends Controller
{
    public function index()
    {
        return view('apps.masteragrifarm');
    }

    public function getAllAgriFarm()
    {
        try {
            $data = AgriFarm::orderBy('fv_agricode', 'ASC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        } catch (Error $err) {
            return response()->json([
                'status' => '300',
                'message' => 'Wah ada error nih, kenapa hayoo? ' . $err->getMessage()
            ]);
        }
    }

    public function getDetailAgriFarm($id)
    {
        $fv_agricode = base64_decode($id);

        $data = AgriFarm::where('fv_agricode', $fv_agricode)->first();

        if (empty($data)) {
            return response()->json([
                'status' => 300,
                'message' => 'Data tidak dapat ditemukan'
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Data berhasil didapatkan',
            'data' => $data
        ]);
    }

    public function addAgriFarm(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'fv_agriname' => 'required'
        ]);

        if ($validated) {
            try {
                $successData = [
                    'title' => '',
                    'message' => ''
                ];

                if ($request->status_update == 'TRUE') {
                    $dataUpdate = AgriFarm::find($request->fv_agricode);

                    if (!empty($dataUpdate)) {
                        $successData['title'] = 'Yeay Data berhasil diupdate! ';
                        $successData['message'] = $dataUpdate->fv_agriname . ' telah diupdate menjadi ' . $request->fv_agriname;
                        $dataUpdate->update([
                            'fv_agriname' => $request->fv_agriname,
                            'updated_by' => Auth::user()->name
                        ]);

                        return redirect()->back()->withSuccess($successData);
                    }
                }

                AgriFarm::create([
                    'fv_agriname' => $request->fv_agriname,
                    'created_by' => Auth::user()->name
                ]);

                $successData['title'] = 'Yeay, Urban Agri berhasil ditambahkan! ';
                $successData['message'] = 'Selamat datang di SiPetta ' . $request->fv_agriname;
                return redirect()->back()->withSuccess($successData);
            } catch (Error $err) {
                return response()->json([
                    'status' => 300,
                    'message' => 'Wah ada error nih, kenapa hayoo !! ' . $err->getMessage()
                ]);
            }
        }
    }

    public function deleteAgriFarm($id)
    {
        $fv_agricode = base64_decode($id);
        $delete = AgriFarm::find($fv_agricode);
        if (!empty($delete)) {
            $delete->delete();
            $data = [
                'title' => 'Yeay agri farm berhasil dihapus!! ',
                'message' => 'Selamat tinggal ' . $delete->fv_agriname
            ];

            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil dihapus',
                'data' => $data
            ]);
        }

        return response()->json([
            'status' => '300',
            'message' => 'Wah ada error nih, kenapa hayoo? Data gagal ditemukan'
        ]);
    }
}
