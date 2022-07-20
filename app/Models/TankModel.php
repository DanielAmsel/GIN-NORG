<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TankModel extends Model
{
    use HasFactory;

    protected $table = 'tank_model';
    protected $primaryKey = 'modelname';
    public $incrementing = false; //keine Inkrementierung, da PK String ist
    protected $keyType = 'string'; //PK ist kein integer
    public $timestamps = false;

    //Relation zum Tank (1-n)
    public function storageTank() {
        return $this->hasMany(StorageTank::class);
    }
}
