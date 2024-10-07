<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    protected $fillable = ['criteria_id', 'name', 'parent_id', 'tag_folder', 'folder_path'];

    /**
     * Relasi ke model Criteria.
     */
    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }

    /**
     * Relasi ke model Folder untuk parent.
     */
    public function parent()
    {
        return $this->belongsTo(Folder::class, 'parent_id');
    }

    /**
     * Relasi ke model Folder untuk subfolder.
     */
    public function subfolders()
    {
        return $this->hasMany(Folder::class, 'parent_id');
    }

    /**
     * Relasi ke model Document.
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
