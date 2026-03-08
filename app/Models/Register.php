<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    protected $table = 'registers';

    protected $fillable = [
        'name',
        'email',
        'password',
        'contact',
        'address',
        'role',
    ];
}
