<?php defined('SYSPATH') or die('No direct script access.');

class Helper_PublicLevelOfWanted extends Controller
{
    public static $maxLevel = 3;
    public static function encodePublicLevel($publicityArray)
    {
        $encoded = 0;
        foreach ($publicityArray as $key => $value) {

            if ($value=='name'		) $encoded+=1;
            if ($value=='notes'		) $encoded+=2;
        }

        return $encoded;
    }
    public static function encodePublicLevel2($publicityArray)
    {
        $encoded = 0;

        if ($publicityArray['name']		 ===true) $encoded+=1;
        if ($publicityArray['notes']	 ===true) $encoded+=2;

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
        $publicityArray['notes']=false;

        if (Helper_PublicLevelOfWanted::getFlag($encodedLevel,0)) $publicityArray['name']=true;
        if (Helper_PublicLevelOfWanted::getFlag($encodedLevel,1)) $publicityArray['notes']=true;

        return $publicityArray;

    }

    private static $translations = array("name"=>"nazwa", "rating"=>"ocena", "photo"=>"zdjęcie", "date"=>"data", "location"=>"lokal", "companions"=>"towarzystwo", "notes"=>"notatki");
    public static function translateRawPublicityName($input)
    {
        return Helper_PublicLevelOfWanted::$translations[$input];
    }
}