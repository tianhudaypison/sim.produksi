<?php

class TipeKemejaModel extends CI_Model
{
    public function getAllEntries(){
      $this->db->where('status', 1);
      $this->db->order_by('mtipekemeja.id', 'DESC');
      $query = $this->db->get('mtipekemeja');

      return $query->result();
    }

    public function getSpecifiedEntries($id){
      $this->db->where('id', $id);
      $this->db->where('status', 1);
      $query = $this->db->get('mtipekemeja');

      return $query->row();
    }

    public function insert()
    {
        $this->nama = $_POST['nama'];
        $this->harga = $_POST['harga'];

        if ($this->db->insert('mtipekemeja', $this)) {
            return true;
        } else {
            $this->error_message = 'Penyimpanan Gagal';

            return false;
        }
    }

    public function update()
    {
        $this->nama = $_POST['nama'];
        $this->harga = $_POST['harga'];

        if ($this->db->update('mtipekemeja', $this, array('id' => $_POST['id']))) {
            return true;
        } else {
            $this->error_message = 'Penyimpanan Gagal';

            return false;
        }
    }

    public function delete($id)
    {
        $this->status = 0;

        if ($this->db->update('mtipekemeja', $this, array('id' => $id))) {
            return true;
        } else {
            $this->error_message = 'Penyimpanan Gagal';

            return false;
        }
    }
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
