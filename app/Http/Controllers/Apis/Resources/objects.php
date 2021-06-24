<?php
namespace App\Http\Controllers\Apis\Resources;

use App\Http\Controllers\Apis\Helper\helper ;
use  App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Controller;
use App\Models\phones;
use App\Models\emails;
use App\Models\favourites;
use App\Models\biddings;
use App\Models\bidders;
use App\Models\carts;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class objects extends index
{
    public static function account ($record)
    {
        if($record == null  ) {return null;}
        $object = [];
        $object['apiToken'] = $record->apiToken;
        $object['phone'] = $record->phone;
        $object[Str::singular($record->getTable())] = self::{Str::singular($record->getTable())}($record);

        return $object;
    }

    public static function currency ($record)
    {
        $object = [];
        $object['id'] = $record->id;
        $object['name'] = $record->{'name_'.self::$lang};
        $object['code'] = $record->code;
        $object['value_in_dollar'] = $record->value_in_dollar;

        return $object;
    }
    public static function user ($record)
    {
        if($record == null  ) {return null;}
        $object = [];
        $object['id'] = $record->id;
        $object['name'] = $record->name;
        $record->currency ? $object['currency'] = self::currency($record->currency) : null ;
        $record->image?$object['image'] =Request()->root().$record->image:$object['image'] =null;
        $object['email'] = $record->email;
        $object['phone'] = $record->phone;
        $object['lang'] = $record->lang;
        $object['fees']= $record->fees ;
        !$record->currency ? :$object['currency']= self::currency($record->currency );
        !$record->region ? :$object['city']= self::region($record->region );

        return $object;
    }

    public static function service ($record)
    {
        if($record == null  ) {return null;}
        $object = [];
        $object['id'] = $record->id;
        $object['name'] = $record->{'name_'.self::$lang};
        $object['price'] = $record->price;
        $object['warrantyPeriod'] = $record->warranty_period;
        $object['warrantyType'] = $record->warranty_type;
        $object['lang'] = $record->lang;
        return $object;
    }

    public static function provider ($record)
    {
        if($record == null  ) {return null;}
        $object = [];
        $object['id'] = $record->id;
        $object['name'] = $record->name;
        $object['email'] = $record->email;
        $object['description'] = $record->description;
        $object['phone'] = $record->phone;
        $record->company ? $object['company'] = $record->company:null;;
        $object['categories'] = self::ArrayOfObjects($record->categories??[],'category');
        $object['location'] = self::location($record->location);
        $object['reviews'] = self::ArrayOfObjects($record->reviews??[],'review');
        $object['images'] = self::ArrayOfObjects($record->images??[],'image');
        $object['reviewCount'] = $record->reviews->count();
        $object['review'] = round($record->reviews->avg('rate'),2);
        $object['ifFav'] =favourites::where('users_id',self::$account->id,)->where('providers_id',$record->id)->count()? true:false;
        $object['lang'] = $record->lang;
        return $object;
    }

    public static function userMin ($record)
    {
        if($record == null  ) {return null;}
        $object = [];
        $object['id'] = $record->id;
        $object['name'] = $record->name;
        $record->image?$object['image'] =Request()->root().$record->image:$object['image'] =null;
        return $object;
    }

    public static function category ($record)
    {

        $object = [];
        $object['id'] = $record->id;
        $object['name']=$record['name_'.self::$lang];
       $object['images'] = self::image($record->image) ;
        return $object;
    }
    public static function location ($record)
    {
        if($record == null  ) {return null;}
        $object = [];
        $object['id']=$record->id;
        $object['longitude']=$record->longitude;
        $object['latitude']=$record->latitude;
        $object['address']=$record->address;
        $object['description']=$record['description_'.self::$lang];
        return $object;
    }

    public static function notification  ($record){
        // this object take record from notify table ;
        if($record == null  ) {return null;}
        $object['id'] = $record->id;
        $object['type'] = $record->notification->type;
        $object['content']=$record->notification['content_'.self::$lang];
        $record->orders? $object['order'] = self::order($record->orders):false;
        $object['isSeen'] = $record->isSeen == 1 ? true : false ;
        $object['createdAt'] = $record->created_at;
        return $object;
    }

    public static function info ($record)
    {

        $object = [];
        $object['aboutUs']=$record['aboutUs_'.self::$lang];
        $object['policyTerms']=$record['policyTerms_'.self::$lang];
        $object['privacy']=$record['privacy_'.self::$lang];
        $object['emails'] = $record->emails;
        $object['phones'] = $record->phones;
        return $object;
    }


    public static function countryInRegion ($record)
    {

        $object = [];
        $object['id'] = $record->id;
        $object['name'] = $record->{'name_'.self::$lang};
        $record->cities->count()?$object['cities'] = self::ArrayOfObjects($record->cities,'region'):null;
        return $object;
    }
    public static function region ($record)
    {

        $object = [];
        $object['id'] = $record->id;
        $object['name'] = $record->{'name_'.self::$lang};
        $record->regions->count()?$object['districts'] = self::ArrayOfObjects($record->regions,'region'):null;
        return $object;
    }

    public static function country ($record)
    {

        $object = [];
        $object['id'] = $record->id;
        $object['name'] = $record->{'name_'.self::$lang};
        return $object;
    }

    public static function city ($record)
    {
        $object = [];
        $object['id'] = $record->id;
        $object['name'] = $record->{'name_'.self::$lang};
        return $object;
    }
    public static function product ($record)
    {
        $object = [];
        $object['id'] = $record->id;
        $object['name'] = $record->{'name_'.self::$lang};
        $object['description'] = $record->{'description_'.self::$lang};
        $object['price'] = $record->price;
        $object['features'] = self::ArrayOfObjects($record->features??[],'feature');
        $object['images'] = self::ArrayOfObjects($record->images??[],'image');
        $object['model'] = $record->model;
        $object['status'] = $record->status;
        $object['model'] = $record->model;
        $object['modelYear'] = $record->model_year;
        $object['brand'] = self::brand($record->brand);
        return $object;
    }

    public static function image ($record)
    {
        $object = [];
        $object['id'] = $record->id;
        $object['image'] = Str::contains($record->image,'http') ? $record->image :Request()->root().$record->image;
        return $object;
    }
    public static function feature ($record)
    {
        $object = [];
        $object['id'] = $record->id;
        $object['name'] = $record->{'name_'.self::$lang};
        $object['image'] = Str::contains($record->image,'http') ? $record->image :Request()->root().$record->image;
        return $object;
    }


    public static function order ($record)
    {
        $object = [];
        $object['id'] = (double)$record->id;
        $object['date'] = (double) strtotime( $record->date);
        $object['time'] = (double) strtotime($record->time);
        $object['status'] = $record->status;
        $object['materials'] = $record->materials;
        $object['description'] = $record->description;
        $object['location'] = self::location($record->location);
        $object['provider'] = self::provider($record->provider);
        $record->voucher ? $object['discount'] = (double)$record->voucher->discount : null ;
        $object['fees'] = $record->fees;
        $object['carts']  = self::ArrayOfObjects($record->carts,'cart');
        $object['images']  = self::ArrayOfObjects($record->images,'image');
        return $object;
    }
    public static function cart ($record)
    {
        $object = [];
        $object['id'] = (double)$record->id;
        $object['price'] = (double)$record->price;
        !$record->service? :$object['service'] = self::service($record->service);
        $record->service? :$object['others'] = true;
        $object['warrantyPeriod'] = $record->warranty_period;
        return $object;
    }

    public static function review ($record)
    {
        $object = [];
        $object['id'] = $record->id;
        $object['user'] = self::userMin($record->user);
        $object['rate'] = $record->rate;
        $object['comment'] = $record->comment;
        return $object;
    }



    public static function ArrayOfObjects ($Items, $objectname)
    {
        if(count($Items)==0) return $Items;
        $Array = [];
        foreach ($Items as $Item) {
            $Item ? $Array[] = self::$objectname($Item) :null;
        }
        return $Array;
    }
}
