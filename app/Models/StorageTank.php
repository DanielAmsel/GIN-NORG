<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\TankModel;

class StorageTank extends Model
{
    use HasFactory;

    protected $table = 'storage_tank';
    protected $fillable = ['tank_name', 'modelname'];
    public $timestamps = false;

    // 1-n relation to Sample
    public function sample() {
        return $this->hasMany(Sample::class);
    }

    // 1-1 relation to TankModel
    public function tankModel() {
        return $this->hasOne(TankModel::class);
    }

    // Get Tank_Model for current storageTank
    public function tankConstruction() {
        $tankCapacities = DB::table('tank_model')->where('modelname', $this->modelname)->get();
        return $tankCapacities[0];
    }

    public function getInserts() {
        
        $numberInserts = TankModel::where('modelname', $this->modelname)->get('number_of_inserts');
        return $numberInserts[0]->number_of_inserts;
    }

    public function getTubes() {
        
        $numberTubes = TankModel::where('modelname', $this->modelname)->get('number_of_tubes');
        return $numberTubes[0]->number_of_tubes;
    }

    public function getSamples() {
        
        $numberSamples = TankModel::where('modelname', $this->modelname)->get('number_of_samples');
        return $numberSamples[0]->number_of_samples;
    }


}
