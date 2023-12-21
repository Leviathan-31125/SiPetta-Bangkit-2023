<?php

namespace App\Http\Controllers\WebAdmin;

use App\Http\Controllers\Controller;
use App\Models\NewsLetter;
use App\Models\TRXType;
use Carbon\Carbon;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class NewsLetterController extends Controller
{
    public function index()
    {
        return view('apps.masternewsletter');
    }

    public function getAllNewsLetter()
    {
        $data = NewsLetter::with('category')->orderBy('fd_releasedate', 'DESC')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function getDetailNewsLetter($id)
    {
        $newId = base64_decode($id);
        $data = NewsLetter::with('category')->where('fc_newsletterid', $newId)->first();

        return response()->json([
            'status' => 200,
            'data' => $data
        ]);
    }

    public function addNewsLetter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fv_title' => 'required',
            'ft_description' => 'required',
            'fd_releasedate' => 'required|date',
            'fv_writer' => 'required',
            'fv_category' => 'required'
        ]);

        if ($validator) {
            try {
                $statusUpdate = $request->status_update;
                // return dd($request);
                if ($statusUpdate == "TRUE") {
                    $id = $request->fc_newsletterid;
                    NewsLetter::where('fc_newsletterid', $id)->update([
                        'fv_title' => $request->fv_title,
                        'ft_description' => $request->ft_description,
                        'fv_category' => $request->fv_category,
                        'fd_releasedate' => $request->fd_releasedate,
                        'fv_writer' => $request->fv_writer,
                        'ft_linkresource' => $request->ft_linkresource == null ? null : $request->ft_linkresource,
                        'updated_at' => Carbon::now(),
                        'updated_by' => Auth::user()->id
                    ]);

                    return redirect()->back()->withSuccess([
                        'status' => 'Yeay Data Berhasil Diupdate Cuy!',
                        'message' => 'Pastikan data sudah benar yok.'
                    ]);
                }

                NewsLetter::create([
                    'fv_title' => $request->fv_title,
                    'ft_description' => $request->ft_description,
                    'fv_category' => $request->fv_category,
                    'fd_releasedate' => $request->fd_releasedate,
                    'fv_writer' => $request->fv_writer,
                    'ft_linkresource' => $request->ft_linkresource == null ? null : $request->ft_linkresource,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id
                ]);

                return redirect()->back()->withSuccess([
                    'status' => 'Yeay Success Cuy!',
                    'message' => 'News Letter baru berhasil ditambahkan, skuy lagi.'
                ]);

                // return response()->json([
                //     'status' => 200,
                //     'message' => "Data Berhasil Ditambahkan"
                // ]);
            } catch (Error $err) {
                return response()->json([
                    'status' => 300,
                    'message' => "Ooopss, error nih :" + $err->getMessage()
                ]);
            }
        }
    }

    public function deleteNewsLetter($id)
    {
        $newsLetterId = base64_decode($id);
        try {
            NewsLetter::where('fc_newsletterid', $newsLetterId)
                ->delete();

            return response()->json([
                'status' => 200,
                'message' => "Data berhasil dihapus",
                'data' => [
                    'title' => "Yeay data News Letter berhasil dihapus!",
                    'message' => "Data telah dihapus dan tidak dapat dirollback lagi."
                ]
            ]);
        } catch (Error $err) {
            return response()->json([
                'status' => 300,
                'message' => "Ooopss, error nih :" + $err->getMessage()
            ]);
        }
    }

    public function getAllCategory()
    {
        try {
            $data = TRXType::where('fc_trx', 'NEWSCATEGORY')->get();

            return response()->json([
                'status' => 200,
                'data' => $data
            ]);
        } catch (Error $err) {
            return response()->json([
                'status' => 300,
                'message' => 'Wah ada error nih, ' + $err
            ]);
        }
    }

    public function updateNewsLetter($id, Request $request)
    {
        $newId = base64_decode($id);

        try {
            NewsLetter::where('fc_newsletterid', $newId)->update([
                'fv_title' => $request->fv_title,
                'ft_description' => $request->ft_description,
                'fv_category' => $request->fv_category,
                'fd_releasedate' => $request->fd_releasedate,
                'fv_writer' => $request->fv_writer,
                'ft_linkresource' => $request->ft_linkresource == null ? null : $request->ft_linkresource,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id
            ]);

            return redirect()->back()->withSuccess([
                'status' => 'Yeay Success Cuy!',
                'message' => 'News Letter baru berhasil ditambahkan, skuy lagi.'
            ]);

            // return response()->json([
            //     'status' => 200,
            //     'message' => "Data Berhasil Ditambahkan"
            // ]);
        } catch (Error $err) {
            return response()->json([
                'status' => 300,
                'message' => "Ooopss, error nih :" + $err->getMessage()
            ]);
        }
    }
}
