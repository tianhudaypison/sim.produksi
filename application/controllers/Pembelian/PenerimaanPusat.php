<?php

class PenerimaanPusat extends CI_Controller
{
    protected $pagePath;
    protected $breadcrum;

    public function __construct()
    {
        parent::__construct();
        PermissionLogin($this->session);
        $this->pagePath = 'Pembelian/PenerimaanPusat/';
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<text>', '</text>');
        $this->breadcrum = array(
          array('Pembelian', '#'),
          array('Penerimaan Pusat', $this->pagePath),
        );

        // CallModel
        $this->load->model('Pembelian/PenerimaanPusatModel', 'model');
    }

    public function index()
    {
        $data = array();
        $data['title'] = 'Penerimaan Pusat';
        $data['template'] = $this->pagePath.'index';
        $data['loader'] = array(
          'path' => base_url().$this->pagePath,
          'stylesheet' => $this->pagePath.'Loader/index_stylesheet',
          'javascript' => $this->pagePath.'Loader/index_javascript',
        );
        $data['breadcrum'] = array_merge($this->breadcrum, array(
          array('Index', ''),
        ));

        // GetModel
        $data['listIndex'] = $this->model->getAllEntries();

        $data = array_merge($data, pathHelper());
        $this->parser->parse('template', $data);
    }

    public function create()
    {
        $data = array(
          'id' => '',
          'nopenerimaan' => 'AUTO_GENERATE',
          'nopemesanan' => '',
          'nodo' => '',
          'idrekanan' => '',
          'tanggal' => date('Y-m-d'),
          'idpemesanan' => '',
          'totalproduk' => '',
        );
        $data['title'] = 'Tambah Transaksi';
        $data['template'] = $this->pagePath.'manage';
        $data['loader'] = array(
          'path' => base_url().$this->pagePath,
          'stylesheet' => $this->pagePath.'Loader/manage_stylesheet',
          'javascript' => $this->pagePath.'Loader/manage_javascript',
        );
        $data['breadcrum'] = array_merge($this->breadcrum, array(
          array('Tambah', ''),
        ));

        $data['listRekanan'] = $this->model->getRekanan();
        $data['listPemesanan'] = $this->model->getPemesanan();
        $data['listProduk'] = $this->model->getProdukKemasan();
        $data['listDetailPenerimaanPusat'] = array();

        $data = array_merge($data, pathHelper());
        $this->parser->parse('template', $data);
    }

    public function edit($id)
    {
        if ($id != '') {
            $row = $this->model->getSpecifiedEntries($id);
            if (isset($row->id)) {
                $data = array(
                  'id'              => $row->id,
                  'nopenerimaan'    => $row->nopenerimaan,
                  'nopemesanan'     => $row->nopemesanan,
                  'nodo'            => $row->nodo,
                  'idrekanan'       => $row->idrekanan,
                  'idpemesanan'     => $row->idpemesanan,
                  'tanggal'         => $row->tanggal,
                  'totalproduk'     => $row->totalproduk,
                );

                $data['error'] = '';
                $data['title'] = 'Ubah Data';
                $data['template'] = $this->pagePath.'manage';
                $data['loader'] = array(
                  'path' => base_url().$this->pagePath,
                  'stylesheet' => $this->pagePath.'Loader/manage_stylesheet',
                  'javascript' => $this->pagePath.'Loader/manage_javascript',
                );
                $data['breadcrum'] = array_merge($this->breadcrum, array(
                  array('Ubah', ''),
                ));

                $data['listRekanan'] = $this->model->getRekanan();
                $data['listPemesanan'] = $this->model->getPemesananSelected($row->idpemesanan);
                $data['listDetailPenerimaanPusat'] = $this->model->getDetailPenerimaanPusat();

                $data = array_merge($data, pathHelper());
                $this->parser->parse('template', $data);
            } else {
                $this->session->set_flashdata('error', true);
                $this->session->set_flashdata('message_flash', 'data tidak ditemukan.');
                redirect($this->pagePath, 'location');
            }
        } else {
            $this->session->set_flashdata('error', true);
            $this->session->set_flashdata('message_flash', 'data tidak ditemukan.');
            redirect($this->pagePath);
        }
    }

