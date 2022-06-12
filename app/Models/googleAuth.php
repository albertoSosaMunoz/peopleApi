<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class googleAuth extends Model
{
    use HasFactory;
    protected $primaryKey = 'email'; // or null
}
