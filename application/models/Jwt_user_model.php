
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Jwt_user_model extends CI_Model{

    function check_login($email,$password){

        $this->db->select('user.id');
        $this->db->from('user');
        $this->db->where('email',$email);
        $this->db->where('password',$password);
        $this->db->where('status',1);
        
        $query = $this->db->get()->row();

        if($query){
            return $query;
        }else{
            return false;
        }
    }


    function signup($data){
        $this->db->insert('user',$data);
        return $this->db->insert_id();
    }

    function getRoles(){
        $this->db->select('*');
        $this->db->from('role');
        $query = $this->db->get();

        return $query->result_array();
    }

    function getUsersDetailsById($user_id){
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('id',$user_id);
        $query = $this->db->get()->row();
        return $query;
    }

}
