<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leaves extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function leavetype()
    {
        return $this->hasOne(LeaveTypes::class,'id','type')->latest();
    }
    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
