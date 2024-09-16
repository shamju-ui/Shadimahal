<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class FeePayment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'student_id', 
        'grade', 
        'fee_amount', 
        'term', 
        'date', 
        'receipt_number',
        'created_by',
        'deleted_by',
    ];

    protected $dates = ['deleted_at','created_at'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    // protected $fillable = ['student_id', 'date', 'amount', 'method'];

    public function student()
    {
        return $this->belongsTo(student::class);
    }
}

