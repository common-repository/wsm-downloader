<?php
class facebook {
	
    function decoder($url) {
        $msg['success'] = false;
        $msg['body'] = 'Seems like there is nothing here!';
        $url = str_replace("m.facebook" , "facebook" , $url);
		if(strpos($url , 'watch/?v') != false){
			$url = $this->get_redirect_link($url);
		}
		
        $data = $this->wsmd_file_get_content($url);
        
        $fullstring = $data;

        $parsed = $this->get_string_between($fullstring, '?xml', '/MPD>\n');
		if($parsed== ''){
        $msg['success'] = false;
        $msg['body'] = 'Seems like there is nothing here!';
        return json_encode($msg);		
		}		
        $parsed = str_replace("\\n", "", $parsed);
        $parsed = str_replace("\\x3C", "<", $parsed);
        $parsed = str_replace("\\", "", $parsed);
        $parsed = '<?xml' . $parsed . '/MPD>';
        $xml = new SimpleXMLElement($parsed);
        $json_file = json_encode($xml, JSON_PRETTY_PRINT);
        $object = json_decode($json_file);
        $adaptation = $object->Period->AdaptationSet;
        ///video part
        if ($adaptation[0]) {
            $videos = $adaptation[0]->Representation;
            foreach ($videos as $key => $value) {
                $attr = '@attributes';
                $quality = $value->$attr->FBQualityLabel;
                $src = $value->BaseURL;
                $msg['formats'][] = ['direct_url' => $src, 'feu_url' => $src, 'type' => pathinfo(explode("?", $src)[0] , PATHINFO_EXTENSION), 'quality' => $quality, 'size' => wsmd_get_file_size($src), ];
            }
        }
        if ($sdLink = $this->getSDLink($data)) {
            $src = $sdLink;
            $msg['streams'][] = ['direct_url' => $src, 'feu_url' => $src, 'type' => pathinfo(explode("?", $src)[0] , PATHINFO_EXTENSION), 'quality' => 'LQ', 'size' => wsmd_get_file_size($src), ];
        }
        if ($hdLink = $this->getHDLink($data)) {
            $src = $hdLink;
            $msg['streams'][] = ['direct_url' => $src, 'feu_url' => $src, 'type' => pathinfo(explode("?", $src)[0] , PATHINFO_EXTENSION), 'quality' => 'HQ', 'size' => wsmd_get_file_size($src), ];
        }
        ///audio part
        if ($adaptation[1]) {
            $audio = $adaptation[1]->Representation->BaseURL;
            if ($audio) {
                $src = $audio;
                $msg['audio'][] = ['direct_url' => $src, 'feu_url' => $src, 'type' => pathinfo(explode("?", $src)[0] , PATHINFO_EXTENSION), 'quality' => '128kb', 'size' => wsmd_get_file_size($src), ];
            }
        }
		
		if($adaptation[0] or $sdLink or $hdLink or $adaptation[1]){
            $msg['success'] = true;
			$msg['thumnail_src'] = $this->getthumnail($data);
            unset($msg['body']);
            $msg['title'] = $this->getTitle($data);			
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
	
	
    function generateId($url) {
        $id = '';
        if (is_int($url)) {
            $id = $url;
        } elseif (preg_match('#(\d+)/?$#', $url, $matches)) {
            $id = $matches[1];
        }
        return $id;
    }
	
    function getthumnail($data) {
	
		$data = str_replace("<!--" , "" , $data);
		$data = str_replace("-->" , "" , $data);
		$src = '';
		$src_x = array();
        libxml_use_internal_errors(true);
        $doc = new DomDocument();
        $doc->loadHTML($data);
        $xpath = new DOMXPath($doc);
        $query = '//div[@class="hidden_elem"][1]//img';
        $metas = $xpath->query($query);
        foreach ($metas as $meta) {		
		$src_x[] = $meta->getAttribute('src');
        }
		$src = $src_x[0];
		
		if ($src == ''){
        $query = '//*/meta[starts-with(@property, \'twitter:\')]';
        $metas = $xpath->query($query);
        foreach ($metas as $meta) {
			unset($msg['body']);
            $msg['success'] = true;
            $property = $meta->getAttribute('property');
            $content = $meta->getAttribute('content');
            if ($property == 'twitter:image') {
                $src = $content;
            }
        }			
		}
        return $src;
    }	
	
	
    function cleanStr($str) {
        return html_entity_decode(strip_tags($str), ENT_QUOTES, 'UTF-8');
    }
	
    function getSDLink($curl_content) {
        $regexRateLimit = '/sd_src_no_ratelimit:"([^"]+)"/';
        $regexSrc = '/sd_src:"([^"]+)"/';
        if (preg_match($regexRateLimit, $curl_content, $match)) {
            return $match[1];
        } elseif (preg_match($regexSrc, $curl_content, $match)) {
            return $match[1];
        } else {
            return false;
        }
    }
	
	
    function getHDLink($curl_content) {
        $regexRateLimit = '/hd_src_no_ratelimit:"([^"]+)"/';
        $regexSrc = '/hd_src:"([^"]+)"/';
        if (preg_match($regexRateLimit, $curl_content, $match)) {
            return $match[1];
        } elseif (preg_match($regexSrc, $curl_content, $match)) {
            return $match[1];
        } else {
            return false;
        }
    }
	
	
    function getTitle($curl_content) {
        $title = null;
        if (preg_match('/h2 class="uiHeaderTitle"?[^>]+>(.+?)<\/h2>/', $curl_content, $matches)) {
            $title = $matches[1];
        } elseif (preg_match('/title id="pageTitle">(.+?)<\/title>/', $curl_content, $matches)) {
            $title = $matches[1];
        }
        return $this->cleanStr($title);
    }
	
	
    function getDescription($curl_content) {
        if (preg_match('/span class="hasCaption">(.+?)<\/span>/', $curl_content, $matches)) {
            return $this->cleanStr($matches[1]);
        }
        return false;
    }
	
	function get_redirect_link($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_ENCODING , "gzip");
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36 Edge/12.10240');
    $data = curl_exec($ch);
    curl_close($ch);
	$parsed = $this->get_string_between($data, 'window.location.replace("', '");</script>');
	return stripslashes($parsed);
	}
	
	
	function wsmd_file_get_content($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_ENCODING , "gzip");
    curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'sec-fetch-dest: document',
'sec-fetch-mode: navigate',
'sec-fetch-user: ?1',
'upgrade-insecure-requests: 1',
'user-agent: Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.75 Safari/537.36'
));		
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;	
	}
}