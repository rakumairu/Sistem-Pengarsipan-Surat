<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for the suratmasuk
 */
class SuratMasukModel extends CI_Model{

  /** @var int id of suratmasuk */
  var $id;

  /** @var String nomor_surat of suratmasuk */
  var $nomor_surat;

  /** @var DateTime the time and date of the suratmasuk */
  var $tanggal_undangan;

  /** @var String asal_surat of suratmasuk */
  var $asal_surat;

  /** @var String perihal of suratmasuk */
  var $perihal;

  /** @var String keterangan of suratmasuk */
  var $keterangan;

  /** @var String tujuan of suratmasuk */
  var $tujuan;

  /** @var String the name of file that will be uploaded */
  var $dokumen;

  /** @var String status of suratmasuk */
  var $status;

  /** @var String detail_disposisi of suratmasuk */
  var $detail_disposisi;

  /** @var DateTime the time and date when the data is created */
  var $tanggal_data;

  var $users_username;

  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Fetching the data of suratmasuk from database
   * @param  boolean $id id of suratmasuk that will be used
   * @return array       Array of the data that will be used
   */
  public function get($id = FALSE)
  {
    if ($id == FALSE) {
      $this->db->select('*');
      $this->db->from('surat_masuk');
      $this->db->join('users', 'users.username = surat_masuk.users_username');
      $query = $this->db->get();
      return $query->result_array();
    } else {
      $query = $this->db->get_where('surat_masuk', array('id' => $id));
      return $query->row_array();
    }
  }

  /**
   * Count the amount of data that hasn't been approved yet
   * @return int The amount of the data
   */
  public function countDisposisi()
  {
    $this->db->where('status', 1);
    $this->db->or_where('status', 2);
    $this->db->from('surat_masuk');
    return $this->db->count_all_results();
  }

  /**
   * Inserting data to database
   * @param  String  $dokumen the file name that will be uploaded
   * @return boolean          return if the insert is success or not
   */
  public function insert($dokumen)
  {
    $this->nomor_surat = preg_replace('/\s/', '', $this->input->post('nomor_surat'));
    $this->tanggal_undangan = $this->input->post('tanggal_undangan');
    $this->asal_surat = $this->input->post('asal_surat');
    $this->perihal = $this->input->post('perihal');
    $this->keterangan = $this->input->post('keterangan');
    $this->tujuan = $this->input->post('tujuan');
    $this->dokumen = $dokumen;
    $this->status = 1;
    $this->detail_disposisi = '';
    $this->users_username = $this->input->post('username');

    if ($this->db->insert('surat_masuk', $this)) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  /**
   * Update the existing suratmasuk with new data
   * @param  int    $id_new      id that will be edited
   * @param  String $dokumen_new file name that will be updated
   * @return boolean             return wether or not the update is success or not
   */
  public function update($id_new, $dokumen_new)
  {
    if (!$dokumen_new == FALSE) {
      $this->id = $id_new;
      $this->nomor_surat = preg_replace('/\s/', '', $this->input->post('nomor_surat'));
      $this->tanggal_undangan = $this->input->post('tanggal_undangan');
      $this->asal_surat = $this->input->post('asal_surat');
      $this->perihal = $this->input->post('perihal');
      $this->keterangan = $this->input->post('keterangan');
      $this->tujuan = $this->input->post('tujuan');
      $this->dokumen = $dokumen_new;
      $this->tanggal_data = $this->input->post('tanggal_data');
      $this->status = $this->input->post('status');
      $this->detail_disposisi = $this->input->post('detail_disposisi');
      $this->users_username = $this->input->post('username');
    } else {
      $this->id = $id_new;
      $this->nomor_surat = preg_replace('/\s/', '', $this->input->post('nomor_surat'));
      $this->tanggal_undangan = $this->input->post('tanggal_undangan');
      $this->asal_surat = $this->input->post('asal_surat');
      $this->perihal = $this->input->post('perihal');
      $this->keterangan = $this->input->post('keterangan');
      $this->tujuan = $this->input->post('tujuan');
      $this->tanggal_data = $this->input->post('tanggal_data');
      $this->status = $this->input->post('status');
      $this->detail_disposisi = $this->input->post('detail_disposisi');
      $this->dokumen = $this->input->post('dokumen');
      $this->users_username = $this->input->post('username');
    }

    $this->db->where('id', $this->id);
    if ($this->db->update('surat_masuk', $this)) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  /**
   * Delete the existing suratmasuk
   * @param  int      $id id of suratmasuk that will be deleted
   * @return boolean      return wether or not that the delete is success or not
   */
  public function delete($id)
  {
    $this->db->where('id',$id);
    if ($this->db->delete('surat_masuk')) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  /**
   * Download the file of recap
   * @param  Date $from  The time and date that it will be started to listed
   * @param  Date $till  The time and date that it will be marked as the last suratmasuk
   * @return array       The data that will be downloaded as xlsx file
   */
  public function unduh($from, $till)
  {
    $this->db->where('tanggal_data >=', $from);
    $this->db->where('tanggal_data <', $till);
    $query = $this->db->get('surat_masuk');

    return $query->result_array();
  }

}
