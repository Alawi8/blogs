<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'section'];

    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id');
    }

    public function test()
    {
        return $this->belongsTo(Test::class);
    }
}
