<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TRXType extends Model
{
    use HasFactory;
    protected $table = 't_trxtype';
    protected $primaryKey = 'id';
    protected $fillable = [
        'fc_trx',
        'fc_trxcode',
        'ft_description',
        'fc_action'
    ];

    public $incrementing = false;
}
