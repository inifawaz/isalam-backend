<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'is_ended'];

    public function category()
    {
        return $this->belongsTo(ProjectCategory::class);
    }

    public function updates()
    {
        return $this->hasMany(ProjectUpdate::class);
    }
}
