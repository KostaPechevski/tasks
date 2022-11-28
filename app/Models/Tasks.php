<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = [
        'editDate'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function geteditDateAttribute() {
        return false;
    }
}
