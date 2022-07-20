<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Positions extends Model
{
    use HasFactory;

    // TODO: Tabelle positions gibt es so nicht mehr
    protected $table = 'positions';
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    // TODO: überarbeiten ist so nicht mehr aktuell!
    public function storageTank() {
        return $this->hasMany(StorageTank::class);
    }
}
