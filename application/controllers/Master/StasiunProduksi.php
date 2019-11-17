<?php

class StasiunProduksi extends CI_Controller
{
    protected $pagePath;
    protected $breadcrum;

    public function __construct()
    {
        parent::__construct();
        PermissionLogin($this->session);
        $this->pagePath = 'Master/StasiunProduksi/';
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<text>', '</text>');
        $this->breadcrum = array(
          array('Master', '#'),
          array('Stasiun Produksi', $this->pagePath),
        );

        // CallModel
        $this->load->model('Master/StasiunProduksiModel', 'model');
    }

    public function index()
    {
        $data = array();
        $data['title'] = 'Stasiun Produksi';
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
          'nama' => '',
          'keterangan' => '',
          'totalkapasitas' => '',
        );

        $data['error'] = '';
        $data['title'] = 'Tambah Data';
        $data['template'] = $this->pagePath.'manage';
        $data['loader'] = array(
          'path' => base_url().$this->pagePath,
          'stylesheet' => $this->pagePath.'Loader/manage_stylesheet',
          'javascript' => $this->pagePath.'Loader/manage_javascript',
        );
        $data['breadcrum'] = array_merge($this->breadcrum, array(
          array('Tambah', ''),
        ));

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
                  'nama' => $row->nama,
                  'keterangan' => $row->keterangan,
                  'totalkapasitas' => $row->totalkapasitas,
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
                  'nama' => $row->nama,
                  'keterangan' => $row->keterangan,
                  'totalkapasitas' => $row->totalkapasitas,
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

    public function save()
    {
        $this->form_validation->set_rules('nama', 'Stasiun Produksi', 'trim|required|min_length[1]');
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

    public function delete($id)
    {
        $this->model->delete($id);
        $this->session->set_flashdata('confirm', true);
        $this->session->set_flashdata('message_flash', 'data telah terhapus.');
        redirect($this->pagePath, 'location');
    }
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
