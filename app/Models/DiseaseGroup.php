<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiseaseGroup extends Model
{
    use HasFactory;
    protected $table = 't_diseasegroup';
    protected $primaryKey = 'fv_qcode';
    protected $fillable = [
        'fv_diseasequestion',
        'created_by'
    ];
    public $incrementing = false;

    public function listOptions()
    {
        return $this->hasMany(DiseaseIndicator::class, 'fv_qcode', 'fv_qcode');
    }
}
