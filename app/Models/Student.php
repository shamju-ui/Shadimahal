<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\FeePayments;

class Student extends Model
{
    use SoftDeletes;

    protected $table = 'students';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id', 'student_name', 'student_image', 'student_id', 'student_mobile', 'guardian_name', 
        'guardian_id', 'guardian_mobile', 'address_line_1', 'address_line_2', 
        'educational_institution', 'institution_mobile', 'course_id', 'stream_id', 
        'current_grade', 'total_fees', 'allocated_fees' 
    ];

    protected $dates = ['deleted_at'];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function stream()
    {
        return $this->belongsTo(Stream::class, 'stream_id');
    }

    public function FeePayment()
    {
        return $this->hasMany(FeePayment::class);
    }

    public function markList()
    {
        return $this->hasMany(MarkList::class);
    }
}

