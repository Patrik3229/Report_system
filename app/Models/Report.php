<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'perpetrator_id',
        'reporter_id',
        'submitted_time',
        'handled_time',
        'report_status',
        'reporter_comment',
        'admin_comment',
        'handling_admin_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    protected $casts = [
        'submitted_time' => 'datetime',
        'handled_time' => 'datetime',
    ];

    public function perpetrator()
    {
        return $this->belongsTo(User::class, 'perpetrator_id');
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function handlingAdmin()
    {
        return $this->belongsTo(User::class, 'handling_admin_id');
    }
}
