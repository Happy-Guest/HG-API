<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'type',
        'schedule',
        'occupation',
        'limit',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime:d/m/Y',
        'updated_at' => 'datetime:d/m/Y',
        'deleted_at' => 'datetime:d/m/Y',
    ];

    /**
     * Get the service reserve for the service.
     */
    public function reserve()
    {
        return $this->hasMany(Reserve::class);
    }

    /**
     * Get the service order for the service.
     */
    public function order()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the service items for the service.
     */
    public function serviceItems()
    {
        return $this->hasMany(ServiceItem::class);
    }
}
