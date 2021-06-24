<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    public $timestamps = false,$with=['client','production_type','employee'];
    protected $guarded=[];
    function production_type(){
        return $this->belongsTo(production_types::class,'production_type_id');
    }
    function employee(){
        return $this->belongsTo(employees::class,'employees_id');
    }
    function client(){
        return $this->belongsTo(clients::class,'clients_id');
    }

}
