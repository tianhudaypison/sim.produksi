<div class="row">
  <div class="col-12">
    <form id="form" class="form-horizontal" action="<?= $loader['path'] ?>splitProcess" method="POST" role="form">
      <div class="row">
        <div class="col-12">
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
                              <label class="col-2 col-form-label">Pemesanan</label>
                              <div class="col-10">
                                <select id="idPemesanan" class="form-control select2" name="idpemesanan">
                                  <option value="0" selected disabled>Pilih Opsi</option>
                                  <?php foreach ($listDraftPemesanan as $row) { ?>
                                    <option value="<?= $row->id ?>" data-idrekanan="<?= $row->idrekanan ?>" data-idterm="<?= $row->idterm ?>" data-kreditmaxbayar="<?= $row->kreditmaxbayar ?>" data-idtemplatepajak="<?= $row->idtemplatepajak ?>"><?= $row->nopemesanan ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <!-- end row -->

        			<input type="hidden" id="noPemesanan" name="nopemesanan" readonly value="">
        			<input type="hidden" id="idRekanan" name="idrekanan" readonly value="">
        			<input type="hidden" id="idTerm" name="idterm" readonly value="">
        			<input type="hidden" id="kreditMaxBayar" name="kreditmaxbayar" readonly value="">
        			<input type="hidden" id="idTemplatePajak" name="idtemplatepajak" readonly value="">

              <input type="hidden" id="totalProduk1" name="totalproduk1" value="">
              <input type="hidden" id="totalPemesanan1" name="totalpemesanan1" value="">
              <input type="hidden" id="totalDiskonPemesanan1" name="totaldiskonpemesanan1" value="">
              <input type="hidden" id="totalDiskonBonus1" name="totaldiskonbonus1" value="">
              <input type="hidden" id="totalCashback1" name="totalcashback1" value="">
              <input type="hidden" id="grandTotal1" name="totalakhir1" value="">

              <input type="hidden" id="totalProduk2" name="totalproduk2" value="">
              <input type="hidden" id="totalPemesanan2" name="totalpemesanan2" value="">
              <input type="hidden" id="totalDiskonPemesanan2" name="totaldiskonpemesanan2" value="">
              <input type="hidden" id="totalDiskonBonus2" name="totaldiskonbonus2" value="">
              <input type="hidden" id="totalCashback2" name="totalcashback2" value="">
              <input type="hidden" id="grandTotal2" name="totalakhir2" value="">

              <input type="hidden" id="produkValue1" name="produkvalue1">
              <input type="hidden" id="produkValue2" name="produkvalue2">
          </div>

          <div class="row">
            <div class="col-9">
              <div class="card-box formProduk p-1">
                <div class="row">
                  <div class="col-12">
                    <table id="produkList1" class="tablesaw m-t-20 table m-b-0 tablesaw-stack" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                          <tr>
                              <th colspan="2">Produk</th>
                              <th>Harga</th>
                              <th>Kuantitas</th>
                              <th>Subtotal</th>
                              <th></th>
                          </tr>
                        </thead>
                        <tbody></tbody>
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
                                <p class="inbox-item-text">Rp <span id="summaryTotalPemesanan1">0</span></p>
                            </div>
                        </a>
                        <a href="#">
                            <div class="inbox-item">
                                <p class="inbox-item-author">Total Discount Pemesanan</p>
                                <p class="inbox-item-text">Rp <span id="summaryTotalDiskonPemesanan1">0</span></p>
                            </div>
                        </a>
                        <a href="#">
                            <div class="inbox-item">
                                <p class="inbox-item-author">Total Discount Bonus</p>
                                <p class="inbox-item-text">Rp <span id="summaryTotalDiskonBonus1">0</span></p>
                            </div>
                        </a>
                        <a href="#">
                            <div class="inbox-item">
                                <p class="inbox-item-author">Total Cashback</p>
                                <p class="inbox-item-text">Rp <span id="summaryTotalCashback1">0</span></p>
                            </div>
                        </a>
                        <a href="#">
                            <div class="inbox-item">
                                <p class="inbox-item-author">Grand Total</p>
                                <p class="inbox-item-text">Rp <span id="summaryGrandTotal1">0</span></p>
                            </div>
                        </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <hr>
  				<span class="badge badge-primary">SPLIT DATA PRODUK</span>
          <br><br>

          <div class="row">
            <div class="col-9">
              <div class="card-box formProduk p-1">
                <div class="row">
                  <div class="col-12">
                    <table id="produkList2" class="tablesaw m-t-20 table m-b-0 tablesaw-stack" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                          <tr>
                              <th colspan="2">Produk</th>
                              <th>Harga</th>
                              <th>Kuantitas</th>
                              <th>Subtotal</th>
                          </tr>
                        </thead>
                        <tbody></tbody>
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
                                <p class="inbox-item-text">Rp <span id="summaryTotalPemesanan2">0</span></p>
                            </div>
                        </a>
                        <a href="#">
                            <div class="inbox-item">
                                <p class="inbox-item-author">Total Discount Pemesanan</p>
                                <p class="inbox-item-text">Rp <span id="summaryTotalDiskonPemesanan2">0</span></p>
                            </div>
                        </a>
                        <a href="#">
                            <div class="inbox-item">
                                <p class="inbox-item-author">Total Discount Bonus</p>
                                <p class="inbox-item-text">Rp <span id="summaryTotalDiskonBonus2">0</span></p>
                            </div>
                        </a>
                        <a href="#">
                            <div class="inbox-item">
                                <p class="inbox-item-author">Total Cashback</p>
                                <p class="inbox-item-text">Rp <span id="summaryTotalCashback2">0</span></p>
                            </div>
                        </a>
                        <a href="#">
                            <div class="inbox-item">
                                <p class="inbox-item-author">Grand Total</p>
                                <p class="inbox-item-text">Rp <span id="summaryGrandTotal2">0</span></p>
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

        </div>
      </div>
    </form>
  </div>
</div>
