<div class="row">
  <div class="col-12">
    <form id="form" class="form-horizontal" action="<?= $loader['path'] ?>save" method="POST" role="form">
      <div class="card-box">
          <div class="row">
              <div class="col-12">
                  <div class="p-20">
                      <div class="form-group row">
                          <label class="col-2 col-form-label">Tanggal</label>
                          <div class="col-10">
                            <div class="input-group">
                               <input type="text" id="tanggal" class="form-control datepicker-autoclose" placeholder="yyyy-mm-dd" name="tanggal" value="{tanggal}">
                               <div class="input-group-append">
                                   <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                               </div>
                             </div>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-2 col-form-label">No. Penerimaan</label>
                          <div class="col-10">
                            <input type="text" class="form-control" value="{nopenerimaan}" disabled>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-2 col-form-label">No. Mutasi</label>
                          <div class="col-10">
                            <input type="text" class="form-control" value="{nomutasi}" disabled>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-2 col-form-label">No. Mutasi</label>
                          <div class="col-10">
                            <input type="text" class="form-control" value="{namagudang}" disabled>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <!-- end row -->

          <input type="hidden" name="idmutasi" value="{id}">
          <input type="hidden" name="idgudang" value="{idgudang}">
          <input type="hidden" id="totalProduk" name="totalproduk" value="{totalproduk}">
          <input type="hidden" id="produkValue" name="produkvalue">
      </div>

      <div class="card-box formProduk p-1">
        <div class="row">
          <div class="col-12">
            <table id="produkList" class="tablesaw m-t-20 table m-b-0 tablesaw-stack" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                  <tr>
                      <th>Produk</th>
                      <th>Kuantitas Diterima</th>
                      <th>Kuantitas Penerimaan</th>
                      <th></th>
                  </tr>
                </thead>

                <tbody>
                  <? foreach ($listProduk as $index => $row): ?>
                  <tr>
                  <td hidden><?= ($index+1) ?></td>
                  <td>
                    <div class="card text-white bg-product">
                      <div class="card-body">
                        <blockquote class="card-bodyquote text-dark mb-0">
                          <div class="product-name"><strong><i class="fi-box"></i> <?= $row->namaproduk ?></strong> <i>(<?= $row->namaperusahaan ?>)</i></div>
                          <footer class="blockquote-footer text-dark small">Kemasan : <?= $row->namakemasan ?></footer>

                          <? $kuantitassisa = ($row->kuantitas - $row->kuantitasdimutasi); ?>

                          <hr class="mt-1 mb-1">
                          <footer class="text-dark small"><strong>Kuantitas</strong></footer>
                          <footer class="text-dark small"><?= GetKuantitasKonversi($row->idprodukkemasan, $row->kuantitas) ?></footer>
                        </blockquote>
                      </div>
                    </div>
                  </td>
                  <td hidden><?= $row->idprodukkemasan ?></td>
                  <td><?= GetKuantitasKonversi($row->idprodukkemasan, $row->kuantitasdimutasi) ?></td>
                  <td><?= GetKuantitasKonversi($row->idprodukkemasan, $kuantitassisa) ?></td>
                  <td><a href="javascript: void(0);" class="btn btn-outline-primary waves-effect produkEdit" data-idrekanan="<?= $row->idrekanan ?>" data-idprodukkemasan="<?= $row->idprodukkemasan ?>" data-kuantitasmax="<?= $row->kuantitas ?>" data-stbonus="<?= $row->stbonus ?>" data-toggle="modal" data-target="#modalDetailPerProduct"><i class="fa fa-pencil"></i> Ubah</a></td>
                  <? endforeach; ?>
                </tbody>
            </table>
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

<div id="modalDetailPerProduct" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalDetailPerProductLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:60%;max-width:inherit;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="modalDetailPerProductLabel">Detail Penerimaan Produk</h4>
            </div>
            <div class="modal-body">
              <div class="form-horizontal" role="form">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">

                      <input type="hidden" class="form-control" id="rowIndexDetail">
                      <input type="hidden" class="form-control" id="numberDetail">
                      <input type="hidden" class="form-control" id="idRekanan">
                      <input type="hidden" class="form-control" id="idProdukKemasanDetail">
                      <input type="hidden" class="form-control" id="kuantitasKonversi">
                      <input type="hidden" class="form-control" id="kuantitasPemesanan">
                      <input type="hidden" class="form-control" id="stBonus">

                      <table id="produkDetailList" class="tablesaw m-t-20 table m-b-0 tablesaw-stack" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                          <thead>
                            <tr>
                              <th width="20%">
                                <select id="idSatuan" class="form-control select2">
                                  <option selected disabled>Pilih Satuan</option>
                                </select>
                              </th>
                              <th width="20%">
                                <input type="text" id="kuantitasProduk" class="form-control number detail" placeholder="Kuantitas"></th>
                              </th>
                              <th width="10%">
                                <a href="#" id="produkDetailAdd" class="btn btn-custom waves-effect waves-light">Tambah</a>
                              </th>
                            </tr>
                            <tr>
                              <th>Satuan</th>
                              <th>Kuantitas</th>
                              <th></th>
                            </tr>
                          </thead>

                          <tbody>
                          </tbody>
                      </table>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
