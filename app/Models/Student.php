<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = "students";

    use HasFactory;

    protected $fillable = [
        'image',
        'email',
        'first_name',
        'middle_name',
        'last_name',
        'age',
        'gender',
        'address',
        'contact_number',
        'course',
        'year'
    ];
}
