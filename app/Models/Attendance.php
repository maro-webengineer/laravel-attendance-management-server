<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory, HasUuids;

    // PRIMARY KEY uuid 設定
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'work_date',
        'clock_in',
        'clock_out',
        'break_started_at',
        'break_ended_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
