<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class Code extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $cascadeDeletes = ['userCodes'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'rooms',
        'entry_date',
        'exit_date',
        'used',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'entry_date' => 'datetime:d/m/Y',
        'exit_date' => 'datetime:d/m/Y',
        'created_at' => 'datetime:d/m/Y',
        'updated_at' => 'datetime:d/m/Y',
    ];

    /**
     * Get the user codes for the code.
     */
    public function userCodes()
    {
        return $this->hasMany(UserCode::class);
    }

    /**
     * Get the users for the code.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_codes');
    }
}
