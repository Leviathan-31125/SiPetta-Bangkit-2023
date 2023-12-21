<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsLetter extends Model
{
    use HasFactory;

    protected $table = 't_newsletter';
    protected $primaryKey = 'fc_newsletterid';


    protected $fillable = [
        'fv_title',
        'ft_description',
        'fv_category',
        'fd_releasedate',
        'fv_writer',
        'ft_linkresource',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public $incrementing = false;

    public function category()
    {
        return $this->hasOne(TRXType::class, 'fc_trxcode', 'fv_category')->where('fc_trx', 'NEWSCATEGORY');
    }
}
