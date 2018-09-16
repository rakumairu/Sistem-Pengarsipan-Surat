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

  /** @var String mark if a user want to reset their password */
  var $reset_token;

  /** @var DateTime date and time when the reset token will be expired */
  var $reset_expire;


  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Functino to fetch data from database
   * @param  boolean $username    username of the user that will be used to fetch their data
   * @param  boolean $email       email of user that will be used to fetch their data
   * @param  boolean $reset_token reset_token of user that will be userd to fetch their data
   * @return array                user data
   */
  public function get($username = FALSE, $email = FALSE, $reset_token = FALSE)
  {
    // IDEA: diubah jadi 1 parameter aja, tapi array masukannya
    // Fetch data from database to display in the edit view
    if ($username != FALSE) {
      return $this->db->get_where('users', array('username' => $username))->row_array();
    }

    // Fetch data from database to change their reset token and reset expire
    if ($email != FALSE) {
      return $this->db->get_where('users', array('email' => $email))->row_array();
    }

    // Fetch data from database to change password if a user is requested a forgot password
    if ($reset_token != FALSE) {
      return $this->db->get_where('users', array('reset_token' => $reset_token))->row_array();
    }

    return $this->db->get('users')->result_array();
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

  /**
   * Function to insert user data into database
   * @return bool return wether the insert is successfull or not
   */
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

  /**
   * Function to delete existing user
   * @param  String $username Username of user that will be used as a key to delete their data
   * @return bool             return wether the delete is successfull or not
   */
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
  public function edit($new_password = FALSE, $username = FALSE)
  {
    if ($username == FALSE) {
      // To change display name and/or email of user from the user settings
      if ($new_password == FALSE) {
        $password = $this->get($this->session->userdata('username'))['password'];
        $this->username = $this->session->userdata('username');
        $this->password = $password;
        $this->level = $this->session->userdata('level');
        $this->display_name = $this->input->post('display_name');
        $this->email = $this->input->post('email');
      } else {
        // To change password from within the user settings
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
    } else {
      // To change the password from reset password
      $new = $this->get($username,FALSE);
      $new['password'] = md5($this->input->post('password'));
      $new['reset_token'] = NULL;
      $new['reset_expire'] = NULL;

      $this->db->where('username', $new['username']);
      if ($this->db->update('users', $new)) {
        return TRUE;
      } else {
        return FALSE;
      }
    }
  }

  /**
   * Change the value of reset_token and reset_expire from a user that requested a forgot password
   * @param array $data data of the user that will be changed
   */
  public function reset($data)
  {
    $this->db->where('username', $data['username']);
    $time = new DateTime();
    // NOTE: expire 3 jam, ada masalah sama timezone nya
    $time->modify('+9 hours');

    if ($this->db->update('users',
    array(
      'reset_token' => $data['reset_token'],
      'reset_expire' => date_format($time, 'Y/m/d H:i:s'),))) {
      return TRUE;
    }
    return FALSE;
  }
}
