<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'assigned_company',
        'details',
        'installment',
        'total_installment',
        'garage',
        'car_money',
        'utility_charge',
        'special_discount',
        'tiles_charge',
        'other_charge',


    ];

// Customer.php
public function flats()
{
    return $this->belongsToMany(Flat::class, 'customer_flat'); // Adjust the pivot table name as needed
}

    public function assignedCompany()
    {
        return $this->belongsTo(Project::class, 'assigned_company', 'id');
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }


    public function flatVouchers()
      {
          return $this->hasMany(FlatVoucher::class, 'customer_id');
      }


}
