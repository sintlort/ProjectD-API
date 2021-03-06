<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class tb_project extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'tb_project';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_project','start_project','end_project','desc_project','status_project','no_hp','max_orang','user_id','project_image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function assignment()
    {
        return $this->hasMany(tb_detail_project::class,'id_project','id');
    }

    public function user()
    {
        return $this->belongsTo(tb_user::class,'user_id','id');
    }
}
