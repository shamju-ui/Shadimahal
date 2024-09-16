<?php

namespace App\Http\Controllers\Admin;

use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use App\Models\HoleBooking;
use App\Models\BookingPayment as Amount;
use App\Models\BookingDateTime as Booking;
use App\Models\Cancellation as Cancel;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DateTime;
use DB;
class HomeController
{
    public function index()
    {
        $years = range(date('Y')+2, date('Y') - 10);
        return view('home', compact('years'));
    }
    
    public function getData(Request $request)
    {
        $year = $request->input('year', date('Y'));
    
        // Fetch total bookings data from HoleBooking
        // $totalBookings = HoleBooking::whereYear('created_at', $year)->get();
        // $totalCount = $totalBookings->count();
        // $totalAmount = $totalBookings->sum('total_amount');
        // $totalDiscount = $totalBookings->sum('discount'); 
        // $totalReceived = Amount::whereYear('created_at', $year)->sum('amount');
        // $totalOutstanding = $totalAmount - $totalReceived;
         // Replace this with the desired year

// Retrieve HoleBooking records based on the year from the booking_date_times table
$totalBookings = HoleBooking::whereHas('bookingDateTimes', function ($query) use ($year) {
    $query->whereYear('booked_date', $year);
})->get();

$totalCount = $totalBookings->count();
$totalAmount = $totalBookings->sum('total_amount');
$bookingIds = $totalBookings->pluck('id');
$totalDiscount = $totalBookings->sum('discount');
//$totalReceived = Amount::whereYear('created_at', $year)->sum('amount');
$totalReceived = Amount::whereIn('booking_id', $bookingIds)->sum('amount');
$totalOutstanding = $totalAmount - $totalReceived;
    
        // Fetch canceled bookings data
        // $canceledBookings = HoleBooking::onlyTrashed()->whereYear('created_at', $year)->get();
        // $canceledCount = $canceledBookings->count();
        // $canceledAmount = Cancel::whereIn('hall_id', $canceledBookings->pluck('id'))->sum('amount');

        $canceledBookings = HoleBooking::onlyTrashed()->whereHas('bookingDateTimes', function ($query) use ($year) {
            $query->onlyTrashed()->whereYear('booked_date', $year);
        })->get();

        $canceledCount = $canceledBookings->count();
        $canceledAmount = Cancel::whereIn('hall_id', $canceledBookings->pluck('id'))->sum('amount');
    
        // Fetch monthly revenue data
        $monthlyRevenue = Amount::select(DB::raw('MONTH(date_1) as month, SUM(amount) as total_received'))
            ->whereYear('date_1', $year)
            ->groupBy('month')
            ->get()
            ->keyBy('month');
    
        $refundProcessed = Cancel::select(DB::raw('MONTH(created_at) as month, SUM(amount) as refund_processed'))
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->get()
            ->keyBy('month');
    
        return response()->json([
            'year' => $year,
            'totalBookings' => [
                'count' => $totalCount,
                'amount' => $totalAmount,
                'discount' => $totalDiscount,
                'received' => $totalReceived,
                'outstanding' => $totalOutstanding,
            ],
            'cancellations' => [
                'count' => $canceledCount,
                'refund' => $canceledAmount,
                'retained' => $totalReceived - $canceledAmount,
            ],
            'monthlyRevenue' => $monthlyRevenue,
            'refundProcessed' => $refundProcessed,
        ]);
    }
    



    // public function index(Request $request)
    // {
    //     $years = range(date('Y'), date('Y') - 10);
    //     return view('home', compact('years'));
    // }
    // public function getData(Request $request)
    // {
    //     $year = $request->input('year', date('Y'));

    //     // Fetch total bookings data from HoleBooking
    //     $totalBookings = HoleBooking::whereYear('created_at', $year)->get();
    //     $totalCount = $totalBookings->count();
    //     $totalAmount = $totalBookings->sum('total_amount');
    //     $totalDiscount = $totalBookings->sum('discount');
    //     $totalReceived = Amount::whereYear('created_at', $year)->sum('amount');
    //     $totalOutstanding = $totalAmount - $totalReceived;

