<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Models\bills as model;
use App\Models\employees;
use App\Models\clients;


class bills extends dashboard
{
    function __construct(Request $request)
    {
        // $this->account= \App\Models\admins::where('apiToken',$request->header('Authorization'))->first();
        $this->model= model::class;
    }
    public function index(Request $request)
    {
        $records= $this->model::query();

        if($request->search){
            $records->where('id','like','%'.$request->search.'%')
                    ;
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

    public function store(Request $request)
    {
        $this->model::create($request->all());
        clients::find($request->clients_id)->decrement('debits',$request->price);
        return response()->json(['status'=>200]);
    }
    public function update(Request $request,$id)
    {
        clients::find($request->clients_id)->increment('debits',$this->model::find($id)->price);
        $this->model::where('id',$id)->update([
            'price'=>$request->price,
        ]);
        clients::find($request->clients_id)->decrement('debits',$request->price);
        return response()->json(['status'=>200]);
    }

}
