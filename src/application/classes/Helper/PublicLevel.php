<?php defined('SYSPATH') or die('No direct script access.');

class Helper_PublicLevel extends Controller
{
    public static $maxLevel = 127;
    public static function encodePublicLevel($publicityArray)
    {
        $encoded = 0;
        foreach ($publicityArray as $key => $value) {

            if ($value=='name'		) $encoded+=1;
            if ($value=='rating'	) $encoded+=2;
            if ($value=='photo'		) $encoded+=4;
            if ($value=='date'		) $encoded+=8;
            if ($value=='location'	) $encoded+=16;
            if ($value=='companions') $encoded+=32;
            if ($value=='notes'		) $encoded+=64;
        }

        return $encoded;
    }
    public static function encodePublicLevel2($publicityArray)
    {
        $encoded = 0;

        if ($publicityArray['name']		 ===true) $encoded+=1;
        if ($publicityArray['rating']	 ===true) $encoded+=2;
        if ($publicityArray['photo']	 ===true) $encoded+=4;
        if ($publicityArray['date']		 ===true) $encoded+=8;
        if ($publicityArray['location']	 ===true) $encoded+=16;
        if ($publicityArray['companions']===true) $encoded+=32;
        if ($publicityArray['notes']	 ===true) $encoded+=64;

        return $encoded;

    }
    private static function getFlag($encoded, $num)
    {
        $encoded+=4096;
        return decbin($encoded)[strlen(decbin($encoded))-$num-1];
    }
    public static function decodePublicLevel($encodedLevel)
    {
        $publicityArray=array();
        $publicityArray['name']=false;
        $publicityArray['rating']=false;
        $publicityArray['photo']=false;
        $publicityArray['date']=false;
        $publicityArray['location']=false;
        $publicityArray['companions']=false;
        $publicityArray['notes']=false;

        if (Helper_PublicLevel::getFlag($encodedLevel,0)) $publicityArray['name']=true;
        if (Helper_PublicLevel::getFlag($encodedLevel,1)) $publicityArray['rating']=true;
        if (Helper_PublicLevel::getFlag($encodedLevel,2)) $publicityArray['photo']=true;
        if (Helper_PublicLevel::getFlag($encodedLevel,3)) $publicityArray['date']=true;
        if (Helper_PublicLevel::getFlag($encodedLevel,4)) $publicityArray['location']=true;
        if (Helper_PublicLevel::getFlag($encodedLevel,5)) $publicityArray['companions']=true;
        if (Helper_PublicLevel::getFlag($encodedLevel,6)) $publicityArray['notes']=true;

        return $publicityArray;

    }

    private static $translations = array("name"=>"nazwa", "rating"=>"ocena", "photo"=>"zdjęcie", "date"=>"data", "location"=>"lokal", "companions"=>"towarzystwo", "notes"=>"notatki");
    public static function translateRawPublicityName($input)
    {
        return Helper_PublicLevel::$translations[$input];
    }
}