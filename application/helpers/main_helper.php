<?php
function Breadcrum($data)
{
    $result = array();
    foreach ($data as $row) {
        if ($row[1] == '#') {
            $url = '<li><a href="#">'.$row[0].'</a></li>';
        } elseif ($row[1] == '') {
            $url = '<li class="active">'.$row[0].'</li>';
        } else {
            $url = '<li><a href="'.site_url($row[1]).'">'.$row[0].'</a></li>';
        }
        array_push($result, $url);
    }
    return implode("", $result);
}

function HumanDate($date)
{
    $date = date("j F Y", strtotime($date));
    return $date;
}

function HumanDateShort($date)
{
    $date = date("d-m-Y", strtotime($date));
    return $date;
}

function HumanDateMid($date)
{
    $date = date("j M Y", strtotime($date));
    return $date;
}

function HumanDateTime($date)
{
    $date = date("d-m-Y h:i:s ", strtotime($date));
    return $date;
}

function MonthYearDate($date)
{
    $date = date("F Y", strtotime($date));
    return $date;
}

function YearDate($date)
{
    $date = date("Y", strtotime($date));
    return $date;
}

function HomeDate()
{
    $date = date("l, j F Y");
    return $date;
}

function SitemapDate($date)
{
    $date = date("Y-m-d", strtotime($date));
    $time = date("h:i:s+07:00", strtotime($date));
    return $date."T".$time;
}

function MonthDate($date)
{
    switch ($date) {
    case 1: $date="Januari";
        break;
    case 2: $date="Februari";
        break;
    case 3: $date="Maret";
        break;
    case 4: $date="April";
        break;
    case 5: $date="Mei";
        break;
    case 6: $date="Juni";
        break;
    case 7: $date="Juli";
        break;
    case 8: $date="Agustus";
        break;
    case 9: $date="September";
        break;
    case 10: $date="Oktober";
        break;
    case 11: $date="November";
        break;
    case 12: $date="Desember";
        break;
    }
    return $date;
}

function LastLoginDate($date)
{
    if ($date != '' && $date != '0000-00-00 00:00:00') {
        $date = date("j F Y h:i:s", strtotime($date));
    } else {
        $date = 'First Login';
    }
    return $date;
}

function PermissionLogin($session)
{
    if (!$session->userdata('logged_in')) {
        $session->set_flashdata('error', true);
        $session->set_flashdata('message_flash', 'Access Denied');
        redirect('login');
    }
}

function PermissionLoggedIn($session)
{
    if ($session->userdata('logged_in')) {
        $session->set_flashdata('error', true);
        $session->set_flashdata('message_flash', 'Access Denied');
        redirect('dashboard');
    }
}

function Notify($session)
{
    if ($session->flashdata('error')) {
        return NotifyError($session->flashdata('message_flash'));
    } elseif ($session->flashdata('confirm')) {
        return NotifySuccess($session->flashdata('message_flash'));
    } else {
        return '';
    }
}

function NotifyError($message)
{
    return '<div class="alert alert-custom alert-dismissible bg-danger text-white border-0 fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    <strong>Maaf,</strong> '.$message.'</div>';
}

function NotifySuccess($message)
{
    return '<div class="alert alert-custom alert-dismissible bg-success text-white border-0 fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    <strong>Berhasil,</strong> '.$message.'</div>';
}

function RemoveComma($number, $delimiter = ",")
{
    return str_replace($delimiter, "", $number);
}

function IsMenuActive($menu)
{
    $CI =& get_instance();
    return ($CI->uri->segment(2) == $menu ? 'active':'');
}

function TreeView($level, $name)
{
    $indent = '';
    for ($i = 0; $i < $level; $i++) {
        if ($i > 0) {
            $indent .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        } else {
            $indent .= '';
        }
    }

    if ($i > 0) {
        $indent .= '└─';
    } else {
        $indent .= '';
    }

    return $indent.' '.$name;
}

function StatusGiroCek($id)
{
    if ($id !='') {
        $permission = array(
        "0" => '<span class="badge badge-warning">Progress</span>',
        "1" => '<span class="badge badge-success">Diterima</span>',
        "2" => '<span class="badge badge-danger">Ditolak</span>',
        );
        return $permission[$id];
    } else {
        return '';
    }
}

function StatusTerm($id)
{
    if ($id !='') {
        $permission = array(
        "1" => '<span class="badge badge-warning">CBD</span>',
        "2" => '<span class="badge badge-danger">KREDIT</span>',
        );
        return $permission[$id];
    } else {
        return '';
    }
}

function JenisProduk($id)
{
    if ($id !='') {
        $permission = array(
          1 => 'Obat',
          2 => 'Pupuk',
          3 => 'Benih',
        );
        return $permission[$id];
    } else {
        return '';
    }
}

function StatusBranchTransaksi($status)
{
    if ($status == 1) {
        return '<div class="badge badge-success"><i class="fa fa-check"></i></div>';
    } else {
        return '<div class="badge badge-danger"><i class="fa fa-times"></i></div>';
    }
}

function StatusDraft($id)
{
    if ($id !='') {
        $permission = array(
        "0" => '<span class="badge badge-warning">Belum Diproses</span>',
        "1" => '<span class="badge badge-success">Sudah Diproses</span>',
        );
        return $permission[$id];
    } else {
        return '';
    }
}

function StatusPembayaran($id)
{
    if ($id !='') {
        $permission = array(
        "0" => '<span class="badge badge-warning">Belum Lunas</span>',
        "1" => '<span class="badge badge-success">Lunas</span>',
        );
        return $permission[$id];
    } else {
        return '';
    }
}

function StatusKomplain($id)
{
    if ($id !='') {
        $permission = array(
        "1" => '<span class="badge badge-danger">On Progress</span>',
        "2" => '<span class="badge badge-warning">Proses Tindakan</span>',
        "3" => '<span class="badge badge-success">Selesai</span>',
        );
        return $permission[$id];
    } else {
        return '';
    }
}

function JenisPengirimanPembelian($id)
{
    if ($id !='') {
        $permission = array(
            "0" => "",
            "1" => "Ongkos dibayar rekanan",
            "2" => "Pengiriman pihak ke 3",
            "3" => "Pengambilan sendiri",
        );
        return $permission[$id];
    } else {
        return '';
    }
}

function GetKuantitasKonversi($idprodukkemasan, $kuantitas)
{
    $_this =& get_instance();
    $_this->db->select('mproduk_kemasan_satuan.*, msatuan.nama AS namasatuan');
    $_this->db->join('msatuan', 'msatuan.id = mproduk_kemasan_satuan.idsatuan');
    $_this->db->where('mproduk_kemasan_satuan.idprodukkemasan', $idprodukkemasan);
    $_this->db->order_by('mproduk_kemasan_satuan.posisi', 'ASC');
    $query = $_this->db->get('mproduk_kemasan_satuan');

    $label = "";
    foreach ($query->result() as $row) {
        if($kuantitas >= $row->jumlah){
            $kuantitasHasilBagi = floor($kuantitas / $row->jumlah);
            $kuantitas = $kuantitas - ($kuantitas - ($kuantitas % $row->jumlah));
        }else{
            if($kuantitas < 1){
                $kuantitasHasilBagi = floor($kuantitas);
            }else{
                $kuantitasHasilBagi = 0;
            }
        }

        if($kuantitasHasilBagi != 0){
        $label .= "$kuantitasHasilBagi $row->namasatuan<br>";
        }
    }

    if($label != ""){
        $label = $label;
    }else{
        $label = "-";
    }

    return $label;
}
