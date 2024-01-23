<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mProgram extends Model
{
    use HasFactory;

    protected $table = 'm_program';
    protected $primaryKey = 'id';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function mProgramJenisCCK()
    {
        return $this->hasOne(mProgramJenisCCK::class, 'id', 'id_program_jenis_cck');
    }

    public function mProgramLokasiCC()
    {
        return $this->hasOne(mProgramLokasiCC::class, 'id', 'id_program_lokasi_cc');
    }

    public function trProgresProgramSR()
    {
        return $this->hasOne(trProgresProgramSR::class, 'id_program', 'id');
    }

    public function trProgresProgramPRMany()
    {
        return $this->hasMany(trProgresProgramPR::class, 'id_program', 'id');
    }

    public function trProgresProgramPOMany()
    {
        return $this->hasMany(trProgresProgramPO::class, 'id_program', 'id');
    }

    public function trProgresProgramGRMany()
    {
        return $this->hasMany(trProgresProgramGR::class, 'id_program', 'id');
    }
}
