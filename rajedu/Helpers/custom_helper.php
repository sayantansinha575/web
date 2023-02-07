<?php
if (! function_exists('asset_url')) {
	function asset_url()
	{
		return site_url('public/');
	}
}

if (! function_exists('pr')) {
    function pr($dataArr, $die = true)
    {
        echo "<pre>";
        print_r($dataArr);
        if ($die) {
            die;
        }
    }
}

if (! function_exists('slugify')) {
    function slugify($string, $spaceRepl = "-")
    {
        $string = trim($string);
        $string = str_replace("&", "and", $string);
        $string = preg_replace("/[^a-zA-Z0-9 _-]/", "", $string);
        $string = strtolower($string);
        $string = preg_replace("/[ ]+/", " ", $string);
        $string = str_replace(" ", $spaceRepl, $string);
        return $string;
    }
}

if (! function_exists('encrypt')) {
    function encrypt($string) 
    {
        $output = false;
        $key = hash('sha256', getenv('secret_key'));
        $iv = substr(hash('sha256', getenv('secret_iv')), 0, 16);
        $output = openssl_encrypt($string, getenv('encrypt_method'), $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }
}

if (! function_exists('decrypt')) {
    function decrypt($string) 
    {
        $output = false;
        $key = hash('sha256', getenv('secret_key'));
        $iv = substr(hash('sha256', getenv('secret_iv')), 0, 16);
        $output = openssl_decrypt(base64_decode($string), getenv('encrypt_method'), $key, 0, $iv);
        return $output;
    }
}

if (! function_exists('getActiveProductCountByFilters')) {
    function getActiveProductCountByFilters(string $type = '', int $id = 0 ) 
    {
        $db = db_connect();
        $builder = $db->table('view_products');
        $builder->where('type', $type);
        switch (strtolower($type)) {
            case 'pro':
                // code...
                break;
            
            default:
                // code...
                break;
        }
        $builder->where("find_in_set($id, filter_products)");
    }
}