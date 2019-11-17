<?php

function pathHelper()
{
    $CI =& get_instance();
    $data = array(
        'base_url' 		 => base_url(),
        'assets_path'  => base_url().'assets/',
        'plugins_path' => base_url().'plugins/',
        'controller_name' => $CI->uri->segment(2),
        'method_name' => $CI->uri->segment(3),
    );
    return $data;
}