    public function view($id)
    {
        if ($id != '') {
            $row = $this->model->getSpecifiedEntries($id);
            if (isset($row->id)) {
                $data = array(
                  'id'              => $row->id,
                  'nopenerimaan'    => $row->nopenerimaan,
                  'nopemesanan'     => $row->nopemesanan,
                  'nodo'            => $row->nodo,
                  'idrekanan'       => $row->idrekanan,
                  'idpemesanan'     => $row->idpemesanan,
                  'tanggal'         => $row->tanggal,
                  'totalproduk'     => $row->totalproduk,
                );

                $data['error'] = '';
                $data['title'] = 'Rincian Data';
                $data['template'] = $this->pagePath.'view';
                $data['loader'] = array(
                  'path' => base_url().$this->pagePath,
                  'stylesheet' => $this->pagePath.'Loader/manage_stylesheet',
                  'javascript' => $this->pagePath.'Loader/manage_javascript',
                );
                $data['breadcrum'] = array_merge($this->breadcrum, array(
                  array('Rincian', ''),
                ));

                $data['listRekanan'] = $this->model->getRekanan();
                $data['listPemesanan'] = $this->model->getPemesananSelected($row->idpemesanan);
                $data['listDetailPenerimaanPusat'] = $this->model->getDetailPenerimaanPusat();

                $data = array_merge($data, pathHelper());
                $this->parser->parse('template', $data);
            } else {
                $this->session->set_flashdata('error', true);
                $this->session->set_flashdata('message_flash', 'data tidak ditemukan.');
                redirect($this->pagePath, 'location');
            }
        } else {
            $this->session->set_flashdata('error', true);
            $this->session->set_flashdata('message_flash', 'data tidak ditemukan.');
            redirect($this->pagePath);
        }
    }

    public function direct($id)
    {
        if ($id != '') {
            $row = $this->model->getSpecifiedEntries($id);
            if (isset($row->id)) {
                $data = array(
                  'id'              => $row->id,
                  'nopenerimaan'    => $row->nopenerimaan,
                  'nopemesanan'     => $row->nopemesanan,
                  'nodo'            => $row->nodo,
                  'idrekanan'       => $row->idrekanan,
                  'idpemesanan'     => $row->idpemesanan,
                  'tanggal'         => $row->tanggal,
                  'totalproduk'     => $row->totalproduk,
                );

                $data['error'] = '';
                $data['title'] = 'Direct Link (Mutasi Gudang)';
                $data['template'] = $this->pagePath.'direct';
                $data['loader'] = array(
                  'path' => base_url().$this->pagePath,
                  'stylesheet' => $this->pagePath.'Loader/direct_stylesheet',
                  'javascript' => $this->pagePath.'Loader/direct_javascript',
                );
                $data['breadcrum'] = array_merge($this->breadcrum, array(
                  array('Direct Link', ''),
                ));

                $data['listRekanan'] = $this->model->getRekanan();
                $data['listProduk'] = $this->model->getProdukDirect($id);
                $data['listGudang'] = $this->model->getGudang();

                $data = array_merge($data, pathHelper());
                $this->parser->parse('template', $data);
            } else {
                $this->session->set_flashdata('error', true);
                $this->session->set_flashdata('message_flash', 'data tidak ditemukan.');
                redirect($this->pagePath, 'location');
            }
        } else {
            $this->session->set_flashdata('error', true);
            $this->session->set_flashdata('message_flash', 'data tidak ditemukan.');
            redirect($this->pagePath);
        }
    }

    public function invoice()
    {
    }

    public function save()
    {
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required|min_length[1]');
        if ($this->form_validation->run() == true) {
            if ($this->input->post('id') == '') {
                if ($this->model->insert()) {
                    $this->session->set_flashdata('confirm', true);
                    $this->session->set_flashdata('message_flash', 'data telah disimpan.');
                    redirect($this->pagePath, 'location');
                }
            } else {
                if ($this->model->update()) {
                    $this->session->set_flashdata('confirm', true);
                    $this->session->set_flashdata('message_flash', 'data telah disimpan.');
                    redirect($this->pagePath, 'location');
                }
            }
        } else {
            $this->failedSave($this->input->post('id'));
        }
    }

    public function saveDirect()
    {
        if ($this->model->insertDirect()) {
            $this->session->set_flashdata('confirm', true);
            $this->session->set_flashdata('message_flash', 'data telah disimpan.');
            redirect($this->pagePath, 'location');
        }
    }

    public function failedSave($id)
    {
        $data = $this->input->post();
        $data['error'] = validation_errors();
        $data['template'] = $this->pagePath.'manage';
        $data['loader'] = array(
          'path' => base_url().$this->pagePath,
          'stylesheet' => $this->pagePath.'Loader/manage_stylesheet',
          'javascript' => $this->pagePath.'Loader/manage_javascript',
        );

        $data['listRekanan'] = $this->model->getRekanan();
        $data['listPemesanan'] = $this->model->getPemesananSelected($row->idpemesanan);
        $data['listDetailPenerimaanPusat'] = array();

        if ($id == '') {
            $data['title'] = 'Tambah Data';
            $data['breadcrum'] = array_merge($this->breadcrum, array(
              array('Tambah', ''),
            ));
        } else {
            $data['title'] = 'Ubah Data';
            $data['breadcrum'] = array_merge($this->breadcrum, array(
              array('Ubah', ''),
            ));
        }

        $data = array_merge($data, pathHelper());
        $this->parser->parse('template', $data);
    }

