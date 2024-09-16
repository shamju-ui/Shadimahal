<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyHoleBookingRequest;
use App\Http\Requests\StoreHoleBookingRequest;
use App\Http\Requests\UpdateHoleBookingRequest;
use App\Models\HoleBooking;
use App\Models\BookingPayment;
use App\Models\BookingDateTime;
use App\Models\Cancellation;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

use DateTime;
use Carbon\Carbon;
use Session;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request as req;
class HoleBookingController extends Controller
{
    // public function index()
    // {
    //     abort_if(Gate::denies('hole_booking_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //     $showAll = req::query('showAll');

    //     if ($showAll) {
    //         $holeBookings = HoleBooking::with(['bookingDateTimes' => function($query) {
    //             $query->orderBy('booked_date', 'asc');
    //         }])->get();
    //     } else {
    //         $holeBookings = HoleBooking::with(['bookingDateTimes' => function($query) {
    //             $query->where('booked_date', '>=', now())->orderBy('booked_date', 'asc');
    //         }])->get();
    //         $holeBookings = $holeBookings->filter(function ($holeBooking) {
    //             return $holeBooking->bookingDateTimes->isNotEmpty();
    //         });
    //     }
       
    //     $holeBookings->each(function($holeBooking) {
    //         $holeBooking->booked_dates = $holeBooking->bookingDateTimes->map(function($bookingDateTime) {
    //             try {
    //                 $bookedDate = Carbon::createFromFormat('d/m/Y', $bookingDateTime->booked_date);
    //             } catch (\Exception $e) {
    //                 \Log::warning("Invalid date format: " . $bookingDateTime->booked_date);
    //                 return 'Invalid date format';
    //             }
    //             return $bookedDate->format('d/m/Y') . ' ' . $bookingDateTime->time_slot;
    //         })->implode(', ');
    
    //         // Set the earliest booked date for sorting
    //         $earliestBookedDate = $holeBooking->bookingDateTimes->map(function($bookingDateTime) {
    //             return Carbon::createFromFormat('d/m/Y', $bookingDateTime->booked_date);
    //         })->sort()->first();
    
    //         $holeBooking->earliest_booked_date = $earliestBookedDate->format('d/m/Y');
    //     });
    
