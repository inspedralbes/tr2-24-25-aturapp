<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    protected $fillable = ['sector', 'geometry'];

    public function alertas()
    {
        return $this->hasMany(Alerta::class);
    }
}
