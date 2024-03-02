<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = ['month_date', 'voucher_no', 'description', 'amount', 'payee', 'category', 'project_id', 'item_id', 'note', 'paid_to', 'bank_id'];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }


    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

}
