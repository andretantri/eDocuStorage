<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Relasi ke model Document melalui DocumentTag.
     */
    public function documents()
    {
        return $this->belongsToMany(Document::class, 'document_tag');
    }

    /**
     * Relasi ke model Folder melalui FolderTag.
     */
    public function folders()
    {
        return $this->belongsToMany(Folder::class, 'folder_tag');
    }
}
