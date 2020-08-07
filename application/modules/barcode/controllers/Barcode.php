<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barcode extends MY_Controller {

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
      //  error_reporting(E_ALL);
       // $this->load->model('state/state_model');
        $this->load->model('barcode_model');
        //if(!isset($_SESSION) || count($_SESSION)<1){ $this->session_timedout(); }
    }


	public function index()
	{		 
 		$data = array();
 		$data['js_script'] = 'barcode';
        	$data['csrfName'] = $this->security->get_csrf_token_name();
        	$data['csrfHash'] = $this->security->get_csrf_hash();
	        $data['list'] = $this->barcode_model->get_all_product_list();
	        $this->load->view('../../loggedin_template/header',$data);
        	$this->load->view('barcode_add',$data);
        	$this->load->view('../../loggedin_template/footer',$data);
        	//$this->load->view('barcode_add.php');
	}
	
	public function generate()
	{
	
		$id=$this->input->post('ProductId');
		$result=$this->barcode_model->get_product_details_by_id($id);
		$data['ProductName']=$result['ProductName'];
		$data['diprice']=$result['Diprice'];
		$data['Batch']=$result['Batch'];
		$data['Expiry']=$result['Expiry'];
		$data['BarcodeCount']=$this->input->post('BarcodeCount');
		$data['js_script'] = 'barcode';
		$data['ProductBarcode'] = $result['ProductBarcode'];


		//$file=$this->barcode( '', $text, '','', $code_type, $print, $sizefactor,$product, $price,$expiry,$batch );
		include(APPPATH.'third_party/php-barcode-generator/src/BarcodeGenerator.php');
		include(APPPATH.'third_party/php-barcode-generator/src/BarcodeGeneratorPNG.php');
		$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
		$barcode = $generator->getBarcode($data, $generator::TYPE_CODE_128);

		file_put_contents('barcode.png', $barcode);
		$this->load->view('generate',$data);
		/*
		
			
		include(APPPATH.'third_party/php-barcode-generator/src/BarcodeGeneratorSVG.php');
			include(APPPATH.'third_party/php-barcode-generator/src/BarcodeGeneratorHTML.php');
		$generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
		$generatorSVG = new Picqer\Barcode\BarcodeGeneratorSVG();
		//$generatorHTML = new Picqer\Barcode\BarcodeGeneratorHTML();	
		$no  = $this->randomNumber(13);
		//$no = str_pad($no, 12, "0", STR_PAD_LEFT);
		$code=$no;
		$Bar = new Picqer\Barcode\BarcodeGeneratorHTML();
		//$barcode=$Bar->getBarcode($code, $Bar::TYPE_CODE_128);
		
		$barcode=$Bar->getBarcode($result['ProductBarcode'], $Bar::TYPE_CODE_128);
		$code=$this->barcode_model->barcode_update($barcode);
		$data['code'] = $code;		
      

        //$this->assertStringEqualsFile('tests/verified-files/081231723897-ean13.svg', $generated);
    */
    
    
		
		
	}
	
 public	function randomNumber($length) {
    $result = '';

    for($i = 0; $i < $length; $i++) {
        $result .= mt_rand(0, 9);
    }

    return $result;
}





}
