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
                        <th width="20%">Nama</th>
                        <th width="30%">Keterangan</th>
                        <th width="20%">Harga</th>
                        <th width="20%">Satuan</th>
                        <th width="10%"></th>
                    </tr>
                  </thead>

                  <tbody>
                    <? foreach ($listIndex as $index => $row): ?>
                      <tr>
                          <td><?= $index+1 ?></td>
                          <td><?= $row->nama ?></td>
                          <td><?= $row->keterangan ?></td>
                          <td><?= $row->harga ?></td>
                          <td><?= $row->satuan ?></td>
                          <td>
                            <div class="btn-group mb-2">
                              <a href="<?= $loader['path'] ?>edit/<?= $row->id ?>" class="btn btn-custom"><i class="fa fa-edit"></i> Ubah</a>
                              <button type="button" class="btn btn-custom dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <span class="sr-only">Toggle Dropdown</span>
                              </button>
                              <div class="dropdown-menu">
                                  <a href="<?= $loader['path'] ?>view/<?= $row->id ?>" class="dropdown-item" href="#"><i class="fa fa-list-alt"></i> Rincian</a>
                                  <div class="dropdown-divider"></div>
                                  <a href="<?= $loader['path'] ?>delete/<?= $row->id ?>" class="dropdown-item" href="#"><i class="fa fa-trash"></i> Hapus</a>
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