    public function delete()
    {
        $this->model->delete();
        $this->session->set_flashdata('confirm', true);
        $this->session->set_flashdata('message_flash', 'data telah terhapus.');
        redirect($this->pagePath, 'location');
    }

    // JQuery Process
    public function getDetailPemesanan($idpemesanan)
    {
      $content = '';
      if ($idpemesanan):
        $data = $this->model->getDetailPemesanan(urldecode($idpemesanan));
        foreach ($data as $index => $row):
          $content .= '<tr>';
          $content .= '  <td hidden>'.($index+1).'</td>';
          $content .= '  <td>';
          $content .= '    <div class="card text-white bg-product">';
          $content .= '      <div class="card-body">';
          $content .= '        <blockquote class="card-bodyquote text-dark mb-0">';
          $content .= '          <div class="product-name"><strong><i class="fi-box"></i> '.$row->namaproduk.'</strong> <i>('.$row->namaperusahaan.')</i></div>';
          $content .= '          <footer class="blockquote-footer text-dark small">Kemasan : '.$row->namakemasan.'</footer>';
          $content .= '          <hr class="mt-1 mb-1">';
          $content .= '          <footer class="blockquote-footer text-dark small">Status : '.($row->stbonus == 1 ? 'Bonus' : 'Non Bonus').'</footer>';

          if($row->stbonus == 0):
          $content .= '            <footer class="blockquote-footer text-dark small">Cashback : '.$row->cashback.'</footer>';
          $content .= '            <footer class="blockquote-footer text-dark small">Discount : '.$row->diskon.'%</footer>';
          endif;

          $kuantitassisa = ($row->kuantitas - $row->kuantitasditerima);

          $content .= '          <hr class="mt-1 mb-1">';
          $content .= '          <footer class="text-dark small"><strong>Kuantitas Pemesanan</strong></footer>';
          $content .= '          <footer class="text-dark small">'.GetKuantitasKonversi($row->idprodukkemasan, $row->kuantitas).'</footer>';
          $content .= '        </blockquote>';
          $content .= '      </div>';
          $content .= '    </div>';
          $content .= '  </td>';
          $content .= '  <td hidden>'.$row->idprodukkemasan.'</td>';
          $content .= '  <td>'.GetKuantitasKonversi($row->idprodukkemasan, $row->kuantitasditerima).'</td>';
          $content .= '  <td>'.GetKuantitasKonversi($row->idprodukkemasan, $kuantitassisa).'</td>';
          $content .= '  <td><a href="javascript: void(0);" class="btn btn-outline-primary waves-effect produkEdit" data-idprodukkemasan="'.$row->idprodukkemasan.'" data-kuantitasmax="'.$row->kuantitas.'" data-stbonus="'.$row->stbonus.'" data-toggle="modal" data-target="#modalDetailPerProduct"><i class="fa fa-pencil"></i> Ubah</a></td>';
        endforeach;
      else:
        $content = '';
      endif;

      $this->output->set_output($content);
    }

    public function getInfoTempProduk($idprodukkemasan)
    {
        $arr = $this->model->getInfoTempProduk($idprodukkemasan);
        $this->output->set_output(json_encode($arr));
    }

    public function getNoPemesananByRekanan()
    {
        $idRekanan = $this->input->post('idrekanan');

        $data = $this->model->getNoPemesananByRekanan($idRekanan);
        if($data){
          $content = '<option value="#">Pilih Opsi</option>';
          foreach ($data as $row) {
            $content .= '<option value="'.$row->id.'">'.$row->nopemesanan.'</option>';
          }
        }

        $this->output->set_output($content);
    }

    public function getNoPemesananByProduk()
    {
        $idrekanan = $this->input->post('idrekanan');
        $idprodukkemasan = $this->input->post('idprodukkemasan');

        $content = '<div class="row text-center scrolling-wrapper-flexbox">';
        $data = $this->model->getNoPemesananByProduk($idrekanan, $idprodukkemasan);
        if($data){
          foreach ($data as $row) {
            $content .= '<a href="#" class="col-sm-6 col-xl-3 selectNoPemesanan" data-idpemesanan="'.$row->id.'" data-dismiss="modal">
              <div class="card-box widget-flat border-custom bg-custom text-white mb-0">
                <i class="dripicons-document"></i>
                <h3 class="m-b-10"></h3>
                <p class="text-uppercase m-b-5 font-13 font-600">'.$row->nopemesanan.'</p>
              </div>
            </a>';
          }
        }
        $content .= '</div>';

        $this->output->set_output($content);
    }
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
