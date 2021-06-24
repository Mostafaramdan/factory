<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productions extends Model
{
    public $timestamps = false ,$appends=['variable_costs','production_materials','total',
                                          'price_per_one','production_type'],
                                $with=['production_costs'];
    protected $guarded=[];
    function production_costs()
    {
        return $this->hasMany(production_costs::class,'productions_id');
    }
    function GetProductionMaterialsAttribute()
    {
        return $this->production_costs->where('materials_types_id','!=',null)->flatten(2);
    }
    function GetVariableCostsAttribute()
    {
        return $this->production_costs->where('variable_costs_id','!=',null)->flatten(2);
    }

    function GetTotalAttribute()
    {
        return $this->production_costs->sum('total') ;
    }
    function GetPricePerOneAttribute()
    {
        return ($this->total + $this->salaries)/$this->quantity;
    }
    function GetProductionTypeAttribute()
    {
        return production_types::find($this->production_type_id)->name;
    }
}
