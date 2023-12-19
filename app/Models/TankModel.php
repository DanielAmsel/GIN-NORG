<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TankModel extends Model
{
    use HasFactory;

    protected $table = 'tank_model';
    protected $primaryKey = 'modelname';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    // 1-n relation to StorageTank
    public function storageTank() {
        return $this->hasMany(StorageTank::class);
    }
}
