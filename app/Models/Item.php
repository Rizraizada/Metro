<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['name','purchase_date','supplier','details'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function vouchers()
    {
        return $this->hasMany(Voucher::class);
    }
}

