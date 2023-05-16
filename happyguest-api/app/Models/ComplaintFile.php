<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintFile extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'complaint_id',
        'filename',
    ];

    /**
     * Get the complaint that owns the complaint file.
     */
    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }
}
