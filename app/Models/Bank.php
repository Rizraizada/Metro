<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
// app/Models/Bank.php

protected $fillable = ['bank_name', 'branch_no', 'owner', 'opening_balance', 'details','deposit','withdraw'];
}
