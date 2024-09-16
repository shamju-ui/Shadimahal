<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class BookingPayment extends Model
{
    use SoftDeletes, HasFactory,HasUuids;

    public $table = 'booking_payments';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'date_1',
        
    ];

    protected $fillable = [
        'amount',
        'amount_type',
        'booking_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'receipt',
        'date_1',
        'date_2',
    ];

    public const AMOUNT_TYPE_SELECT = [
        'advance'     => 'Advance',
        'electricity' => 'Electricity',
        'balance'     => 'Balance',
        'others'      => 'Others',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function booking()
    {
        return $this->belongsTo(HoleBooking::class, 'booking_id');
    }
}
