<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TankCapacity extends Model
{
    use HasFactory;

    protected $table = 'tank_capacity';
    public $timestamps = false;

    //Relation zum Tank (1-1)
    public function storageTank() {
        return $this->hasOne(StorageTank::class);
    }
}
