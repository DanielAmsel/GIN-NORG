<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorageTank extends Model
{
    use HasFactory;

    protected $table = 'storage_tank';
    protected $fillable = ['tank_number', 'modelname'];
    public $timestamps = false;

    //Relation zur Probe (1-n)
    public function sample() {
        return $this->hasMany(Sample::class);
    }

    //Relation zum Tankmodel (1-1)
    public function tankModel() {
        return $this->hasOne(TankModel::class);
    }
}
