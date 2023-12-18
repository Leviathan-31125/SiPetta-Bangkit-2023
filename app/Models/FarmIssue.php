<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FarmIssue extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 't_farmissue';
    protected $primaryKey = 'fc_issueid';
    protected $fillable = [
        'fc_userid',
        'fv_agricode',
        'fc_issuetitle',
        'fc_issuedescription',
        'fd_issuereleasedate',
        'fc_repliedstatus',
        'fc_replierid',
        'ft_useranswer'
    ];
    protected $dates = ['deleted_at'];

    public $incrementing = false;

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'fc_userid');
    }

    public function expertise()
    {
        return $this->hasOne(User::class, 'id', 'fc_replierid');
    }

    public function farmAgri()
    {
        return $this->hasOne(AgriFarm::class, 'fv_agricode', 'fv_agricode');
    }
}
