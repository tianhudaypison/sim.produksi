<?php

class Pemesanan extends CI_Controller
{
    protected $pagePath;
    protected $breadcrum;

    public function __construct()
    {
        parent::__construct();
        PermissionLogin($this->session);
        $this->pagePath = 'Pembelian/Pemesanan/';
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<text>', '</text>');
        $this->breadcrum = array(
          array('Pembelian', '#'),
          array('Pemesanan Produk', $this->pagePath),
        );

        // CallModel
        $this->load->model('Pembelian/PemesananModel', 'model');
    }

    public function index()
    {
        $data = array();
        $data['title'] = 'Pemesanan Produk';
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
          'nopemesanan' => 'AUTO_GENERATE',
          'tanggal' => date('Y-m-d'),
          'idrekanan' => '',
          'idterm' => '1',
          'kreditdiskon' => '',
          'kredithari' => '',
          'kreditmaxbayar' => '0',
          'idtemplatepajak' => '',
          'totalproduk' => '0',
          'totalpemesanan' => '0',
          'totaldiskonpemesanan' => '0',
          'totaldiskonbonus' => '0',
          'totalcashback' => '0',
          'totalakhir' => '0',
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
        $data['listTemplatePajak'] = $this->model->getTemplatePajak();
        $data['listProduk'] = $this->model->getProdukKemasan();
        $data['listDetailPemesanan'] = array();

        $data = array_merge($data, pathHelper());
        $this->parser->parse('template', $data);
    }

