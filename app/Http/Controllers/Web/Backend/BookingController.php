<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Booking::with(['user', 'product', 'package'])->orderBy('id', 'desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('title', function ($data) {
                    $ttitle = Str::limit($data->product->title, 20);
                    return "<a href='" . route('admin.product.show', $data->product->id) . "'>" . $ttitle . "</a>";
                })
                ->addColumn('customer', function ($data) {
                    return "<a href='" . route('admin.users.show', $data->user->id) . "'>" . $data->user->name . "</a>";
                })
                ->addColumn('thumb', function ($data) {
                    if ($data->product->thumb) {
                        $url = asset($data->product->thumb);
                        return '<img src="' . $url . '" alt="thumb" width="50px" height="50px" style="margin-left:20px;">';
                    } else {
                        return '<img src="' . asset('default/logo.png') . '" alt="image" width="50px" height="50px" style="margin-left:20px;">';
                    }
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">

                                <a href="#" type="button" onclick="goToOpen(' . $data->id . ')" class="btn btn-success fs-14 text-white delete-icn" title="Delete">
                                    <i class="fe fe-eye"></i>
                                </a>

                                <a href="#" type="button" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white delete-icn" title="Delete">
                                    <i class="fe fe-trash"></i>
                                </a>
                            </div>';
                })
                ->rawColumns(['title', 'customer', 'thumb' ,'action'])
                ->make();
        }
        return view("backend.layouts.product.booking.index");
    }

    public function show($id)
    {
        $booking = Booking::with(['user', 'product', 'package'])->find($id);
        $transactions = Transaction::whereJsonContains('metadata->booking_id', $booking->id)->get();
        return view("backend.layouts.product.booking.show", compact('booking', 'transactions'));
    }
}
