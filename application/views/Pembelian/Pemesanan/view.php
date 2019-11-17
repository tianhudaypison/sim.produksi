<div class="row">
  <div class="col-12">
    <form id="form" class="form-horizontal" role="form">
      <div class="row">
        <div class="col-9">
          <div class="card-box">
              <div class="row">
                  <div class="col-12">
                      <div class="p-20">
                          <div class="form-group row">
                              <label class="col-2 col-form-label">Tanggal</label>
                              <div class="col-10">
                                <div class="input-group">
                                   <input type="text" class="form-control datepicker-autoclose" readonly value="{tanggal}">
                                   <div class="input-group-append">
                                       <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                   </div>
                                 </div>
                              </div>
                          </div>
                          <div class="form-group row">
                              <label class="col-2 col-form-label">Rekanan</label>
                              <div class="col-10">
                                <select class="form-control select2" disabled>
                                  <option value="0" selected disabled>Pilih Opsi</option>
                                  <?php foreach ($listRekanan as $row) { ?>
                                    <option value="<?= $row->id ?>" <?=($row->id == $idrekanan ? 'selected' : '') ?>><?= $row->namarekanan; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                          </div>
                          <div class="form-group row">
                              <label class="col-2 col-form-label">Template Pajak</label>
                              <div class="col-10">
                                <select class="form-control select2" disabled>
                                  <option value="0" selected disabled>Pilih Opsi</option>
                                  <?php foreach ($listTemplatePajak as $row) { ?>
                                    <option value="<?= $row->id ?>" <?=($row->id == $idtemplatepajak ? 'selected' : '') ?>><?= $row->nama; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                          </div>
                          <div class="form-group row">
                              <label class="col-2 col-form-label">Term</label>
                              <div class="col-10">
                                <select class="form-control select2" disabled>
                                  <option value="0" selected disabled>Pilih Opsi</option>
                                  <option value="1" <?= ($idterm == 1 ? 'selected' : '') ?>>CBD</option>
                                  <option value="2" <?= ($idterm == 2 ? 'selected' : '') ?>>Kredit</option>
                                </select>
                              </div>
                          </div>
                          <div class="form-group row" <?= ($idterm == 1 ? 'style="display:none"' : '') ?>>
                              <label class="col-2 col-form-label"></label>
                              <div class="col-10">
                                <div class="tags-default">
                                    <input type="text" id="kreditDiskon" data-role="tagsinput" disabled value="{kreditdiskon}">
                                </div>
                              </div>
                          </div>
                          <div class="form-group row" <?= ($idterm == 1 ? 'style="display:none"' : '') ?>>
                              <label class="col-2 col-form-label"></label>
                              <div class="col-10">
                                <div class="tags-default">
                                    <input type="text" id="kreditHari" data-role="tagsinput" disabled value="{kredithari}">
                                </div>
                              </div>
                          </div>
                          <div class="form-group row" <?= ($idterm == 1 ? 'style="display:none"' : '') ?>>
                              <label class="col-2 col-form-label"></label>
                              <div class="col-10">
                                <input type="text" class="form-control number" readonly>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <!-- end row -->
          </div>

          <div class="card-box formProduk p-1">
            <div class="row">
              <div class="col-12">
                <table id="produkList" class="tablesaw m-t-20 table m-b-0 tablesaw-stack" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                      <tr>
                          <th>Produk</th>
                          <th>Harga</th>
                          <th>Kuantitas</th>
                          <th>Subtotal</th>
                      </tr>
                    </thead>

                    <tbody>
                      <? foreach ($listDetailPemesanan as $index => $row): ?>
                        <tr>
                          <td hidden><?= ($index+1) ?></td>
                          <td>
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
                          <td hidden>idsatuan</td>
                          <td><?= number_format($row->harga) ?></td>
                          <td><?= GetKuantitasKonversi($row->idprodukkemasan, $row->kuantitas) ?></td>
                          <td hidden><?= number_format($row->kuantitas) ?></td>
                          <td><?= number_format($row->total) ?></td>
                          <td hidden><?= number_format($row->diskon) ?></td>
                          <td hidden><?= number_format($row->cashback) ?></td>
                          <td hidden><?= $row->stbonus ?></td>
                      <? endforeach; ?>
                    </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-3">
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
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
