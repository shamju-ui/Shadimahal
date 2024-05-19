<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyNewBookingRequest;
use App\Http\Requests\StoreNewBookingRequest;
use App\Http\Requests\UpdateNewBookingRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NewBookingController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('new_booking_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.newBookings.index');
    }

    public function create()
    {
        abort_if(Gate::denies('new_booking_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.newBookings.create');
    }

    public function store(StoreNewBookingRequest $request)
    {
        $newBooking = NewBooking::create($request->all());

        return redirect()->route('admin.new-bookings.index');
    }

    public function edit(NewBooking $newBooking)
    {
        abort_if(Gate::denies('new_booking_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.newBookings.edit', compact('newBooking'));
    }

    public function update(UpdateNewBookingRequest $request, NewBooking $newBooking)
    {
        $newBooking->update($request->all());

        return redirect()->route('admin.new-bookings.index');
    }

    public function show(NewBooking $newBooking)
    {
        abort_if(Gate::denies('new_booking_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.newBookings.show', compact('newBooking'));
    }

    public function destroy(NewBooking $newBooking)
    {
        abort_if(Gate::denies('new_booking_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $newBooking->delete();

        return back();
    }

    public function massDestroy(MassDestroyNewBookingRequest $request)
    {
        $newBookings = NewBooking::find(request('ids'));

        foreach ($newBookings as $newBooking) {
            $newBooking->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
