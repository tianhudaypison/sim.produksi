<div class="row">
    <div class="col-12">
        <div class="card-box">

            <div class="row">
                <div class="col-12">
                    <div class="p-20">
                        <form class="form-horizontal" action="<?= $loader['path'] ?>save" method="POST" role="form">
                            <div class="form-group row">
                                <label class="col-2 col-form-label">Nama</label>
                                <div class="col-10">
                                   <input type="text" class="form-control" placeholder="Nama" name="nama" value="{nama}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-2 col-form-label">Alamat</label>
                                <div class="col-10">
                                   <textarea class="form-control" placeholder="Alamat" name="alamat">{alamat}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-2 col-form-label">Telepon</label>
                                <div class="col-10">
                                   <input type="text" class="form-control" placeholder="Telepon" name="telepon" value="{telepon}">
                                </div>
                            </div>

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
