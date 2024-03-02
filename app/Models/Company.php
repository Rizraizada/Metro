<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'website',
        'founded_date',
        'description',
        'contact_person',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
