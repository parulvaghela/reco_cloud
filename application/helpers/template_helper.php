<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    /* Applies a page template to a returned view */
    
    function load_admin_template($data)
    {
        echo Modules::run('admin/template_admin/index', $data);
    }
    
    function load_public_template($data)
    {
        echo Modules::run('public/template_public/index', $data);
	}
	function key_encrypt($string) {
        $secret_key = 'USER_ENCRYPT_DECRYPT_KEY';
        $secret_iv = 'earth_secret_iv';
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        return base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
        //$output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
    }
    function key_decrypt($string) {
        $secret_key = 'USER_ENCRYPT_DECRYPT_KEY';
        $secret_iv = 'earth_secret_iv';
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        return openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        //base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
    }

?>
