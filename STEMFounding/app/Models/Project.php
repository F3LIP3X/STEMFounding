<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'url_Img',
        'url_Video',
        'current_investment',
        'min_investment',
        'max_investment',
        'limit_date',
        'state',
    ];

    
    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function comments() {
        return $this->hasMany( Comment::class );
    }

    public function investments() {
        return $this->hasMany(Investment::class);
    }
}
