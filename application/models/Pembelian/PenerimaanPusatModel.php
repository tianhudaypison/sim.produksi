<?php

class PenerimaanPusatModel extends CI_Model
{
    public function getAllEntries(){
        $this->db->select('tpembelian02_penerimaan_pusat.*,
           tpembelian01_pemesanan.nopemesanan,
           mrekanan.namarekanan');
        $this->db->join('tpembelian01_pemesanan', 'tpembelian01_pemesanan.id = tpembelian02_penerimaan_pusat.idpemesanan');
        $this->db->join('mrekanan', 'mrekanan.id = tpembelian01_pemesanan.idrekanan');
        $this->db->where('tpembelian02_penerimaan_pusat.status', 1);
        $this->db->order_by('tpembelian02_penerimaan_pusat.id', 'DESC');
        $query = $this->db->get('tpembelian02_penerimaan_pusat');

        return $query->result();
    }

    public function getSpecifiedEntries($id)
    {
        $this->db->select('tpembelian02_penerimaan_pusat.*,
          tpembelian01_pemesanan.nopemesanan,
          mrekanan.namarekanan,
          mpegawai.namapegawai AS namauserinput');
        $this->db->where('tpembelian02_penerimaan_pusat.id', $id);
        $this->db->join('tpembelian01_pemesanan', 'tpembelian01_pemesanan.id =  tpembelian02_penerimaan_pusat.idpemesanan');
        $this->db->join('mrekanan', 'mrekanan.id =  tpembelian01_pemesanan.idrekanan');
        $this->db->join('mpegawai', 'mpegawai.id =  tpembelian02_penerimaan_pusat.iduserinput', 'LEFT');
        $query = $this->db->get('tpembelian02_penerimaan_pusat');

        return $query->row();
    }

    public function getDetailPenerimaanPusat($idpenerimaan)
    {
        $this->db->select('tpembelian02_penerimaan_pusat_detail.*,
          mproduk.nama,
          mperusahaan.nama as perusahaan,
          mproduk_kemasan.nama AS namakemasan');
        $this->db->join('mproduk_kemasan', 'mproduk_kemasan.id = tpembelian02_penerimaan_pusat_detail.idprodukkemasan');
        $this->db->join('mproduk', 'mproduk.id = mproduk_kemasan.idproduk');
        $this->db->join('mperusahaan', 'mperusahaan.id = mproduk.idperusahaan');
        $this->db->where('tpembelian02_penerimaan_pusat_detail.idpenerimaan', $idpenerimaan);
        $query = $this->db->get('tpembelian02_penerimaan_pusat_detail');

        return $query->result();
    }

    public function getPemesanan()
    {
        $query = $this->db->get('v_pembelian01_pemesanan_pusat_pending');

        return $query->result();
    }

    public function getPemesananSelected($idpemesanan)
    {
        $this->db->where('id', $idpemesanan);
        $query = $this->db->get('tpembelian01_pemesanan');

        return $query->result();
    }

    public function getRekanan()
    {
        $this->db->order_by('namarekanan', 'ASC');
        $this->db->where('status', 1);
        $query = $this->db->get('mrekanan');

        return $query->result();
    }

    public function getGudang()
    {
        $this->db->order_by('nama', 'ASC');
        $this->db->where('status', 1);
        $query = $this->db->get('mgudang');

        return $query->result();
    }

    public function getProdukKemasan()
    {
        $this->db->select('mproduk_kemasan.id,
          mproduk.nama AS namaproduk,
          mperusahaan.nama AS namaperusahaan,
          mproduk_kemasan.nama AS namakemasan');
        $this->db->join('mproduk', 'mproduk.id = mproduk_kemasan.idproduk');
        $this->db->join('mperusahaan', 'mperusahaan.id = mproduk.idperusahaan');
        $query = $this->db->get('mproduk_kemasan');

        return $query->result();
    }

    public function getProdukDirect($idpenerimaan)
    {
        $this->db->where('idpenerimaan', $idpenerimaan);
        $query = $this->db->get('v_pembelian03_mutasi_pusat_detail_pending');

        return $query->result();
    }

    public function insert()
    {
        // $this->nopenerimaan = 'AUTO_GENERATE';
        $this->nodo         = $_POST['nodo'];
        $this->tanggal      = $_POST['tanggal'];
        $this->idrekanan    = $_POST['idrekanan'];
        $this->idpemesanan  = $_POST['idpemesanan'];
        $this->iduserinput  = $this->session->userdata('userid');

        $totalProduk = 0;
        if($this->db->insert('tpembelian02_penerimaan_pusat', $this)){
          $idpenerimaan = $this->db->insert_id();

          // PROCESS GROUPING
          $produkList = json_decode($_POST['produkvalue']);
          $produkGroup = array_reduce($produkList, function ($object, $row) {
            if(isset($object[$row[1].$row[6]])){
              $object[$row[1].$row[6]][5]   += RemoveComma($row[5]);
            }else{
              $object[$row[1].$row[6]][1]   = $row[1];
              $object[$row[1].$row[6]][5]   = RemoveComma($row[5]);
              $object[$row[1].$row[6]][6]   = $row[6];
            }

            return $object;
          });

          // DETAIL PRODUK
          foreach ($produkGroup as $row) {
            $dataDetail = array();
            $dataDetail['idpenerimaan']         = $idpenerimaan;
            $dataDetail['idrekanan']            = $this->idrekanan;
            $dataDetail['idprodukkemasan']      = $row[1];
            $dataDetail['kuantitas']            = RemoveComma($row[5]);
            $dataDetail['stbonus']              = $row[6];

            $totalProduk = $totalProduk + RemoveComma($row[5]);

            $this->db->insert('tpembelian02_penerimaan_pusat_detail', $dataDetail);
          }

          $this->db->set('totalproduk', $totalProduk);
          $this->db->where('id', $idpenerimaan);
          $this->db->update('tpembelian02_penerimaan_pusat');
        }

        return true;
    }

    public function update()
    {
        $this->db->set('nodo', $_POST['nodo']);
        $this->db->set('tanggal', $_POST['tanggal']);
        $this->db->set('idrekanan', $_POST['idrekanan']);
        $this->db->set('idpemesanan', $_POST['idpemesanan']);

        $this->db->where('id', $_POST['id']);
        if($this->db->update('tpembelian02_penerimaan_pusat')) {
            $idpenerimaan = $_POST['id'];

            $this->db->where('idpenerimaan', $idpenerimaan);
            if ($this->db->delete('tpembelian02_penerimaan_pusat_detail')) {
              // PROCESS GROUPING
              $produkList = json_decode($_POST['produkvalue']);
              $produkGroup = array_reduce($produkList, function ($object, $row) {
                if(isset($object[$row[1].$row[6]])){
                  $object[$row[1].$row[6]][5]   += RemoveComma($row[5]);
                }else{
                  $object[$row[1].$row[6]][1]   = $row[1];
                  $object[$row[1].$row[6]][5]   = RemoveComma($row[5]);
                  $object[$row[1].$row[6]][6]   = $row[6];
                }

                return $object;
              });

              // DETAIL PRODUK
              foreach ($produkGroup as $row) {
                $dataDetail = array();
                $dataDetail['idpenerimaan']         = $idpenerimaan;
                $dataDetail['idrekanan']            = $this->idrekanan;
                $dataDetail['idprodukkemasan']      = $row[1];
                $dataDetail['kuantitas']            = RemoveComma($row[5]);
                $dataDetail['stbonus']              = $row[6];

                $totalProduk = $totalProduk + RemoveComma($row[5]);

                $this->db->insert('tpembelian02_penerimaan_pusat_detail', $dataDetail);
              }
            }

            $this->db->set('totalproduk', $totalProduk);
            $this->db->where('id', $idpenerimaan);
            $this->db->update('tpembelian02_penerimaan_pusat');
        }

        return true;
    }

    public function insertDirect()
    {
        // $this->nomutasi     = 'AUTO_GENERATE';
        $this->tanggal      = $_POST['tanggal'];
        $this->idpenerimaan = $_POST['idpenerimaan'];
        $this->idgudang     = $_POST['idgudang'];

        $totalProduk = 0;
        if($this->db->insert('tpembelian03_mutasi_pusat', $this)){
          $idmutasi = $this->db->insert_id();

          // PROCESS GROUPING
          $produkList = json_decode($_POST['produkvalue']);
          $produkGroup = array_reduce($produkList, function ($object, $row) {
            if(isset($object[$row[1].$row[6]])){
              $object[$row[1].$row[6]][5]   += RemoveComma($row[5]);
            }else{
              $object[$row[1].$row[6]][1]   = $row[1];
              $object[$row[1].$row[6]][5]   = RemoveComma($row[5]);
              $object[$row[1].$row[6]][6]   = $row[6];
            }

            return $object;
          });

          // DETAIL PRODUK
          foreach ($produkGroup as $row) {
            $dataDetail = array();
            $dataDetail['idmutasi']             = $idmutasi;
            $dataDetail['idrekanan']            = $_POST['idrekanan'];
            $dataDetail['idprodukkemasan']      = $row[1];
            $dataDetail['kuantitas']            = RemoveComma($row[5]);
            $dataDetail['stbonus']              = $row[6];

            $totalProduk = $totalProduk + RemoveComma($row[5]);

            $this->db->insert('tpembelian03_mutasi_pusat_detail', $dataDetail);
          }

          $this->db->set('totalproduk', $totalProduk);
          $this->db->where('id', $idmutasi);
          $this->db->update('tpembelian03_mutasi_pusat');
        }

        return true;
    }

    public function delete()
    {
        $this->status = 0;

        if ($this->db->update('tpembelian01_pemesanan', $this, array('id' => $_POST['idtransaksi']))) {
            return true;
        } else {
            $this->error_message = 'Penyimpanan Gagal';

            return false;
        }
    }

    // JQuery Process
    public function getDetailPemesanan($idpemesanan)
    {
        $this->db->where('idpemesanan', $idpemesanan);
        $this->db->order_by('idprodukkemasan', 'ASC');
        $query = $this->db->get('v_pembelian02_penerimaan_pusat_detail_pending');

        return $query->result();
    }

    function getInfoTempProduk($idprodukkemasan){
        $this->db->select('mproduk.nama AS namaproduk,
        mproduk_kemasan.nama AS namakemasan,
        mperusahaan.nama AS namaperusahaan');
        $this->db->join('mproduk', 'mproduk.id = mproduk_kemasan.idproduk');
        $this->db->join('mperusahaan', 'mperusahaan.id = mproduk.idperusahaan');
        $this->db->where('mproduk_kemasan.id', $idprodukkemasan);
        $query = $this->db->get('mproduk_kemasan');

        $row = $query->row();
        if($query->num_rows() > 0){
          $data['namaproduk'] = $row->namaproduk;
          $data['namakemasan'] = $row->namakemasan;
          $data['namaperusahaan'] = $row->namaperusahaan;
        }else{
          $data['namaproduk'] = '';
          $data['namakemasan'] = '';
          $data['namaperusahaan'] = '';
        }

        return $data;
    }

    public function getNoPemesananByRekanan($idrekanan)
    {
        $this->db->where('idrekanan', $idrekanan);
        $query = $this->db->get('v_pembelian01_pemesanan_pusat_pending');

        return $query->result();
    }

    public function getNoPemesananByProduk($idrekanan, $idprodukkemasan)
    {
        $query = $this->db->query("SELECT
        	v_pembelian01_pemesanan_pusat_pending.*
        FROM
        	(
        		SELECT
        			idpemesanan,GROUP_CONCAT(idprodukkemasan ORDER BY idprodukkemasan ASC) idkemasangrup
        		FROM
        			tpembelian01_pemesanan_detail
            WHERE idrekanan = '".$idrekanan."'
        		GROUP BY
        			idpemesanan
            HAVING idkemasangrup  = '".$idprodukkemasan."'
        	) AS result
        INNER JOIN v_pembelian01_pemesanan_pusat_pending ON v_pembelian01_pemesanan_pusat_pending.id = result.idpemesanan");

        return $query->result();
    }
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
