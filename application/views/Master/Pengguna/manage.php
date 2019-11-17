<div class="row">
    <div class="col-12">
      <form id="form" class="form-horizontal" action="<?= $loader['path'] ?>save" method="POST" role="form">
        <div class="card-box">
            <div class="row">
                <div class="col-12">
                    <div class="p-20">
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Pegawai</label>
                            <div class="col-10">
                              <select class="form-control select2" name="idpegawai">
                                <option value="#" selected disabled>Pilih Opsi</option>
                               <?php foreach($listMarketing as $row){ ?>
                                 <option value="<?=$row->id?>" <?=($idpegawai==$row->id) ? "selected" : "" ?>><?=$row->nama?></option>
                               <?php } ?>
                              </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Username</label>
                            <div class="col-10">
                               <input type="text" class="form-control" placeholder="Username" name="username" value="{username}">
                            </div>
                        </div>
                        <div class="form-group row">
                					<label class="col-2 col-form-label">Katasandi</label>
                					<div class="col-10">
                						<input type="password" class="form-control" placeholder="Katasandi" name="password" value="" />
                					</div>
                				</div>
                				<div class="form-group row">
                					<label class="col-2 col-form-label">Konfirmasi Katasandi</label>
                					<div class="col-10">
                						<input type="password" class="form-control" placeholder="Konfirmasi Katasandi" name="confirm_password" value="" />
                					</div>
                				</div>
                        <div class="form-group row">
                          <label class="col-2 col-form-label">Hak Akses</label>
                          <div class="col-10">
                            <select class="form-control select2" name="idhakakses">
                              <option value="#" selected disabled>Pilih Opsi</option>
                							<?php foreach($listHakAkses as $row){ ?>
                								<option value="<?=$row->id?>" <?=($idhakakses==$row->id) ? "selected" : "" ?>><?=$row->nama?></option>
                							<?php } ?>
                          	</select>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div> <!-- end card-box -->

        <div class="form-group row">
            <label class="col-2 col-form-label"></label>
            <div class="col-10">
               <button type="submit" class="btn btn-success waves-effect waves-light">Simpan</button>
               <a href="<?= $loader['path'] ?>" class="btn btn-danger waves-effect waves-light">Batal</a>
            </div>
        </div>

        <input type="hidden" name="id" value="{id}">
      </form>
  </div><!-- end col -->
</div>
