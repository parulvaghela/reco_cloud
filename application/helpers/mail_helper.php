<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



if (!function_exists('forward_mail')) {

    function forward_mail($email, $message, $subject = '', $attachment = '', $from_name = '') {
        $CI = get_instance();

        $CI->load->model('admin/admin_model','admin');
        $email_setting = $CI->admin->email_setting_data();
        $from_name = $email_setting['name'];
        $smtp_username = $email_setting['smtp_user'];
      //  $smtp_pass = $email_setting['smtp_pass'];
        $reply_to = $email_setting['reply_to'];
        $smtp_port = $email_setting['smtp_port'];
        $smtp_host = $email_setting['smtp_host'];
        $smtp_pass = 'Itabtech2021@';
        
        if (empty($from_name)) {
            $from_name = "itabtechinfosys";
        }
        
        $email_from = $smtp_username;
    
        $email_config = Array(
            'protocol' => 'smtp',
            'smtp_host' => $smtp_host,
            'smtp_port' => $smtp_port,
            'smtp_user' => $smtp_username,
            'smtp_pass' => $smtp_pass,
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE
        );
       // echo '<pre>'; print_r($email_config); exit;
        $CI->load->library('email', $email_config);
        $CI->email->set_newline("\r\n");

        $CI->email->subject($subject);
        $CI->email->to($email);
        $CI->email->reply_to($reply_to, $from_name);
        $CI->email->from($email_from, $from_name);
        $CI->email->message($message);
        if (!empty($attachment))
        {
            $CI->email->attach($attachment);
        }
        $result = $CI->email->send();
        return $result;
        exit;
    }

}
