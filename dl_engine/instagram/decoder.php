<?php
class instagram {
    function decoder($url) {
        $msg['success'] = false;
        $msg['body'] = 'Seems like there is nothing here!';
		
		$fixed_url = explode('?' , $url);
		$url = rtrim($fixed_url[0] , '/');
		
		$data0 = json_decode(wsmd_file_get_content('https://api.instagram.com/oembed/?url='.$url));
		
		if(isset($data0->title)){
			$msg['title'] = $data0->title;
            $msg['thumnail_src'] = $data0->thumbnail_url;
            $msg['success'] = true;
                    $src = $data0->thumbnail_url;
                    $quality = $data0->thumbnail_width . 'x' . $data0->thumbnail_height;
					$type_p = pathinfo(explode("?" , $src)[0], PATHINFO_EXTENSION);
                    $msg['photo'][] = ['direct_url' => $src, 'feu_url' => $src, 'type' => $type_p, 'quality' => $quality, 'size' => wsmd_get_file_size($src), ];			
		}
		
        $data = wsmd_file_get_content($url.'/embed/captioned/');
          
        ////////aditional info extractor
        $json_file = $this->get_string_between($data, "window.__additionalDataLoaded('graphql',", ');');
        $parsed_json = json_decode($json_file);
        $post_page[0] = $parsed_json;
		
		if($post_page[0] == ''){
        $json_file = $this->get_string_between($data, "window.__additionalDataLoaded('extra',", ');');
        $parsed_json = json_decode($json_file);
        $post_page[0] = $parsed_json;			
		}
		
		if($post_page[0] == ''){
		$data = wsmd_file_get_content($url);	
        $json_file = $this->get_string_between($data, "window._sharedData =", ';</script>');
        $parsed_json = json_decode($json_file);
        $post_page1 = $parsed_json->entry_data->PostPage;
         $post_page[0] = $post_page1[0]->graphql;		
		}		
            
                
           if(isset($post_page[0]->shortcode_media->display_url)){
			   unset($msg['photo']);
            $msg['thumnail_src'] = $post_page[0]->shortcode_media->display_url;
            $msg['success'] = true;
                    $src = $post_page[0]->shortcode_media->display_url;
                    $quality = $data0->thumbnail_width . 'x' . $data0->thumbnail_height;
					$type_p = pathinfo(explode("?" , $src)[0], PATHINFO_EXTENSION);
                    $msg['photo'][] = ['direct_url' => $src, 'feu_url' => $src, 'type' => $type_p, 'quality' => $quality, 'size' => wsmd_get_file_size($src), ];			   
		   }
           
                
           if(isset($post_page[0]->shortcode_media->video_url)){
                $src = $post_page[0]->shortcode_media->video_url;
				$type = pathinfo(explode("?" , $src)[0], PATHINFO_EXTENSION);
                $msg['streams'][] = ['direct_url' => $src, 'feu_url' => $src, 'type' => $type, 'quality' => 'HQ', 'size' => wsmd_get_file_size($src), ];
		   }
		

        if (!empty($post_page[0]->shortcode_media->edge_sidecar_to_children)) {
            $childrens = $post_page[0]->shortcode_media->edge_sidecar_to_children->edges;
            foreach ($childrens as $child) {
                $child_node = $child->node;
                if ($child_node->is_video === true) {
                    $src = $child_node->video_url;
					$type_v = pathinfo(explode("?" , $src)[0], PATHINFO_EXTENSION);
                    $msg['streams'][] = ['direct_url' => $src, 'feu_url' => $src, 'type' => $type_v, 'quality' => 'HQ', 'size' => wsmd_get_file_size($src), ];
                } else {
                    $src = $child_node->display_url;
                    $quality = $child_node->dimensions->width . 'x' . $child_node->dimensions->height;
					$type_p = pathinfo(explode("?" , $src)[0], PATHINFO_EXTENSION);
                    $msg['photo'][] = ['direct_url' => $src, 'feu_url' => $src, 'type' => $type_p, 'quality' => $quality, 'size' => wsmd_get_file_size($src), ];
                }
            }
        }


       if(empty($msg['photo']) and !empty($post_page[0]->shortcode_media->display_resources)){
        $resurces = $post_page[0]->shortcode_media->display_resources;
		foreach($resurces as $resurce){
                    $src = $resurce->src;
                    $quality = $resurce->config_width . 'x' . $resurce->config_height;
					$type_p = pathinfo(explode("?" , $src)[0], PATHINFO_EXTENSION);
                    $msg['photo'][] = ['direct_url' => $src, 'feu_url' => $src, 'type' => $type_p, 'quality' => $quality, 'size' => wsmd_get_file_size($src), ];			
		}
	   }
	   
if(empty($msg['photo'][1]) and $msg['success'] == false){ 
$data = wsmd_file_get_content($url.'/embed/');	  
$first_extract = $this->get_string_between(str_replace('&amp;' , '&' , $data) , '<img class="EmbeddedMediaImage"' , '/>');
$second = $this->get_string_between($first_extract , 'srcset="' , '"');
$exloded = explode("," , $second);
$msg['success'] = true;
foreach($exloded as $explod1){
	$extract = explode(' ' , $explod1);
	$msg['photo'][] = ['direct_url' => $extract[0], 'feu_url' => $extract[0], 'type' => 'jpg' , 'quality' => $extract[1], 'size' => wsmd_get_file_size($extract[0]), ];
	$msg['thumnail_src'] =$extract[0];
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