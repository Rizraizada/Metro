<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['company_id','name','project_location','start_date','end_date','manager','description','garage'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function vouchers()
    {
        return $this->hasMany(Voucher::class);
    }

        public function flats()
    {
        return $this->hasMany(Flat::class);
    }

    public function company()
     {
         return $this->belongsTo(Company::class);
     }



}
