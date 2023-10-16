<?php

class berita_model extends CI_Model
{
  public function  getBerita()
  {
    $this->db->select('*');
    $this->db->from('konten');
    return $this->db->get()->result();
  }

  public function import($data){
    $judul = $data['judul'];

    $existing_data = $this->db->get_where('konten', array('judul' => $judul))->row();

    if ($existing_data) {
        $this->db->where('judul', $judul);
        $this->db->update('konten', $data);
    } else {
        $this->db->insert('konten', $data);
    }
  }
}
