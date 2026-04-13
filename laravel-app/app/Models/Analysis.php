<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Analysis extends Model
{
    protected $fillable = [
        'image_path',
        'prediction',
        'confidence',
        'analysis_json',
    ];

    protected $casts = [
        'analysis_json' => 'array',
    ];

    /**
     * Table hanya punya created_at (tanpa updated_at).
     */
    public const UPDATED_AT = null;
}
