<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for the suratkeluar
 */
class SuratKeluarModel extends CI_Model{

  /** @var int id of suratkeluar */
  var $id;

  /** @var String nomor_surat of suratkeluar */
  var $nomor_surat;

  /** @var String kepada of suratkeluar */
  var $kepada;

  /** @var String perihal of suratkeluar */
  var $perihal;

  /** @var String bidang of suratkeluar */
  var $bidang;

  /** @var String file name of suratkeluar */
  var $dokumen;

  /** @var DateTime the time and date when the data is created */
  var $tanggal_data;

  /** @var String the username that last edited the data */
  var $users_username;

  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Fetching the data of suratkeluar from database
   * @param  boolean $id id of suratkeluar that will be used
   * @return array       Array of the data that will be used
   */
  public function get($id = FALSE)
  {
    if ($id == FALSE) {
      $this->db->select('*');
      $this->db->from('surat_keluar');
      $this->db->order_by('id', 'DESC');
      $query = $this->db->get();
      return $query->result_array();
    } else {
      $query = $this->db->get_where('surat_keluar', array('id' => $id));
      return $query->row_array();
    }
  }

  /**
   * Get the last suratkeluar
   * @return array Array of the data that will be used
   */
  public function last_surat()
  {
    $this->db->limit(1);
    $this->db->order_by('id', 'DESC');
    $query = $this->db->get('surat_keluar');
    return $query->row_array();
  }

  /**
   * Inserting data to database
   * @param  String  $dokumen the file name that will be uploaded
   * @return boolean          return if the insert is success or not
   */
  public function insert($dokumen)
  {
    $this->nomor_surat = preg_replace('/\s/', '', $this->input->post('nomor_surat'));
    $this->kepada = $this->input->post('kepada');
    $this->perihal = $this->input->post('perihal');
    $this->bidang = $this->input->post('bidang');
    $this->dokumen = $dokumen;
    $this->users_username = $this->input->post('username');

    if ($this->db->insert('surat_keluar', $this)) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  /**
   * Update the existing suratkeluar with new data
   * @param  int    $id_new      id that will be edited
   * @param  String $dokumen_new file name that will be updated
   * @return boolean             return wether or not the update is success or not
   */
  public function update($id_new, $dokumen_new)
  {
    if (!$dokumen_new == FALSE) {
      $this->id = $id_new;
      $this->nomor_surat = preg_replace('/\s/', '', $this->input->post('nomor_surat'));
      $this->kepada = $this->input->post('kepada');
      $this->perihal = $this->input->post('perihal');
      $this->bidang = $this->input->post('bidang');
      $this->dokumen = $dokumen_new;
      $this->tanggal_data = $this->input->post('tanggal_data');
      $this->users_username = $this->input->post('username');
    } else {
      $this->id = $id_new;
      $this->nomor_surat = preg_replace('/\s/', '', $this->input->post('nomor_surat'));
      $this->kepada = $this->input->post('kepada');
      $this->perihal = $this->input->post('perihal');
      $this->bidang = $this->input->post('bidang');
      $this->tanggal_data = $this->input->post('tanggal_data');
      $this->dokumen = $this->input->post('dokumen');
      $this->users_username = $this->input->post('username');
    }

    $this->db->where('id', $this->id);
    if ($this->db->update('surat_keluar', $this)) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  /**
   * Delete the existing suratkeluar
   * @param  int      $id id of suratkeluar that will be deleted
   * @return boolean      return wether or not that the delete is success or not
   */
  public function delete($id)
  {
    $this->db->where('id',$id);
    if ($this->db->delete('surat_keluar')) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  /**
   * Download the file of recap
   * @param  Date $from  The time and date that it will be started to listed
   * @param  Date $till  The time and date that it will be marked as the last suratkeluar
   * @return array       The data that will be downloaded as xlsx file
   */
  public function unduh($from, $till)
  {
    $this->db->where('tanggal_data >=', $from);
    $this->db->where('tanggal_data <', $till);
    $query = $this->db->get('surat_keluar');

    return $query->result_array();
  }

}
