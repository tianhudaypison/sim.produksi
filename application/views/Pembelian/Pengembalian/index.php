<div class="row">
    <div class="col-12">
        <? $this->load->view('Component/NavPemesananPusat') ?>
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title">
              {title}
            </h4>
            <div class="clearfix"></div>

            <div class="row">
              <table id="key-table" class="tablesaw tablesaw-stack m-t-20 table m-b-0" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                  <thead>
                    <tr>
                        <th width="10%">No</th>
                        <th width="10%">No. Penerimaan</th>
                        <th width="10%">No. Mutasi</th>
                        <th width="10%">Tanggal</th>
                        <th width="15%">Gudang</th>
                        <th width="15%">Total Produk</th>
                        <th width="10%"></th>
                    </tr>
                  </thead>

                  <tbody>
                    <? foreach ($listIndex as $index => $row): ?>
                      <tr>
                          <td><?= $index+1 ?></td>
                          <td><?= $row->nopenerimaan ?></td>
                          <td><?= $row->nomutasi ?></td>
                          <td><?= HumanDate($row->tanggal) ?></td>
                          <td><?= $row->namagudang ?></td>
                          <td><?= number_format($row->totalproduk) ?></td>
                          <td>
                            <div class="btn-group mb-2">
            									<? if($row->nopenerimaan == '-'){ ?>
                                <a href="<?= $loader['path'] ?>create/<?= $row->id ?>" class="btn btn-custom"><i class="fa fa-edit"></i> Penerimaan</a>
                              <? }else{ ?>
            										<?php if($row->stapprove == '0'){ ?>
                                  <a href="<?= $loader['path'] ?>approve/<?= $row->id ?>" class="btn btn-custom"><i class="fa fa-check"></i> Approve</a>
                                <? } ?>
                              <? } ?>
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
