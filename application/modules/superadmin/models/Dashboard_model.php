<?php

class Dashboard_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }


    public function get_dashboard_count(){
        $query_cat = $this->db->query("SELECT id FROM CategoryMaster");
        $ttl_category = $query_cat->num_rows();
        
        $query_prod = $this->db->query("SELECT id FROM ProductMaster");
        $ttl_products = $query_prod->num_rows();
        
        $query_shop = $this->db->query("SELECT id FROM ShopMaster");
        $ttl_shop = $query_shop->num_rows();
        
        $query_user = $this->db->query("SELECT id FROM UserMaster");
        $ttl_user = $query_user->num_rows();
        
        return array('categories'=>$ttl_category,'products'=>$ttl_products,'shop'=>$ttl_shop,'user'=>$ttl_user);
        
    }
    
    public function get_shopsettings(){
        $shopquery = $this->db->query("SELECT FlagTitle,FlagSetValue FROM ShopSettings ");
        $shopdatas = $shopquery->result_array();
        foreach($shopdatas as $s){
            $shopdata[$s['FlagTitle']] = $s['FlagSetValue'];
        }
        return $shopdata;
    }
    

    
    public function set_shopsettings(){
	    $task = $this->input->post('task');
	    $taskvalue = $this->input->post('taskvalue');
        $q = $this->db->query("UPDATE ShopSettings SET FlagSetValue='".$taskvalue."' WHERE FlagTitle='".$task."'");
	}
	




} // class ends here
