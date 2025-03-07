<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model {
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'img_url',
        'project_id',
    ];

    public function project() {
        return $this->belongsTo(Project::class);
    }
}
