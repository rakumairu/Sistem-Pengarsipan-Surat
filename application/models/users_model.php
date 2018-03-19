<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for the users
 */
class Users_model extends CI_Model{

  public function __construct()
  {
    parent::__construct();
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
      return $result->row(0)->level;
    } else {
      return FALSE;
    }
  }

}
