<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlatVoucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'month',
        'voucher_no',
        'paid_to',
        'category',
        'customer_id',
        'project_id',
        'flat_id',
        'amount',
        'description',
        'payee',
        'delay_charge',
        'car_money',
        'utility_charge',
        'special_discount',
        'tiles_work',
        'refund_money',
        'miscellaneous_cost',
        'note',
        'bank_id',

    ];

    // Relationships

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function flat()
    {
        return $this->belongsTo(Flat::class);
    }
    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }
}
