<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Student;

class Student extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable=[
    'name',
    'age'
    ];

    public function teacher(){
        return $this->belongsToMany(Teacher::class,'student_teacher' );
    }
}
