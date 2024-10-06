<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{

    use HasFactory;

    protected $fillable = ['folder_id', 'name', 'path', 'google_drive_id', 'description'];

    /**
     * Relasi ke model Folder.
     */
    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    /**
     * Relasi ke model Tag melalui DocumentTag.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'document_tag');
    }
}
