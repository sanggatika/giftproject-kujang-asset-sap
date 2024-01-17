<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mAuthorization extends Model
{
    use HasFactory;

    protected $table = 'm_authorization';
    protected $primaryKey = 'id';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function mMenu()
    {
        return $this->hasOne(mMenu::class, 'id', 'id_menu');
    }

    public function mRoles()
    {
        return $this->hasOne(mRoles::class, 'id', 'id_role');
    }
}
