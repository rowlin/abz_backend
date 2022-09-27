<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $fillable = ['name','status'];


    protected $hidden = ['status'];

    public function position(){
        return $this->hasOne(User::class , 'position_id');
    }

    public $timestamps = false;

}
