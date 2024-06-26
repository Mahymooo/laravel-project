<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\City;

class Client extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable=[
        'clientname',
        'phone',
        'email',
        'website',
        'city_id',
        'active',
        'img',
        'address',
        
    ];
    public function city(){
        return $this->belongsTo(City::class);
    }
}
