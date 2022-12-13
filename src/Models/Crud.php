<?php

namespace Rklab\Crud\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crud extends Model
{
    use HasFactory;

    protected $fillable = ['table_name', 'model_name', 'route'];
}
