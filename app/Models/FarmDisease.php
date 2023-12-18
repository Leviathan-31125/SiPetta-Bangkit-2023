<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmDisease extends Model
{
    use HasFactory;

    protected $table = 't_farmdisease';
    protected $primaryKey = 'fv_diseasecode';
    protected $fillable = [
        'fv_diseasename',
        'fv_listindicators',
        'created_by'
    ];

    public $incrementing = false;
}
