<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';
    public $timestamps = false;

    //Relation zum User (1-n)
    public function user() {
        return $this->belongsTo(User::class);
    }
}
