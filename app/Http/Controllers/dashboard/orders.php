<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Models\orders as model;
use App\Exports\orders as orderExp;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\employees;
use App\Models\productions;
use App\Models\clients;
use App\Models\production_types;


class orders extends dashboard
{
    function __construct(Request $request)
    {
        $this->model= model::class;
    }
    public function index(Request $request)
    {
        $records= $this->model::where('order_type','sold');

        if($request->search){
            $records->where('id','like','%'.$request->search.'%')
                    ->orWhere('status','like','%'.$request->search.'%');
        }
        $records->orderBy($request->filterBy??'id',$request->filterType??'DESC'); // filter
        if($request->status){
            $records->where('status',$request->status);
        }

        $itemPerPage= $request->itemPerPage??self::$itemPerPage;
        $totalPages= ceil($records->count()/$itemPerPage);
        $records= $records->forPage($request->page,$itemPerPage)->get();
        return response()->json([
            "status"=>$records->count()?200:204,
            "totalPages"=>$totalPages,
            "records"=>$records,
        ]);
    }
    public static function downloadOrders(Request $request)
    {
        $records = model::where('created_at','>=',$request->from??'2020-12-30')->where('created_at','<=',$request->to??'3030-12-30')->get();
        return Excel::download(new orderExp($records), 'الطلبات.xlsx');
    }
    public static function getProductionPrice()
    {
        $costs=[];
        foreach(production_types::all() as $production_type ){
            $production = productions::where('production_type_id',$production_type->id)
                                        ->get();
            if($production->count())
                $costs[]=[
                    'production_type'=>$production_type->id,
                    'costs'=>productions::where('production_type_id',$production_type->id)
                                        ->get()
                                        ->sum('total') / $production->sum('quantity')
                ];
        }

        return $costs;
    }
    public function store(Request $request)
    {
        $available_quantity= productions::where('production_type_id',$request->production_type_id)->sum('store');
        if($available_quantity < $request->quantity){
            return response()->json(['status'=>416,'quantity'=>$available_quantity]);
        }
        $quantity= $request->quantity;
        foreach(productions::where('production_type_id',$request->production_type_id)->get()->sortBy('total') as $production){
            if($production->store >= $quantity ){
                $production->decrement('store',$quantity);
                break;
            }else{
                $quantity = $quantity - $production->store;
                $production->decrement('store',$production->store);
            }
        }
        $production = $this->model::create($request->all());
        clients::find($request->clients_id)->increment('debits',$request->price * $request->quantity);
        return response()->json(['status'=>200]);
    }
    public function update(Request $request,$id)
    {
        $record =$this->model::find($id);

        $available_quantity= productions::where('production_type_id',$request->production_type_id)->sum('store');
        if(($available_quantity + $record->quantity) < $request->quantity ){
            return response()->json(['status'=>416,'quantity'=>$available_quantity]);
        }
        $client =clients::find($record->clients_id);
        $client->decrement('debits',$record->price * $record->quantity);
        productions::first()->increment('store',$record->quantity);
        $quantity= $request->quantity;
        foreach(productions::where('production_type_id',$request->production_type_id)->get()->sortBy('total') as $production){
            if($production->store >= $quantity ){
                $production->decrement('store',$quantity);
                break;
            }else{
                $quantity = $quantity - $production->store;
                $production->decrement('store',$production->store);
            }
        }
        $production = $record->update([
            'clients_id'=>$request->clients_id,
            'employees_id'=>$request->employees_id,
            'production_type_id'=>$request->production_type_id,
            'price'=>$request->price,
            'profits'=>$request->profits,
            'quantity'=>$request->quantity,
        ]);
        $client->increment('debits',$request->price * $request->quantity);
        return response()->json(['status'=>200]);
    }
    public function destroy($id)
    {
        $record =$this->model::find($id);
        $client =clients::find($record->clients_id);
        $client->decrement('debits',$record->price * $record->quantity);
        productions::first()->increment('store',$record->quantity);
        $this->model::destroy($id);
        return response()->json(['status'=>200]);
    }

}
