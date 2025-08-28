<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Bundle;
use App\Models\Category;

class QrCode extends Model
{
    public $timestamps = true;

    protected $guarded = ['id'];

    // Method to mark the QR code as used
    public function markAsUsed()
    {
        $this->update(['is_used' => true]);
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
public function bundle()
    {
        return $this->belongsTo('App\Models\Bundle', 'bundle_id');
    }

    // Define the relationship with the Category model
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }
// Define the relationship with the Category model
    public function webinar()
    {
        return $this->belongsTo('App\Models\Webinar', 'webinar_ids');
    }
  public function used_in_course()
    {
        return $this->belongsTo('App\Models\Webinar', 'used_in');
    }
    // Optionally, you can add other relationships and methods as needed
}
