<?php

namespace App\Http\Controllers\WebAdmin;

use App\Http\Controllers\Controller;
use App\Models\NewsLetter;
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
        $data = NewsLetter::orderBy('fd_releasedate', 'DESC')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function addNewsLetter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'releasedate' => 'required|date',
            'writer' => 'required'
        ]);

        if ($validator) {
            try {
                NewsLetter::create([
                    'fv_title' => $request->title,
                    'ft_description' => $request->description,
                    'fd_releasedate' => $request->releasedate,
                    'fv_writer' => $request->writer,
                    'ft_linkresource' => $request->linkrespurce == null ? null : $request->linkresource,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => "Data Berhasil Ditambahkan"
                ]);
            } catch (Error $err) {
                return response()->json([
                    'status' => 300,
                    'message' => "Ooopss, error nih :" + $err->getMessage()
                ]);
            }
        }
    }

    public function deleteNewsLetter($newsLetterId)
    {
        try {
            NewsLetter::where('fc_newsletterid', $newsLetterId)
                ->delete();

            return response()->json([
                'status' => 200,
                'message' => "Data Berhasil Dihapus"
            ]);
        } catch (Error $err) {
            return response()->json([
                'status' => 300,
                'message' => "Ooopss, error nih :" + $err->getMessage()
            ]);
        }
    }
}
