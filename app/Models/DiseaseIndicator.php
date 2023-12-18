<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiseaseIndicator extends Model
{
    use HasFactory;
    protected $table = 't_diseaseindicator';
    protected $primaryKey = 'fv_indicatorcode';
    protected $fillable = [
        'fv_agricode',
        'fv_qcode',
        'fv_indicatorname',
        'created_by',
    ];
    public $incrementing = false;

    public function agriFarm()
    {
        return $this->hasOne(AgriFarm::class, 'fv_agricode', 'fv_agricode');
    }

    public function diseaseGroup()
    {
        return $this->hasOne(DiseaseGroup::class, 'fv_qcode', 'fv_qcode');
    }
}
