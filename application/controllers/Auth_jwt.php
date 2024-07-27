<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_jwt extends CI_Controller {   

    public function __construct(){
		parent::__construct();
		error_reporting(0);
		$this->load->model('jwt_user_model');        
		$this->load->helper('verifyAuthToken');
		$this->load->helper('jwt');
		
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Methods: GET, OPTIONS, POST, GET, PUT");
		header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
		
	}  

	public function login(){      
		$jwt = new JWT();
		$JwtSecretKey = "myloginSecret";

		// $email = $this->input->post('email');
		// $password = $this->input->post('password');
        $email = 'sumit@basix.in';
		$password = '123';        

		$result = $this->jwt_user_model->check_login($email,$password);	       
		
		if($result===false){
			echo 'User not found!';
		}else{
			$token = $jwt->encode($result,$JwtSecretKey,'HS256');           
			echo json_encode($token);
		}

	}

	public function signup(){

		if($this->input->post()){
			$name = $this->input->post('name');
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$role_id = $this->input->post('role_id');
			$data = array(
				'name'=>$name,
				'email'=>$email ,
				'password'=> $password,
				'role_id'=> $role_id,
			);

			$userId = $this->jwt_user_model->signup($data);
			if($userId){
				echo 'User Registered successfully!';
			}else{
				echo 'User Registeration faild!';
			}
		}

	}

	public function get_roles(){
		$roles = $this->jwt_user_model->getRoles();
		echo json_encode($roles);
	}


	public function getUsers(){
		
		$headerToken = $this->input->get_request_header('Authorization');
		$splitToken = explode(" ", $headerToken);
		$token =  $splitToken[1];

		//          -----------------or for testing------------------------
		// $token =  'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEifQ.37VBIOeEJEnXgWlaJWGilIu0o9tbsV8GWxw7CvGfwTU';

		try {
			$token = verifyAuthToken($token);
			$user_details = json_decode($token);			
			if($token){
				$users = $this->jwt_user_model->getUsersDetailsById($user_details->id);			
				echo json_encode($users);
			}		
				
		}
		catch(Exception $e) {
		    // echo 'Message: ' .$e->getMessage();
			$error = array(
				"status"=>401,
				"message"=>"Invalid Token provided",
				"sucess"=>false
				);

			echo json_encode($error);
		}
			
		
	}

}