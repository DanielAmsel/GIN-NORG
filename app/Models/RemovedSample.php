<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemovedSample extends Model
{
    use HasFactory;

    protected $table = 'removed_sample';
    public $timestamps = false;

    // 1-1 relation to User
    public function user() {
        return $this->hasOne(User::class);
    }

    // 1-1 relation to Sample
    public function sample() {
        return $this->hasOne(Sample::class);
    }
}
