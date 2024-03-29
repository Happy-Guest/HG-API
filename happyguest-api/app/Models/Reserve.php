<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'user_name',
        'nr_people',
        'time',
        'status',
        'service_id',
        'comment'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'time' => 'datetime:d/m/Y H:i',
        'created_at' => 'datetime:d/m/Y',
        'updated_at' => 'datetime:d/m/Y',
        'deleted_at' => 'datetime:d/m/Y',
    ];

    /**
     * Get the user that owns the user reserve.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the service that owns the service reserve.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
