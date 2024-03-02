<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flat extends Model
{

    protected $fillable = ['flat_number','project_id',''];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
     public function customers()
{
    return $this->belongsToMany(Customer::class, 'customer_flat', 'flat_id', 'customer_id');
}
public function flat()
{
    return $this->belongsTo(Flat::class, 'flat_id');
}

public function vouchers()
{
    return $this->hasMany(FlatVoucher::class);
}



}
