<div class="row">
    <div class="col-12">
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title">
              {title}
              <div class="float-right mb-2">
                  <a href="<?= $loader['path'] ?>create" class="btn btn-sm btn-danger waves-light waves-effect"><i class="fa fa-plus"></i> Tambah</a>
              </div>
            </h4>
            <div class="clearfix"></div>

            <div class="row">
              <table id="key-table" class="tablesaw tablesaw-stack m-t-20 table m-b-0" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                  <thead>
                    <tr>
                        <th width="10%">No</th>
                        <th width="10%">No. Pemesanan</th>
                        <th width="10%">Tanggal</th>
                        <th width="20%">Rekanan</th>
                        <th width="10%">Total Pemesanan</th>
                        <th width="10%">Term</th>
                        <th width="20%">Status</th>
                        <th width="10%"></th>
                    </tr>
                  </thead>

                  <tbody>
                    <? foreach ($listIndex as $index => $row): ?>
                      <?
                        // Checker Status Proses
                        $this->db->where('tpembelian02_penerimaan_pusat.idpemesanan', $row->id);
                        $query = $this->db->get('tpembelian02_penerimaan_pusat');

                        if($query->num_rows() > 0) {
                          $statusProses = 1;
                        }else{
                          $statusProses = 0;
                        }
                      ?>

                      <?
                        // Checker Status Pemesanan & Penerimaan
                        $this->db->select('COALESCE(tpembelian01_pemesanan.totalproduk, 0) AS totalpemesanan,
                        SUM(COALESCE(tpembelian02_penerimaan_pusat.totalproduk, 0)) AS totalpenerimaan');

                        $this->db->join('tpembelian02_penerimaan_pusat', 'tpembelian02_penerimaan_pusat.idpemesanan = tpembelian01_pemesanan.id', 'LEFT');
                        $this->db->where('tpembelian01_pemesanan.id', $row->id);
                        $this->db->group_by('tpembelian02_penerimaan_pusat.idpemesanan');
                        $query = $this->db->get('tpembelian01_pemesanan');

                        $rowCheck1 = $query->row();
                      ?>

                      <?
                        // Checker Status Penerimaan & Mutasi
                        $this->db->select('SUM(COALESCE(tpembelian02_penerimaan_pusat.totalproduk, 0)) AS totalpenerimaan,
                        SUM(COALESCE(tpembelian03_mutasi_pusat.totalproduk, 0)) AS totalmutasi');

                        $this->db->join('tpembelian03_mutasi_pusat', 'tpembelian03_mutasi_pusat.idpenerimaan = tpembelian02_penerimaan_pusat.id', 'LEFT');
                        // $this->db->where('tpembelian02_penerimaan_pusat.id', $row->id);
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
                        // $this->db->where('tpembelian03_mutasi_pusat.id', $row->id);
                        // $this->db->group_by('tpembelian04_penerimaan_gudang.idmutasi');
                        $query = $this->db->get('tpembelian03_mutasi_pusat');

                        $rowCheck3 = $query->row();
                      ?>

                      <?php $statusBranch = (($rowCheck1->totalpemesanan == $rowCheck1->totalpenerimaan) && ($rowCheck1->totalpenerimaan == (isset($rowCheck2->totalmutasi) ? $rowCheck2->totalmutasi : 0)) && ((isset($rowCheck2->totalmutasi) ? $rowCheck2->totalmutasi : 0) == (isset($rowCheck3->totalpenerimaanmutasi) ? $rowCheck3->totalpenerimaanmutasi : 0)) ? 1 : 0) ?>

                      <tr class="<?= ($row->status != 1 ? 'bg-closed' : ($statusProses == 1 ? 'bg-finish' : '')) ?>">
                          <td><?= $index+1 ?></td>
                          <td><?= $row->nopemesanan ?></td>
                          <td><?= HumanDate($row->tanggal) ?></td>
                          <td><?= $row->namarekanan ?></td>
                          <td><?= number_format($row->totalpemesanan) ?></td>
                          <td><?= StatusTerm($row->idterm) ?></td>
                          <td>
                            <div class="btn-group mb-2">
                              <a href="<?= $loader['path'] ?>branch/<?= $row->id ?>" class="btn btn-custom"><i class="fa fa-code-fork"></i> Branch Link</a>
                              <a href="#modalInfo" class="btn btn-primary infoTransaksi" title="Informasi" data-notransaksi="<?= $row->nopemesanan ?>" data-refferensi="<?= $row->transaksipergantian ?>" data-catatan="<?= $row->catatanpergantian ?>" data-status="<?= $row->status ?>" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="fa fa-info-circle"></i></a>
                              <button type="button" class="btn <?= ($statusBranch == 1 ? 'btn-success' : 'btn-danger') ?>" data-toggle="tooltip" title="Status">
                                  <?= StatusBranchTransaksi($statusBranch); ?>
                              </button>
                            </div>
                          </td>
                          <td>
                            <? if($row->status == 1): ?>
                              <div class="btn-group mb-2">
                                <a href="<?= $loader['path'] ?>edit/<?= $row->id ?>" class="btn btn-custom"><i class="fa fa-edit"></i> Ubah</a>
                                <button type="button" class="btn btn-custom dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu">
                                    <? if($statusProses == 0): ?>
                                    <a href="<?= $loader['path'] ?>merge/<?= $row->id ?>" class="dropdown-item"><i class="fa fa-code-fork"></i> Merge</a>
                                    <a href="<?= $loader['path'] ?>split/<?= $row->id ?>" class="dropdown-item"><i class="fa fa-cut"></i> Split</a>
                                    <div class="dropdown-divider"></div>
                                    <? endif; ?>
                                    <a href="<?= $loader['path'] ?>view/<?= $row->id ?>" class="dropdown-item"><i class="fa fa-list-alt"></i> Rincian</a>
                                    <a href="<?= $loader['path'] ?>invoice/<?= $row->id ?>" class="dropdown-item"><i class="fa fa-print"></i> Faktur</a>

                                    <? if($statusProses == 0): ?>
                                    <div class="dropdown-divider"></div>
                                    <a href="#modalDelete" class="dropdown-item hapusTransaksi" data-idtransaksi="<?= $row->id ?>" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="fa fa-trash"></i> Hapus</a>
                                    <? endif; ?>
                                </div>
                              </div>
          									<? elseif($row->status == 0): ?>
          										<a class="btn btn-danger w-100" href="javascript: void(0);" data-toggle="tooltip" title="Tanggal Hapus : <?= HumanDate($row->tanggalpergantian) ?>">Transaksi di Hapus</a>
          									<? elseif($row->status == 2): ?>
          										<a class="btn btn-danger w-100" href="javascript: void(0);" data-toggle="tooltip" title="Tanggal Merge : <?= HumanDate($row->tanggalpergantian) ?>">Transaksi di Merge</a>
          									<? elseif($row->status == 3): ?>
          										<a class="btn btn-danger w-100" href="javascript: void(0);" data-toggle="tooltip" title="Tanggal Split : <?= HumanDate($row->tanggalpergantian) ?>">Transaksi di Split</a>
          									<? endif; ?>
                          </td>
                      </tr>
                    <? endforeach; ?>
                  </tbody>
              </table>
            </div>
        </div>
    </div>
</div> <!-- end row -->


<!-- Modal Info -->
<div id="modalInfo" class="modal-demo">
    <div class="custom-modal-text">
        <form class="form-horizontal" action="#">
    			<div class="mb-0" id="infoContent"></div>
        </form>
    </div>
</div>

<!-- Modal Delete -->
<div id="modalDelete" class="modal-demo">
    <div class="custom-modal-text">
        <form class="form-horizontal" action="{base_url}Pembelian/Pemesanan/delete" method="POST">
          <div class="form-group m-b-25">
              <div class="col-12">
                <label for="alasanHapus">Alasan Hapus</label>
									<textarea class="form-control" name="catatanpergantian" placeholder="Alasan Hapus"></textarea>
              </div>
          </div>

					<input type="hidden" id="idTransaksi" name="idtransaksi" value="">

          <div class="form-group account-btn text-center m-t-10">
              <div class="col-12">
                  <button type="submit" class="btn w-lg btn-rounded btn-danger waves-effect waves-light">Hapus Transaksi</button>
              </div>
          </div>
        </form>
    </div>
</div>