    public function edit($id)
    {
        if ($id != '') {
            $row = $this->model->getSpecifiedEntries($id);
            if (isset($row->id)) {
                $data = array(
                  'id' => $row->id,
                  'nopemesanan' => $row->nopemesanan,
                  'tanggal'  => $row->tanggal,
                  'idrekanan' => $row->idrekanan,
                  'idterm' => $row->idterm,
                  'kreditdiskon' => $row->kreditdiskon,
                  'kredithari' => $row->kredithari,
                  'kreditmaxbayar' => $row->kreditmaxbayar,
                  'idtemplatepajak' => $row->idtemplatepajak,
                  'totalproduk' => $row->totalproduk,
                  'totalpemesanan' => $row->totalpemesanan,
                  'totaldiskonpemesanan' => $row->totaldiskonpemesanan,
                  'totaldiskonbonus' => $row->totaldiskonbonus,
                  'totalcashback' => $row->totalcashback,
                  'totalakhir' => $row->totalakhir,
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
                $data['listTemplatePajak'] = $this->model->getTemplatePajak();
                $data['listProduk'] = $this->model->getProdukKemasan();
                $data['listDetailPemesanan'] = $this->model->getDetailPemesanan($id);

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
                  'id' => $row->id,
                  'nopemesanan' => $row->nopemesanan,
                  'tanggal'  => $row->tanggal,
                  'idrekanan' => $row->idrekanan,
                  'idterm' => $row->idterm,
                  'kreditdiskon' => $row->kreditdiskon,
                  'kredithari' => $row->kredithari,
                  'kreditmaxbayar' => $row->kreditmaxbayar,
                  'idtemplatepajak' => $row->idtemplatepajak,
                  'totalproduk' => $row->totalproduk,
                  'totalpemesanan' => $row->totalpemesanan,
                  'totaldiskonpemesanan' => $row->totaldiskonpemesanan,
                  'totaldiskonbonus' => $row->totaldiskonbonus,
                  'totalcashback' => $row->totalcashback,
                  'totalakhir' => $row->totalakhir,
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
                $data['listTemplatePajak'] = $this->model->getTemplatePajak();
                $data['listProduk'] = $this->model->getProdukKemasan();
                $data['listDetailPemesanan'] = $this->model->getDetailPemesanan($id);

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

    public function merge()
    {
        $data = array(
          'id'            => '',
          'tanggal'       => date("Y-m-d"),
          'idpemesanan1'  => '',
          'idpemesanan2'  => '',
        );
        $data['title'] = 'Merge Transaksi';
        $data['template'] = $this->pagePath.'merge';
        $data['loader'] = array(
          'path' => base_url().$this->pagePath,
          'stylesheet' => $this->pagePath.'Loader/merge_stylesheet',
          'javascript' => $this->pagePath.'Loader/merge_javascript',
        );
        $data['breadcrum'] = array_merge($this->breadcrum, array(
          array('Merge', ''),
        ));

        $data['listDraftPemesanan'] = $this->model->getPemesananDraft();

        $data = array_merge($data, pathHelper());
        $this->parser->parse('template', $data);
    }

    public function split()
    {
        $data = array(
          'id'            => '',
          'tanggal'       => date("Y-m-d"),
          'idpemesanan'   => '',
        );
        $data['title'] = 'Split Transaksi';
        $data['template'] = $this->pagePath.'split';
        $data['loader'] = array(
          'path' => base_url().$this->pagePath,
          'stylesheet' => $this->pagePath.'Loader/split_stylesheet',
          'javascript' => $this->pagePath.'Loader/split_javascript',
        );
        $data['breadcrum'] = array_merge($this->breadcrum, array(
          array('Split', ''),
        ));

        $data['listDraftPemesanan'] = $this->model->getPemesananDraft();

        $data = array_merge($data, pathHelper());
        $this->parser->parse('template', $data);
    }

    public function branch($id)
    {
        if ($id != '') {
            $row = $this->model->getSpecifiedEntries($id);
            if (isset($row->id)) {
                $data = array(
                  'id' => $row->id,
                  'nopemesanan' => $row->nopemesanan,
                );

                $data['error'] = '';
                $data['title'] = 'Branch Link';
                $data['template'] = $this->pagePath.'branch';
                $data['loader'] = array(
                  'path' => base_url().$this->pagePath,
                  'stylesheet' => $this->pagePath.'Loader/index_stylesheet',
                  'javascript' => $this->pagePath.'Loader/index_javascript',
                );
                $data['breadcrum'] = array_merge($this->breadcrum, array(
                  array('Branch Link', ''),
                ));

                $data['listDetailPemesanan'] = $this->model->getDetailPemesanan($id);

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
        $data['listTemplatePajak'] = $this->model->getTemplatePajak();
        $data['listProduk'] = $this->model->getProdukKemasan();
        $data['listDetailPemesanan'] = array();

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

    public function approve($id)
    {
        $this->model->approve($id);
        $this->session->set_flashdata('confirm', true);
        $this->session->set_flashdata('message_flash', 'data telah di approve.');
        redirect($this->pagePath, 'location');
    }

    public function splitProcess()
    {
        $this->model->split();
        $this->session->set_flashdata('confirm', true);
        $this->session->set_flashdata('message_flash', 'data telah di approve.');
        redirect($this->pagePath, 'location');
    }

    // JQuery Process
    public function getSatuanProduk($idprodukkemasan, $selected=0)
    {
      $data = $this->model->getSatuanProduk($idprodukkemasan);
      $content = '';
      foreach ($data as $row) {
        $content .= '<option value="'.$row->idsatuan.'" '.($selected == $row->idsatuan ? "selected" : "" ).' data-kuantitaskonversi="'.$row->jumlah.'">'.$row->namasatuan.'</option>';
      }
      $this->output->set_output($content);
    }

    public function getPemesananDraft2()
    {
      $idPemesanan = $this->input->post('idpemesanan');
      $idRekanan = $this->input->post('idrekanan');
      $idTemplatePajak = $this->input->post('idtemplatepajak');
      $idTerm = $this->input->post('idterm');

      $data = $this->model->getPemesananDraft2($idPemesanan, $idRekanan, $idTemplatePajak, $idTerm);
      $content = '<option value="#">Pilih Opsi</option>';
      foreach ($data as $row) {
        $content .= '<option value="'.$row->id.'">'.$row->nopemesanan.'</option>';
      }
      $this->output->set_output($content);
    }

    public function getDetailPemesanan($idpemesanan, $split=0)
    {
      $content = '';
      if ($idpemesanan):
        $data = $this->model->getDetailPemesanan(urldecode($idpemesanan));
        foreach ($data as $index => $row):
          $content .= '<tr>';
          $content .= '  <td hidden>'.($index+1).'</td>';
          $content .= '  <td colspan="2">';
          $content .= '    <div class="card text-white bg-product">';
          $content .= '      <div class="card-body">';
          $content .= '        <blockquote class="card-bodyquote text-dark mb-0">';
          $content .= '          <div class="product-name"><strong><i class="fi-box"></i> '.$row->namaproduk.'</strong> <i>('.$row->namaperusahaan.')</i></div>';
          $content .= '          <footer class="blockquote-footer text-dark small">Kemasan : '.$row->namakemasan.'</footer>';
          $content .= '          <hr class="mt-1 mb-1">';
          $content .= '          <footer class="blockquote-footer text-dark small">Status : '.($row->stbonus == 1 ? 'Bonus' : 'Non Bonus').'</footer>';

          if($row->stbonus == 1):
          $content .= '            <footer class="blockquote-footer text-dark small">Cashback : '.$row->cashback.'</footer>';
          $content .= '            <footer class="blockquote-footer text-dark small">Discount : '.$row->discount.'%</footer>';
          endif;

          $content .= '        </blockquote>';
          $content .= '      </div>';
          $content .= '    </div>';
          $content .= '  </td>';
          $content .= '  <td hidden>'.$row->idprodukkemasan.'</td>';
          $content .= '  <td hidden>idsatuan</td>';
          $content .= '  <td>'.number_format($row->harga).'</td>';

          if($split):
          $content .= '  <td hidden>'.number_format($row->kuantitas).'</td>';
          $content .= '  <td><input type="text" class="form-control kuantitasProduk number" value="'.number_format($row->kuantitas).'"></td>';
          else:
          $content .= '  <td>'.number_format($row->kuantitas).'</td>';
          $content .= '  <td hidden>'.number_format($row->kuantitas).'</td>';
          endif;

          $content .= '  <td>'.number_format($row->total).'</td>';
          $content .= '  <td hidden>'.number_format($row->diskon).'</td>';
          $content .= '  <td hidden>'.number_format($row->cashback).'</td>';
          $content .= '  <td hidden>'.$row->stbonus.'</td>';

          if($split):
  		    $content .= '  <td><a href="javascript: void(0);" class="btn btn-outline-primary produkSplit"><i class="fa fa-cut"></i> Split</a></td>';
      		endif;
        endforeach;
      else:
        $content = '';
      endif;

      $this->output->set_output($content);
    }

    public function getInfoTransaksi()
    {
      $notransaksi = $this->input->post('notransaksi');
      $refferensi = $this->input->post('refferensi');
      $catatan = $this->input->post('catatan');
      $status = $this->input->post('status');

      $content = '';
      $data = $this->model->getInfoTransaksi($refferensi);

      if($status != 0){
        if(count($data)){
          $content .= '<div class="alert alert-custom alert-dismissible bg-custom text-white border-0 fade show" role="alert">'.$catatan.'</div>';
          $content .= '<div class="row text-center"><div class="col-12"><div class="row">';
          foreach ($data as $row) {
            $content .= '<a href="view/'.$row->id.'" class="col-sm-6 col-xl-6">
            <div class="card-box widget-flat border-danger bg-danger text-white mb-0">
            <i class="dripicons-document"></i>
            <h3 class="m-b-10"></h3>
            <p class="text-uppercase m-b-5 font-13 font-600">'.$row->nopemesanan.'</p>
            </div>
            </a>';
          }
          $content .= '</div</div></div>';
        }else{
          $content .= '<div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" role="alert">
              Tidak Ada Proses Merge / Split Untuk Transaksi <strong>'.$notransaksi.'</strong> !
          </div>';
        }
      }else{
        $content .= '<div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" role="alert">
            Transaksi ini telah dihapus dengan alasan <strong>'.$catatan.'</strong> !
        </div>';
      }
      $this->output->set_output($content);
    }
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
