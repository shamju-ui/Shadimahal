<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
    use HasFactory;
    public $table = 'stream';
    public $timestamps = false;
    protected $fillable = ['name', 'course_id']; // Add other fields if necessary

    // A subject belongs to a course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
