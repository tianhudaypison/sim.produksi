<?php

class PengembalianModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllEntries()
    {
        $this->db->select('tpembelian03_mutasi_pusat.*,
			     COALESCE(tpembelian04_penerimaan_gudang.nopenerimaan, "-") AS nopenerimaan,
           tpembelian04_penerimaan_gudang.id AS idpenerimaangudang,
           tpembelian04_penerimaan_gudang.stapprove,
           mgudang.nama AS namagudang,
           COALESCE(tpembelian04_penerimaan_gudang.totalproduk, "0") AS totalpenerimaan');
        $this->db->join('tpembelian04_penerimaan_gudang', 'tpembelian04_penerimaan_gudang.idmutasi = tpembelian03_mutasi_pusat.id', 'LEFT');
        $this->db->join('mgudang', 'mgudang.id = tpembelian03_mutasi_pusat.idgudang');
        $this->db->where('tpembelian03_mutasi_pusat.status', 1);
        $this->db->order_by('tpembelian03_mutasi_pusat.id', 'DESC');
        $query = $this->db->get('tpembelian03_mutasi_pusat');

        return $query->result();
    }

    public function getSpecifiedEntries($id)
    {
        $this->db->select('tpembelian03_mutasi_pusat.*,
           COALESCE(tpembelian04_penerimaan_gudang.nopenerimaan, "-") AS nopenerimaan,
           mgudang.nama AS namagudang,
           mpegawai.namapegawai AS namauserinput');
        $this->db->join('tpembelian04_penerimaan_gudang', 'tpembelian04_penerimaan_gudang.idmutasi = tpembelian03_mutasi_pusat.id', 'LEFT');
        $this->db->join('mpegawai', 'mpegawai.id = tpembelian04_penerimaan_gudang.iduserinput', 'LEFT');
        $this->db->join('mgudang', 'mgudang.id = tpembelian03_mutasi_pusat.idgudang');
        $this->db->where('tpembelian03_mutasi_pusat.id', $id);
        $query = $this->db->get('tpembelian03_mutasi_pusat');

        return $query->row();
    }

    public function getListProduk($idpenerimaan)
    {
        $this->db->select('tpembelian04_penerimaan_gudang_detail.*,
          mproduk.nama,
          mperusahaan.nama as perusahaan,
          mproduk_kemasan.nama AS namakemasan,
          (CASE
            WHEN tpembelian04_penerimaan_gudang_detail.jenissatuan = 1 THEN mproduk_kemasan.satuankecil
            WHEN tpembelian04_penerimaan_gudang_detail.jenissatuan = 2 THEN mproduk_kemasan.satuanmenengah
            WHEN tpembelian04_penerimaan_gudang_detail.jenissatuan = 3 THEN mproduk_kemasan.satuanbesar
          END) AS namasatuan,
          mproduk_kemasan.satuankecil AS namasatuankecil');
        $this->db->join('mproduk_kemasan', 'mproduk_kemasan.id = tpembelian04_penerimaan_gudang_detail.idprodukkemasan');
        $this->db->join('mproduk', 'mproduk.id = mproduk_kemasan.idproduk');
        $this->db->join('mperusahaan', 'mperusahaan.id = mproduk.idperusahaan');
        $this->db->where('tpembelian04_penerimaan_gudang_detail.idpenerimaan', $idpenerimaan);
        $query = $this->db->get('tpembelian04_penerimaan_gudang_detail');

        return $query->result();
    }

    public function getListProdukPenerimaan($idmutasi)
    {
        $this->db->where('idmutasi', $idmutasi);
        $query = $this->db->get('v_pembelian04_penerimaan_gudang_detail_pending');

        return $query->result();
    }

    public function insert()
    {
        // $this->nopenerimaan = 'AUTO_GENERATE';
        $this->tanggal      = $_POST['tanggal'];
        $this->idmutasi     = $_POST['idmutasi'];
        $this->idgudang     = $_POST['idgudang'];
        $this->iduserinput  = $this->session->userdata('userid');

        $totalProduk = 0;
        if($this->db->insert('tpembelian04_penerimaan_gudang', $this)) {
          $idpenerimaan = $this->db->insert_id();

          // PROCESS GROUPING
          $produkList = json_decode($_POST['produkvalue']);
          $produkGroup = array_reduce($produkList, function ($object, $row) {
            if (isset($object[$row[2].$row[7]])) {
              $object[$row[2].$row[7]][6]   += RemoveComma($row[6]);
            } else {
              $object[$row[2].$row[7]][1]   = $row[1];
              $object[$row[2].$row[7]][2]   = $row[2];
              $object[$row[2].$row[7]][6]   = RemoveComma($row[6]);
              $object[$row[2].$row[7]][7]   = $row[6];
            }

            return $object;
          });

          // DETAIL PRODUK
          foreach ($produkGroup as $row) {
              $dataDetail = array();
              $dataDetail['idpenerimaan']         = $idpenerimaan;
              $dataDetail['idrekanan']            = $row[1];
              $dataDetail['idprodukkemasan']      = $row[2];
              $dataDetail['kuantitas']            = RemoveComma($row[6]);
              $dataDetail['stbonus']              = $row[7];

              $totalProduk = $totalProduk + RemoveComma($row[6]);

              $this->db->insert('tpembelian04_penerimaan_gudang_detail', $dataDetail);
          }

          $this->db->set('totalproduk', $totalProduk);
          $this->db->where('id', $idpenerimaan);
          $this->db->update('tpembelian04_penerimaan_gudang');
        }

        return true;
    }

    public function update()
    {
        $idpenerimaan = $_POST['idpenerimaan'];

        // DETAIL PRODUK
        $this->db->where('idpenerimaan', $idpenerimaan);
        if ($this->db->delete('tpembelian04_penerimaan_gudang_detail')) {

          // PROCESS GROUPING
          $produkList = json_decode($_POST['produkvalue']);
          $produkGroup = array_reduce($produkList, function ($object, $row) {
            if (isset($object[$row[2].$row[7]])) {
              $object[$row[2].$row[7]][6]   += RemoveComma($row[6]);
            } else {
              $object[$row[2].$row[7]][1]   = $row[1];
              $object[$row[2].$row[7]][2]   = $row[2];
              $object[$row[2].$row[7]][6]   = RemoveComma($row[6]);
              $object[$row[2].$row[7]][7]   = $row[6];
            }

            return $object;
          });

          // DETAIL PRODUK
          foreach ($produkGroup as $row) {
              $dataDetail = array();
              $dataDetail['idpenerimaan']         = $idpenerimaan;
              $dataDetail['idrekanan']            = $row[1];
              $dataDetail['idprodukkemasan']      = $row[2];
              $dataDetail['kuantitas']            = RemoveComma($row[6]);
              $dataDetail['stbonus']              = $row[7];

              $totalProduk = $totalProduk + RemoveComma($row[6]);

              $this->db->insert('tpembelian04_penerimaan_gudang_detail', $dataDetail);
          }
        }

        $this->db->set('totalproduk', $totalProduk);
        $this->db->where('id', $idpenerimaan);
        $this->db->update('tpembelian04_penerimaan_gudang');

        return true;
    }

    public function approve($id)
    {
        $this->db->set('stapprove', 1);
        $this->db->where('id', $id);
        $this->db->update('tpembelian04_penerimaan_gudang');

        return true;
    }
}
