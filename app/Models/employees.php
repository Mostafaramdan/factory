<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employees extends Model
{
    public $timestamps = false ,$appends=['salary_per_day'];
    protected $guarded=[];
    function getSalaryPerDayAttribute()
    {
        if($this->salary_type == 'monthly'){
            return $this->salary /cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
        }else{
            return $this->salary ;
        }
    }
}
