<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAccessClient extends Model
{
    use HasFactory;

    protected $table = 'log_access';
    public $timestamps = false;
}
