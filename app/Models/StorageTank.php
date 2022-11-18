<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StorageTank extends Model
{
    use HasFactory;

    protected $table = 'storage_tank';
    protected $fillable = ['tank_name', 'modelname'];
    public $timestamps = false;

    //Relation zur Probe (1-n)
    public function sample() {
        return $this->hasMany(Sample::class);
    }

    //Relation zum Tankmodel (1-1)
    public function tankModel() {
        return $this->hasOne(TankModel::class);
    }

    //Get Tank_Model for current storageTank
    public function tankConstruction() {
        $tankCapacities = DB::table('tank_model')->where('modelname', $this->modelname)->get();
        return $tankCapacities[0];
    }
}
