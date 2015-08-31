<?php defined('SYSPATH') or die('No direct script access.');

class Helper_BeerDataProviderSearcher extends Controller
{
    public static function getDatabaseFilename()
    {
        return dirname(__FILE__)."/../../../files/Mapa_strony.html";
    }
    private static function getDatabaseDate()
    {
        return filemtime(Helper_BeerDataProviderSearcher::getDatabaseFilename());
    }
    public static function isDatabaseOutdated()
    {
        return( Helper_BeerDataProviderSearcher::getDatabaseDate()+ 2* 24*60*60 < time() );
    }
    private static function file_get_contents_utf8($fn) {
        $content = file_get_contents($fn);
        return mb_convert_encoding($content, 'UTF-8');
    }

    public static function updateDatabaseFile()
    {
        file_put_contents(Helper_BeerDataProviderSearcher::getDatabaseFilename(), Helper_BeerDataProviderSearcher::file_get_contents_utf8("http://ocen-piwo.pl/Mapa_strony.html"));
    }

}