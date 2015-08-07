<?php defined('SYSPATH') or die('No direct script access.');

class Controller_BeerDataProviderSearcher extends Controller {

    public function action_index()
    {
        $query=$this->request->query('name');
        $domain = "http://ocen-piwo.pl";
        $listUrl= "Mapa_strony.html";
        $content = file_get_contents($domain."/".$listUrl);

        $regex="/<a href=\'([^\']*?)\'\s".
            "id='[^\']*?\'\s".
            "><b>".
            "([^\']*?".$query."[^\']*?)".
            "<\/b>/i";

        $cnt = preg_match_all(
            $regex,
            $content,
            $matches
        );

        $ret = array();
        for ($i=0;$i<$cnt;$i++){
            $ret[$i]=array(
                "name"=>$matches[2][$i],
                "url" =>$domain."/".$matches[1][$i],
            );
        }

        $this->response->body(json_encode($ret));
    }

}