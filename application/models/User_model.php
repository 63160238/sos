<?php
defined('BASEPATH') OR exit('');

class User_model extends CI_Model{
    public function __construct(){
        parent::__construct();
    }

    // /////// add user //////
    public function add($prename,$firstname,$lastname,$firstnameEng,$lastnameEng,$idCard,$role,$position,$username,$password){

        $data = ['id_card'=>$idCard, 'prename'=>$prename,  'fname_th'=>$firstname, 'lname_th'=>$lastname, 'fname_en'=>$firstnameEng, 'lname_en'=>$lastnameEng, 'position'=>$position, 'role'=>$role, 'username'=>$username, 'password'=>$password];

        //set the datetime based on the db driver in use
        $this->db->platform() == "sqlite3"
                ?
        $this->db->set('created_on', "datetime('now')", FALSE)
                :
        $this->db->set('created_on', "NOW()", FALSE);

        $this->db->insert('users', $data);

        if($this->db->affected_rows() > 0){
            return $this->db->insert_id();
        }

        else{
            return FALSE;
        }
    }

    ///// get All user /////
    public function getAll(){
      $this->db->where('username !=','ivsoft');
      $run_q = $this->db->get('users');
      if($run_q->num_rows() > 0){
          return $run_q->result();
      }else{
          return FALSE;
      }
    }

    /////  update user //////
    public function update($user_id, $prename, $firstname, $lastname, $firstnameEng, $lastnameEng, $idCard, $role, $position){

      $data = ['id_card'=>$idCard, 'prename'=>$prename,  'fname_th'=>$firstname, 'lname_th'=>$lastname, 'fname_en'=>$firstnameEng, 'lname_en'=>$lastnameEng, 'position'=>$position, 'role'=>$role];

      $this->db->where('user_id', $user_id);

      $this->db->update('users', $data);

      return TRUE;
    }

    public function delete($user_id, $new_value){
      $this->db->where('user_id', $user_id);
      $this->db->update('users', ['status'=>$new_value]);

      if($this->db->affected_rows()){
          return TRUE;
      }else{
          return FALSE;
      }
   }

   public function get_user_info($username){
     $this->db->where('username',$username);

     $run_q = $this->db->get('users');

     if($run_q->num_rows() > 0 ){
       return $run_q->result();
     }else{
       return FALSE;
     }
   }

   public function update_last_login($user_id){
     $this->db->where('user_id',$user_id);
     //set the datetime based on the db driver in use
     $this->db->platform() == "sqlite3"
             ?
     $this->db->set('last_login', "datetime('now')", FALSE)
             :
     $this->db->set('last_login', "NOW()", FALSE);

     $this->db->update('users');

     if(!$this->db->error()){
       return TRUE;
     }else{
       return FALSE;
     }
   }

   public function changePass($user_id, $new_pass){
     $this->db->where('user_id', $user_id);
     $this->db->update('users', ['password'=>$new_pass]);

     if($this->db->affected_rows()){
         return TRUE;
     }else{
         return FALSE;
     }
   }

   public function changeSemester($semester){
     $this->db->where('user_id', $_SESSION['user_id']);
     $this->db->update('users', ['current_semester'=>$semester]);

     if($this->db->affected_rows()){
         return TRUE;
     }else{
         return FALSE;
     }
   }

   public function changeSchoolYear($schoolYear){
     $this->db->where('user_id', $_SESSION['user_id']);
     $this->db->update('users', ['current_school_year'=>$schoolYear]);

     if($this->db->affected_rows()){
         return TRUE;
     }else{
         return FALSE;
     }
   }

   public function getAllUserRoles($arrayWhere = ''){
       $this->db->select('r.role_id, r.user_id, r.groups_id, u.prename, u.fname_th, u.lname_th, g.groups_title, r.role');
     $arrayWhere?  $this->db->where($arrayWhere) : '';
     $this->db->join('users u', 'u.user_id = r.user_id', 'left');
     $this->db->join('user_groups g', 'g.groups_id = r.groups_id', 'left');
     $this->db->order_by('user_id');
     $run_q = $this->db->get('user_roles r');
     if($run_q->num_rows() > 0){
         return $run_q->result();
     }else{
         return FALSE;
     }
   }

   public function getUserRoles(){
     if(isset($_SESSION['groups_id']) && $_SESSION['groups_id'] == ''){
       $this->db->where(array('user_id'=>$_SESSION['user_id'], 'status'=>1));
     }else{
       $this->db->where("(user_id='".$_SESSION['user_id']."' or groups_id in (".$_SESSION['groups_id'].") ) and status=1");
     }
     $run_q = $this->db->get('user_roles');
     if($run_q->num_rows() > 0){
         return $run_q->result();
     }else{
         return FALSE;
     }
   }

   public function getGroup(){
     $this->db->select('*');
     $run_q = $this->db->get('user_groups');
     if($run_q->num_rows() > 0){
         return $run_q->result();
     }else{
         return FALSE;
     }
   }

   public function getAllUserRolesNew($arrayWhere = ''){
       $this->db->select('r.role_id, r.user_id, r.groups_id, u.prename, u.fname_th, u.lname_th, g.groups_title, r.role, us.prename as group_prename, us.fname_th as group_fname, us.lname_th as group_lname');
     $arrayWhere?  $this->db->where($arrayWhere) : '';
     $this->db->join('users u', 'u.user_id = r.user_id', 'left');
     $this->db->join('user_groups g', 'g.groups_id = r.groups_id', 'left');
     $this->db->join('users us','r.groups_id = us.user_id','left');
     $run_q = $this->db->get('user_roles r');
     if($run_q->num_rows() > 0){
         return $run_q->result();
     }else{
         return FALSE;
     }
   }



}
