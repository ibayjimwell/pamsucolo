<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    // ... traits
    protected $fillable = [
        'student_id',
        'is_admin', // for admin logic
    ];
    // ... hidden attributes
    protected $casts = [
        'is_admin' => 'boolean',
    ];

    /**
     * Get the student record associated with the user.
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_number', 'student_number');
    }
    
    // Add accessors to retrieve name/email from the Student model
    public function getNameAttribute()
    {
        return optional($this->student)->first_name . ' ' . optional($this->student)->last_name;
    }

    public function getEmailAttribute()
    {
        return optional($this->student)->email;
    }
}