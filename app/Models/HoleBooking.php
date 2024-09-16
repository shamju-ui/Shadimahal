<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class HoleBooking extends Model
{
    use SoftDeletes, HasFactory;
    use HasUuids;
    public $table = 'hole_bookings';

    public static $searchable = [
        // 'am',
        // 'pm',
        // 'ad',
    ];

    protected $dates = [
        // 'date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const TIME_SLOT_SELECT = [
        // 'AM' => 'AM',
        // 'PM' => 'PM',
        // 'AD' => 'AD',
    ];

    protected $fillable = [
      //  'date',
     //   'time_slot',
        'name',
        'mobile_1',
        'mobile_2',
        'address_line_1',
        'address_line_2',
        'total_amount',
        'elactric_charges',
        'comment',
        'created_at',
        'updated_at',
        'deleted_at',
        'event_type',
        'discount',
        'discount_by'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function bookingBookingPayments()
    {
        return $this->hasMany(BookingPayment::class, 'booking_id', 'id');
    }
    public function bookingDateTimes()
    {
        return $this->hasMany(BookingDateTime::class, 'hall_booking_id');
    }

    public function bookingPayments()
    {
        return $this->hasMany(BookingPayment::class, 'booking_id');
    }


    public function getDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }
}
