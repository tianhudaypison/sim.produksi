<?php

class StasiunProduksiModel extends CI_Model
{
    public function getAllEntries(){
      $this->db->where('status', 1);
      $this->db->order_by('mstasiun.id', 'DESC');
      $query = $this->db->get('mstasiun');

      return $query->result();
    }

    public function getSpecifiedEntries($id){
      $this->db->where('id', $id);
      $this->db->where('status', 1);
      $query = $this->db->get('mstasiun');

      return $query->row();
    }

    public function insert()
    {
        $this->nama = $_POST['nama'];
        $this->keterangan = $_POST['keterangan'];
        $this->totalkapasitas = $_POST['totalkapasitas'];

        if ($this->db->insert('mstasiun', $this)) {
            $idstasiun = $this->db->insert_id();
            $namaMesin = $_POST['namamesin'];
            $kapasitasMesin = $_POST['kapasitasmesin'];

            foreach ($namaMesin as $index => $row) {
              $data = array();
              $data['idstasiun'] = $idstasiun;
              $data['nama'] = $row;
              $data['kapasitas'] = $kapasitasMesin[$index];

              $this->db->insert('mstasiun_detail', $data);
            }

            return true;
        } else {
            $this->error_message = 'Penyimpanan Gagal';

            return false;
        }
    }

    public function update()
    {
        $this->nama = $_POST['nama'];
        $this->keterangan = $_POST['keterangan'];
        $this->totalkapasitas = $_POST['totalkapasitas'];

        if ($this->db->update('mstasiun', $this, array('id' => $_POST['id']))) {
            return true;
        } else {
            $this->error_message = 'Penyimpanan Gagal';

            return false;
        }
    }

    public function delete($id)
    {
        $this->status = 0;

        if ($this->db->update('mstasiun', $this, array('id' => $id))) {
            return true;
        } else {
            $this->error_message = 'Penyimpanan Gagal';

            return false;
        }
    }
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
