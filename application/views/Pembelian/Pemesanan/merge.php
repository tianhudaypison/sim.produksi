<div class="row">
  <div class="col-12">
    <form id="form" class="form-horizontal" action="<?= $loader['path'] ?>save" method="POST" role="form">
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
                                   <input type="text" id="tanggal" class="form-control datepicker-autoclose" placeholder="yyyy-mm-dd" name="tanggal" value="{tanggal}">
                                   <div class="input-group-append">
                                       <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                   </div>
                                 </div>
                              </div>
                          </div>
                          <div class="form-group row">
                              <label class="col-2 col-form-label">Pemesanan 1</label>
                              <div class="col-10">
                                <select id="idPemesanan1" class="form-control select2" name="idpemesanan1">
                                  <option value="0" selected disabled>Pilih Opsi</option>
                                  <?php foreach ($listDraftPemesanan as $row) { ?>
                                    <option value="<?= $row->id ?>" data-idrekanan="<?= $row->idrekanan ?>" data-idterm="<?= $row->idterm ?>" data-kreditmaxbayar="<?= $row->kreditmaxbayar ?>" data-idtemplatepajak="<?= $row->idtemplatepajak ?>"><?= $row->nopemesanan ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                          </div>
                          <div class="form-group row">
                              <label class="col-2 col-form-label">Pemesanan 2</label>
                              <div class="col-10">
                                <select id="idPemesanan2" class="form-control select2" name="idpemesanan2">
                                  <option value="0" selected disabled>Pilih Opsi</option>
                                </select>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <!-- end row -->

              <input type="hidden" name="mergeprocess" readonly value="1">
        			<input type="hidden" id="noPemesanan1" name="nopemesanan1" readonly value="">
        			<input type="hidden" id="noPemesanan2" name="nopemesanan2" readonly value="">
        			<input type="hidden" id="idRekanan" name="idrekanan" readonly value="">
        			<input type="hidden" id="idTerm" name="idterm" readonly value="">
        			<input type="hidden" id="kreditMaxBayar" name="kreditmaxbayar" readonly value="">
        			<input type="hidden" id="idTemplatePajak" name="idtemplatepajak" readonly value="">

              <input type="hidden" id="totalProduk" name="totalproduk" value="{totalproduk}">
              <input type="hidden" id="totalPemesanan" name="totalpemesanan" value="{totalpemesanan}">
              <input type="hidden" id="totalDiskonPemesanan" name="totaldiskonpemesanan" value="{totaldiskonpemesanan}">
              <input type="hidden" id="totalDiskonBonus" name="totaldiskonbonus" value="{totaldiskonbonus}">
              <input type="hidden" id="totalCashback" name="totalcashback" value="{totalcashback}">
              <input type="hidden" id="grandTotal" name="totalakhir" value="{totalakhir}">
              <input type="hidden" id="produkValue" name="produkvalue">
          </div>

          <div class="card-box formProduk p-1">
            <div class="row">
              <div class="col-12">
                <table id="produkList" class="tablesaw m-t-20 table m-b-0 tablesaw-stack" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                      <tr>
                          <th colspan="2">Produk</th>
                          <th>Harga</th>
                          <th>Kuantitas</th>
                          <th>Subtotal</th>
                      </tr>
                    </thead>

                    <tbody>
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
          <input type="hidden" class="form-control" id="kuantitasKonversiSatuanKecil" value="">
          <input type="hidden" class="form-control" id="kuantitasKonversi" value="">
          <input type="hidden" class="form-control" id="statusBonus" value="0">

          <div class="form-group m-b-25">
              <div class="col-12">
                  <label for="">Status Produk</label>
                  <div class="row">
                    <div class="col-xl-12 row text-center">
                      <a href="javascript: void(0);" class="col-sm-6 col-xl-6">
                        <div id="produkNonBonus" class="card-box widget-flat border-custom bg-outline-custom active mb-0">
                          <i class="dripicons-shopping-bag"></i>
                          <h3 class="m-b-10"></h3>
                          <p class="text-uppercase m-b-5 font-13 font-600">Non Bonus</p>
                        </div>
                      </a>
                      <a href="javascript: void(0);" class="col-sm-6 col-xl-6">
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

          <div id="formCashback" class="form-group m-b-25" style="display:none">
              <div class="col-12">
                <label for="cashback">Cashback</label>
                <input type="text" id="cashback" class="form-control number detail" placeholder="Cashback" value="">
              </div>
          </div>
          <div id="formDiscount" class="form-group m-b-25" style="display:none">
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
