<?php

class WCP_BackEnd_Users_Controller {

    public function get_data() {
        $user = wp_get_current_user();
        global $wpdb, $wp;
        $data = array();
        
        $user_data = file_get_contents('https://jsonplaceholder.typicode.com/users');
        $user_data = json_decode($user_data);
        

        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'username',
            3 => 'email',
        );
        
        $result = $user_data;
        $totalData = 0;
        $totalFiltered = 0;
        if (count($result > 0)) {
            $totalData = count($result);
            $totalFiltered = count($result);
        }

        $service_price_list = $user_data;
        $arr_data = Array();
        $arr_data = $result;

        foreach ($service_price_list as $row) {
            $temp['id'] = '<a href="javascript:void(0);" onclick="get_user_data('.$row->id.');">'.$row->id.'</a>';
            $temp['name'] = '<a href="javascript:void(0);" onclick="get_user_data('.$row->id.');">'.$row->name.'</a>';
            $temp['username'] = '<a href="javascript:void(0);" onclick="get_user_data('.$row->id.');">'.$row->username.'</a>';
            $temp['email'] = '<a href="javascript:void(0);" onclick="get_user_data('.$row->id.');">'.$row->email.'</a>';
            $data[] = $temp;
            $id = "";
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
            "sql" => $sql
        );
        echo json_encode($json_data);
        exit(0);
    }
    
    public function get_user_detail() {
        if(isset($_POST['id']) && $_POST['id']!='') {
            $user_details = file_get_contents('https://jsonplaceholder.typicode.com/users/'.$_POST['id']);
            $user_details = json_decode($user_details);
            if(!empty($user_details)) {
                $name = $user_details->name;
                $username = $user_details->username;
                $email = $user_details->email;
                $address = $user_details->address->street.' '.$user_details->address->suite.' '.$user_details->address->city.' '.$user_details->address->zipcode;
                $phone = $user_details->phone;
                $website = $user_details->website;
                $company_name = $user_details->company->name;
                echo json_encode(array('status'=>1,'name'=>$name,'username'=>$username,'email'=>$email,'address'=>$address,'phone'=>$phone,'website'=>$website,'company_name'=>$company_name));
            } else {
                echo json_encode(array('status'=>0));
            }
        } else {
            echo json_encode(array('status'=>0));
        }
        die;
    }

    public function index() {
        ob_start();
        global $wpdb;
        
        wp_enqueue_style('custom.css', plugins_url('website-custom-plugin/WCP/assets/css/custom.css'));
        wp_enqueue_style('bootstrap_min.css', plugins_url('website-custom-plugin/WCP/assets/css/bootstrap.min.css'));
        wp_enqueue_style('datatable_min.css', plugins_url('website-custom-plugin/WCP/assets/css/jquery.dataTables.min.css'));
        
        wp_enqueue_script('bootstrap_min', plugins_url('website-custom-plugin/WCP/assets/js/bootstrap.min.js'));
        wp_enqueue_script('datatables', plugins_url('website-custom-plugin/WCP/assets/js/datatables.min.js'));
        
        include(dirname(__FILE__) . "/html/user_list.php");
        $s = ob_get_contents();
        ob_end_clean();
        print $s;
    }


    function add_menu_pages() {
        add_menu_page('Users', 'Users', 'manage_options', 'users', Array("WCP_BackEnd_Users_Controller", "index"));
    }

}

$WCP_BackEnd_Users_Controller = new WCP_BackEnd_Users_Controller();

add_action('admin_menu', array("WCP_BackEnd_Users_Controller", 'add_menu_pages'));

add_action('wp_ajax_WCP_BackEnd_Users_Controller::get_data', Array('WCP_BackEnd_Users_Controller', 'get_data'));
add_action('wp_ajax_nopriv_WCP_BackEnd_Users_Controller::get_data', array('WCP_BackEnd_Users_Controller', 'get_data'));

add_action('wp_ajax_WCP_BackEnd_Users_Controller::get_user_detail', Array('WCP_BackEnd_Users_Controller', 'get_user_detail'));
add_action('wp_ajax_nopriv_WCP_BackEnd_Users_Controller::get_user_detail', array('WCP_BackEnd_Users_Controller', 'get_user_detail'));

?>