    //     // Sort the collection by the earliest booked date
    //     $holeBookings = $holeBookings->sortBy('earliest_booked_date');
    //     return view('admin.hallBookings.index', compact('holeBookings'));
    // }
    public function index()
    {
        abort_if(Gate::denies('hole_booking_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        $showAll = req::query('showAll', 'false') === 'true';
    
        if ($showAll) {
            $holeBookings = HoleBooking::with(['bookingDateTimes' => function($query) {
                $query->orderBy('booked_date', 'asc');
            }])->get();
        } else {
            $holeBookings = HoleBooking::with(['bookingDateTimes' => function($query) {
                $query->where('booked_date', '>=', now()->subDays(7))->orderBy('booked_date', 'asc');
            }])->get();
    
            // Filter out HoleBooking entries with no valid bookingDateTimes
            $holeBookings = $holeBookings->filter(function ($holeBooking) {
                return $holeBooking->bookingDateTimes->isNotEmpty();
            });
        }
    
        $formats = ['d/m/Y', 'Y-m-d']; // Define the date formats
    
        $holeBookings->each(function($holeBooking) use ($formats) {
            $holeBooking->booked_dates = $holeBooking->bookingDateTimes->map(function($bookingDateTime) use ($formats) {
                $bookedDate = null;
                foreach ($formats as $format) {
                    try {
                        $bookedDate = Carbon::createFromFormat($format, $bookingDateTime->booked_date);
                        break; // Exit the loop if the date is successfully parsed
                    } catch (\Exception $e) {
                        // Continue trying next format
                    }
                }
                if ($bookedDate) {
                    return $bookedDate->format('d/m/Y') . ' ' . $bookingDateTime->time_slot;
                } else {
                    \Log::warning("Invalid date format: " . $bookingDateTime->booked_date);
                    return 'Invalid date format';
                }
            })->implode(', ');
    
            // Set the earliest booked date for sorting
            $earliestBookedDate = $holeBooking->bookingDateTimes->map(function($bookingDateTime) use ($formats) {
                $bookedDate = null;
                foreach ($formats as $format) {
                    try {
                        $bookedDate = Carbon::createFromFormat($format, $bookingDateTime->booked_date);
                        break; // Exit the loop if the date is successfully parsed
                    } catch (\Exception $e) {
                        // Continue trying next format
                    }
                }
                return $bookedDate;
            })->filter()->sort()->first(); // Filter out null dates
    
            $holeBooking->earliest_booked_date = $earliestBookedDate ? $earliestBookedDate->format('d/m/Y') : null;
        });
    
        // Sort the collection by the earliest booked date
        $holeBookings = $holeBookings->sortBy('earliest_booked_date');
    
        return view('admin.hallBookings.index', compact('holeBookings'));
    }
    
    public function create()
    {
        abort_if(Gate::denies('hole_booking_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.hallBookings.create');
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
       
         $bookingArray = explode(',', $request['booking_details']);
         foreach ($bookingArray as $booking) {
            [$rawDate, $slot] = explode('-', $booking);
            $rawDate = trim(preg_replace('/\((.*?)\)/', '', $rawDate));
        
            // Check if a booking with the same date and time slot already exists
            $existingBooking = BookingDateTime::where('booked_date', $rawDate)
                                                ->where('time_slot', $slot)
                                                
                                                ->first();
                                                if($existingBooking)
                                                return back()->with('error', 'Already Booking Exists on Date ' . $rawDate.' and slot '. $slot);
         }
        
         $holeBooking = HoleBooking::create($request->all());
        foreach ($bookingArray as $booking) {
            [$rawDate, $slot] = explode('-', $booking);
            $rawDate = trim(preg_replace('/\((.*?)\)/', '', $rawDate));
            $booking = BookingDateTime::create([
                'booked_date' => $rawDate,
                'time_slot' => $slot,
                'hall_booking_id' => $holeBooking->id
            ]);
        }
         if($request->advance_paid)
          $bookingPayment = BookingPayment::create([
            'amount_type' => 'advance',
            'amount' => $request->advance_paid,
            'booking_id'=>$holeBooking->id,
            'receipt'=> $request->receipt_1,
            'date_1'=> $request->date_1
          ]);
          if($request->balance_amount && $request->balance_amount!=0)
          $bookingPayment = BookingPayment::create([
            'amount_type' => 'balance',
            'amount' => $request->balance_amount,
            'booking_id'=>$holeBooking->id,
            'receipt'=> $request->receipt_2,
            'date_1'=> $request->date_2
          ]);

          DB::table('logs')->insert([
            'level' => 'create',
            'message' => json_encode($request->all()),
            'context' =>  Auth::user()->email,
            'created_at' => now(),
            'updated_at' => now(),
         ]);
          Session::flash('success', 'Booking created successfully!');
          return redirect()->route('admin.hall-bookings.index');
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
    $bookings = BookingDateTime::whereBetween('booked_date', [$fromDate, $toDate])->get();

    // Return the search results as JSON
    return response()->json($bookings);
    }
    public function edit(Request $request, string $holeBooking)
    {
        abort_if(Gate::denies('hole_booking_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $holeBooking = HoleBooking::findOrFail($holeBooking);
        $bookingDateTimes = BookingDateTime::where('hall_booking_id', $holeBooking->id)->get();
        $bookingPayments = BookingPayment::where('booking_id', $holeBooking->id)->orderBy('date_1', 'asc')->get();
        return view('admin.hallBookings.edit', compact('holeBooking', 'bookingDateTimes', 'bookingPayments'));

    }

    public function update(Request $request, HoleBooking $holeBooking)
    {
      
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'mobile_1' => 'required|string',
           
        ]);
      
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $holeBooking = HoleBooking::findOrFail($request->id);
        $holeBooking->update($request->all());
        // DB::update('UPDATE hole_bookings SET name = ?, mobile_1 = ?, mobile_2 = ?, address_line_1 = ?, address_line_2 = ?, event_type = ?, total_amount = ?, elactric_charges = ?, advance = ? WHERE id = ?', [
        //     $request['name'],
        //     $request['mobile_1'],
        //     $request['mobile_2'],
        //     $request['address_line_1'],
        //     $request['address_line_2'],
        //     $request['event_type'],
        //     $request['total_amount'],
        //     $validatedData['elactric_charges'],
        //     $validatedData['advance'],
        //     $id,
        // ]);
        // Update HoleBooking
        // $holeBooking->update($request->only([
        //     'name', 'mobile_1', 'mobile_2', 'address_line_1', 'address_line_2', 'event_type',
        //     'total_amount', 'elactric_charges', 'advance'
        // ]));
    
        // Update BookingDateTime
        $bookingArray = explode(',', $request->booking_details);
        $existingBookingDateTimes = BookingDateTime::where('hall_booking_id', $holeBooking->id)->get();
        $existingBookingDateTimesMap = $existingBookingDateTimes->keyBy('id');
    
        // foreach ($bookingArray as $booking) {
        //     [$rawDate, $slot] = explode('-', $booking);
        //     $rawDate = trim(preg_replace('/\((.*?)\)/', '', $rawDate));
        //     $bookingDateTime = $existingBookingDateTimesMap->where('booked_date', $rawDate)->where('time_slot', $slot)->first();
    
        //     if ($bookingDateTime) {
        //         // Update existing booking date/time
        //         $bookingDateTime->update([
        //             'booked_date' => $rawDate,
        //             'time_slot' => $slot,
        //         ]);
        //     } else {
        //         // Create new booking date/time
        //         BookingDateTime::create([
        //             'booked_date' => $rawDate,
        //             'time_slot' => $slot,
        //             'hall_booking_id' => $holeBooking->id
        //         ]);
        //     }
        // }
    
        // // Remove deleted booking date/times
        // $bookingDetails = collect($bookingArray)->map(function($booking) {
        //     return trim(preg_replace('/\((.*?)\)/', '', explode('-', $booking)[0]));
        // })->toArray();
        // BookingDateTime::where('hall_booking_id', $holeBooking->id)->whereNotIn('booked_date', $bookingDetails)->delete();
    
        // Update BookingPayment
        BookingPayment::where('booking_id', $holeBooking->id)->delete();
        if ($request->advance_paid) {
            BookingPayment::create([
                'amount_type' => 'advance',
                'amount' => $request->advance_paid,
                'booking_id' => $holeBooking->id,
                'receipt' => $request->receipt_1,
                'date_1'=> $request->date_1
            ]);
        }
        if ($request->balance_amount && $request->balance_amount != 0) {
            BookingPayment::create([
                'amount_type' => 'balance',
                'amount' => $request->balance_amount,
                'booking_id' => $holeBooking->id,
                'receipt' => $request->receipt_2,
                'date_1'=> $request->date_2
            ]);
        }
        DB::table('logs')->insert([
            'level' => 'update',
            'message' => json_encode($request->all()),
            'context' =>  Auth::user()->email,
            'created_at' => now(),
            'updated_at' => now(),
         ]);
        return redirect()->route('admin.hall-bookings.index')->with('success', 'Booking updated successfully');
    }
    

    public function show(Request $request,string $holeBookingId)
    {
        abort_if(Gate::denies('hole_booking_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $holeBooking = HoleBooking::find( $holeBookingId);
        if (!$holeBooking) {
            abort(404, 'Hole Booking not found');
        }
        $formats = ['d/m/Y', 'Y-m-d']; 
        $bookingDateTimes = BookingDateTime::where('hall_booking_id', $holeBookingId)->get();
        $holeBooking->booked_dates = $bookingDateTimes->map(function($bookingDateTime) use ($formats) {
            $bookedDate = null;
            foreach ($formats as $format) {
                try {
                    $bookedDate = Carbon::createFromFormat($format, $bookingDateTime->booked_date);
                    break; // Exit the loop if the date is successfully parsed
                } catch (\Exception $e) {
                    // Continue trying next format
                }
            }
            if ($bookedDate) {
                return $bookedDate->format('d/m/Y') . ' ' . $bookingDateTime->time_slot;
            } else {
                \Log::warning("Invalid date format: " . $bookingDateTime->booked_date);
                return 'Invalid date format';
            }
        })->implode(', ');
        
        $bookingPayments = BookingPayment::where('booking_id', $holeBookingId)->orderBy('date_1', 'asc')->get();
        return view('admin.hallBookings.show', compact('holeBooking', 'bookingDateTimes', 'bookingPayments'));
    }

    public function destroy(Request $request,HoleBooking $holeBooking)
    {
      
        abort_if(Gate::denies('hole_booking_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        DB::beginTransaction();
        try {
          
            // Delete the related BookingDateTime records
            BookingDateTime::where('hall_booking_id', $request->id)->delete();
            BookingPayment::where('booking_id', $request->id)->delete();
            $holeBooking::where('id', $request->id)->delete();
            Cancellation::create([
                'hall_id' => $request->id,
                'user_id' => Auth::id(),
                'amount' => $request->cancellation_amount,
                'canceled_at' => now(),
            ]);
            DB::table('logs')->insert([
                'level' => 'cancel',
                'message' => json_encode($request->all()),
                'context' =>  Auth::user()->email,
                'created_at' => now(),
                'updated_at' => now(),
             ]);
             DB::commit();
            return back()->with('success', 'Hole Booking deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            DB::table('logs')->insert([
                'level' => 'error',
                'message' => json_encode($request->all()),
                'context' =>  Auth::user()->email,
                'created_at' => now(),
                'updated_at' => now(),
             ]);
            return back()->with('error', 'Error deleting Hole Booking: ' . $e->getMessage());
        }
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
