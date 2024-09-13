<?php

namespace App\Models;

use Database\Seeders\UserSeeder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;
    protected $fillable = ['tweet'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function liked()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
