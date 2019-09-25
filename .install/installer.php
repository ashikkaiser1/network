<?php

//error_reporting(0);
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of index
 *
 * @author kuldeep
 */
class installer {

    //put your code here


    private $sys_options = array(
        "transactionIdType" => "IP/YY/MM/DD/OFFER_ID",
        "SITENAME" => "",
        "SITEURL" => "/",
        "ASSETS" => "/assets/",
        "UPLOAD" => "/upload/",
        "EMAIL_ACC" => "",
        "CURR" => "$",
        "IMP_URL" => "",
        "CONV_PIXEL" => "",
        "HOST" => "",
        "EMAIL_PROTOCOL" => "SMTP",
        "EMAIL_SMTP_HOST" => "mail.example.com",
        "EMAIL_SMTP_PORT" => "507",
        "EMAIL_SMTP_USER" => "",
        "EMAIL_SMTP_PASS" => "",
        "OFFER_DATE_FROMAT" => "Y-m-d H:i:s",
        "OFFER_DATE_FROMAT_SHOW" => "d-m-Y",
        "STOSPOSTBACK" => "",
        "PROTOCOL" => "http",
        "TIMEZONE" => "Asia/Kolkata",
        "LOGO" => "",
        "FAVICON" => "",
        "REFERAL_AMT" => "100",
        "COMM_PERCENTAGE" => "30",
        "LOGIN_PAGE" => "",
        "AUTO_APPROVAL"=>"1",
        "POINTS"=>50
        
    );
    private $con;
    private $json = array("success" => FALSE);
    private $sqlFile = "./dbs/adserver_sql.sql";
    private $request = array();

    //moremint_manish
    //admin@123


    private function validation() {
        $this->init_request();
    }

    public function check_mysql_connetion($return = 1) {
        $this->validation();
//        echo '<pre>';
//        print_r($this->request);
        $this->con = mysqli_connect($this->request['master_host'], $this->request['master_user'], $this->request['master_password'], $this->request['master_db']);
        // Check connection
        if (mysqli_connect_errno()) {
            $this->json['msg'] = "Step 1. Failed to connect to MySQL: " . mysqli_connect_error();
            echo json_encode($this->json);
            return;
        } else {
            $this->json['msg'] = "Step 1. Completed. Database connecting Successfully......";
        }
        if ($return) {
            $this->json['success'] = TRUE;
            echo json_encode($this->json);
        }
    }

    public function create_tables() {

        $this->check_mysql_connetion(0);
        // Temporary variable, used to store current query
        $templine = '';
// Read in entire file
        $fp = fopen("./dbs/adserver_sql.sql", 'r');
// Loop through each line
        while (($line = fgets($fp)) !== false) {
            // Skip it if it's a comment
            if (substr($line, 0, 2) == '--' || $line == '')
                continue;
            // Add this line to the current segment
            $line=str_replace('DELIMITER', '', $line);
            $line=str_replace('$$', '', $line);

            $templine .= $line;
            // If it has a semicolon at the end, it's the end of the query
            if (substr(trim($line), -1, 1) == ';') {
                // Perform the query
//                $templine=mysqli_escape_string($this->con, $templine);

                if (!mysqli_query($this->con, $templine)) {
                    $this->mysqli_error_report('Step 2. Error performing query '.$templine . mysqli_error($this->con));
                }
                // Reset temp variable to empty
                $templine = '';
            }
        }
        
        $this->database_file_update();
        $this->json['msg'] = "Step 2. Tables imported successfully";
        $this->json['success'] = TRUE;
        echo json_encode($this->json);
    }

