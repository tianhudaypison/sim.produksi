<?php

class PengirimanModel extends CI_Model
{
    public function getAllEntries(){
        $this->db->select('tpembelian05_pengiriman.*,
          tpembelian02_penerimaan_pusat.nopenerimaan');
        $this->db->from('tpembelian05_pengiriman');
        $this->db->join('tpembelian02_penerimaan_pusat', 'tpembelian02_penerimaan_pusat.id = tpembelian05_pengiriman.idpenerimaan');
        $this->db->order_by('tpembelian05_pengiriman.id', 'DESC');
        $query = $this->db->get();

        return $query->result();
    }

    public function getSpecifiedEntries($id)
    {
        $this->db->select('tpembelian05_pengiriman.*,
          tpembelian02_penerimaan_pusat.nopenerimaan');
        $this->db->join('tpembelian02_penerimaan_pusat', 'tpembelian02_penerimaan_pusat.id = tpembelian05_pengiriman.idpenerimaan');
        $this->db->where('tpembelian05_pengiriman.id', $id);
        $query = $this->db->get('tpembelian05_pengiriman');

        return $query->row();
    }

    public function getPenerimaan()
    {
        $this->db->order_by('tpembelian02_penerimaan_pusat.id', 'DESC');
        $this->db->where('tpembelian02_penerimaan_pusat.stpengiriman', 0);
        $query = $this->db->get('tpembelian02_penerimaan_pusat');

        return $query->result();
    }

    public function getDetailPengiriman($id)
    {
        $this->db->where('idpengiriman', $id);
        $query = $this->db->get('tpembelian05_pengiriman_detail');

        return $query->result();
    }

    public function getNoBalance()
    {
        $this->db->like('nobalance', 'BL.EXPS.'.date('y').date('m'), 'after');
        $this->db->from('tbalance_expense');
        $query = $this->db->count_all_results();

        if ($query > 0) {
            $autono = $query + 1;
            $autono = 'BL.EXPS.'.date('y').date('m').str_pad($autono, 3, '0', STR_PAD_LEFT);
        } else {
            $autono = 'BL.EXPS.'.date('y').date('m').'001';
        }

        return $autono;
    }

    public function insert()
    {
        $this->nopengiriman        = 'AUTO_GENERATE';
        $this->tanggal             = $_POST['tanggal'];
        $this->idpenerimaan        = $_POST['idpenerimaan'];
        $this->totalpengiriman     = RemoveComma($_POST['totalpengiriman']);

        if ($this->db->insert('tpembelian05_pengiriman', $this)) {
            $idpengiriman = $this->db->insert_id();
            $pengiriman_list = json_decode($_POST['pengirimanvalue']);
            foreach ($pengiriman_list as $row) {
              $detail = array();
              $detail['idpengiriman'] = $idpengiriman;
              $detail['keterangan']   = $row[1];
              $detail['noresi']       = $row[2];
              $detail['total']        = RemoveComma($row[3]);

              $this->db->insert('tpembelian05_pengiriman_detail', $detail);
            }

            // post to balance expense
            $data = array();
            $data['nobalance']        = $this->getNoBalance();
            $data['noreff_pembelian'] = $this->nopengiriman;
            $data['keterangan']       = 'Biaya Pengiriman Produk';
            $data['nominal']          = $this->totalpengiriman;
            $data['st_barang']        = 0;
            $data['st_pembayaran']    = 0;
            $data['status']           = 1;

            if($this->db->insert('tbalance_expense', $data)){
              $idbalance = $this->db->insert_id();
              $data = array();
              $data['idbalance'] = $idbalance;
              $data['idrekanan'] = 0;

              $this->db->insert('tbalance_expense_detail', $data);
            }

            $this->db->set('stpengiriman', 1);
            $this->db->where('id', $_POST['idpenerimaan']);
            $this->db->update('tpembelian02_penerimaan_pusat');

            return true;
        } else {
            $this->error_message = 'Penyimpanan Gagal';

            return false;
        }
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
