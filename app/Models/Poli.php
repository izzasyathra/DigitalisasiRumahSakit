<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    protected $fillable = ['name','description','icon'];
    public function doctors(){ return $this->hasMany(User::class)->where('role','doctor'); }
}
