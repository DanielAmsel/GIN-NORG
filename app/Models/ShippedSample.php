<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippedSample extends Model
{
    use HasFactory;

    protected $table = 'shipped_sample';
    public $timestamps = false;

    public function user() {
        return $this->hasOne(User::class);
    }

    public function sample() {
        return $this->hasOne(Sample::class);
    }
}
