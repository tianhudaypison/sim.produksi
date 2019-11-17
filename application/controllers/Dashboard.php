<?php

class Dashboard extends CI_Controller
{
    protected $pagePath;
    protected $breadcrum;

    public function __construct()
    {
        parent::__construct();
        PermissionLogin($this->session);
        $this->pagePath = 'Dashboard/';
        $this->breadcrum = array(
          array('Dashboard', '#'),
        );
    }

    public function index()
    {
        $data = array();
        $data['title'] = 'Dashboard';
        $data['template'] = $this->pagePath.'index';
        $data['loader'] = array(
          'path' => base_url().$this->pagePath,
          'stylesheet' => $this->pagePath.'Loader/stylesheet',
          'javascript' => $this->pagePath.'Loader/javascript',
        );
        $data['breadcrum'] = $this->breadcrum;

        $data = array_merge($data, pathHelper());
        $this->parser->parse('template', $data);
    }
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
