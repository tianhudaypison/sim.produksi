<div class="row">
  <div class="col-12">
    <form id="form" class="form-horizontal" action="<?= $loader['path'] ?>save" method="POST" role="form">
      <div class="row">
        <div class="col-md-9 col-xs-12">
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
                              <label class="col-md-2 col-xs-3 col-form-label">Template Pajak</label>
                              <div class="col-md-10 col-xs-9">
                                <select id="idTemplatePajak" class="form-control select2" name="idtemplatepajak">
                                  <option value="0" selected disabled>Pilih Opsi</option>
                                  <?php foreach ($listTemplatePajak as $row) { ?>
                                    <option value="<?= $row->id ?>" <?=($row->id == $idtemplatepajak ? 'selected' : '') ?>><?= $row->nama; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                          </div>
                          <div class="form-group row">
                              <label class="col-md-2 col-xs-3 col-form-label">Term</label>
                              <div class="col-md-10 col-xs-9">
                                <select id="idTerm" class="form-control select2" name="idterm">
                                  <option value="0" selected disabled>Pilih Opsi</option>
                                  <option value="1" <?= ($idterm == 1 ? 'selected' : '') ?>>CBD</option>
                                  <option value="2" <?= ($idterm == 2 ? 'selected' : '') ?>>Kredit</option>
                                </select>
                              </div>
                          </div>
                          <div class="form-group row formTermKredit" <?= ($idterm == 1 ? 'style="display:none"' : '') ?>>
                              <label class="col-md-2 col-xs-3 col-form-label">Diskon</label>
                              <div class="col-md-10 col-xs-9">
                                <div class="tags-default">
                                    <input type="text" id="kreditDiskon" data-role="tagsinput" placeholder="Kredit Diskon" name="kreditdiskon" value="{kreditdiskon}">
                                </div>
                              </div>
                          </div>
                          <div class="form-group row formTermKredit" <?= ($idterm == 1 ? 'style="display:none"' : '') ?>>
                              <label class="col-md-2 col-xs-3 col-form-label">Hari</label>
                              <div class="col-md-10 col-xs-9">
                                <div class="tags-default">
                                    <input type="text" id="kreditHari" data-role="tagsinput" placeholder="Kredit Hari" name="kredithari" value="{kredithari}">
                                </div>
                              </div>
                          </div>
                          <div class="form-group row formTermKredit" <?= ($idterm == 1 ? 'style="display:none"' : '') ?>>
                              <label class="col-md-2 col-xs-3 col-form-label">Max Bayar</label>
                              <div class="col-md-10 col-xs-9">
                                <input type="text" id="kreditMaxBayar" class="form-control number" name="kreditmaxbayar" value="{kreditmaxbayar}">
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <!-- end row -->

              <input type="hidden" id="totalProduk" name="totalproduk" value="{totalproduk}">
              <input type="hidden" id="totalPemesanan" name="totalpemesanan" value="{totalpemesanan}">
              <input type="hidden" id="totalDiskonPemesanan" name="totaldiskonpemesanan" value="{totaldiskonpemesanan}">
              <input type="hidden" id="totalDiskonBonus" name="totaldiskonbonus" value="{totaldiskonbonus}">
              <input type="hidden" id="totalCashback" name="totalcashback" value="{totalcashback}">
              <input type="hidden" id="grandTotal" name="totalakhir" value="{totalakhir}">
              <input type="hidden" id="produkValue" name="produkvalue">
          </div>

          <div class="card-box formProduk p-1" <?= ($this->uri->segment(3) == 'edit' ? '' : 'style="display:none"') ?>>
            <div class="row">
              <div class="col-12">
                <div style="overflow-x: scroll;">
                <table id="produkList" class="tablesaw m-t-20 table m-b-0 tablesaw-stack table-transaction" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                      <tr>
                          <th class="col-w20">
                            <select id="idProdukKemasan" class="form-control select2">
                              <option value="0" selected disabled>Pilih Produk</option>
                              <?php foreach ($listProduk as $row) { ?>
                                <option value="<?= $row->id ?>"><?= $row->namaproduk ?> - <?= $row->namakemasan ?> - <?= $row->namaperusahaan ?></option>
                              <?php } ?>
                            </select>
                          </th>
                          <th class="col-w15">
                            <select id="idSatuan" class="form-control select2">
                              <option selected disabled>Pilih Satuan</option>
                            </select>
                          </th>
                          <th class="col-w15">
                            <input type="text" id="hargaBeli" class="form-control number detail" placeholder="Harga Beli">
                          </th>
                          <th class="col-w15">
                            <input type="text" id="kuantitasProduk" class="form-control number detail" placeholder="Kuantitas"></th>
                          <th class="col-w15">
                            <input type="text" id="subTotal" class="form-control number detail" readonly placeholder="Subtotal"></th>
                          <th class="col-w20">
                            <a href="#modalConfirm" class="btn btn-custom waves-effect waves-light" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a">Tambah</a>
                          </th>
                      </tr>
                      <tr>
                          <th colspan="2">Produk</th>
                          <th>Harga</th>
                          <th>Kuantitas</th>
                          <th>Subtotal</th>
                          <th></th>
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
                      					      <footer class="blockquote-footer text-dark small">Discount : <?= $row->diskon ?>%</footer>
                      				      <? endif; ?>

                      				    </blockquote>
                                </div>
                              </div>
                            </td>
                            <td hidden><?= $row->idprodukkemasan ?></td>
                            <td><?= number_format($row->harga) ?></td>
                            <td><?= number_format($row->kuantitas) ?></td>
                            <td hidden><?= number_format($row->kuantitas) ?></td>
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
        </div>
        <div class="col-md-3 col-xs-12">
          <div class="row">
            <div class="col-12">
              <div class="card-box ribbon-box">
                <div class="ribbon ribbon-primary">Summary</div>
                <div class="clearfix"></div>
                <div class="inbox-widget">
                    <a href="#">
                        <div class="inbox-item">
                            <p class="inbox-item-author">Sub Total</p>
                            <p class="inbox-item-text">Rp <span id="summaryTotalPemesanan">0</span></p>
                        </div>
                    </a>
                    <a href="#">
                        <div class="inbox-item">
                            <p class="inbox-item-author">Total Discount Pemesanan</p>
                            <p class="inbox-item-text">Rp <span id="summaryTotalDiskonPemesanan">0</span></p>
                        </div>
                    </a>
                    <a href="#">
                        <div class="inbox-item">
                            <p class="inbox-item-author">Total Discount Bonus</p>
                            <p class="inbox-item-text">Rp <span id="summaryTotalDiskonBonus">0</span></p>
                        </div>
                    </a>
                    <a href="#">
                        <div class="inbox-item">
                            <p class="inbox-item-author">Total Cashback</p>
                            <p class="inbox-item-text">Rp <span id="summaryTotalCashback">0</span></p>
                        </div>
                    </a>
                    <a href="#">
                        <div class="inbox-item">
                            <p class="inbox-item-author">Grand Total</p>
                            <p class="inbox-item-text">Rp <span id="summaryGrandTotal">0</span></p>
                        </div>
                    </a>
                </div>
                <br>
                <div class="form-group row mb-0">
                  <div class="col-12">
                    <button type="submit" class="btn btn-success waves-effect waves-light">Simpan</button>
                    <a href="<?= $loader['path'] ?>" class="btn btn-danger waves-effect waves-light">Batal</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal -->
<div id="modalConfirm" class="modal-demo">
    <div class="custom-modal-text">
        <form class="form-horizontal" action="#">

          <input type="hidden" class="form-control" id="rowindex">
          <input type="hidden" class="form-control" id="number">
          <input type="hidden" class="form-control" id="kuantitasKonversi" value="">
          <input type="hidden" class="form-control" id="statusBonus" value="0">

          <div class="form-group m-b-25">
              <div class="col-12">
                  <label for="">Status Produk</label>
                  <div class="row">
                    <div class="col-12 row text-center">
                      <a href="javascript: void(0);" class="col-6">
                        <div id="produkNonBonus" class="card-box widget-flat border-custom bg-outline-custom active mb-0">
                          <i class="dripicons-shopping-bag"></i>
                          <h3 class="m-b-10"></h3>
                          <p class="text-uppercase m-b-5 font-13 font-600">Non Bonus</p>
                        </div>
                      </a>
                      <a href="javascript: void(0);" class="col-6">
                        <div id="produkBonus" class="card-box widget-flat border-primary bg-outline-custom mb-0 <?= IsMenuActive('TipeHama') ?>">
                          <i class="dripicons-shopping-bag"></i>
                          <h3 class="m-b-10"></h3>
                          <p class="text-uppercase m-b-5 font-13 font-600">Bonus</p>
                        </div>
                      </a>
                    </div>
                  </div>
              </div>
          </div>

          <hr>

          <div id="formCashback" class="form-group m-b-25">
              <div class="col-12">
                <label for="cashback">Cashback</label>
                <input type="text" id="cashback" class="form-control number detail" placeholder="Cashback" value="">
              </div>
          </div>
          <div id="formDiscount" class="form-group m-b-25">
              <div class="col-12">
                <label for="discount">Discount</label>
                <div class="input-group">
                   <input type="text" id="discount" class="form-control number detail" placeholder="Discount" value="">
                   <div class="input-group-append">
                       <span class="input-group-text">%</span>
                   </div>
                </div>
              </div>
          </div>

          <div class="form-group account-btn text-center m-t-10">
              <div class="col-12">
                  <button type="button" id="produkAdd" class="btn w-lg btn-rounded btn-custom waves-effect waves-light" onclick="Custombox.close();">Tambahkan</button>
              </div>
          </div>
        </form>
    </div>
</div>
