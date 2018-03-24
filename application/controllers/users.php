<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller class for the users
 */
class Users extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Index page of user controller that will be used to show, crate and delete user
   * @return void Show the index page
   */
  public function index()
  {
    // Checking if the user already logged in or not
    if (!$this->session->userdata('logged_in') == TRUE) {
      redirect('login');
    }

    // Handle if the user is not admin
    if ($this->session->userdata('level') != 3) {
      $this->session->set_flashdata('failed','Anda tidak memiliki akses yang tepat');
      redirect('suratmasuk');
    }

    // The data that will be passed on to the view
    $data['title'] = 'Daftar Pengguna';
    $data['icon'] = '<span class="fas fa-user"></span>';
    $data['menu'] = 'users';

    // Fetching the data from database
    $data['users'] = $this->users_model->get(FALSE,FALSE,FALSE);

    // Loading the index view
    $this->load->view('templates/header',$data);
    $this->load->view('users/index');
    $this->load->view('templates/footer');
  }

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
      if ($this->session->userdata('level') != 3) {
        redirect('suratmasuk');
      } else {
        redirect('users');
      }
    }
    // Load the login page
    $this->form_validation->set_rules('username', 'Username', 'required|callback_usernameNotExist');
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
      $data = $this->users_model->login($username, $password);

      /**
      * Checking if the data is empty, and assign the information to array
      * @var array data of the user
      */
      if ($data) {
        $user_data = array(
          'username' => $data->username,
          'level' => $data->level,
          'display_name' => $data->display_name,
          'email' => $data->email,
          'logged_in' => TRUE
        );

        // Put the user information to the user data
        $this->session->set_userdata($user_data);
        if ($this->session->userdata('level') != 3) {
          redirect('suratmasuk');
        } else {
          redirect('users');
        }
      } else {
        // FIXME: kalo masuk ini $_post nya kereset
        $this->session->set_flashdata('failed','Kombinasi username dan kata sandi salah');
        redirect('login');
      }
    } else {
      $this->load->view('users/login');
    }
  }

  /**
   * Do logout for the user from the system
   * @return void show the login page
   */
  public function logout()
  {
    // Destroy the session to delete the user data
    session_destroy();
    redirect('login');
  }

  /**
   * Setting for the user to either change display name, email or password
   * @return void Load the view
   */
  public function userSetting()
  {
    // Checking if the user already logged in or not
    if (!$this->session->userdata('logged_in') == TRUE) {
      redirect('login');
    }
    // Data that will be passed on to the view
    $data['title'] = 'Pengaturan Akun';
    $data['icon'] = '<span class="fas fa-user"></span>';

    /**
     * Checking if the form used is data or password
     * @var bool
     */
    if ($this->input->post('data')) {
      // Rules for the form validation
      $this->form_validation->set_rules('display_name', 'Nama pengguna', 'required');
      $this->form_validation->set_rules('email', 'Email pengguna', 'required|valid_email');
      $this->form_validation->set_message('required', 'Harap mengisi kolom {field}');
      $this->form_validation->set_message('valid_email', 'Harap menggunakan email yang valid');

      /**
       * Checking wether or not the form validation is running
       * @var bool
       */
      if ($this->form_validation->run() == TRUE) {
        /**
         * Checking wether or not the edit is successfull or not
         * @var bool
         */
        if ($this->users_model->edit(FALSE,FALSE)) {
          // Re assigning the user data for the display_name and email
          $this->session->set_userdata('display_name', $this->input->post('display_name'));
          $this->session->set_userdata('email', $this->input->post('email'));
          $this->session->set_flashdata('success','Anda berhasil mengubah data anda');
          redirect('settings');
        } else {
          $this->session->set_flashdata('failed','Gagal mengubah data anda');
          redirect('settings');
        }
      } else {
        // Loading the view
        $this->load->view('templates/header', $data);
        $this->load->view('users/settings');
        $this->load->view('templates/footer');
      }
    } elseif($this->input->post('password_button')) {
      // Rules for the form validation
      $this->form_validation->set_rules('password', 'Kata sandi lama', 'required|callback_checkPassword');
      $this->form_validation->set_rules('new_password', 'Kata sandi baru', 'required|callback_newPassword');
      $this->form_validation->set_rules('confirmation', 'Konfirmasi kata sandi baru', 'required|matches[new_password]');
      $this->form_validation->set_message('matches', 'Konfirmasi kata sandi baru tidak sesuai');
      $this->form_validation->set_message('required', 'Harap mengisi kolom {field}');

      /**
       * Checking wether or not the form_validation is running
       * @var bool
       */
      if ($this->form_validation->run() == TRUE) {
        /** @var String new password that will be inserted to database */
        $new_password = md5($this->input->post('new_password'));

        /**
         * Checking wether or not the edit is succesfull
         * @var bool
         */
        if ($this->users_model->edit($new_password,FALSE)) {
          $this->session->set_flashdata('success','Anda berhasil mengubah password anda');
          redirect('settings');
        } else {
          $this->session->set_flashdata('failed','Gagal mengubah password anda');
          redirect('settings');
        }
      } else {
        // Load the view
        $this->load->view('templates/header', $data);
        $this->load->view('users/settings');
        $this->load->view('templates/footer');
      }
    } else {
      // Load the view
      $this->load->view('templates/header', $data);
      $this->load->view('users/settings');
      $this->load->view('templates/footer');
    }
  }

  /**
   * Function to create new user
   * @return void Load the view
   */
  public function create()
  {
    // Checking if the user already logged in or not
    if (!$this->session->userdata('logged_in') == TRUE) {
      redirect('login');
    }

    // Handle if the user is not admin
    if ($this->session->userdata('level') != 3) {
      $this->session->set_flashdata('failed','Anda tidak memiliki akses yang tepat');
      redirect('suratmasuk');
    }

    // Data that will be passed on to the view
    $data['title'] = 'Tambah Pengguna';
    $data['icon'] = '<span class="fas fa-user"></span>';
    $data['menu'] = 'users';

    // Error rule for the form validation
    $this->form_validation->set_rules('username', 'Username', 'trim|required|callback_usernameExist');
    $this->form_validation->set_rules('password', 'Kata Sandi', 'required');
    $this->form_validation->set_rules('password_conf', 'Konfirmasi Kata Sandi', 'required|matches[password]');
    $this->form_validation->set_rules('level', 'Jabatan', 'required|callback_zeroCheck');
    $this->form_validation->set_rules('display_name', 'Nama Tampilan', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_emailExist');
    $this->form_validation->set_message('matches', 'Konfirmasi kata sandi tidak sesuai');
    $this->form_validation->set_message('required', 'Harap mengisi kolom {field}');
    $this->form_validation->set_message('valid_email', 'Harap menggunakan email yang valid');

    /**
     * Check wether or not the form_validation is running
     * @var bool
     */
    if ($this->form_validation->run() == FALSE) {
      // Load the view
      $this->load->view('templates/header', $data);
      $this->load->view('users/create');
      $this->load->view('templates/footer');
    } else {
      /**
       * Checking wether or not the insert is successfull
       * @var bool
       */
      if ($this->users_model->insert()) {
        $this->session->set_flashdata('success','Berhasil menambahkan pengguna baru');
        redirect('users');
      } else {
        $this->session->set_flashdata('failed','Gagal menambahkan pengguna baru');
        redirect('users/create');
      }
    }
  }

  /**
   * Function that used to delete existing user
   * @param  String $username Username of the user
   * @return void             Load the view
   */
  public function delete($username)
  {
    // Checking if the user already logged in or not
    if (!$this->session->userdata('logged_in') == TRUE) {
      redirect('login');
    }

    // Handle if the user is not admin
    if ($this->session->userdata('level') != 3) {
      $this->session->set_flashdata('failed','Anda tidak memiliki akses yang tepat');
      redirect('suratmasuk');
    }

    /**
     * Checking wether the delete is successfull or not
     * @var bool
     */
    if ($this->users_model->delete($username)) {
      $this->session->set_flashdata('success','Berhasil manghapus pengguna');
    } else {
      $this->session->set_flashdata('failed','Gagal manghapus pengguna');
    }
    redirect('users');
  }

  /**
   * Function to send email if user forgot their password
   * @return void Load the view
   */
  public function forgot()
  {
    // Checking if the user already logged in or not
    if ($this->session->userdata('logged_in') == TRUE) {
      redirect('login');
    }

    // Error rule for the form validation
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_checkEmail');
    $this->form_validation->set_message('required', 'Harap mengisi kolom {field}');
    $this->form_validation->set_message('valid_email', 'Harap menggunakan email yang valid');

    /**
     * Checking wether the form_validation is running or not
     * @var bool
     */
    if ($this->form_validation->run() == FALSE) {
      // Load the view
      $this->load->view('users/forgot');
    } else {
      // Fetch the data with corsponding email
      $email = $this->users_model->get(FALSE,$this->input->post('email'),FALSE);

      // Generating unique token to use as link for the reset password
      $email['reset_token'] = $this->generateToken();

      /**
       * Checking wether the email has sent successfully or not
       * @var bool
       */
      if ($this->sendEmail($email)) {
        // Put reset token and reset expire for the link
        $this->users_model->reset($email);
        $this->session->set_flashdata('success','Berhasil mengirim reset password');
        redirect('login');
      } else {
        $this->session->set_flashdata('failed','Gagal mengirim reset password');
        redirect('forgot');
      }
    }
  }

  /**
   * function to send email to reset user password
   * @param  String $email User's email that reqesting to reset password
   * @return void          load the view
   */
  public function sendEmail($email)
  {
    // Load the composer autoload
    require 'vendor/autoload.php';

    // FIXME: diubah jadi pake if di akhir aja
    $mail = new PHPMailer();

    //Server settings
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'demaspiraa@gmail.com';
    $mail->Password = 'theaurions00';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->SMTPAutoTLS = false;

    //Recipients
    $mail->setFrom('demaspiraa@gmail.com', 'Admin');
    $mail->addAddress($email['email'], $email['display_name']);

    //Content
    $mail->isHTML(true);
    $mail->Subject = 'Reset Kata Sandi Pengarsipan Surat';
    $mail->Body    = 'Tautan reset kata sandi akan kadaluwarsa dalam 3 jam '.base_url().'reset/'.$email['reset_token'];

    // IT'S NOT RECOMMENDED TO USE THIS, IT BYPASS THE SECURE CONNECTION, ONLY USING IT FOR THIS PROJECT
    $mail->SMTPOptions = array(
      'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
      )
    );

    if ($mail->send()) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Function to reset password of a user
   * @param String $reset_token Reset token that will be used to check in database if the coresponding user is really reseting their password
   */
  public function reset($reset_token)
  {
    // Checking if the user already logged in or not
    if ($this->session->userdata('logged_in') == TRUE) {
      redirect('login');
    }

    /**
     * Checking if there is data that have coresponding reset token
     * @var array
     */
    if ($user = $this->users_model->get(FALSE,FALSE,$reset_token)) {
      $time = new DateTime();
      /**
       * Comparing the reset expire and today date and time
       * @var bool
       */
      if (strtotime($time->format('Y/m/d H:i:s')) > strtotime($user['reset_expire'])) {
        show_404();
      } else {
        // Error rule for the form validation
        $this->form_validation->set_rules('password', 'Kata sandi', 'required');
        $this->form_validation->set_rules('password_conf', 'Konfirmasi kata sandi', 'required|matches[password]');
        $this->form_validation->set_message('matches', 'Konfirmasi kata sandi tidak sesuai');
        $this->form_validation->set_message('required', 'Harap mengisi kolom {field}');

        /**
         * Checking wether the form_validation is running or not
         * @var bool
         */
        if ($this->form_validation->run() == FALSE) {
          // reloading the view
          $data['reset_token'] = $user['reset_token'];
          $this->load->view('users/reset',$data);
        } else {
          /**
           * Checking wether the edit is successfull or not
           * @var bool
           */
          if ($this->users_model->edit(FALSE,$user['username'])) {
            $this->session->set_flashdata('success','Berhasil mereset password');
            redirect('login');
          } else {
            $this->session->set_flashdata('failed','Gagal mereset password');
            redirect('reset/'.$username);
          }
        }
      }
    } else {
      show_404();
    }
  }

  /**
   * Checking if the level selected is 0
   * @param  int  $level level that selected by user
   * @return bool        value if it's successfull or not
   */
  public function zeroCheck($level)
  {
    /**
     * Checking if the level is equal to 0
     * @var int
     */
    if ($level == 0) {
      $this->form_validation->set_message('zeroCheck','Harap memilih jabatan pengguna');
      return FALSE;
    }
    return TRUE;
  }

  /**
   * Function to check wether the old password is the same as their password
   * @param  String $password The old password that inserted by the user
   * @return bool           The value if it's worked or not
   */
  public function checkPassword($password)
  {
    // Fetching the old password from database coresponding to their username
    $old_password = $this->users_model->get($this->session->userdata('username'),FALSE,FALSE)['password'];
    if (md5($password) != $old_password) {
      $this->form_validation->set_message('checkPassword','Kata sandi yang lama tidak sesuai');
      return FALSE;
    }
    return TRUE;
  }

  /**
   * Function to check if the email is already registered or not
   * @param  String $email Email that will be changed
   * @return bool        value if it's worked or not
   */
  public function checkEmail($email)
  {
    // Fetching from all of the user data
    $users = $this->users_model->get(FALSE,FALSE,FALSE);

    // Error flag
    $flag = 0;

    foreach ($users as $user) {
      if ($user['email'] == $email) {
        $flag = 1;
      }
    }
    if ($flag == 0) {
      $this->form_validation->set_message('checkEmail','Email anda tidak terdaftar');
      return FALSE;
    }
    return TRUE;
  }

  /**
   * Function to ch3ck if the new password that inserted by the user is not the same as the old password
   * @param  String $new_password New password that the user input
   * @return bool                 false if the new password is the same as the old password
   */
  public function newPassword($new_password)
  {
    // Fetching the old password coresponding to the username of the user
    $old_password = $this->users_model->get($this->session->userdata('username'),FALSE,FALSE)['password'];

    /**
     * Checking ig the new password is same as the old password
     * @var bool
     */
    if (md5($new_password) == $old_password) {
      $this->form_validation->set_message('newPassword','Kata sandi baru sama dengan kata sandi lama');
      return FALSE;
    }
    return TRUE;
  }

  /**
   * Function to check if the username that used to login does exist
   * @param  String $username username that user input
   * @return bool             false if the username doesnt exist
   */
  public function usernameNotExist($username)
  {
    if ($this->users_model->get($username,FALSE,FALSE)) {
      return TRUE;
    }
    $this->form_validation->set_message('usernameNotExist','Nama pengguna tersebut tidak terdaftar');
    return FALSE;
  }

  /**
   * Function to check if the username that will be created is already existing in the database or not
   * @param  String $username username that will be created
   * @return bool             false if the username is already exist
   */
  public function usernameExist($username)
  {
    if ($this->users_model->get($username,FALSE,FALSE)) {
      $this->form_validation->set_message('usernameExist','Username pengguna tersebut sudah terdaftar');
      return FALSE;
    }
    return TRUE;
  }

  /**
   * Function to check if email that corespond with the new user is already used before
   * @param  String $email email that will be inserted
   * @return bool          false if the email is already used in database
   */
  // FIXME: diubah jenis input nya jadi email di create dll atau pake form validation lagi
  public function emailExist($email)
  {
    if ($this->users_model->get(FALSE,$email,FALSE)) {
      $this->form_validation->set_message('emailExist','Email tersebut sudah terdaftar');
      return FALSE;
    }
    return TRUE;
  }

  /**
   * Function that will generate a unique random string consist of 32 characters
   * @return String A string that will be used as reset token to reset user password within given time limit
   */
  // FIXME: dicari masing2 fungsinya
  public function generateToken()
  {
    $reset_token = '';
    $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $max = mb_strlen($keyspace, '8bit') - 1;

    while ($reset_token == '' || $this->users_model->get(FALSE,FALSE,$reset_token)) {
      for ($i = 0; $i < 32; ++$i) {
        $reset_token .= $keyspace[random_int(0, $max)];
      }
    }
    return md5($reset_token);
  }
}
