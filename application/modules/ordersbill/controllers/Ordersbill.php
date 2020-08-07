<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ordersbill extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

    public function __construct() {
        parent::__construct();
        $this->load->model('ordersbill/ordersbill_model');

    }
    
    public function partywise_bills_list()
    {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'orders';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->ordersbill_model->get_partywise_bills_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('ordersbill/orders_partywise_bill_list',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }
    
    
} // end of class