<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trProgresProgram extends Model
{
    use HasFactory;

    protected $table = 'tr_program_progres';
    protected $primaryKey = 'id';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function mProgram()
    {
        return $this->hasOne(mProgram::class, 'id', 'id_program');
    }

    public function mProgramAccount()
    {
        return $this->hasOne(mProgramAccount::class, 'id', 'id_program_account');
    }

    public function mProgramDepartementCCK()
    {
        return $this->hasOne(mProgramDepartementCCK::class, 'id', 'id_program_departement_cck');
    }

    public function mProgramBagianCC()
    {
        return $this->hasOne(mProgramBagianCC::class, 'id', 'id_program_bagian_cc');
    }
}
