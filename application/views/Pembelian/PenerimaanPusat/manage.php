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
                          <label class="col-md-2 col-xs-3 col-form-label">Rekanan</label>
                          <div class="col-md-10 col-xs-9">
                            <select id="idRekanan" class="form-control select2" name="idrekanan">
                              <option value="0" selected disabled>Pilih Opsi</option>
                              <?php foreach ($listRekanan as $row) { ?>
                                <option value="<?= $row->id ?>" <?=($row->id == $idrekanan ? 'selected' : '') ?>><?= $row->namarekanan; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-md-2 col-xs-3 col-form-label">No. Pemesanan</label>
                          <div class="col-md-10 col-xs-9">
                            <div class="row">
                              <div class="col-md-9 col-sm-12">
                                <select id="idPemesanan" class="form-control select2" name="idpemesanan">
                                  <option value="0" selected disabled>Pilih Opsi</option>
                                  <?php if($method_name == 'edit'){ ?>
                    								<?php foreach($list_pemesanan as $row){ ?>
                    									<option value="<?= $row->id ?>" <?= ($row->id == $idpemesanan ? 'selected' : '') ?>><?= $row->nopemesanan ?></option>
                    								<?php } ?>
                    							<?php } ?>
                                </select>
                              </div>
                              <div class="col-md-3 col-sm-12">
                                <a href="javascript: void(0);" class="btn btn-primary w-100" data-toggle="modal" data-target="#modalFilterByProduct"><i class="fa fa-search"></i> Filter By Product</a>
                              </div>
                            </div>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-md-2 col-xs-3 col-form-label">No. DO (Rekanan)</label>
                          <div class="col-md-10 col-xs-9">
                            <input type="text" id="nodo" class="form-control" name="nodo" value="{nodo}">
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <!-- end row -->

          <input type="hidden" id="totalProduk" name="totalproduk" value="{totalproduk}">
          <input type="hidden" id="produkValue" name="produkvalue">
      </div>

      <div class="card-box formProduk p-1">
        <div class="row">
          <div class="col-12">
            <div style="overflow-x: scroll;">
            <table id="produkList" class="tablesaw m-t-20 table m-b-0 tablesaw-stack table-transaction" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                  <tr>
                      <th class="col-w20">Produk</th>
                      <th class="col-w20">Kuantitas Penerimaan</th>
                      <th class="col-w20">Kuantitas Sisa</th>
                      <th class="col-w20"></th>
                  </tr>
                </thead>

                <tbody>
                  <? if($this->uri->segment(3) == 'edit'): ?>
                    <? foreach ($listDetailPemesanan as $index => $row): ?>
                      <tr>
                        <td hidden><?= ($index+1) ?></td>
                        <td colspan="2">
                          <div class="card text-white bg-product">
                            <div class="card-body">
                              <blockquote class="card-bodyquote text-dark mb-0">
                                <div class="product-name"><strong><i class="fi-box"></i> <?= $row->namaproduk ?></strong> <i>(<?= $row->namaperusahaan ?>)</i></div>
                                <footer class="blockquote-footer text-dark small">Kemasan : <?= $row->namakemasan ?></footer>
                                <hr class="mt-1 mb-1">
                  				      <footer class="blockquote-footer text-dark small">Status : <?= ($row->stbonus == 1 ? 'Bonus' : 'Non Bonus') ?></footer>

                  				      <? if($row->stbonus == 1): ?>
                  					      <footer class="blockquote-footer text-dark small">Cashback : <?= $row->cashback ?></footer>
                  					      <footer class="blockquote-footer text-dark small">Discount : <?= $row->discount ?>%</footer>
                  				      <? endif; ?>

                  				    </blockquote>
                            </div>
                          </div>
                        </td>
                        <td hidden><?= $row->idprodukkemasan ?></td>
                        <td hidden><?= $row->jenissatuan ?></td>
                        <td hidden><?= $row->nilaikonversisatuan ?></td>
                        <td><?= number_format($row->harga) ?></td>
                        <td><?= number_format($row->kuantitas) ?></td>
                        <td><?= number_format($row->total) ?></td>
                        <td hidden><?= number_format($row->diskon) ?></td>
                        <td hidden><?= number_format($row->cashback) ?></td>
                        <td hidden><?= $row->stbonus ?></td>
                        <td>
                          <div class="btn-group mb-2">
                            <button type="button" class="btn btn-outline-primary waves-effect produkEdit"><i class="fa fa-pencil"></i> Ubah</button>
                            <button type="button" class="btn btn-outline-danger waves-effect produkRemove"><i class="fa fa-trash-o"></i> Hapus</button>
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

<div id="modalFilterByProduct" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalFilterByProductLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:60%;max-width:inherit;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="modalFilterByProductLabel">Filter Pemesanan By Produk</h4>
            </div>
            <div class="modal-body">
              <div class="form-horizontal" role="form">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">

                      <input type="hidden" class="form-control" id="rowIndexTemp">
                      <input type="hidden" class="form-control" id="numberTemp">

                      <table id="produkTempList" class="tablesaw m-t-20 table m-b-0 tablesaw-stack" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                          <thead>
                            <tr>
                              <th width="20%">
                                <select id="idProdukKemasan" class="form-control select2">
                                  <option value="0" selected disabled>Pilih Produk</option>
                                  <?php foreach ($listProduk as $row) { ?>
                                    <option value="<?= $row->id ?>"><?= $row->namaproduk ?> - <?= $row->namakemasan ?> - <?= $row->namaperusahaan ?></option>
                                  <?php } ?>
                                </select>
                              </th>
                              <th width="10%">
                                <a href="#" id="produkTempAdd" class="btn btn-custom waves-effect waves-light">Tambah</a>
                              </th>
                            </tr>
                            <tr>
                              <th>Produk</th>
                              <th></th>
                            </tr>
                          </thead>

                          <tbody>
                          </tbody>
                      </table>

                      <hr>

                      <div id="listNoPemesanan"></div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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
