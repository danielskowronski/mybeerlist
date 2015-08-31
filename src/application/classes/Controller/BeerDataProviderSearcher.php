<?php defined('SYSPATH') or die('No direct script access.');

class Controller_BeerDataProviderSearcher extends Controller {

    public function action_index()
    {
        $queriedBeerName=$this->request->query('name');

        if (Helper_BeerDataProviderSearcher::isDatabaseOutdated())
        {
            Helper_BeerDataProviderSearcher::updateDatabaseFile();
        }

        $databaseContent = file_get_contents(Helper_BeerDataProviderSearcher::getDatabaseFilename());

        $regex="/<a\shref=\'([^\']*?)\'\s".
            "id='[^\']*?\'\s".
            "><b>".
            "([^\']*?".$queriedBeerName."[^\']*?)".
            "<\/b>/iu";

        $resultsCnt = preg_match_all(
            $regex,
            $databaseContent,
            $matches
        );

        $domain = "http://ocen-piwo.pl/";
        $results = array();
        for ($i=0;$i<$resultsCnt;$i++){
            $results[$i]=array(
                "name"=>$matches[2][$i],
                "url" =>$domain."/".$matches[1][$i],
            );
        }

        $this->response->body(json_encode($results));
    }

}