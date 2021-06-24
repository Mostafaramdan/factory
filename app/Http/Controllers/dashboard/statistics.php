<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Models\orders as model;
use App\Models\services;
use App\Models\categories;
use App\Models\productions;
use App\Models\employees;
use App\Models\production_types;

class statistics extends dashboard
{
    public static $request;
    function __construct(Request $request)
    {
        $this->model= model::class;
        self::$request= $request;
    }
    public function index(Request $request)
    {

        $record=[
            'waiting'=> $this->model::where('created_at','>=',$request->from??'2020-12-30')->where('created_at','<=',$request->to??'3030-12-30')->count(),
            'orders'=> $this->model::where('created_at','>=',$request->from??'2020-12-30')->count(),
            'allOrders'=> $this->model::where('created_at','>=',$request->from??'2020-12-30')->where('created_at','<=',$request->to??'3030-12-30')->forPage(0,100)->get(),
            'price'=>  $this->model::where('created_at','>=',$request->from??'2020-12-30')->where('created_at','<=',$request->to??'3030-12-30')->sum('price'),
            'quantity'=>  $this->model::where('created_at','>=',$request->from??'2020-12-30')->where('created_at','<=',$request->to??'3030-12-30')->sum('quantity'),
            'total_quantity'=>  productions::where('created_at','>=',$request->from??'2020-12-30')->where('created_at','<=',$request->to??'3030-12-30')->sum('quantity'),
            'expenses'=>  productions::where('created_at','>=',$request->from??'2020-12-30')->where('created_at','<=',$request->to??'3030-12-30')->get()->sum('total'),
            'salaries'=>  employees::all()->sum('salary_per_day'),
            'profits'=>  $this->model::where('created_at','>=',$request->from??'2020-12-30')->where('created_at','<=',$request->to??'3030-12-30')->sum('profits'),
            'total_productions'=>self::total_production()
        ];

        return response()->json([
            "status"=>200,
            "record"=>$record,
        ]);
    }
    public static function total_production()
    {
        $total_production=[];
        foreach(production_types::all() as $type){
            $total_production[] =
            [
                'production_type'=>$type,
                'total'=>productions::where('production_type_id',$type->id)
                        // ->where('created_at','>=',self::$request->from??'2020-12-30')
                        // ->where('created_at','<=',self::$request->to??'3030-12-30')
                        ->sum('store')
                ];
        }
        return $total_production;
    }
}
