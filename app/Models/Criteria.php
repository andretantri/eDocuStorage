<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    // Relasi ke `topics`
    public function folders()
    {
        return $this->hasMany(Folder::class);
    }
}
