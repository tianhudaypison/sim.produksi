<div class="row">
    <div class="col-12">
        <div class="card-box">

            <div class="row">
                <div class="col-12">
                    <div class="p-20">
                        <form class="form-horizontal" action="<?= $loader['path'] ?>save" method="POST" role="form">
                            <div class="form-group row">
                                <label class="col-2 col-form-label">Stasiun Produksi</label>
                                <div class="col-10">
                                   <input type="text" class="form-control" placeholder="Stasiun Produksi" name="nama" value="{nama}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-2 col-form-label">Keterangan</label>
                                <div class="col-10">
                                   <input type="text" class="form-control" placeholder="Keterangan" name="keterangan" value="{keterangan}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-2 col-form-label">Jumlah Mesin</label>
                                <div class="col-10">
                                   <input type="text" class="form-control" placeholder="Jumlah Mesin" id="jumlahMesin" value="0">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-2 col-form-label">Total Kapasitas</label>
                                <div class="col-10">
                                   <input type="text" class="form-control" placeholder="Total Kapasitas" id="totalKapasitas" name="totalkapasitas" readonly value="{totalkapasitas}">
                                </div>
                            </div>

                            <hr>

                            <div class="groupContent"></div>

                            <div class="form-group row mb-0">
                                <label class="col-2 col-form-label"></label>
                                <div class="col-10">
                                   <button type="submit" class="btn btn-success waves-effect waves-light">Simpan</button>
                                   <a href="<?= $loader['path'] ?>" class="btn btn-danger waves-effect waves-light">Batal</a>
                                </div>
                            </div>

                            <input type="hidden" name="id" value="{id}">
                        </form>
                    </div>
                </div>
            </div>
            <!-- end row -->

        </div> <!-- end card-box -->
    </div><!-- end col -->
</div>
