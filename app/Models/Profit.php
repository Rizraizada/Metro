<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profit extends Model
{
    use HasFactory;

    protected $fillable = [
        'flat_voucher_id',
        'amount',
    ];

    // Relationships

    public function flatVoucher()
    {
        return $this->belongsTo(FlatVoucher::class);
    }
}


