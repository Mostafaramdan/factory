<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Models\productions as model;
use Illuminate\Support\Facades\Hash;
use App\Models\production_costs;
use App\Models\employees;

class productions extends dashboard

{
    function __construct()
    {
        $this->model= model::class;
    }
    public function index(Request $request)
    {
        $records= $this->model::query();
        if($request->search){
            $records->where('name','like','%'.$request->search.'%')
                    ;
        }
        $records->orderBy($request->filterBy??'id',$request->filterType??'DESC'); // filter

        $itemPerPage= $request->itemPerPage??self::$itemPerPage;
        $totalPages= ceil($records->count()/$itemPerPage);
        $records= $records->forPage($request->page,$itemPerPage)->get();
        return response()->json([
            "status"=>$records->count()?200:204,
            "totalPages"=>$totalPages,
            "records"=>$records,
        ]);
    }
    public function store(Request $request)
    {
        $production = $this->model::create([
            'production_type_id'=>$request->production_type_id,
            'quantity'=>$request->quantity,
            'store'=>$request->quantity,
            'salaries'=>employees::all()->sum('salary_per_day')
        ]);
        foreach($request->variable_costs as $variable_cost){
            production_costs::create([
                'variable_costs_id'=>$variable_cost['variable_costs_id'],
                'total'=>$variable_cost['total'],
                'productions_id'=>$production->id,
            ]);
        }
        foreach($request->production_materials as $production_material){
            production_costs::create([
                'materials_types_id'=>$production_material['materials_types_id'],
                'quantity'=>$production_material['quantity'],
                'total'=>$production_material['total'],
                'productions_id'=>$production->id,
            ]);
        }
        return response()->json(['status'=>200]);
    }
    public function update(Request $request, $id)
    {
        $production =  $this->model::where('id',$id)->update([
            'production_type_id'=>$request->production_type_id,
            'quantity'=>$request->quantity,
            'store'=>$request->quantity,
            'salaries'=>employees::all()->sum('salary_per_day')
        ]);
        production_costs::where('productions_id',$id)->delete();
            foreach($request->variable_costs as $variable_cost){
            production_costs::create([
                'variable_costs_id'=>$variable_cost['variable_costs_id'],
                'total'=>$variable_cost['total'],
                'productions_id'=>$id,
            ]);
        }
        foreach($request->production_materials as $production_material){
            production_costs::create([
                'materials_types_id'=>$production_material['materials_types_id'],
                'quantity'=>$production_material['quantity'],
                'total'=>$production_material['total'],
                'productions_id'=>$id,
            ]);
        }
        return response()->json(['status'=>200]);
    }

}

