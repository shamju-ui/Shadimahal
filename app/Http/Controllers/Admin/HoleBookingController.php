<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyHoleBookingRequest;
use App\Http\Requests\StoreHoleBookingRequest;
use App\Http\Requests\UpdateHoleBookingRequest;
use App\Models\HoleBooking;
use App\Models\BooingDateTime;
use App\Models\BookingPayment;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DateTime;
use Session;
use Illuminate\Support\Facades\Validator;
class HoleBookingController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('hole_booking_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $holeBookings = HoleBooking::all();

        return view('admin.holeBookings.index', compact('holeBookings'));
    }

    public function create()
    {
        abort_if(Gate::denies('hole_booking_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.holeBookings.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'mobile_1' => 'required|string',
            'total_amount' => 'required|numeric',
            'elactric_charges' => 'required|numeric',
            'advance' => 'required|numeric',
            'booking_details' => 'required',
        ]);
       
        // $request->validate
       $holeBooking = HoleBooking::create($request->all());
        $bookingArray = explode(',', $request['booking_details']);
     
        foreach ($bookingArray as $booking) {
            [$rawDate, $slot] = explode('-', $booking);
        //    $date = DateTime::createFromFormat('d/m/Y', $rawDate)->format('Y-m-d');
            
            $booking = BooingDateTime::create([
                'booked_date' => $rawDate,
                'time_slot' => $slot,
                'hall_booking_id'=>$holeBooking->id
            ]);
           
        }

        if($request->has('advance'))
          $bookingPayment = BookingPayment::create([
            'amount_type' => 'advance',
            'amount' => $request->advance,
            'booking_id'=>$holeBooking->id
          ]);
          Session::flash('success', 'Booking created successfully!');
          return redirect()->route('admin.hole-bookings.index');
    }
    public function search(Request $request)
    {
        // Validate the request parameters
    $request->validate([
        'fromDate' => 'required|date',
        'toDate' => 'required|date|after_or_equal:fromDate',
    ]);

    // Retrieve the fromDate and toDate from the request
    $fromDate = $request->input('fromDate');
    $toDate = $request->input('toDate');

    // Search for bookings between the specified dates
    $bookings = BooingDateTime::whereBetween('booked_date', [$fromDate, $toDate])->get();

    // Return the search results as JSON
    return response()->json($bookings);
    }
    public function edit(HoleBooking $holeBooking)
    {
        abort_if(Gate::denies('hole_booking_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.holeBookings.edit', compact('holeBooking'));
    }

    public function update(UpdateHoleBookingRequest $request, HoleBooking $holeBooking)
    {
        $holeBooking->update($request->all());

        return redirect()->route('admin.hole-bookings.index');
    }

    public function show(HoleBooking $holeBooking)
    {
        abort_if(Gate::denies('hole_booking_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $holeBooking->load('bookingBookingPayments');

        return view('admin.holeBookings.show', compact('holeBooking'));
    }

    public function destroy(HoleBooking $holeBooking)
    {
        abort_if(Gate::denies('hole_booking_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $holeBooking->delete();

        return back();
    }

    public function massDestroy(MassDestroyHoleBookingRequest $request)
    {
        $holeBookings = HoleBooking::find(request('ids'));

        foreach ($holeBookings as $holeBooking) {
            $holeBooking->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
