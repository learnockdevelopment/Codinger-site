<?php

namespace App\Models\Translation;

use Illuminate\Database\Eloquent\Model;

class SubjectTranslation extends Model
{
    protected $table = 'subject_translations';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $guarded = ['id'];
}
