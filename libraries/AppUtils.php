<?php

// library for re-usable utility functions
// All methods should be static, accessed like: AppUtils::method(...);
class AppUtils {

    /*-------------------------------------------------------------------------------------------------
    
    -------------------------------------------------------------------------------------------------*/
    public static function test_input($data) {
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = stripslashes($data);
        return $data;
    }

    public static function yt_video_info($url) {
        // requires extension=php_curl.dll in php.ini
        // in particular interested in thumbnail_url and title.
        $youtube = "http://www.youtube.com/oembed?url=". $url ."&format=json";
        $curl = curl_init($youtube);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        return json_decode($result, true);
    }
    public static function ytv_get_info($yt_video_id) {
        
        $content = file_get_contents("http://youtube.com/get_video_info?video_id=".$yt_video_id);
        parse_str($content, $ytarr);
        if (isset($ytarr['title']) && isset($ytarr['thumbnail_url'])) {
            $video['title'] = $ytarr['title'];
            $video['thumbnail_url'] = $ytarr['thumbnail_url'];
            return $video;
        }
        else {
            // Embedded Disabled
            return NULL;
        }
        
    }
} #eoc    