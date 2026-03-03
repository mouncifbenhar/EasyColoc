<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{

    protected $fillable = [
       'colocation_id',
       'token'
    ];

    public function colocation(){
        return $this->belongsTo(Colocation::class,'colocation_id');
    }
}
