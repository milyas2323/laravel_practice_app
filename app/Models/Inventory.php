<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventory';

    protected $fillable = [
        'name',
        'description',
        'image',
        'employee_id',
    ];

    public function creator()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function getImagePathAttribute()
    {
        return Storage::disk('public')->url($this->image);
    }
}
