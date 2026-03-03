<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Invitation;
use Illuminate\Database\Eloquent\Model;

class Colocation extends Model
{
    protected $fillable = [
       'title', 
       'state'
    ];
    public function user(){
        return $this->belongsToMany(User::class, 'colocation_user')->withPivot('role');
    }
    public function invitation(){
        return $this->hasMany(Invitation::class,'colocation_id');
    }
     public function Category(){
        return $this->hasMany(Category::class,'colocation_id');
    }
    public function expenses()
    {
        return $this->hasMany(Expence::class);
    }
     public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    
}
