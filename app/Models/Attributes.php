<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use PhpParser\Node\AttributeGroup;

class Attributes extends Model
{
    protected $fillable = [
        'attribute_name',
        'group_id',
    ];
    public function attributeGroups():BelongsTo
    {
        return $this->belongsTo(AttributeGroup::class);
    }
}
