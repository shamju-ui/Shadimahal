<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyBookingPaymentRequest;
use App\Http\Requests\StoreBookingPaymentRequest;
use App\Http\Requests\UpdateBookingPaymentRequest;
use App\Models\BookingPayment;
use App\Models\HoleBooking;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BookingPaymentController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('booking_payment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bookingPayments = BookingPayment::with(['booking'])->get();

        return view('admin.bookingPayments.index', compact('bookingPayments'));
    }

    public function create()
    {
        abort_if(Gate::denies('booking_payment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bookings = HoleBooking::pluck('date', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.bookingPayments.create', compact('bookings'));
    }

    public function store(StoreBookingPaymentRequest $request)
    {
        $bookingPayment = BookingPayment::create($request->all());

        return redirect()->route('admin.booking-payments.index');
    }

    public function edit(BookingPayment $bookingPayment)
    {
        abort_if(Gate::denies('booking_payment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bookings = HoleBooking::pluck('date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $bookingPayment->load('booking');

        return view('admin.bookingPayments.edit', compact('bookingPayment', 'bookings'));
    }

    public function update(UpdateBookingPaymentRequest $request, BookingPayment $bookingPayment)
    {
        $bookingPayment->update($request->all());

        return redirect()->route('admin.booking-payments.index');
    }

    public function show(BookingPayment $bookingPayment)
    {
        abort_if(Gate::denies('booking_payment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bookingPayment->load('booking');

        return view('admin.bookingPayments.show', compact('bookingPayment'));
    }

    public function destroy(BookingPayment $bookingPayment)
    {
        abort_if(Gate::denies('booking_payment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bookingPayment->delete();

        return back();
    }

    public function massDestroy(MassDestroyBookingPaymentRequest $request)
    {
        $bookingPayments = BookingPayment::find(request('ids'));

        foreach ($bookingPayments as $bookingPayment) {
            $bookingPayment->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
