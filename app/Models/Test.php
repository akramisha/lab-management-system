<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $table = 'tests';

    protected $fillable = [
        'name',
        'description',
        'cost',
        'preparation_instructions',
        'is_active',
    ];
}
