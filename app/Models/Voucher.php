<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Voucher extends Model
{
    public $timestamps = true;

    protected $guarded = ['id'];

    // Method to mark the voucher as used
    public function markAsUsed()
    {
        $this->update(['is_used' => true]);
    }
// Define the relationship to the User model
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    // Optionally, you can add other relationships and methods as needed
}
