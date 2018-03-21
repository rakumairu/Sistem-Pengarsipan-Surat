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
  {
    if ($this->session->userdata('level') != 3) {
      $this->session->set_flashdata('failed','Anda tidak memiliki akses yang tepat');
      redirect('suratmasuk');
    }

    $data['title'] = 'Daftar Pengguna';
    $data['icon'] = '<span class="fas fa-user"></span>';
    $data['menu'] = 'users';

    $data['users'] = $this->users_model->get();

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
    } else {
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
            'password' => $data->password,
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
          $this->session->set_flashdata('failed','Gagal login');
          redirect('login');
        }
      } else {
        $this->load->view('users/login');
      }
    }
  }

  /**
   * Do logout for the user from the system
   * @return void show the login page
   */
  public function logout()
  {
    session_destroy();
    redirect('login');
  }

  public function userSetting()
  {
    $data['title'] = 'Pengaturan Akun';
    $data['icon'] = '<span class="fas fa-user"></span>';

    if ($this->input->post('data')) {
      // IDEA: dipikirin lagi mereka wajib punya email apa engga
      // IDEA: email buat ngirim forgot password
      $this->form_validation->set_rules('display_name', 'Nama pengguna', 'required');
      $this->form_validation->set_rules('email', 'Email pengguna', 'required');
      $this->form_validation->set_message('required', 'Harap mengisi kolom {field}');

      if ($this->form_validation->run() == TRUE) {
        if ($this->users_model->edit()) {
          $this->session->set_userdata('display_name', $this->input->post('display_name'));
          $this->session->set_userdata('email', $this->input->post('email'));
          $this->session->set_flashdata('success','Anda berhasil mengubah data anda');
          redirect('user');
        } else {
          $this->session->set_flashdata('failed','Gagal mengubah data anda');
          redirect('user');
        }
      } else {
        $this->load->view('templates/header', $data);
        $this->load->view('users/settings');
        $this->load->view('templates/footer');
      }
    } elseif($this->input->post('password_button')) {
      $this->form_validation->set_rules('password', 'Kata sandi lama', 'required|callback_checkPassword');
      $this->form_validation->set_rules('new_password', 'Kata sandi baru', 'required|callback_newPassword');
      $this->form_validation->set_rules('confirmation', 'Konfirmasi kata sandi baru', 'required|matches[new_password]');
      $this->form_validation->set_message('matches', 'Konfirmasi kata sandi baru tidak sesuai');
      $this->form_validation->set_message('required', 'Harap mengisi kolom {field}');

      if ($this->form_validation->run() == TRUE) {
        $new_password = md5($this->input->post('new_password'));
        if ($this->users_model->edit($new_password)) {
          $this->session->set_userdata('password', $new_password);
          $this->session->set_flashdata('success','Anda berhasil mengubah password anda');
          redirect('user');
        } else {
          $this->session->set_flashdata('failed','Gagal mengubah password anda');
          redirect('user');
        }
      } else {
        $this->load->view('templates/header', $data);
        $this->load->view('users/settings');
        $this->load->view('templates/footer');
      }
    } else {
      $this->load->view('templates/header', $data);
      $this->load->view('users/settings');
      $this->load->view('templates/footer');
    }
  }

  public function create()
  {
    if ($this->session->userdata('level') != 3) {
      $this->session->set_flashdata('failed','Anda tidak memiliki akses yang tepat');
      redirect('suratmasuk');
    }

    $data['title'] = 'Tambah Pengguna';
    $data['icon'] = '<span class="fas fa-user"></span>';
    $data['menu'] = 'users';

    // Error rule for the form validation
    $this->form_validation->set_rules('username', 'Username', 'trim|required');
    $this->form_validation->set_rules('password', 'Kata Sandi', 'required');
    $this->form_validation->set_rules('password_conf', 'Konfirmasi Kata Sandi', 'required|matches[password]');
    $this->form_validation->set_rules('level', 'Jabatan', 'required|callback_zeroCheck');
    $this->form_validation->set_rules('display_name', 'Nama Tampilan', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required');
    $this->form_validation->set_message('matches', 'Konfirmasi kata sandi tidak sesuai');
    $this->form_validation->set_message('required', 'Harap mengisi kolom {field}');

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('templates/header', $data);
      $this->load->view('users/create');
      $this->load->view('templates/footer');
    } else {
      if ($this->users_model->insert()) {
        $this->session->set_flashdata('success','Berhasil menambahkan pengguna baru');
        redirect('users');
      } else {
        $this->session->set_flashdata('failed','Gagal menambahkan pengguna baru');
        redirect('users/create');
      }
    }
  }

  public function delete($username)
  {
    if ($this->session->userdata('level') != 3) {
      $this->session->set_flashdata('failed','Anda tidak memiliki akses yang tepat');
      redirect('suratmasuk');
    }

    if ($this->users_model->delete($username)) {
      $this->session->set_flashdata('success','Berhasil manghapus pengguna');
    } else {
      $this->session->set_flashdata('failed','Gagal manghapus pengguna');
    }
    redirect('users');
  }

  public function zeroCheck($level)
  {
    if ($level == 0) {
      $this->form_validation->set_message('zeroCheck','Harap memilih jabatan pengguna');
      return FALSE;
    }
    return TRUE;
  }

  public function checkPassword($password)
  {
    if (md5($password) != $this->session->userdata('password')) {
      $this->form_validation->set_message('checkPassword','Kata sandi yang lama tidak sesuai');
      return FALSE;
    }
    return TRUE;
  }

  public function newPassword($new_password)
  {
    if (md5($new_password) == $this->session->userdata('password')) {
      $this->form_validation->set_message('newPassword','Kata sandi baru sama dengan kata sandi lama');
      return FALSE;
    }
    return TRUE;
  }

  public function usernameNotExist($username)
  {
    if ($this->users_model->get($username)) {
      return TRUE;
    }
    $this->form_validation->set_message('usernameNotExist','Nama pengguna tersebut tidak terdaftar');
    return FALSE;
  }
}
