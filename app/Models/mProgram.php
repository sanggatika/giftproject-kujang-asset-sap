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

    public function tmpProgramProgresImportMany()
    {
        return $this->hasMany(tmpProgramProgresImport::class, 'id_program', 'id');
    }

    public function tmpProgramProgresImportLast()
    {
        return $this->hasOne(tmpProgramProgresImport::class, 'id_program', 'id')->where('count_import', function($query) {
            $query->selectRaw('MAX(count_import)')
                  ->from('tmp_program_progres_import');
        });
    }

    public function trProgresProgramMany()
    {
        return $this->hasMany(trProgresProgram::class, 'id_program', 'id');
    }

    public function trProgresProgramLast()
    {
        return $this->hasOne(trProgresProgram::class, 'id_program', 'id')->where('count_import', function($query) {
            $query->selectRaw('MAX(count_import)')
                  ->from('tr_program_progres');
        });
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
