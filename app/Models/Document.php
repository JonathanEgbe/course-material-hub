<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'course_code',
        'description',
        'file_name',
        'file_path',
        'file_size',
        'file_type',
    ];

    /**
     * Get the file size formatted in human-readable format.
     */
    public function getFormattedSizeAttribute(): string
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Get the file icon class based on file type.
     */
    public function getIconAttribute(): string
    {
        $icons = [
            'pdf' => 'bi-filetype-pdf text-danger',
            'doc' => 'bi-filetype-doc text-primary',
            'docx' => 'bi-filetype-docx text-primary',
            'ppt' => 'bi-filetype-ppt text-warning',
            'pptx' => 'bi-filetype-pptx text-warning',
            'zip' => 'bi-file-zip-fill text-secondary',
        ];

        return $icons[$this->file_type] ?? 'bi-file-earmark text-secondary';
    }
}