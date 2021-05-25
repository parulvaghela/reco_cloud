<?php
/**
 * LeagueMeme.com
 *
 * Public Template controller
 *
 * LICENSE:
 *
 * @package		Public
 * @subpackage  Template Controller
 * @author		mayur
 * @copyright	Copyright (c) 2015 Web Development Experts
 * @link		http://www.WebDevelopment.expert
 * @since		Version 5.0
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Template_public extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model','user');
    }

    public function index($data) {
        $data['header'] = $this->header();
        $data['footer'] = $this->footer();
        $data['top_nav'] = $this->top_nav();
        $data['sidebar'] = $this->sidebar();
        $this->load->view('template/main', $data);
        
    }
    
    public function header(){		
       return $this->load->view('template/header','', true);
    }	
    public function top_nav(){
        $data = array();
        if($this->session->userdata('user_logged_in'))
        {
            $u_id = $this->session->userdata('user_logged_in')['id'];
        }
        return $this->load->view('template/top_nav', $data, true);
    }

    public function footer(){
        $data = array();
        return $this->load->view('template/footer',$data, true);
    }
    public function sidebar() {
        $data = array();
        if($this->session->userdata('user_logged_in'))
        {
            $u_id = $this->session->userdata('user_logged_in')['id'];
            $result = $this->user->get_userdata_byid($u_id);
            if($result != 0)
            {
                $data['register_type'] = $result['register_type'];
                $data['profile_pic'] = $result['profile_pic'];
                $data['first_name'] = $result['first_name'];
                $data['last_name'] = $result['last_name'];
            }
        }
        return $this->load->view('template/sidebar',$data, true);
     }

}
