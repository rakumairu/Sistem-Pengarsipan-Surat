<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller class for the suratmasuk
 */
class SuratMasukController extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    // Checking if the user already logged in or not
    if (!$this->session->userdata('logged_in') == TRUE) {
      redirect('login');
    }

    // Checking if the user is 'admin' then redirect it to users
    if ($this->session->userdata('level') == 3) {
      $this->session->set_flashdata('failed','Anda tidak memiliki akses yang tepat');
      redirect('users');
    }
  }

  /**
   * Index of the SuratMasukController controller
   * @return void menampilkan view suratmasuk/index
   */
  function index()
  {
    // Data that will passed to the view
    $data['title'] = 'Surat Masuk';
    $data['icon'] = '<span class="fas fa-cloud-download-alt"></span>';
    $data['menu'] = 'surat_masuk';
    $data['jumlah'] = $this->db->count_all('surat_masuk');

    /**
     * Checking if the user is kepdin
     * @var boolean
     */
    if ($this->session->userdata('level') == 2) {
      $data['disposisi'] = $this->SuratMasukModel->countDisposisi();
    }

    // Fetching the data from database
    $data['surat_masuk'] = $this->SuratMasukModel->get();

    // Loading the view based on the user level
    $this->load->view('templates/header', $data);
    if ($this->session->userdata('level') == 1) {
      $this->load->view('suratmasuk/index', $data);
    } elseif ($this->session->userdata('level') == 2) {
      $this->load->view('kepdin/index', $data);
    }
    $this->load->view('templates/footer');
  }

  /**
   * Function that used to creating new suratmasuk
   * @return void Menampilkan view suratmasuk/create
   */
  public function create()
  {
    // Checking if the user is kepdin then redirect it back to suratmasuk
    if ($this->session->userdata('level') == 2) {
      $this->session->set_flashdata('failed','Anda tidak memiliki akses yang tepat');
      redirect('suratmasuk');
    }

    // Data that will be pased to the view
    $data['title'] = 'Tambah Surat Masuk';
    $data['icon'] = '<span class="fas fa-cloud-download-alt"></span>';
    $data['menu'] = 'surat_masuk';

    // Error rule for the form validation
    $this->form_validation->set_rules('nomor_surat', 'Nomor Surat', 'trim|required');
    $this->form_validation->set_rules('tanggal_undangan', 'Tanggal Undangan', 'required');
    $this->form_validation->set_rules('asal_surat', 'Asal Surat', 'required');
    $this->form_validation->set_rules('perihal', 'Perihal Surat', 'required');
    $this->form_validation->set_rules('keterangan', 'Keterangan Surat', 'required');
    $this->form_validation->set_rules('tujuan', 'Tujuan Surat', 'required');
    $this->form_validation->set_message('required', 'Harap mengisi kolom {field}');

    /**
     * Checking if the form is currently running or not
     *   if it is, it will try to insert teh data
     *   if it isn't, it will load the create view
     * @var boolean
     */
    if ($this->form_validation->run() == FALSE) {
      // Loading the create view
      $this->load->view('templates/header', $data);
      $this->load->view('suratmasuk/create');
      $this->load->view('templates/footer');
    } else {
      // Configuration for the file upload
      $config['upload_path'] = './assets/upload';
      $config['allowed_types'] = 'jpg|png|doc|pdf|docx';
      $config['max_size'] = 2048000;
      $config['max_width'] = 4000;
      $config['max_height'] = 5000;

      // Loading library for uploading using configuration of $config
      $this->load->library('upload', $config);

      // Renaming the file name with nomor_surat-date.ext
      // $name = preg_replace('/\s/', '', $this->input->post('nomor_surat'))."-".$this->input->post('tanggal_undangan').".".pathinfo($_FILES['dokumen']['name'], PATHINFO_EXTENSION);
      $name = preg_replace('/[^a-zA-Z0-9_]/', '_', $this->input->post('nomor_surat'))."-".$this->input->post('tanggal_undangan').".".pathinfo($_FILES['dokumen']['name'], PATHINFO_EXTENSION);
      // $name_new = preg_replace('/\./', '_', $name);
      $_FILES['dokumen']['name'] = str_replace('/', '_', $name);

      /**
       * Checking wether or not the upload is running
       * @var boolean
       */
      if ($this->upload->do_upload('dokumen')) {
        // Uploading the file
        $data = array('dokumen' => $this->upload->data());
        $this->upload->data();
        $dokumen = $_FILES['dokumen']['name'];
      } else {
        /** @var string the name of the file that will be inserted to the database */
        $dokumen = 'nodoc';

        /**
         * Checking if the errors is not equal to 'didn't upload'
         *   if it is, it will redirect it back with the error description
         * @var int
         */
        if ($_FILES['dokumen']['error'] != 4) {
          $this->session->set_flashdata('upload_error',$this->upload->display_errors('<p class="small text-danger" role="alert">','</p>'));
          $this->session->set_flashdata('post_data', $this->input->post());
          redirect('suratmasuk/create', 'refresh');
        }
      }

      /**
       * Checking if the insert is success or not
       *   if it is, then it will redirect to suratmasuk
       *   it it isn't, it will redirect back with an error message
       * @var boolean
       */
      if ($this->SuratMasukModel->insert($dokumen)) {
        $this->session->set_flashdata('success','Berhasil memasukkan data baru');
        redirect('suratmasuk');
      } else {
        $this->session->set_flashdata('failed','Gagal memasukkan data baru');
        redirect('suratmasuk/create');
      }
    }
  }

  /**
   * Function that used to editing the existing suratmasuk
   * @param  int  $id id of the suratmasuk that will be edited
   * @return void     Load the view of suratmasuk/edit
   */
  public function edit($id)
  {
    // Checking if the user is kepdin then redirect it back to suratmasuk
    if ($this->session->userdata('level') == 2) {
      $this->session->set_flashdata('failed','Anda tidak memiliki akses yang tepat');
      redirect('suratmasuk');
    }

    // Data that will be pased to the view
    $data['title'] = 'Edit Surat Masuk';
    $data['icon'] = '<span class="fas fa-cloud-download-alt"></span>';
    $data['menu'] = 'surat_masuk';
    $data['id'] = $id;

    // Error rule for the form validation
    $this->form_validation->set_rules('nomor_surat', 'Nomor Surat', 'required');
    $this->form_validation->set_rules('tanggal_undangan', 'Tanggal Undangan', 'required');
    $this->form_validation->set_rules('asal_surat', 'Asal Surat', 'required');
    $this->form_validation->set_rules('perihal', 'Perihal Surat', 'required');
    $this->form_validation->set_rules('keterangan', 'Keterangan Surat', 'required');
    $this->form_validation->set_rules('tujuan', 'Tujuan Surat', 'required');
    $this->form_validation->set_message('required', 'Harap mengisi kolom {field}');

    /**
     * Checking if the form is currently running or not
     *   if it is, it will try to insert teh data
     *   if it isn't, it will load the edit view
     * @var boolean
     */
    if ($this->form_validation->run() == FALSE) {
      // Fetching the data from database
      $data['surat_masuk'] = $this->SuratMasukModel->get($id);

      // Loading the edit view
      $this->load->view('templates/header', $data);
      $this->load->view('suratmasuk/edit', $data);
      $this->load->view('templates/footer');
    } else {
      // Configuration for the file upload
      $config['upload_path'] = './assets/upload';
      $config['allowed_types'] = 'jpg|png|doc|pdf|docx';
      $config['max_size'] = 2048000;
      $config['max_width'] = 4000;
      $config['max_height'] = 5000;
      $config['overwrite'] = TRUE;

      // Loading library for uploading using configuration of $config
      $this->load->library('upload', $config);

      // Renaming the file name with nomor_surat-date.ext
      $name = preg_replace('/[^a-zA-Z0-9_]/', '_', $this->input->post('nomor_surat'))."-".$this->input->post('tanggal_undangan').".".pathinfo($_FILES['dokumen_new']['name'], PATHINFO_EXTENSION);
      // $name = preg_replace('/[^a-zA-Z0-9_]/', '_', $this->input->post('nomor_surat'))."-".$this->input->post('tanggal_undangan').".".pathinfo($_FILES['dokumen']['name'], PATHINFO_EXTENSION);
      // $name_new = preg_replace('/\./', '_', $name);
      $_FILES['dokumen_new']['name'] = str_replace('/', '_', $name);

      /**
       * Checking wether or not the upload is running
       * @var boolean
       */
      if ($this->upload->do_upload('dokumen_new')) {
        // Uploading the file
        $data = array('dokumen_new' => $this->upload->data());
        $this->upload->data();
        $dokumen = $_FILES['dokumen_new']['name'];
      } else {
        /** @var boolean condition of the file */
        $dokumen = FALSE;

        /**
         * Checking if the errors is not equal to 'didn't upload'
         *   if it is, it will redirect it back with the error description
         * @var int
         */
        if ($_FILES['dokumen_new']['error'] != 4) {
          $this->session->set_flashdata('upload_error',$this->upload->display_errors('<p class="small text-danger" role="alert">','</p>'));
          $this->session->set_flashdata('post_data', $this->input->post());
          redirect('suratmasuk/'.$id);
        }
      }

      /**
       * Checking if the insert is success or not
       *   if it is, then it will redirect to suratmasuk
       *   it it isn't, it will redirect back with an error message
       * @var boolean
       */
      if ($this->SuratMasukModel->update($id, $dokumen)) {
        $this->session->set_flashdata('success','Berhasil mengubah data');
        redirect('suratmasuk');
      } else {
        $this->session->set_flashdata('failed','Gagal mengubah data');
        redirect('suratmasuk/'.$id);
      }
    }
  }

  /**
   * Change the status of suratmasuk
   * @param  int  $id id of suratmasuk that will be disposisi
   * @return void     Loading the view
   */
  public function disposisi($id)
  {
    // Checking if the user is petugas then redirect it back to suratmasuk
    if ($this->session->userdata('level') == 1) {
      $this->session->set_flashdata('failed','Anda tidak memiliki akses yang tepat');
      redirect('suratmasuk');
    }

    // Do update on the status of suratmasuk
    if ($this->SuratMasukModel->update($id, FALSE)) {
      $this->session->set_flashdata('success','Berhasil menyetujui');
      redirect('suratmasuk');
    } else {
      $this->session->set_flashdata('failed','Gagal menyetujui');
      redirect('suratmasuk');
    }
  }

  /**
   * Show the detail of disposisi
   * @param  int  $id id of suratmasuk that will be shown
   * @return void     Load the view
   */
  public function detaildisposisi($id)
  {
    // Fetching the data
    $data['surat_masuk'] = $this->SuratMasukModel->get($id);

    /**
     * Checking if the detail_disposisi is empty or not
     * @var boolean
     */
    if ($data['surat_masuk']['detail_disposisi'] == '') {
      redirect('suratmasuk');
    }

    // Data that will be passed to the view
    $data['title'] = 'Disposisi Surat Masuk';
    $data['icon'] = '<span class="fas fa-cloud-download-alt"></span>';
    $data['menu'] = 'surat_masuk';
    $data['id'] = $id;

    // Loading the view
    $this->load->view('templates/header', $data);
    $this->load->view('suratmasuk/disposisi', $data);
    $this->load->view('templates/footer');
  }

  /**
   * Delete existing suratkeluar
   * @param  int  $id id of suratmasuk that will be deleted
   * @return void     Load the view
   */
  public function delete($id)
  {
    // Checking if the user is kepdin then redirect it back to suratmasuk
    if ($this->session->userdata('level') == 2) {
      $this->session->set_flashdata('failed','Anda tidak memiliki akses yang tepat');
      redirect('suratmasuk');
    } elseif ($this->session->userdata('level') == 3) {
      $this->session->set_flashdata('failed','Anda tidak memiliki akses yang tepat');
      redirect('users');
    }

    /** @var String the name of the file that will be deleted */
    $file_name = $this->SuratMasukModel->get($id)['dokumen'];

    /**
     * If deleting the row from database is successfull
     *   it will continue to delete the file in the server
     * @var boolean
     */
    if ($this->SuratMasukModel->delete($id)) {
      if ($file_name != 'nodoc') {
        // Getting the current working directory
        $cwd = getcwd();
        // Determining the file path
        $file_path = $cwd.'\\assets\\upload\\';
        chdir($file_path);
        // Deleting the file
        unlink($file_name);
        chdir($cwd);
      }

      $this->session->set_flashdata('success','Berhasil mengapus data surat masuk');
    } else {
      $this->session->set_flashdata('failed','Gagal menghapus data surat masuk');
    }
    redirect('suratmasuk');
  }

  /**
   * Function that used to download the file
   * @return void Download the file
   */
  public function unduh()
  {
    // Checking if the user is kepdin then redirect it back to suratmasuk
    if ($this->session->userdata('level') == 2) {
      $this->session->set_flashdata('failed','Anda tidak memiliki akses yang tepat');
      redirect('suratmasuk');
    } elseif ($this->session->userdata('level') == 3) {
      $this->session->set_flashdata('failed','Anda tidak memiliki akses yang tepat');
      redirect('users');
    }

    /**
     * Checking if the from field is not empty and setting
     *   the time based on that
     * @var boolean
     */
    if ($this->input->post('from')) {
      $from = new DateTime($this->input->post('from'));
      $fromName = $from->format('d-m-Y');
    } else {
      $from = new DateTime('2000-01-01');
      $fromName = 'awal';
    }

    /**
     * Checking if the till field is not empty and setting
     *   the time based on that
     * @var boolean
     */
    if ($this->input->post('till')) {
      $till = new DateTime($this->input->post('till'));
    } else {
      $till = new DateTime();
    }

    // Modifying the till date by 1 day to achieve the right download time
    $till->modify('+1 day');

    /**
     * Checking if the data from database could be fetch
     * @var boolean
     */
    if ($data['unduh'] = $this->SuratMasukModel->unduh($from->format('Y-m-d'), $till->format('Y-m-d'))) {
      // Modifying back the time so the file name is correct
      $tillName = $till->modify('-1 day');
      $data['from'] = $from->format('d-m-Y');
      $data['till'] = $tillName->format('d-m-Y');
      $data['nama_file'] = 'rekap_surat_masuk_'.$fromName.'_hingga_'.$tillName->format('d-M-Y').'.xlsx';

      // Loading the view that will be downloaded
      $this->load->view('suratmasuk/unduh', $data);
    } else {
      $this->session->set_flashdata('failed','Tidak ada data yang dapat diunduh');
      redirect('suratmasuk');
    }
  }

}
