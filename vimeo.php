<?php
    $vimeo_url = "http://vimeo.com/api/v2/video/47521525.json";
    $vimeo_info = json_decode(file_get_contents($vimeo_url));

var_dump($vimeo_info);

?>