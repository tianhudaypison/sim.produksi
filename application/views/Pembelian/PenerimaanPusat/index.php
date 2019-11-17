<div class="row">
    <div class="col-12">
        <? $this->load->view('Component/NavPemesananPusat') ?>
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
                        <th width="10%">No. Penerimaan</th>
                        <th width="10%">Tanggal</th>
                        <th width="15%">Rekanan</th>
                        <th width="15%">Total Produk</th>
                        <th width="20%">No. Pemesanan</th>
                        <th width="10%"></th>
                    </tr>
                  </thead>

                  <tbody>
                    <? foreach ($listIndex as $index => $row): ?>
                      <tr>
                          <td><?= $index+1 ?></td>
                          <td><?= $row->nopenerimaan ?></td>
                          <td><?= HumanDate($row->tanggal) ?></td>
                          <td><?= $row->namarekanan ?></td>
                          <td><?= number_format($row->totalproduk) ?></td>
                          <td><span class="badge badge-primary"><?= $row->nopemesanan ?></span></td>
                          <td>
                            <div class="btn-group mb-2">
                              <a href="<?= $loader['path'] ?>edit/<?= $row->id ?>" class="btn btn-custom"><i class="fa fa-edit"></i> Ubah</a>
                              <button type="button" class="btn btn-custom dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <span class="sr-only">Toggle Dropdown</span>
                              </button>
                              <div class="dropdown-menu">
                                  <a href="<?= $loader['path'] ?>direct/<?= $row->id ?>" class="dropdown-item"><i class="fa fa-link"></i> Direct Link</a>
                                  <div class="dropdown-divider"></div>
                                  <a href="<?= $loader['path'] ?>view/<?= $row->id ?>" class="dropdown-item"><i class="fa fa-list-alt"></i> Rincian</a>
                                  <a href="<?= $loader['path'] ?>invoice/<?= $row->id ?>" class="dropdown-item"><i class="fa fa-print"></i> Faktur</a>
                                  <div class="dropdown-divider"></div>
                                  <a href="#modalDelete" class="dropdown-item hapusTransaksi" data-idtransaksi="<?= $row->id ?>" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="fa fa-trash"></i> Hapus</a>
                              </div>
                            </div>
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
