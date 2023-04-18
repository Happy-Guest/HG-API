<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCode extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'code_id',
    ];

    /**
     * Get the code that owns the user code.
     */
    public function code()
    {
        return $this->belongsTo(Code::class);
    }

    /**
     * Get the user that owns the user code.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
