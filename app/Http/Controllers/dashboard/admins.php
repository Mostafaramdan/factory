<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Models\admins as model;
use Illuminate\Support\Facades\Hash;

class admins extends dashboard

{
    function __construct()
    {
        $this->model= model::class;
    }
    public function index(Request $request)
    {
        $records= $this->model::whereNotIn('phone',['0123456789']);
        if($request->search){
            $records->where('name','like','%'.$request->search.'%')
                    ->orWhere('email','like','%'.$request->search.'%')
                    ->orWhere('phone','like','%'.$request->search.'%')
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
        // if($this->model::where('email',$request->email)->count()){
        //     return response()->json(['status'=>403]);
        // }
        if($this->model::where('phone',$request->phone)->count()){
            return response()->json(['status'=>404]);
        }
        $this->model::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'permissions'=>json_encode(config('dashboard.permissions')),
            'password'=>Hash::make($request->password),
        ]);
        return response()->json(['status'=>200]);
    }
    public function update(Request $request, $id)
    {
        // if($this->model::where('email',$request->email)->where('id','!=',$id)->count()){
        //     return response()->json(['status'=>403]);
        // }
        if($this->model::where('phone',$request->phone)->where('id','!=',$id)->count()){
            return response()->json(['status'=>404]);
        }
        $update= [
            'name'=>$request->name,
            'email'=>$request->email,
            'permissions'=>$request->permissions,
            'phone'=>$request->phone,
        ];
        if($request->password){
            $update['password']=Hash::make($request->password);
        }
        $this->model::where('id',$id)->update($update);
        return response()->json(['status'=>200]);
    }

}
