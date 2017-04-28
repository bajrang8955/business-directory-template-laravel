<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    public $timestamps = false;


    public static function get($key, $default = null)
    {

        $result = Setting::where('key', $key)->first();

        if($result){
            return $result->value;
        }else{
            if($default == null){
                return false;
            }else{
                return $default;
            }
            
        }

    }

    public static function set($key, $value)
    {
        $result = Setting::where('key', $key)->first();

        if($result){

            $result->value = $value;

            if($result->save()){
                return true;
            }
            
        }

        return false;

    }

    public static function forget($key)
    {
        $result = Setting::where('key', $key)->first();

        if($result){
            if($result->delete()){
                return true;
            }else{
                return false;
            }
        }

        return true;
    }

    public static function flush()
    {
        if(Setting::getQuery()->delete()){
            return true;
        }else{
            return false;
        }
    }

}
