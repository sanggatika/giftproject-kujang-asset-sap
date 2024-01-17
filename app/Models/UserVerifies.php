<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVerifies extends Model
{
    use HasFactory;

    protected $table = 'user_verifies';
    protected $primaryKey = 'id';

    public $timestamps = false;
}
