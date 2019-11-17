<div class="row">
  <div class="col-12">
    <form id="form" class="form-horizontal" action="<?= $loader['path'] ?>save" method="POST" role="form">
      <div class="card-box">
          <div class="row">
              <div class="col-12">
                  <div class="p-20">
                      <div class="form-group row">
                          <label class="col-md-2 col-xs-3 col-form-label">Tanggal</label>
                          <div class="col-md-10 col-xs-9">
                            <div class="input-group">
                               <input type="text" id="tanggal" class="form-control datepicker-autoclose" placeholder="yyyy-mm-dd" name="tanggal" value="{tanggal}">
                               <div class="input-group-append">
                                   <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                               </div>
                             </div>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-md-2 col-xs-3 col-form-label">No. Penerimaan Pusat</label>
                          <div class="col-md-10 col-xs-9">
                            <select id="idPenerimaan" class="form-control select2" name="idpenerimaan">
                              <option value="0" selected disabled>Pilih Opsi</option>
                              <?php foreach ($listPenerimaan as $row) { ?>
                                <option value="<?= $row->id ?>" <?=($row->id == $idpenerimaan ? 'selected' : '') ?>><?= $row->nopenerimaan; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <!-- end row -->

          <input type="hidden" id="number">
          <input type="hidden" id="rowindex">
          <input type="hidden" id="totalPengiriman" name="totalpengiriman" value="{totalpengiriman}">
          <input type="hidden" id="pengirimanValue" name="pengirimanvalue">
      </div>

      <div class="card-box formProduk p-1">
        <div class="row">
          <div class="col-12">
            <div style="overflow-x: scroll;">
            <table id="pengirimanList" class="tablesaw m-t-20 table m-b-0 tablesaw-stack table-transaction" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                  <tr>
                      <th class="col-w15">
                        <input type="text" id="keterangan" class="form-control detail" placeholder="Keterangan">
                      </th>
                      <th class="col-w15">
                        <input type="text" id="noresi" class="form-control detail" placeholder="No. Resi">
                      </th>
                      <th class="col-w15">
                        <input type="text" id="biaya" class="form-control number detail" placeholder="Biaya"></th>
                      </th>
                      <th class="col-w15">
                        <a id="pengirimanAdd" class="btn btn-custom waves-effect waves-light">Tambah</a>
                      </th>
                  </tr>
                  <tr>
                      <th>Keterangan</th>
                      <th>No. Resi</th>
                      <th>Biaya</th>
                      <th></th>
                  </tr>
                </thead>

                <tbody>
                  <? if($this->uri->segment(3) == 'edit'): ?>
                    <? foreach ($listDetailPengiriman as $index => $row): ?>
                      <tr>
                        <td hidden><?= ($index+1) ?></td>
                        <td><?= $row->keterangan ?></td>
                        <td><?= $row->noresi ?></td>
                        <td><?= number_format($row->biaya) ?></td>
                        <td>
                          <div class="btn-group mb-2">
                            <button type="button" class="btn btn-outline-primary waves-effect pengirimanEdit"><i class="fa fa-pencil"></i> Ubah</button>
                            <button type="button" class="btn btn-outline-danger waves-effect pengirimanRemove"><i class="fa fa-trash-o"></i> Hapus</button>
                          </div>
                        </td>
                    <? endforeach; ?>
                  <? endif; ?>
                </tbody>
            </table>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group row mb-0">
        <div class="col-12">
          <button type="submit" class="btn btn-success waves-effect waves-light">Simpan</button>
          <a href="<?= $loader['path'] ?>" class="btn btn-danger waves-effect waves-light">Batal</a>
        </div>
      </div>
    </form>
  </div>
</div>
