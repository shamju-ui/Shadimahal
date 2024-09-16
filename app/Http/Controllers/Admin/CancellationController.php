<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cancellation;
use App\Models\HoleBooking;
use Illuminate\Http\Request;
use DataTables;

class CancellationController extends Controller
{
    public function index()
    {
        $cancellations = Cancellation::with([
            'hall' => function ($query) {
                $query->with(['bookingDateTimes' => function ($subQuery) {
                    $subQuery->withTrashed(); // Include soft-deleted bookingDateTimes
                }])->withTrashed(); // Include soft-deleted halls
            },
            'user'
        ])->get();
       
        return view('admin.cancellations.index', compact('cancellations'));
        // return view('admin.cancellations.index');
    }

    public function getData(Request $request)
    {
        $cancellations = Cancellation::with(['hall', 'user'])->get();
        return view('admin.cancellations.index', compact('cancellations'));
    }
}
