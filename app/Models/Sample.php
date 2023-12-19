<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sample extends Model
{
    use HasFactory;

    protected $table = 'sample';
    public $timestamps  = false;

    // 1-1 relation to StorageTank
    public function storageTank() {
        return $this->hasOne(StorageTank::class);
    }

    // 1-1 relation to MaterialType
    public function materialType() {
        return $this->hasOne(MaterialType::class);
    }
}
