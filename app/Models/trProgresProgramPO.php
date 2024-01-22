<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trProgresProgramPO extends Model
{
    use HasFactory;

    protected $table = 'tr_program_progres_po';
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

    public function trProgresProgramPROne()
    {
        return $this->hasOne(trProgresProgramPR::class, 'id', 'id_tr_program_progres_pr');
    }
}
