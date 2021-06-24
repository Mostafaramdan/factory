<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class production_costs extends Model
{
    use HasFactory;
    public $timestamps = false ,$with=['variable_cost','matrials_type'];
    protected $guarded=[];
    function variable_cost()
    {
        return $this->belongsTo(variable_costs::class,'variable_costs_id');
    }
    function matrials_type()
    {
        return $this->belongsTo(matrials_types::class,'materials_id');
    }
}
