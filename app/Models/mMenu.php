<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mMenu extends Model
{
    use HasFactory;

    protected $table = 'm_menu';
    protected $primaryKey = 'id';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function mMenuGrup()
    {
        return $this->hasOne(mMenuGrup::class, 'id', 'menu_grup_id');
    }
}
