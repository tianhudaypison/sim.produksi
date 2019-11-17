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
                        <th width="20%">No. Pengiriman</th>
                        <th width="20%">No. Penerimaan Pusat</th>
                        <th width="10%">Tanggal</th>
                        <th width="15%">Total Biaya</th>
                        <th width="15%">Status Pembayaran</th>
                        <th width="10%"></th>
                    </tr>
                  </thead>

                  <tbody>
                    <? foreach ($listIndex as $index => $row): ?>
                      <tr>
                          <td><?= $index+1 ?></td>
                          <td><?= $row->nopengiriman ?></td>
                          <td><?= $row->nopenerimaan ?></td>
                          <td><?= HumanDate($row->tanggal) ?></td>
                          <td><?= number_format($row->totalpengiriman) ?></td>
                          <td><?= StatusPembayaran($row->stpembayaran) ?></td>
                          <td>
                            <div class="btn-group mb-2">
                              <a href="<?= $loader['path'] ?>edit/<?= $row->id ?>" class="btn btn-custom"><i class="fa fa-edit"></i> Ubah</a>
                              <button type="button" class="btn btn-custom dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <span class="sr-only">Toggle Dropdown</span>
                              </button>
                              <div class="dropdown-menu">
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
