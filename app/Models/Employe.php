<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    use HasFactory;

    protected $fillable = [
        "fullname",
        "email",
        "phone",
        "password",
        "photo",
        "position",
        "salary"
    ];
}
