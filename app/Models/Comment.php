<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $guard = 'admin';

    protected $fillable = [
        'body',
        'user_id',
        'image'
    ];

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'user_id');
    }

    public function getImagePathAttribute()
    {
        return Storage::disk('public')->url($this->image);
    }
}
