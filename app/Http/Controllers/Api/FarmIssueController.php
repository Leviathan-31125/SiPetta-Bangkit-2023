<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FarmIssue;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FarmIssueController extends Controller
{
    public function getAllFarmIssue()
    {
        $data = FarmIssue::with('user', 'expertise')
            ->orderBy('fd_issuereleasedate', 'DESC')
            ->get();

        if (!$data) {
            return response()->json([
                'status' => 300,
                'error' => true,
                'message' => "Ooopss, error nih. Hayoo kenapa ? .."
            ]);
        }

        return response()->json([
            'status' => 200,
            'error' => false,
            'message' => 'Hai-hai, kamu berhasil get data',
            'data' => count($data) == 0 ? "Data sedang kosong nih, skuy buat postingan" : $data,
        ]);
    }

    public function getDetailFarmIssue($id)
    {
        $FarmIssueID = $id;

        $data = FarmIssue::with('user', 'expertise')
            ->where('fc_issueid', $id)
            ->first();

        if (!empty($data)) {
            return response()->json([
                'status' => 200,
                'error' => false,
                'message' => 'Hai-hai, kamu berhasil get data',
                'data' => $data,
            ]);
        }

        return response()->json([
            'status' => 300,
            'error' => true,
            'message' => "Ooopss, error nih. Sepertinya FarmIssue tidak ditemukan"
        ]);
    }

    public function addFarmIssue(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'title' => 'require',
            'description' => 'required',
            'agricode' => 'required',
            'userid' => 'required',
            'releasedate' => 'required',
            'useranswer' => 'required'
        ]);

        if ($validated) {
            try {
                $insertData = FarmIssue::create([
                    'fc_issuetitle' => $request->title,
                    'fc_issuedescription' => $request->description,
                    'fv_agricode' => $request->agricode,
                    'fc_userid' => $request->userid,
                    'fd_issuereleasedate' => $request->releasedate,
                    'ft_useranswer' => $request->useranswer
                ]);

                if ($insertData) {
                    return response()->json([
                        'status' => 200,
                        'error' => false,
                        'message' => "Berhasil Insert FarmIssue"
                    ]);
                }

                return response()->json([
                    'status' => 300,
                    'error' => true,
                    'message' => "Ooopss, error nih. FarmIssue gagal diinsert"
                ]);
            } catch (Error $err) {
                return response()->json([
                    'status' => 300,
                    'error' => true,
                    'message' => "Ooopss, error nih. " + $err->getMessage()
                ]);
            }
        }
    }

    public function deleteFarmIssue($id)
    {
        $deletedData = FarmIssue::where('fc_issueid', $id)->first();

        if (!$this->repliedStatus($id)) {
            $deletedData->delete();
            return response()->json([
                'status' => 200,
                'error' => false,
                'message' => "Yeay, Berhasil hapus FarmIssue"
            ]);
        }

        return response()->json([
            'status' => 300,
            'error' => true,
            'message' => "Ooopss, error nih. FarmIssue gagal dihapus karena sudah di reply."
        ]);
    }

    public function updateFarmIssue($id, Request $request)
    {
        $validated = Validator::make($request->all(), [
            'title' => 'require',
            'description' => 'required',
        ]);

        if ($this->repliedStatus($id)) {
            return response()->json([
                'status' => 300,
                'error' => true,
                'message' => "Ooopss, error nih. FarmIssue gagal diupdate karena sudah di reply."
            ]);
        }

        if ($validated) {
            try {
                $data = FarmIssue::find($id);

                $data->update([
                    'fc_issuetitle' => $request->title,
                    'fc_issuedescription' => $request->description
                ]);

                if ($data) {
                    return response()->json([
                        'status' => 200,
                        'error' => false,
                        'message' => "Yeay, Berhasil update FarmIssue"
                    ]);
                }

                return response()->json([
                    'status' => 300,
                    'error' => true,
                    'message' => "Ooopss, error nih. FarmIssue gagal diupdate."
                ]);
            } catch (Error $err) {
                return response()->json([
                    'status' => 300,
                    'error' => true,
                    'message' => "Ooopss, error nih. " + $err->getMessage()
                ]);
            }
        }
    }

    public function replyFarmIssue($id, Request $request)
    {
        $validated = Validator::make($request->all(), [
            'replierid' => 'required'
        ]);

        if ($this->repliedStatus($id)) {
            return response()->json([
                'status' => 300,
                'error' => true,
                'message' => "Ooopss, error nih. FarmIssue gagal direply karena sudah di reply."
            ]);
        }

        if ($validated) {
            try {
                $dataFarmIssue = FarmIssue::find($id);
                $dataFarmIssue->update([
                    'fc_replierid' => $request->replierid,
                    'fc_repliedstatus' => 'T'
                ]);

                return response()->json([
                    'status' => 200,
                    'error' => false,
                    'message' => "Yeay, Berhasil reply FarmIssue"
                ]);
            } catch (Error $err) {
                return response()->json([
                    'status' => 300,
                    'error' => true,
                    'message' => "Ooopss, error nih. " + $err->getMessage()
                ]);
            }
        }
    }


    private function repliedStatus($id)
    {
        $FarmIssueData = FarmIssue::find($id);

        if ($FarmIssueData->fc_repliedstatus == 'T') return true;
        return false;
    }
}
