<?php
//$user_id = $this->session->userdata('users_id');
if($this->session->userdata('logged_in')){
    echo $header;
    echo $top_nav;
    echo $sidebar;
}
echo $content;
if($this->session->userdata('logged_in')){
    echo $footer;
}
?>

