<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BooingDateTime extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'booking_date_times';

    public static $searchable = [
        'booked_date',
    ];

    protected $dates = [
        'booked_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'booked_date',
        'time_slot',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getBookedDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setBookedDateAttribute($value)
    {
        $this->attributes['booked_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }
}
