<?php


namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seminar extends Model
{
    use HasFactory;

    protected $fillable = ['seminar_name', 'seminar_date', 'runner'];
    
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'seminar_course', 'seminar_id', 'course_id');
    }

    public function streams()
    {
        return $this->belongsToMany(Stream::class, 'seminar_stream','seminar_id', 'stream_id');
    }
}
