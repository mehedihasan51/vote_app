<?php

namespace App\Http\Controllers\Web\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Apply;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;


class ApplyController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Apply::orderBy('id', 'desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user', function ($data) {
                    return "<a href='" . route('admin.users.show', $data->user_id) . "'>" . $data->user->name . "</a>";
                })
                ->addColumn('status', function ($data) {
                    $backgroundColor = $data->status == "approved" ? '#4CAF50' : '#ccc';
                    $sliderTranslateX = $data->status == "approved" ? '26px' : '2px';
                    $sliderStyles = "position: absolute; top: 2px; left: 2px; width: 20px; height: 20px; background-color: white; border-radius: 50%; transition: transform 0.3s ease; transform: translateX($sliderTranslateX);";

                    $status = '<div class="form-check form-switch" style="margin-left:40px; position: relative; width: 50px; height: 24px; background-color: ' . $backgroundColor . '; border-radius: 12px; transition: background-color 0.3s ease; cursor: pointer;">';
                    $status .= '<input onclick="showStatusChangeAlert(' . $data->id . ')" type="checkbox" class="form-check-input" id="customSwitch' . $data->id . '" getAreaid="' . $data->id . '" name="status" style="position: absolute; width: 100%; height: 100%; opacity: 0; z-index: 2; cursor: pointer;">';
                    $status .= '<span style="' . $sliderStyles . '"></span>';
                    $status .= '<label for="customSwitch' . $data->id . '" class="form-check-label" style="margin-left: 10px;"></label>';
                    $status .= '</div>';

                    return $status;
                })
                ->rawColumns(['user', 'status'])
                ->make();
        }
        return view("backend.layouts.apply.index");
    }

    public function status(int $id): JsonResponse
    {
        $data = Apply::findOrFail($id);
        if (!$data) {
            return response()->json([
                'status' => 't-error',
                'message' => 'Item not found.',
            ]);
        }
        $data->status = $data->status == 'approved' || $data->status == 'pending' ? 'rejected' : 'approved';
        $data->save();
        return response()->json([
            'status' => 't-success',
            'message' => 'Your action was successful!',
        ]);
    }

}
