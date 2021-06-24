<?php
namespace App\Http\Controllers\Apis\Controllers\register;

use App\Http\Controllers\Apis\Helper\helper ;
use App\Http\Controllers\Apis\Resources\objects;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\sessions;
use App\Models\users;
use App\Models\locations;
use Illuminate\Support\Facades\Hash;

/**
 *
 *
 * APIs for register
 */

class registerController extends index
{
    public static function api ()
    {
        $request=self::$request;

        if($request->location){
            $location = locations::create($request->location);
        }
        $record= users::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'image'=>$request->image,
            'locations_id'=>$location->id??null,
            'regions_id'=>$request->cityId,
            'password'=>Hash::make($request->password),
            'apiToken'=>helper::UniqueRandomXChar(70,['users','providers']),
            'image'=>helper::base64_image($request->image,'users'),
            'fireBaseToken'=>$request->fireBaseToken,
            'lang'=>$request->lang??'ar',

        ]);
        $session = sessions::createUpdate([
                $record->getTable().'_id' =>$record->id,
                // 'code'=>helper::RandomXDigits(5)
                'code'=>1234
            ]);
        // helper::sendSms( $record->phone, $session->code );
        return [
            'status'=>200,
            'message'=>self::$messages['register']["200"],
            'account'=>objects::account($record)
        ];
    }
}
