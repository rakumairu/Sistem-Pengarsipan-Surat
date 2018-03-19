<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller class for the users
 */
class Users extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {}

  /**
   * Login the user based on their level
   * @return void Load view
   */
  public function login()
  {
    /**
     * If there is user that already login it will auto redirect
     * @var boolean
     */
    if ($this->session->userdata('logged_in') == TRUE) {
      redirect('suratmasuk');
    } else {
      // Load the login page
      $this->form_validation->set_rules('username', 'Username', 'required');
      $this->form_validation->set_rules('password', 'Password', 'required');
      $this->form_validation->set_message('required', 'Harap mengisi kolom {field}');

      /**
       * Checking if the form is currently running or not
       *   if it is, it will try to check the data
       *   if it isn't, it will load the login view
       * @var boolean
       */
      if ($this->form_validation->run() == TRUE) {
        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));

        // Fetch the data from database
        $level = $this->users_model->login($username, $password);

        /**
         * Checking if the data is empty, and assign the information to array
         * @var [type]
         */
        if ($level) {
          $user_data = array(
            'username' => $username,
            'level' => $level,
            'logged_in' => TRUE
          );

          // Put the user information to the user data
          $this->session->set_userdata($user_data);
          redirect('suratmasuk');
        } else {
          $this->session->set_flashdata('failed','Gagal login');
          redirect('login');
        }
      } else {
        $this->load->view('users/login');
      }
    }
  }

  public function logout()
  {
    $this->session->unset_userdata('logged_in');
    $this->session->unset_userdata('username');
    $this->session->unset_userdata('level');

    $this->session->set_flashdata('success','Anda berhasil keluar dari sistem');

    redirect('login');
  }

}
