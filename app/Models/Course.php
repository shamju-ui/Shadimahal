<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name']; 
   
    public function streams()
    {
        return $this->hasMany(Stream::class);
    }
    public function seminars()
    {
        return $this->belongsToMany(Seminar::class, 'seminar_course', 'course_id', 'seminar_id');
    }
}
