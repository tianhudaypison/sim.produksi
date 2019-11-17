<?php

class Pengembalian extends CI_Controller
{
    protected $pagePath;
    protected $breadcrum;

    public function __construct()
    {
        parent::__construct();
        PermissionLogin($this->session);
        $this->pagePath = 'Pembelian/Pengembalian/';
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<text>', '</text>');
        $this->breadcrum = array(
          array('Pembelian', '#'),
          array('Pengembalian', $this->pagePath),
        );

        // CallModel
        $this->load->model('Pembelian/PengembalianModel', 'model');
    }

    public function index()
    {
        $data = array();
        $data['title'] = 'Pengembalian';
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

    public function create($id)
    {
      if ($id != '') {
          $row = $this->model->getSpecifiedEntries($id);
          if (isset($row->id)) {
              $data = array(
                'id'              => $row->id,
                'nopenerimaan'    => $row->nopenerimaan,
                'tanggal'         => $row->tanggal,
                'nomutasi'        => $row->nomutasi,
                'idgudang'        => $row->idgudang,
                'namagudang'      => $row->namagudang,
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

              $data['listProduk'] = $this->model->getListProdukPenerimaan($id);

              $data = array_merge($data, pathHelper());
              $this->parser->parse('template', $data);
          }
      }
    }

    public function edit($id)
    {
        if ($id != '') {
            $row = $this->model->getSpecifiedEntries($id);
            if (isset($row->id)) {
                $data = array(
                  'id'              => $row->id,
                  'nopenerimaan'    => $row->nopenerimaan,
                  'nomutasi'        => $row->nomutasi,
                  'namagudang'      => $row->namagudang,
                  'idpenerimaan'    => $row->idpenerimaan,
                  'tanggal'         => $row->tanggal,
                  'totalproduk'     => $row->totalproduk,
                  'status'          => $row->status,
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

                $data['listProduk'] = $this->model->getListProdukPenerimaan($id);

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
                  'nomutasi'        => $row->nomutasi,
                  'nopenerimaan'    => $row->nopenerimaan,
                  'namagudang'      => $row->namagudang,
                  'tanggal'         => $row->tanggal,
                  'totalproduk'     => number_format($row->totalproduk),
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

                $data['listProduk'] = $this->model->getListProduk($id);

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

    public function approve($id)
    {
        if ($this->model->approve($id)) {
            $this->session->set_flashdata('confirm', true);
            $this->session->set_flashdata('message_flash', 'data telah diapprove.');
            redirect($this->pagePath);
        }
    }
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
