<?php

class PemesananModel extends CI_Model
{
    public function getAllEntries(){
      $this->db->select('tpembelian01_pemesanan.*, mrekanan.namarekanan');
      $this->db->join('mrekanan', 'mrekanan.id = tpembelian01_pemesanan.idrekanan');
      $this->db->order_by('tpembelian01_pemesanan.id', 'DESC');
      $query = $this->db->get('tpembelian01_pemesanan');

      return $query->result();
    }

    public function getSpecifiedEntries($id)
    {
        $this->db->select('tpembelian01_pemesanan.*,
          mrekanan.namarekanan,
          GROUP_CONCAT(tblkredit.kreditdiskon) AS kreditdiskon,
          GROUP_CONCAT(tblkredit.kredithari) AS kredithari,
          GROUP_CONCAT(tblkredit.kreditdiskon, "/", tblkredit.kredithari, "" SEPARATOR " - ") as keterangankredit');
        $this->db->where('tpembelian01_pemesanan.id', $id);
        $this->db->join('tpembelian01_pemesanan_kredit tblkredit', 'tblkredit.idpemesanan =  tpembelian01_pemesanan.id', 'LEFT');
        $this->db->join('mrekanan', 'mrekanan.id =  tpembelian01_pemesanan.idrekanan', 'LEFT');
        $query = $this->db->get('tpembelian01_pemesanan');

        return $query->row();
    }

    public function getDetailPemesanan($idpemesanan)
    {
        $this->db->select('tpembelian01_pemesanan_detail.*,
          mproduk.nama AS namaproduk,
          mperusahaan.nama AS namaperusahaan,
          mproduk_kemasan.nama AS namakemasan');
        $this->db->join('mproduk_kemasan', 'mproduk_kemasan.id = tpembelian01_pemesanan_detail.idprodukkemasan');
        $this->db->join('mproduk', 'mproduk.id = mproduk_kemasan.idproduk');
        $this->db->join('mperusahaan', 'mperusahaan.id = mproduk.idperusahaan');
        $this->db->where('tpembelian01_pemesanan_detail.idpemesanan', $idpemesanan);
        $query = $this->db->get('tpembelian01_pemesanan_detail');

        return $query->result();
    }

    public function getRekanan()
    {
        $this->db->order_by('namarekanan', 'ASC');
        $this->db->where('status', 1);
        $query = $this->db->get('mrekanan');

        return $query->result();
    }

    public function getTemplatePajak()
    {
        $this->db->order_by('id', 'ASC');
        $this->db->where('status', 1);
        $query = $this->db->get('mpajak_pembelian_template');

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

    public function getPemesananDraft()
    {
        $this->db->select('tpembelian01_pemesanan.*');
        $this->db->join('tpembelian02_penerimaan_pusat', 'tpembelian02_penerimaan_pusat.idpemesanan = tpembelian01_pemesanan.id','LEFT');
        $this->db->where('tpembelian01_pemesanan.status', 1);
        $this->db->where('tpembelian02_penerimaan_pusat.id', NULL);
        $query = $this->db->get('tpembelian01_pemesanan');

        return $query->result();
    }

    public function insert()
    {
        // $this->nopemesanan          = 'AUTO_GENERATE';
        $this->tanggal              = $_POST['tanggal'];
        $this->idrekanan            = $_POST['idrekanan'];
        $this->idterm               = $_POST['idterm'];
        $this->kreditmaxbayar       = $_POST['kreditmaxbayar'];
        $this->idtemplatepajak      = $_POST['idtemplatepajak'];
        $this->totalproduk          = RemoveComma($_POST['totalproduk']);
        $this->totalpemesanan       = RemoveComma($_POST['totalpemesanan']);
        $this->totaldiskonpemesanan = RemoveComma($_POST['totaldiskonpemesanan']);
        $this->totaldiskonbonus     = RemoveComma($_POST['totaldiskonbonus']);
        $this->totalcashback        = RemoveComma($_POST['totalcashback']);
        $this->totalakhir           = RemoveComma($_POST['totalakhir']);
        $this->iduserinput          = $this->session->userdata('userid');

        if(isset($_POST['mergeprocess'])){
          $this->catatanpergantian = 'Transaksi ini adalah hasil dari Proses Merge, dengan Referensi No. Pemesanan : '.$_POST['nopemesanan1'].' & '.$_POST['nopemesanan2'];
          $this->transaksipergantian = $_POST['idpemesanan1'].','.$_POST['idpemesanan2'];
        }

        if($this->db->insert('tpembelian01_pemesanan', $this)){
          $idpemesanan = $this->db->insert_id();
          $idrekanan = $_POST['idrekanan'];

          // TERM KREDIT
          if ($_POST['idterm'] == '2') {
              if(isset($_POST['mergeprocess'])){

                $this->db->where('tpembelian01_pemesanan_kredit.idpemesanan', $_POST['idpemesanan1']);
                $query = $this->db->get('tpembelian01_pemesanan_kredit');

                 foreach ($query->result() as $row) {
                   $dataKredit = array();
                   $dataKredit['idpemesanan']   = $idpemesanan;
                   $dataKredit['kreditdiskon']  = $row->kreditdiskon;
                   $dataKredit['kredithari']    = $row->kredithari;

                   $this->db->insert('tpembelian01_pemesanan_kredit', $dataKredit);
                 }
              }else{
                $arrDiskon = explode(',', $_POST['kreditdiskon']);
                $arrHari   = explode(',', $_POST['kredithari']);

                foreach ($arrDiskon as $index => $diskon) {
                  $dataKredit = array();
                  $dataKredit['idpemesanan']   = $idpemesanan;
                  $dataKredit['kreditdiskon']  = $diskon;
                  $dataKredit['kredithari']    = $arrHari[$index];

                  $this->db->insert('tpembelian01_pemesanan_kredit', $dataKredit);
                }
              }
          }

          // PROCESS GROUPING
          $produkList = json_decode($_POST['produkvalue']);
          $produkGroup = array_reduce($produkList, function ($object, $row) {
            if(isset($object[$row[2].$row[10]])){
              $object[$row[2].$row[10]][6]   += RemoveComma($row[6]);
              $object[$row[2].$row[10]][7]   += RemoveComma($row[7]);
              $object[$row[2].$row[10]][8]   += RemoveComma($row[8]);
              $object[$row[2].$row[10]][9]   += RemoveComma($row[9]);
            }else{
              $object[$row[2].$row[10]][2]   = $row[2];
              $object[$row[2].$row[10]][4]   = RemoveComma($row[4]);
              $object[$row[2].$row[10]][6]   = RemoveComma($row[6]);
              $object[$row[2].$row[10]][7]   = RemoveComma($row[7]);
              $object[$row[2].$row[10]][8]   = RemoveComma($row[8]);
              $object[$row[2].$row[10]][9]   = RemoveComma($row[9]);
              $object[$row[2].$row[10]][10]  = $row[10];
            }

            return $object;
          });

          // DETAIL PRODUK
          foreach ($produkGroup as $row) {
            $dataDetail = array();
            $dataDetail['idpemesanan']          = $idpemesanan;
            $dataDetail['idrekanan']            = $_POST['idrekanan'];
            $dataDetail['idprodukkemasan']      = $row[2];
            $dataDetail['harga']                = RemoveComma($row[4]);
            $dataDetail['kuantitas']            = RemoveComma($row[6]);
            $dataDetail['total']                = RemoveComma($row[7]);
            $dataDetail['diskon']               = RemoveComma($row[8]);
            $dataDetail['cashback']             = RemoveComma($row[9]);
            $dataDetail['stbonus']              = $row[10];
            $this->db->insert('tpembelian01_pemesanan_detail', $dataDetail);
          }
        }

        if(isset($_POST['mergeprocess'])){
          $this->db->set('catatanpergantian', 'Transaksi ini telah dilakukan Proses Merge, dan dialihkan menjadi No. Pemesanan : '.$this->nopemesanan);
          $this->db->set('transaksipergantian', $idpemesanan);
          $this->db->set('tanggalpergantian', $_POST['tanggal']);
          $this->db->set('status', 2);

          $this->db->where('id', $_POST['idpemesanan1']);
          $this->db->or_where('id', $_POST['idpemesanan2']);
          $this->db->update('tpembelian01_pemesanan');
        }

        return true;
    }

    public function update()
    {
        $this->db->set('tanggal', $_POST['tanggal']);
        $this->db->set('idrekanan', $_POST['idrekanan']);
        $this->db->set('idterm', $_POST['idterm']);
        $this->db->set('kreditmaxbayar', $_POST['kreditmaxbayar']);
        $this->db->set('idtemplatepajak', $_POST['idtemplatepajak']);
        $this->db->set('totalproduk', RemoveComma($_POST['totalproduk']));
        $this->db->set('totalpemesanan', RemoveComma($_POST['totalpemesanan']));
        $this->db->set('totaldiskonpemesanan', RemoveComma($_POST['totaldiskonpemesanan']));
        $this->db->set('totaldiskonbonus', RemoveComma($_POST['totaldiskonbonus']));
        $this->db->set('totalcashback', RemoveComma($_POST['totalcashback']));
        $this->db->set('totalakhir', RemoveComma($_POST['totalakhir']));

        $this->db->where('id', $_POST['id']);
        if($this->db->update('tpembelian01_pemesanan')){
          $idpemesanan = $_POST['id'];

          // TERM KREDIT
          $this->db->where('idpemesanan', $idpemesanan);
          if ($this->db->delete('tpembelian01_pemesanan_kredit')) {
            if ($_POST['idterm'] == '2') {
                $arrDiskon = explode(',', $_POST['kreditdiskon']);
                $arrHari   = explode(',', $_POST['kredithari']);

                foreach ($arrDiskon as $index => $diskon) {
                    $dataKredit = array();
                    $dataKredit['idpemesanan']   = $idpemesanan;
                    $dataKredit['kreditdiskon']  = $diskon;
                    $dataKredit['kredithari']    = $arrHari[$index];

                    $this->db->insert('tpembelian01_pemesanan_kredit', $dataKredit);
                }
            }
          }

          // PROCESS GROUPING
          $produkList = json_decode($_POST['produkvalue']);
          $produkGroup = array_reduce($produkList, function ($object, $row) {
            if(isset($object[$row[2].$row[10]])){
              $object[$row[2].$row[10]][6]   += RemoveComma($row[6]);
              $object[$row[2].$row[10]][7]   += RemoveComma($row[7]);
              $object[$row[2].$row[10]][8]   += RemoveComma($row[8]);
              $object[$row[2].$row[10]][9]   += RemoveComma($row[9]);
            }else{
              $object[$row[2].$row[10]][2]   = $row[2];
              $object[$row[2].$row[10]][4]   = RemoveComma($row[4]);
              $object[$row[2].$row[10]][6]   = RemoveComma($row[6]);
              $object[$row[2].$row[10]][7]   = RemoveComma($row[7]);
              $object[$row[2].$row[10]][8]   = RemoveComma($row[8]);
              $object[$row[2].$row[10]][9]   = RemoveComma($row[9]);
              $object[$row[2].$row[10]][10]  = $row[10];
            }

            return $object;
          });

          // PROCESS GROUPING
          $produkList = json_decode($_POST['produkvalue']);
          $produkGroup = array_reduce($produkList, function ($object, $row) {
            if(isset($object[$row[2].$row[10]])){
              $object[$row[2].$row[10]][6]   += RemoveComma($row[6]);
              $object[$row[2].$row[10]][7]   += RemoveComma($row[7]);
              $object[$row[2].$row[10]][8]   += RemoveComma($row[8]);
              $object[$row[2].$row[10]][9]   += RemoveComma($row[9]);
            }else{
              $object[$row[2].$row[10]][2]   = $row[2];
              $object[$row[2].$row[10]][4]   = RemoveComma($row[4]);
              $object[$row[2].$row[10]][6]   = RemoveComma($row[6]);
              $object[$row[2].$row[10]][7]   = RemoveComma($row[7]);
              $object[$row[2].$row[10]][8]   = RemoveComma($row[8]);
              $object[$row[2].$row[10]][9]   = RemoveComma($row[9]);
              $object[$row[2].$row[10]][10]  = $row[10];
            }

            return $object;
          });

          // DETAIL PRODUK
          $this->db->where('idpemesanan', $idpemesanan);
          if ($this->db->delete('tpembelian01_pemesanan_detail')) {
            foreach ($produkGroup as $row) {
              $dataDetail = array();
              $dataDetail['idpemesanan']          = $idpemesanan;
              $dataDetail['idrekanan']            = $_POST['idrekanan'];
              $dataDetail['idprodukkemasan']      = $row[2];
              $dataDetail['harga']                = RemoveComma($row[4]);
              $dataDetail['kuantitas']            = RemoveComma($row[6]);
              $dataDetail['total']                = RemoveComma($row[7]);
              $dataDetail['diskon']               = RemoveComma($row[8]);
              $dataDetail['cashback']             = RemoveComma($row[9]);
              $dataDetail['stbonus']              = $row[10];
              $this->db->insert('tpembelian01_pemesanan_detail', $dataDetail);
            }
          }
        }

        return true;
    }

    public function split()
    {
        $arrayNoPemesanan = array();
        $arrayIdPemesanan = array();
        for ($i=1; $i <= 2; $i++) {
          // $this->nopemesanan          = 'AUTO_GENERATE';
          $this->tanggal              = $_POST['tanggal'];
          $this->idrekanan            = $_POST['idrekanan'];
          $this->idterm               = $_POST['idterm'];
          $this->kreditmaxbayar       = $_POST['kreditmaxbayar'];
          $this->idtemplatepajak      = $_POST['idtemplatepajak'];
          $this->totalproduk          = RemoveComma($_POST['totalproduk'.$i]);
          $this->totalpemesanan       = RemoveComma($_POST['totalpemesanan'.$i]);
          $this->totaldiskonpemesanan = RemoveComma($_POST['totaldiskonpemesanan'.$i]);
          $this->totaldiskonbonus     = RemoveComma($_POST['totaldiskonbonus'.$i]);
          $this->totalcashback        = RemoveComma($_POST['totalcashback'.$i]);
          $this->totalakhir           = RemoveComma($_POST['totalakhir'.$i]);
          $this->iduserinput          = $this->session->userdata('userid');

          $this->catatanpergantian   = 'Transaksi ini adalah hasil dari Proses Split, dengan Referensi No. Pemesanan : '.$_POST['nopemesanan'];
          $this->transaksipergantian = $_POST['idpemesanan'];

          if($this->db->insert('tpembelian01_pemesanan', $this)){
            $idpemesanan = $this->db->insert_id();

            // TERM KREDIT
            if ($_POST['idterm'] == '2') {
              $this->db->where('tpembelian01_pemesanan_kredit.idpemesanan', $_POST['idpemesanan']);
              $query = $this->db->get('tpembelian01_pemesanan_kredit');

              foreach ($query->result() as $row) {
                $dataKredit = array();
                $dataKredit['idpemesanan']   = $idpemesanan;
                $dataKredit['kreditdiskon']  = $row->kreditdiskon;
                $dataKredit['kredithari']    = $row->kredithari;

                $this->db->insert('tpembelian01_pemesanan_kredit', $dataKredit);
              }
            }

            // PROCESS GROUPING
            $produkList = json_decode($_POST['produkvalue']);
            $produkGroup = array_reduce($produkList, function ($object, $row) {
              if(isset($object[$row[2].$row[10]])){
                $object[$row[2].$row[10]][6]   += RemoveComma($row[6]);
                $object[$row[2].$row[10]][7]   += RemoveComma($row[7]);
                $object[$row[2].$row[10]][8]   += RemoveComma($row[8]);
                $object[$row[2].$row[10]][9]   += RemoveComma($row[9]);
              }else{
                $object[$row[2].$row[10]][2]   = $row[2];
                $object[$row[2].$row[10]][4]   = RemoveComma($row[4]);
                $object[$row[2].$row[10]][6]   = RemoveComma($row[6]);
                $object[$row[2].$row[10]][7]   = RemoveComma($row[7]);
                $object[$row[2].$row[10]][8]   = RemoveComma($row[8]);
                $object[$row[2].$row[10]][9]   = RemoveComma($row[9]);
                $object[$row[2].$row[10]][10]  = $row[10];
              }

              return $object;
            });

            // DETAIL PRODUK
            foreach ($produkGroup as $row) {
              $dataDetail = array();
              $dataDetail['idpemesanan']          = $idpemesanan;
              $dataDetail['idrekanan']            = $_POST['idrekanan'];
              $dataDetail['idprodukkemasan']      = $row[2];
              $dataDetail['harga']                = RemoveComma($row[4]);
              $dataDetail['kuantitas']            = RemoveComma($row[6]);
              $dataDetail['total']                = RemoveComma($row[7]);
              $dataDetail['diskon']               = RemoveComma($row[8]);
              $dataDetail['cashback']             = RemoveComma($row[9]);
              $dataDetail['stbonus']              = $row[10];
              $this->db->insert('tpembelian01_pemesanan_detail', $dataDetail);
            }
          }

          $arrayIdPemesanan[] = $idpemesanan;
          $arrayNoPemesanan[] = $this->nopemesanan;
        }

        $idpemesananImplode = implode(',', $arrayIdPemesanan);
        $nopemesananImplode = implode(', ', $arrayNoPemesanan);

        $this->db->set('catatanpergantian', 'Transaksi ini telah dilakukan Proses Split, dan dialihkan menjadi No. Pemesanan : '.$nopemesananImplode);
        $this->db->set('transaksipergantian', $idpemesananImplode);
        $this->db->set('tanggalpergantian', $_POST['tanggal']);
        $this->db->set('status', 3);

        $this->db->where('id', $_POST['idpemesanan']);
        $this->db->update('tpembelian01_pemesanan');

        return true;
    }

    public function approve($id)
    {
        $this->stapprove = 1;

        if ($this->db->update('tpembelian01_pemesanan', $this, array('id' => $id))) {
            return true;
        }else{
            $this->error_message = 'Penyimpanan Gagal';

            return false;
        }
    }

    public function delete()
    {
        $this->tanggalpergantian = date("Y-m-d");
        $this->catatanpergantian = $_POST['catatanpergantian'];
        $this->status = 0;

        if ($this->db->update('tpembelian01_pemesanan', $this, array('id' => $_POST['idtransaksi']))) {
            return true;
        } else {
            $this->error_message = 'Penyimpanan Gagal';

            return false;
        }
    }

    // JQuery Process
    public function getSatuanProduk($idprodukkemasan)
    {
        $this->db->select("mproduk_kemasan_satuan.*,
        msatuan.nama AS namasatuan");
        $this->db->join('msatuan', 'msatuan.id = mproduk_kemasan_satuan.idsatuan');
        $this->db->where('mproduk_kemasan_satuan.idprodukkemasan', $idprodukkemasan);
        $this->db->order_by('mproduk_kemasan_satuan.posisi', 'DESC');
        $query = $this->db->get('mproduk_kemasan_satuan');

        return $query->result();
    }

    public function getPemesananDraft2($idpemesanan, $idrekanan, $idtemplatepajak, $idterm)
    {
        $this->db->select('tpembelian01_pemesanan.*');
        $this->db->join('tpembelian02_penerimaan_pusat', 'tpembelian02_penerimaan_pusat.idpemesanan = tpembelian01_pemesanan.id','LEFT');
        $this->db->where('tpembelian01_pemesanan.id !=', $idpemesanan);
        $this->db->where('tpembelian01_pemesanan.idrekanan', $idrekanan);
        $this->db->where('tpembelian01_pemesanan.idtemplatepajak', $idtemplatepajak);
        $this->db->where('tpembelian01_pemesanan.idterm', $idterm);
        $this->db->where('tpembelian01_pemesanan.status', 1);
        $this->db->where('tpembelian02_penerimaan_pusat.id', NULL);
        $query = $this->db->get('tpembelian01_pemesanan');

        return $query->result();
    }

    public function getInfoTransaksi($data)
    {
        $array = explode(',', $data);

        $this->db->where_in('id', $array);
        $query = $this->db->get('tpembelian01_pemesanan');

        return $query->result();
    }
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
