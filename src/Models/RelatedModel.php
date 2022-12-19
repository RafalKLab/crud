<?php

namespace Rklab\Crud\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelatedModel extends Model
{
    use HasFactory;

    protected $fillable = ['aim_model', 'ref_model', 'relation_type'];
}
