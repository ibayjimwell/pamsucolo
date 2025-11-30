<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_number',
        'first_name',
        'middle_name',
        'last_name',
        'current_campus',
        'current_course',
        'current_year_level',
        'current_section',
        'email',
        'password', // Portal password (must be hashed)
    ];

    /**
     * Get the user account associated with the student.
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }
}