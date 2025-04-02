<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AttributeGroups extends Model
{
    //
    protected $fillable = [
        'group_name',
    ];
    public function attributes():hasMany{
        return $this->hasMany(AttributeGroups::class);
    }
}
