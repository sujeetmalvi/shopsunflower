<?php

class Home_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }


 /********************************* UNIT ***************************/
    
    public function get_employees_details($imei){

        $sql = "SELECT * FROM employees_master WHERE `EmployeesIMEI`='".$imei."' ";
        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows() > 0) {
            	$result = $query->result_array();
            	return $result;
            } else {
                return false;
            }
        }
    }



public function check_login() {
        $cUserEmail = $this->input->post('loginname');
        $cUserPassword = $this->input->post('loginpassword');
        $today = date('Y-m-d');

        if (!empty($cUserEmail) && !empty($cUserPassword)) {

            $sql = "SELECT * FROM employees_master WHERE `EmployeesEmail`='".$cUserEmail."' AND `EmployeesPassword` = AES_ENCRYPT('".LOGIN_SALT."','".$cUserPassword."' )  ";

            $query = $this->db->query($sql);
            if ($query) {
                if ($query->num_rows() > 0) {
                    $datas = $query->result_array();

                    $countJunior_sql = "SELECT id FROM employees_master WHERE `EmployeesSeniorId`='".$datas[0]['id']."'  ";
                    $queryCountJunior = $this->db->query($countJunior_sql);
                    $JuniorCount = $queryCountJunior->num_rows();


                    $data = array(
                        'id' => trim($datas[0]['id']),
                        'EmployeesFullName' => trim($datas[0]['EmployeesFullName']),
                        'EmployeesMobileNo' => trim($datas[0]['EmployeesMobileNo']),
                        'EmployeesImage' => trim($datas[0]['EmployeesImage']),
                        'CompanyId' => trim($datas[0]['CompanyId']),
                        'JuniorCount' => trim($JuniorCount)
                    );




                    $this->session->set_userdata($data);

                    /***Activity Logs***/
                    //save_activity_details('ADMIN LOGIN');
                    /***Activity Logs End***/

                    return true;
                } else {
                    return false;
                }
            }     
        }
    }



} // class ends here
