<a href="<?= $loader['path'] ?>" class="btn btn-outline-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
<hr>
<div class="card-box table-responsive">
  <div class="row mt-2">
      <?
        // Checker Status Pemesanan & Penerimaan
        $this->db->select('COALESCE(tpembelian01_pemesanan.totalproduk, 0) AS totalpemesanan,
        SUM(COALESCE(tpembelian02_penerimaan_pusat.totalproduk, 0)) AS totalpenerimaan');

        $this->db->join('tpembelian02_penerimaan_pusat', 'tpembelian02_penerimaan_pusat.idpemesanan = tpembelian01_pemesanan.id', 'LEFT');
        $this->db->where('tpembelian01_pemesanan.id', $id);
        $this->db->group_by('tpembelian02_penerimaan_pusat.idpemesanan');
        $query = $this->db->get('tpembelian01_pemesanan');

        $rowCheck1 = $query->row();
      ?>

      <?
        // Checker Status Penerimaan & Mutasi
        $this->db->select('SUM(COALESCE(tpembelian02_penerimaan_pusat.totalproduk, 0)) AS totalpenerimaan,
        SUM(COALESCE(tpembelian03_mutasi_pusat.totalproduk, 0)) AS totalmutasi');

        $this->db->join('tpembelian03_mutasi_pusat', 'tpembelian03_mutasi_pusat.idpenerimaan = tpembelian02_penerimaan_pusat.id', 'LEFT');
        // $this->db->where('tpembelian02_penerimaan_pusat.id', $id);
        // $this->db->group_by('tpembelian03_mutasi_pusat.idpenerimaan');
        $query = $this->db->get('tpembelian02_penerimaan_pusat');

        $rowCheck2 = $query->row();
      ?>

      <?
        // Checker Status Mutasi & Penerimaan Mutasi
        $this->db->select('SUM(COALESCE(tpembelian03_mutasi_pusat.totalproduk, 0)) AS totalmutasi,
        SUM(COALESCE(tpembelian04_penerimaan_gudang.totalproduk, 0)) AS totalpenerimaanmutasi');

        $this->db->join('tpembelian04_penerimaan_gudang', 'tpembelian04_penerimaan_gudang.idmutasi = tpembelian03_mutasi_pusat.id', 'LEFT');
        $this->db->where('tpembelian04_penerimaan_gudang.stapprove', 1);
        // $this->db->where('tpembelian03_mutasi_pusat.id', $id);
        // $this->db->group_by('tpembelian04_penerimaan_gudang.idmutasi');
        $query = $this->db->get('tpembelian03_mutasi_pusat');

        $rowCheck3 = $query->row();
      ?>

      <? $statusBranch1 = (($rowCheck1->totalpemesanan == $rowCheck1->totalpenerimaan) && ($rowCheck1->totalpenerimaan == (isset($rowCheck2->totalmutasi) ? $rowCheck2->totalmutasi : 0)) && ((isset($rowCheck2->totalmutasi) ? $rowCheck2->totalmutasi : 0) == (isset($rowCheck3->totalpenerimaanmutasi) ? $rowCheck3->totalpenerimaanmutasi : 0)) ? 1 : 0) ?>
      <? $statusBranch2 = (($rowCheck1->totalpenerimaan == (isset($rowCheck2->totalmutasi) ? $rowCheck2->totalmutasi : 0)) && ((isset($rowCheck2->totalmutasi) ? $rowCheck2->totalmutasi : 0) == (isset($rowCheck3->totalpenerimaanmutasi) ? $rowCheck3->totalpenerimaanmutasi : 0)) ? 1 : 0) ?>
      <? $statusBranch3 = (((isset($rowCheck2->totalmutasi) ? $rowCheck2->totalmutasi : 0) == (isset($rowCheck3->totalpenerimaanmutasi) ? $rowCheck3->totalpenerimaanmutasi : 0)) ? 1 : 0) ?>


      <ul class="tree">
        <div class="badge badge-primary">PEMESANAN PUSAT </div>&nbsp;<div class="badge badge-primary">{nopemesanan}</div> <?=StatusBranchTransaksi($statusBranch1)?>
        <ul>
        <? foreach ($listDetailPemesanan as $row): ?>
          <li>
            <div class="card text-white branch">
              <div class="card-body">
                <blockquote class="card-bodyquote text-dark">
                  <div class="product-name"><strong><i class="fi-box"></i> <?=($row->stbonus == 1 ? '[BONUS]':'')?> <?= $row->namaproduk ?></strong> <i>(<?= $row->namaperusahaan ?>)</i></div>
                  <footer class="blockquote-footer text-dark font-13">Kemasan : <?= $row->namakemasan ?></footer>

                  <hr class="mt-1 mb-1">
                  <footer class="text-dark small"><strong>Kuantitas Pemesanan</strong></footer>
                  <footer class="text-dark small"><?= GetKuantitasKonversi($row->idprodukkemasan, $row->kuantitas) ?></footer>
                </blockquote>
              </div>
            </div>

            <?
              $this->db->select('tpembelian02_penerimaan_pusat_detail.*,
              tpembelian02_penerimaan_pusat.nopenerimaan,
              mproduk.nama AS namaproduk,
              mperusahaan.nama AS namaperusahaan,
              mproduk_kemasan.nama AS namakemasan');

              $this->db->join('mproduk_kemasan', 'mproduk_kemasan.id = tpembelian02_penerimaan_pusat_detail.idprodukkemasan');
              $this->db->join('mproduk', 'mproduk.id = mproduk_kemasan.idproduk');
              $this->db->join('mperusahaan', 'mperusahaan.id = mproduk.idperusahaan');
              $this->db->join('tpembelian02_penerimaan_pusat', 'tpembelian02_penerimaan_pusat.id = tpembelian02_penerimaan_pusat_detail.idpenerimaan');
              $this->db->join('tpembelian01_pemesanan', 'tpembelian01_pemesanan.id = tpembelian02_penerimaan_pusat.idpemesanan');
              $this->db->where('tpembelian01_pemesanan.id', $row->idpemesanan);
              $this->db->where('tpembelian02_penerimaan_pusat_detail.idprodukkemasan', $row->idprodukkemasan);
              $this->db->where('tpembelian02_penerimaan_pusat_detail.stbonus', $row->stbonus);
              $query = $this->db->get('tpembelian02_penerimaan_pusat_detail');

              $listDetailPenerimaan = $query->result();
            ?>
            <ul>
            <? foreach ($listDetailPenerimaan as $xrow): ?>
              <li>
                <div class="badge badge-primary">PENERIMAAN PUSAT</div>&nbsp;<div class="badge badge-primary"><?=$xrow->nopenerimaan?></div> <?=StatusBranchTransaksi($statusBranch2)?>
                <ul>
                  <li>
                    <div class="card text-white branch">
                      <div class="card-body">
                        <blockquote class="card-bodyquote text-dark">
                          <div class="product-name"><strong><i class="fi-box"></i> <?=($xrow->stbonus == 1 ? '[BONUS]':'')?> <?= $xrow->namaproduk ?></strong> <i>(<?= $xrow->namaperusahaan ?>)</i></div>
                          <footer class="blockquote-footer text-dark font-13">Kemasan : <?= $xrow->namakemasan ?></footer>

                          <hr class="mt-1 mb-1">
                          <footer class="text-dark small"><strong>Kuantitas Penerimaan</strong></footer>
                          <footer class="text-dark small"><?= GetKuantitasKonversi($xrow->idprodukkemasan, $xrow->kuantitas) ?></footer>
                        </blockquote>
                      </div>
                    </div>

                    <?
                      $this->db->select('tpembelian03_mutasi_pusat_detail.*,
                      tpembelian03_mutasi_pusat.nomutasi,
                      mproduk.nama AS namaproduk,
                      mperusahaan.nama AS namaperusahaan,
                      mproduk_kemasan.nama AS namakemasan,
                      mgudang.nama AS namagudang');

                      $this->db->join('mproduk_kemasan', 'mproduk_kemasan.id = tpembelian03_mutasi_pusat_detail.idprodukkemasan');
                      $this->db->join('mproduk', 'mproduk.id = mproduk_kemasan.idproduk');
                      $this->db->join('mperusahaan', 'mperusahaan.id = mproduk.idperusahaan');
                      $this->db->join('tpembelian03_mutasi_pusat', 'tpembelian03_mutasi_pusat.id = tpembelian03_mutasi_pusat_detail.idmutasi');
                      $this->db->join('mgudang', 'mgudang.id = tpembelian03_mutasi_pusat.idgudang');
                      $this->db->join('tpembelian02_penerimaan_pusat', 'tpembelian02_penerimaan_pusat.id = tpembelian03_mutasi_pusat.idpenerimaan');
                      $this->db->where('tpembelian02_penerimaan_pusat.id', $xrow->idpenerimaan);
                      $this->db->where('tpembelian03_mutasi_pusat_detail.idprodukkemasan', $xrow->idprodukkemasan);
                      $this->db->where('tpembelian03_mutasi_pusat_detail.stbonus', $xrow->stbonus);
                      $query = $this->db->get('tpembelian03_mutasi_pusat_detail');

                      $listDetailMutasi = $query->result();
                    ?>
                    <ul>
                    <? foreach ($listDetailMutasi as $yrow): ?>
                      <li>
                        <div class="badge badge-primary">MUTASI KE GUDANG <?= strtoupper($yrow->namagudang) ?></div>&nbsp;<div class="badge badge-primary"><?= $yrow->nomutasi ?></div> <?=StatusBranchTransaksi($statusBranch3)?>
                        <ul>
                          <li>
                            <div class="card text-white branch">
                              <div class="card-body">
                                <blockquote class="card-bodyquote text-dark">
                                  <div class="product-name"><strong><i class="fi-box"></i> <?=($yrow->stbonus == 1 ? '[BONUS]':'')?> <?= $yrow->namaproduk ?></strong> <i>(<?= $yrow->namaperusahaan ?>)</i></div>
                                  <footer class="blockquote-footer text-dark font-13">Kemasan : <?= $yrow->namakemasan ?></footer>

                                  <hr class="mt-1 mb-1">
                                  <footer class="text-dark small"><strong>Kuantitas Mutasi</strong></footer>
                                  <footer class="text-dark small"><?= GetKuantitasKonversi($yrow->idprodukkemasan, $yrow->kuantitas) ?></footer>
                                </blockquote>
                              </div>
                            </div>

                            <?
                              $this->db->select('tpembelian04_penerimaan_gudang_detail.*,
                              tpembelian04_penerimaan_gudang.nopenerimaan,
                              mproduk.nama AS namaproduk,
                              mperusahaan.nama AS namaperusahaan,
                              mproduk_kemasan.nama AS namakemasan,
                              tpembelian04_penerimaan_gudang.stapprove');

                              $this->db->join('mproduk_kemasan', 'mproduk_kemasan.id = tpembelian04_penerimaan_gudang_detail.idprodukkemasan');
                              $this->db->join('mproduk', 'mproduk.id = mproduk_kemasan.idproduk');
                              $this->db->join('mperusahaan', 'mperusahaan.id = mproduk.idperusahaan');
                              $this->db->join('tpembelian04_penerimaan_gudang', 'tpembelian04_penerimaan_gudang.id = tpembelian04_penerimaan_gudang_detail.idpenerimaan');
                              $this->db->join('tpembelian03_mutasi_pusat', 'tpembelian03_mutasi_pusat.id = tpembelian04_penerimaan_gudang_detail.idpenerimaan');
                              $this->db->where('tpembelian03_mutasi_pusat.id', $yrow->idmutasi);
                              $this->db->where('tpembelian04_penerimaan_gudang_detail.idprodukkemasan', $yrow->idprodukkemasan);
                              $this->db->where('tpembelian04_penerimaan_gudang_detail.stbonus', $yrow->stbonus);
                              $query = $this->db->get('tpembelian04_penerimaan_gudang_detail');

                              $listDetailPenerimaanMutasi = $query->result();
                            ?>
                            <ul>
                            <? foreach ($listDetailPenerimaanMutasi as $zrow): ?>
                              <li>
                                <div class="badge badge-primary">PENERIMAAN MUTASI GUDANG</div>&nbsp;<div class="badge badge-primary"><?= $zrow->nopenerimaan ?></div> <?=StatusBranchTransaksi($zrow->stapprove == 1 ? 1 : $statusBranch3)?>
                                <ul>
                                  <li>
                                    <div class="card text-white branch">
                                      <div class="card-body">
                                        <blockquote class="card-bodyquote text-dark">
                                          <div class="product-name"><strong><i class="fi-box"></i> <?=($zrow->stbonus == 1 ? '[BONUS]':'')?> <?= $zrow->namaproduk ?></strong> <i>(<?= $zrow->namaperusahaan ?>)</i></div>
                                          <footer class="blockquote-footer text-dark font-13">Kemasan : <?= $zrow->namakemasan ?></footer>

                                          <hr class="mt-1 mb-1">
                                          <footer class="text-dark small"><strong>Kuantitas Pemesanan</strong></footer>
                                          <footer class="text-dark small"><?= GetKuantitasKonversi($zrow->idprodukkemasan, $zrow->kuantitas) ?></footer>
                                        </blockquote>
                                      </div>
                                    </div>
                                  </li>
                                </ul>
                              </li>
                            <? endforeach; ?>
                          </ul>
                        </li>
                      </ul>
                    </li>
                  <? endforeach; ?>
                  </ul>

                </li>
              </ul>
            </li>
          <? endforeach; ?>
          </ul>
        </li>
      <? endforeach; ?>
      </ul>
    </ul>
  </div>
</div>
