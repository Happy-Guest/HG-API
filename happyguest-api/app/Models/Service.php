<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $cascadeDeletes = ['serviceItems'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'nameEN',
        'email',
        'phone',
        'type',
        'schedule',
        'occupation',
        'limit',
        'description',
        'descriptionEN',
        'menu_url',
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
     * Get the reserves for the service.
     */
    public function reserves()
    {
        return $this->hasMany(Reserve::class);
    }

    /**
     * Get the orders for the service.
     */
    public function orders()
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
