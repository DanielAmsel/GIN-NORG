<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sample extends Model
{
    use HasFactory;

    protected $table = 'sample';
    public $timestamps  = false;

    //Relation zum Tank (1-1)
    public function storageTank() {
        return $this->hasOne(StorageTank::class);
    }

    //Relation zum Materialtyp (Gewebetyp) (1-1)
    public function materialType() {
        return $this->hasOne(MaterialType::class);
    }
}
