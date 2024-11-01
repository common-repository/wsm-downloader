<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class bandcamp {
	
	
    ///////////////////////////////////////////////decoder functions
    function decoder($url) {
		$msg['success'] = false;
        $msg['body'] = 'Seems like there is nothing here!';
        $data = wsmd_file_get_content($url);
        libxml_use_internal_errors(true);
        $doc = new DomDocument();
        $doc->loadHTML($data);
        $xpath = new DOMXPath($doc);
        $query = '//*/meta[starts-with(@property, \'og:\')]';
        $metas = $xpath->query($query);
        foreach ($metas as $meta) {
			unset($msg['body']);
            $msg['success'] = true;
            $property = $meta->getAttribute('property');
            $content = $meta->getAttribute('content');
            if ($property == 'og:title') {
                $msg['title'] = $content;
            }
            if ($property == 'og:image') {
                $msg['thumnail_src'] = $content;
            }
			
            if ($property == 'og:video:secure_url') {
                $embed = $content;
            }			
        }
        ////////decode content
        $data = wsmd_file_get_content($embed);
        $json_file = $this->get_string_between($data, 'var playerdata = ', '};');
        $parsed_json = json_decode($json_file . '}');
        $tracks = $parsed_json->tracks;
        foreach ($tracks as $files) {
            foreach ($files->file as $key => $audio) {
                $src = $audio;
                $type_qu = explode("-", $key);
                $msg['audio'][] = ['direct_url' => $src, 'feu_url' => $src, 'track' => $files->title, 'type' => $type_qu[0], 'quality' => $type_qu[1], 'size' => wsmd_get_file_size($src), ];
            }
        }
        return json_encode($msg);
    }
	
	
    function get_string_between($string, $start, $end) {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini+= strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

}