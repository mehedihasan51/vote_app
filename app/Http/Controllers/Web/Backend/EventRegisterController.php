<?php

namespace App\Http\Controllers\Web\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EventRegister;
use Exception;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;


class EventRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $event_id)
    {
        if ($request->ajax()) {
            $data = EventRegister::with('event')->where('event_id', $event_id)->orderBy('id', 'desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($data) {
                    return Str::limit($data->name, 20);
                })
                ->addColumn('status', function ($data) {
                    $backgroundColor = $data->status == "accept" ? '#4CAF50' : '#ccc';
                    $sliderTranslateX = $data->status == "accept" ? '26px' : '2px';
                    $sliderStyles = "position: absolute; top: 2px; left: 2px; width: 20px; height: 20px; background-color: white; border-radius: 50%; transition: transform 0.3s ease; transform: translateX($sliderTranslateX);";

                    $status = '<div class="form-check form-switch" style="margin-left:40px; position: relative; width: 50px; height: 24px; background-color: ' . $backgroundColor . '; border-radius: 12px; transition: background-color 0.3s ease; cursor: pointer;">';
                    $status .= '<input onclick="showStatusChangeAlert(' . $data->id . ')" type="checkbox" class="form-check-input" id="customSwitch' . $data->id . '" getAreaid="' . $data->id . '" name="status" style="position: absolute; width: 100%; height: 100%; opacity: 0; z-index: 2; cursor: pointer;">';
                    $status .= '<span style="' . $sliderStyles . '"></span>';
                    $status .= '<label for="customSwitch' . $data->id . '" class="form-check-label" style="margin-left: 10px;"></label>';
                    $status .= '</div>';

                    return $status;
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">

                                <a href="#" type="button" onclick="goToEdit(' . $data->id . ')" class="btn btn-primary fs-14 text-white delete-icn" title="Delete">
                                    <i class="fe fe-edit"></i>
                                </a>

                                <a href="#" type="button" onclick="goToOpen(' . $data->id . ')" class="btn btn-success fs-14 text-white delete-icn" title="Delete">
                                    <i class="fe fe-eye"></i>
                                </a>

                                <a href="#" type="button" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white delete-icn" title="Delete">
                                    <i class="fe fe-trash"></i>
                                </a>

                            </div>';
                })
                ->rawColumns(['name', 'status', 'action'])
                ->make();
        }
        return view("backend.layouts.event.register.index", compact('event_id'));
    }
    
    public function create($event_id)
    {
        return view('backend.layouts.event.register.create', compact('event_id'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_id'         => 'required|exists:events,id',
            'name'             => 'required|string|max:250',
            'email'            => 'required|string|max:250',
            'phone'            => 'required|string|max:250',
            'occupation'       => 'required|string|max:250',
            'message'          => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $data = $validator->validated();

            $event_register = new EventRegister();

            $event_register->event_id = $data['event_id'];
            $event_register->name = $data['name'];
            $event_register->email = $data['email'];
            $event_register->phone = $data['phone'];
            $event_register->occupation = $data['occupation'];
            $event_register->message = $data['message'] ?? null;
            $event_register->save();

            session()->put('t-success', 'Event register created successfully');
        } catch (Exception $e) {

            session()->put('t-error', $e->getMessage());
        }

        return redirect()->route('admin.event.register.index', $data['event_id'])->with('t-success', 'Event register created successfully');
    }

    public function show($id)
    {
        $data = EventRegister::with('event')->findOrFail($id);
        return view('backend.layouts.event.register.show', compact('data'));
    }

    public function edit($id)
    {
        $data = EventRegister::with('event')->findOrFail($id);
        return view('backend.layouts.event.register.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'             => 'required|string|max:250',
            'email'            => 'required|string|max:250',
            'phone'            => 'required|string|max:250',
            'occupation'       => 'required|string|max:250',
            'message'          => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $data = $validator->validated();

            $event_register = EventRegister::findOrFail($id);

            $event_register->name = $data['name'];
            $event_register->email = $data['email'];
            $event_register->phone = $data['phone'];
            $event_register->occupation = $data['occupation'];
            $event_register->message = $data['message'] ?? null;
            $event_register->save();

            session()->put('t-success', 'Event register updated successfully');
        } catch (Exception $e) {

            session()->put('t-error', $e->getMessage());
        }

        return redirect()->route('admin.event.register.edit', $event_register->id)->with('t-success', 'Event register updated successfully');
    }

    public function destroy(string $id)
    {
        try {

            $data = EventRegister::findOrFail($id);

            $data->delete();
            return response()->json([
                'status' => 't-success',
                'message' => 'Your action was successful!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 't-error',
                'message' => 'Your action was successful!'
            ]);
        }
    }

    public function status(int $id): JsonResponse
    {
        $data = EventRegister::findOrFail($id);
        if (!$data) {
            return response()->json([
                'status' => 't-error',
                'message' => 'Item not found.',
            ]);
        }
        $data->status = $data->status === 'accept' ? 'reject' : 'accept';
        $data->save();
        return response()->json([
            'status' => 't-success',
            'message' => 'Your action was successful!',
        ]);
    }
}
