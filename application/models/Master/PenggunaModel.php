<?php

class PenggunaModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getMarketing()
    {
        $this->db->order_by('nama', 'ASC');
        $query = $this->db->get('mpegawai');

        return $query->result();
    }

    public function getHakAkses()
    {
        $this->db->order_by('nama', 'ASC');
        $query = $this->db->get('motorisasi');

        return $query->result();
    }

    public function getAllEntries()
    {
        $this->db->select('mpengguna.*, mpegawai.nama, motorisasi.nama AS hakakses');
        $this->db->join('mpegawai', 'mpegawai.id = mpengguna.idpegawai');
        $this->db->join('motorisasi', 'motorisasi.id = mpengguna.idhakakses');
        $this->db->order_by('mpegawai.nama', 'ASC');
        $query = $this->db->get('mpengguna');

        return $query->result();
    }

    public function getSpecifiedEntries($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('mpengguna');

        return $query->row();
    }

    public function insert()
    {
        $this->idpegawai    = $_POST['idpegawai'];
        $this->username     = $_POST['username'];
        $this->idhakakses   = $_POST['idhakakses'];

        ($_POST['password'] != '') ? $this->password = md5($_POST['password']) : $this->password = md5('12345');

        if ($this->db->insert('mpengguna', $this)) {
            return true;
        } else {
            $this->error_message = 'Penyimpanan Gagal';

            return false;
        }
    }

    public function update()
    {
        $this->idpegawai    = $_POST['idpegawai'];
        $this->username     = $_POST['username'];
        $this->idhakakses   = $_POST['idhakakses'];

        if ($_POST['password'] != '') {
            $this->password = md5($_POST['password']);
        }

        if ($this->db->update('mpengguna', $this, array('id' => $_POST['id']))) {
            return true;
        } else {
            $this->error_message = 'Penyimpanan Gagal';

            return false;
        }
    }

    public function remove($id)
    {
        $this->status = 0;

        if ($this->db->update('mpengguna', $this, array('id' => $id))) {
            return true;
        } else {
            $this->error_message = 'Penyimpanan Gagal';

            return false;
        }
    }

    public function login()
    {
        $this->db->where('username', $_POST['username']);
        $this->db->where('password', md5($_POST['password']));
        $this->db->join('mpegawai', 'mpegawai.id = mpengguna.idpegawai');
        $this->db->join('motorisasi', 'motorisasi.id = mpengguna.idhakakses');
        $query = $this->db->get('mpengguna');

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $arrayLoggedIn = array(
               'userid' => $row->id,
               'usersname' => $row->nama,
               'userllogin' => $row->terakhirlogin,
               'userrole' => $row->nama,
               'logged_in' => true,
            );

            $this->session->set_userdata($arrayLoggedIn);
            $this->setLastLogin();
            return true;
        } else {
            return false;
        }
    }

    public function logout()
    {
        $arrayLoggedIn = array(
           'userid' => $this->session->userdata('userid'),
           'username' => $this->session->userdata('username'),
           'userllogin' => $this->session->userdata('userllogin'),
           'userrole' => $this->session->userdata('userrole'),
           'logged_in' => $this->session->userdata('logged_in'),
        );

        $this->session->unset_userdata($arrayLoggedIn);
        $this->session->sess_destroy();
    }

    public function setLastLogin()
    {
        $this->db->update('mpengguna', array('terakhirlogin' => date('Y-m-d h:i:s')), array('id' => $this->session->userdata('userid')));
    }
}
