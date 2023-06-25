<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceItem extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'service_id',
        'item_id',
    ];

    /**
     * Get the service that owns the service item.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the item that owns the service item.
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
