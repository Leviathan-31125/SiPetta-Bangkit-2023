<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgriFarm extends Model
{
    use HasFactory;

    protected $table = 't_farmagri';
    protected $primaryKey = 'fv_agricode';
    protected $fillable = ['fv_agriname', 'created_by', 'updated_by'];
    public $incrementing = false;
}
