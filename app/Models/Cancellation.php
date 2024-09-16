<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cancellation extends Model
{
    use HasFactory;
    use HasFactory;

    protected $table = 'cancellations';

    // The attributes that are mass assignable.
    protected $fillable = [
        'hall_id',
        'amount',
        'canceled_at',
        'user_id'
    ];

    // The attributes that should be cast to native types.
    protected $casts = [
        'canceled_at' => 'datetime',
    ];

    // If there are any relationships, define them here
    // Example: If a cancellation belongs to a hall and a user
    public function hall()
    {
        return $this->belongsTo(HoleBooking::class,'hall_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
