<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{

    use HasFactory;

    protected $fillable = ['folder_id', 'name', 'google_drive_id', 'tag', 'description'];

    /**
     * Relasi ke model Folder.
     */
    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }
}
