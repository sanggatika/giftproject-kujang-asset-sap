<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefRegencies extends Model
{
    use HasFactory;

    protected $table = 'reg_regencies';
    protected $primaryKey = 'id';

    public $timestamps = false;
}
