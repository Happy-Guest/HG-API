<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hotel';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'description',
        'descriptionEN',
        'phone',
        'email',
        'address',
        'website',
        'capacity',
        'policies',
        'policiesEN',
        'access',
        'accessEN',
        'comodities',
        'comoditiesEN',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime:d/m/Y',
        'updated_at' => 'datetime:d/m/Y',
    ];
}