    public function save_network_settings() {
        $this->check_mysql_connetion(0);

        $this->sys_options['SITENAME'] = $this->request['SITENAME'];
        $this->sys_options['SITEURL'] = $this->request['SITEURL'] . $this->sys_options['SITEURL'];
        $this->sys_options['ASSETS'] = $this->request['SITEURL'] . $this->sys_options['ASSETS'];
        $this->sys_options['UPLOAD'] = $this->request['SITEURL'] . $this->sys_options['UPLOAD'];
        $this->sys_options['PROTOCOL'] = $this->request['PROTOCOL'];
        $this->sys_options['TIMEZONE'] = $this->request['TIMEZONE'];

        $query = "DELETE FROM `sys_option`";
        if (!mysqli_query($this->con, $query)) {
            $this->mysqli_error_report("Step 3. Error While executing query..." . $query);
        }

        foreach ($this->sys_options as $key => $option) {

            $query = "INSERT INTO `sys_option`(`option_name`, `option_value`) VALUES ('$key','$option')";
            if (!mysqli_query($this->con, $query)) {

                $this->mysqli_error_report("Step 3. Error While executing query..." . $query);
            }
        }

        $this->json['success'] = TRUE;
        $this->json['msg'] = "Step 3. Network Setting saved successfully.";
        echo json_encode($this->json);
    }

    public function create_admin_account() {
        $this->check_mysql_connetion(0);
        

        $query = "INSERT INTO `users`(`UTID`,`username`, `name`, `email`, `password`, `re_password`,`status`,`verified`)";
        $query .= " VALUES ('1','{$this->request['username']}','{$this->request['name']}','{$this->request['email']}','{$this->request['password']}','{$this->request['re_password']}','1','1')";
        if (!mysqli_query($this->con, $query)) {
            $this->mysqli_error_report("Step 4. Error While executing query..." . $query);
        }
        $this->json['success'] = TRUE;
        $this->json['msg'] = "Step 4. Administrator account is created.";
        echo json_encode($this->json);
    }

    public function init_request() {
        $this->request = $_POST;
        if (empty($this->request)) {
            $this->json['msg'] = "There is not data in request";
            echo json_encode($this->json);
            die();
        }
    }

    private function mysqli_error_report($msg) {

//        echo $msg;

        $this->json['msg'] = $msg;
        echo json_encode($this->json);
        die();
    }

    public function database_file_update() {
        $file = "./file/database.txt";
        $handle = fopen($file, 'r');
        $data = fread($handle, filesize($file));

        $master_host = $this->request['master_host'];
        $master_database = $this->request['master_db'];
        $master_user = $this->request['master_user'];
        $master_password = $this->request['master_password'];
        
        $data = str_replace("{d_hostname}", $master_host, $data);
        $data = str_replace("{d_database}", $master_database, $data);
        $data = str_replace("{d_username}", $master_user, $data);
        $data = str_replace("{d_password}", $master_password, $data);
        
        
        
        $slave_host = isset($this->request['slave_host']) ? $this->request['slave_host'] : $master_host ;
        $slave_database = isset($this->request['slave_db'] ) ? $this->request['slave_db'] : $master_database ;
        $slave_user = isset($this->request['slave_user']) ? $this->request['slave_user'] : $master_user ;
        $slave_password = isset($this->request['slave_password']) ? $this->request['slave_password'] : $master_password ;
        
        $data = str_replace("{r_hostname}", $slave_host, $data);
        $data = str_replace("{r_database}", $slave_database, $data);
        $data = str_replace("{r_username}", $slave_user, $data);
        $data = str_replace("{r_password}", $slave_password, $data);
        
        

        file_put_contents("../application/config/database.php", $data);
		
		$file = "./file/dbConfig.txt";
        $handle = fopen($file, 'r');
        $data = fread($handle, filesize($file));

        $master_host = $this->request['master_host'];
        $master_database = $this->request['master_db'];
        $master_user = $this->request['master_user'];
        $master_password = $this->request['master_password'];
        
        $data = str_replace("{d_hostname}", $master_host, $data);
        $data = str_replace("{d_database}", $master_database, $data);
        $data = str_replace("{d_username}", $master_user, $data);
        $data = str_replace("{d_password}", $master_password, $data);
        
        
        

        file_put_contents("../manager/dbConfig.php", $data);

//        echo $ch;
//        echo $handle;
    }

}

$install = new installer();

//$install->database_file_update();

$step = isset($_GET['step']) ? $_GET['step'] : 0;

switch ($step) {
    case 1: $install->check_mysql_connetion();
        break;
    case 2: $install->create_tables();
        break;
    case 3: $install->save_network_settings();
        break;

    case 4: $install->create_admin_account();
        break;

    default:
        break;
}

