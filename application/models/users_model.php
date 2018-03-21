<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for the users
 */
class Users_model extends CI_Model{

  /** @var String username of user */
  var $username;

  /** @var String display name of user */
  var $display_name;

  /** @var String password of user */
  var $password;

  /** @var String email of user */
  var $email;

  /** @var int level authorixation of user */
  var $level;


  public function __construct()
  {
    parent::__construct();
  }

  public function get($username = FALSE)
  {
    if ($username == FALSE) {
      return $this->db->get('users')->result_array();
    }
    return $this->db->get_where('users', array('username' => $username))->row_array();
  }

  /**
   * Check if login is possible or not
   * @param  String $username username of the user
   * @param  String $password password of the user
   * @return int              the level if the user
   * @return boolean          failed download attempt
   */
  public function login($username, $password)
  {
    $this->db->where('username',$username);
    $this->db->where('password',$password);
    $result = $this->db->get('users');

    if ($result->num_rows() == 1) {
      return $result->row(0);
    } else {
      return FALSE;
    }
  }

  public function insert()
  {
    $this->username = $this->input->post('username');
    $this->password = md5($this->input->post('password'));
    $this->level = $this->input->post('level');
    $this->display_name = $this->input->post('display_name');
    $this->email = $this->input->post('email');

    if ($this->db->insert('users',$this)) {
      return TRUE;
    }
    return FALSE;
  }

  public function delete($username)
  {
    $this->db->where('username',$username);
    if ($this->db->delete('users')) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Change user data
   * @param  String $new_password new password for the user
   * @return boolean              return wether or not the edit is successfull or not
   */
  public function edit($new_password = FALSE)
  {
    if ($new_password == FALSE) {
      $this->username = $this->session->userdata('username');
      $this->password = $this->session->userdata('password');
      $this->level = $this->session->userdata('level');
      $this->display_name = $this->input->post('display_name');
      $this->email = $this->input->post('email');
    } else {
      $this->username = $this->session->userdata('username');
      $this->password = $new_password;
      $this->level = $this->session->userdata('level');
      $this->display_name = $this->session->userdata('display_name');
      $this->email = $this->session->userdata('email');
    }

    $this->db->where('username', $this->username);
    if ($this->db->update('users', $this)) {
      return TRUE;
    } else {
      return FALSE;
    }

  }

}