    //     // Fetch bookings by time slot from Booking
    //     $amBookings = Booking::whereYear('booked_date', $year)->where('time_slot', 'AM')->get();
    //     $pmBookings = Booking::whereYear('booked_date', $year)->where('time_slot', 'PM')->get();
    //     $allDayBookings = Booking::whereYear('booked_date', $year)->where('time_slot', 'All day')->get();

    //     $amCount = $amBookings->count();
    //     $pmCount = $pmBookings->count();
    //     $allDayCount = $allDayBookings->count();

    //     // Fetch total amounts for each time slot from HoleBooking
    //     $amTotal = HoleBooking::whereIn('id', $amBookings->pluck('hall_booking_id'))->sum('total_amount');
    //     $pmTotal = HoleBooking::whereIn('id', $pmBookings->pluck('hall_booking_id'))->sum('total_amount');

    //     $amDiscount = HoleBooking::whereIn('id', $amBookings->pluck('hall_booking_id'))->sum('discount');
    //     $pmDiscount = HoleBooking::whereIn('id', $pmBookings->pluck('hall_booking_id'))->sum('discount');
    //     $allDayTotal = HoleBooking::whereIn('id', $allDayBookings->pluck('hole_booking_id'))->sum('total_amount');

    //     $amReceived = Amount::whereYear('created_at', $year)->whereIn('booking_id', $amBookings->pluck('hall_booking_id'))->sum('amount');
    //     $pmReceived = Amount::whereYear('created_at', $year)->whereIn('booking_id', $pmBookings->pluck('hall_booking_id'))->sum('amount');
    //     $allDayReceived = Amount::whereYear('created_at', $year)->whereIn('booking_id', $allDayBookings->pluck('id'))->sum('amount');

    //     // Fetch canceled bookings by time slot from Booking
    //     $canceledBookings = HoleBooking::whereYear('created_at', $year)->onlyTrashed()->get();
    //     //->whereNotNull('deleted_at')->get();
    //     $canceledCount = $canceledBookings->count();
       
    //     $canceledAmount = Cancel::whereIn('hall_id', $canceledBookings->pluck('id'))->sum('amount');

    //     // Fetch bookings by month from Booking
    //     $bookingsByMonth = Booking::selectRaw('MONTH(booked_date) as month, COUNT(*) as count')
    //         ->whereYear('booked_date', $year)
    //         ->groupBy('month')
    //         ->get();

    //     $bookingsByMonthAmount = HoleBooking::selectRaw('MONTH(created_at) as month, SUM(total_amount) as total_amount')
    //         ->whereYear('created_at', $year)
    //         ->groupBy('month')
    //         ->get()
    //         ->keyBy('month');

    //     $bookingsByMonthReceived = Amount::selectRaw('MONTH(date_1) as month, SUM(amount) as total_amount')
    //         ->whereYear('date_1', $year)
    //         ->groupBy('month')
    //         ->get()
    //         ->keyBy('month');

    //     return response()->json([
    //         'totalCount' => $totalCount,
    //         'totalAmount' => $totalAmount,
    //         'totalReceived' => $totalReceived,
    //         'totalDiscount' => $totalDiscount,
    //         'amDiscount'=> $amDiscount,
    //         'pmDiscount'=> $pmDiscount,
    //         'totalOutstanding' => $totalOutstanding,
    //         'amCount' => $amCount,
    //         'pmCount' => $pmCount,
    //         'allDayCount' => $allDayCount,
    //         'amTotal' => $amTotal,
    //         'pmTotal' => $pmTotal,
    //         'allDayTotal' => $allDayTotal,
    //         'amReceived' => $amReceived,
    //         'pmReceived' => $pmReceived,
    //         'allDayReceived' => $allDayReceived,
    //         'bookingsByMonth' => $bookingsByMonth,
    //         'bookingsByMonthAmount' => $bookingsByMonthAmount,
    //         'bookingsByMonthReceived' => $bookingsByMonthReceived,
    //         'canceledCount' => $canceledCount,
    //         'canceledAmount' => $canceledAmount,
    //     ]);
    // }
}

    


