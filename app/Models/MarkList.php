<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarkList extends Model
{
    use HasFactory;

    // Specify the fields that can be mass-assigned
    protected $fillable = [
        'student_id', 
        'class_name',  // Class field (e.g., "Class 4")
        'term',        // Term (e.g., "1")
        'grade',       // Grade (e.g., "A")
        'date',        // Date of the mark list (e.g., "2024-06-28")
        'comments',    // Comments on the mark list
        'marklist_file', // Name or path of the uploaded mark list file
    ];

    public $timestamps = false;

    public function student()
    {
        return $this->belongsTo(student::class);
    }
}
