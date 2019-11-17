<script src="{plugins_path}switchery/switchery.min.js"></script>
<script src="{plugins_path}bootstrap-tagsinput/js/bootstrap-tagsinput.min.js"></script>
<script src="{plugins_path}select2/js/select2.min.js" type="text/javascript"></script>
<script src="{plugins_path}bootstrap-select/js/bootstrap-select.js" type="text/javascript"></script>
<script src="{plugins_path}bootstrap-filestyle/js/bootstrap-filestyle.min.js" type="text/javascript"></script>
<script src="{plugins_path}bootstrap-maxlength/bootstrap-maxlength.js" type="text/javascript"></script>

<script type="text/javascript" src="{plugins_path}autocomplete/jquery.mockjax.js"></script>
<script type="text/javascript" src="{plugins_path}autocomplete/jquery.autocomplete.min.js"></script>
<script type="text/javascript" src="{plugins_path}autocomplete/countries.js"></script>
<script type="text/javascript" src="{assets_path}pages/jquery.autocomplete.init.js"></script>

<!-- plugin js -->
<script src="{plugins_path}moment/moment.js"></script>
<script src="{plugins_path}bootstrap-timepicker/bootstrap-timepicker.js"></script>
<script src="{plugins_path}bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="{plugins_path}clockpicker/js/bootstrap-clockpicker.min.js"></script>
<script src="{plugins_path}bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="{plugins_path}bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

<!-- Init Js file -->
<script src="{assets_path}pages/jquery.form-pickers.init.js"></script>
<script type="text/javascript" src="{assets_path}pages/jquery.form-advanced.init.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$("#statusktp").click(function() {
			if (this.checked) {
				$('#expiredktp').attr('disabled', 'disabled');
			} else {
				$('#expiredktp').removeAttr('disabled');
				$("#expiredktp").val("");
				$("#expiredktp").focus();
			}
		});

		$("#statusmenikah").click(function() {
			if (this.checked) {
				$("#statusmenikah").val(1);
			} else {
				$("#statusmenikah").val(0);
			}
		});

		$("#stwhatsapp").click(function() {
			if (this.checked) {
				$("#stwhatsapp").val(1);
			} else {
				$("#stwhatsapp").val(0);
			}
		});

		$("#tipepegawai").change(function() {
			if ($(this).val() == 2) {
				$('.form-kontrak').show();
			} else {
				$('.form-kontrak').hide();
			}
		});

		// ALAMAT
		$("#alamatAdd").click(function() {
			var valid = alamatValidate();
			if (!valid) return false;

			if ($("#alamatNumber").val() != '') {
				var number = $("#alamatNumber").val();
				var content = "";
			} else {
				var number = $('#alamatList tr').length;
				var content = "<tr>";
				$('#alamatList tbody tr').filter(function() {
					var $cells = $(this).children('td');
				});
			}

			content += '<td hidden>' + number + '</td>';
			content += '<td>' + $("#kota").val(); + '</td>';
			content += '<td>' + $("#alamat").val(); + '</td>';
			content += '<td>' + $("#kodepos").val(); + '</td>';
      content += '<td><div class="btn-group mb-2"><button type="button" class="btn btn-primary waves-effect rowAlamatEdit"><i class="fa fa-pencil"></i> Ubah</button><button type="button" class="btn btn-danger waves-effect rowAlamatRemove"><i class="fa fa-trash-o"></i> Hapus</button></div></td>';

			if ($("#alamatRowIndex").val() != '') {
				$('#alamatList tbody tr:eq(' + $("#alamatRowIndex").val() + ')').html(content);
			} else {
				content += "</tr>";
				$('#alamatList tbody').append(content);
			}

			alamatClear();
		});

		$(document).on("click", ".rowAlamatEdit", function() {
			$("#alamatRowIndex").val($(this).closest('tr')[0].sectionRowIndex);
			$("#alamatNumber").val($(this).closest('tr').find("td:eq(0)").html());
			$("#kota").val($(this).closest('tr').find("td:eq(1)").html());
			$("#alamat").val($(this).closest('tr').find("td:eq(2)").html());
			$("#kodepos").val($(this).closest('tr').find("td:eq(3)").html());

			return false;
		});

		$(document).on("click", ".rowAlamatRemove", function() {
			if (confirm("Hapus data ?") == true) {
				$(this).closest('td').parent().remove();
			}

			return false;
		});

		// TELEPON
		$("#teleponAdd").click(function() {
			var valid = teleponValidate();
			if (!valid) return false;

			if ($("#teleponNumber").val() != '') {
				var number = $("#teleponNumber").val();
				var content = "";
			} else {
				var number = $('#teleponList tr').length;
				var content = "<tr>";
				$('#teleponList tbody tr').filter(function() {
					var $cells = $(this).children('td');
				});
			}

			content += '<td hidden>' + number + '</td>';
			content += '<td>' + $("#notelepon").val(); + '</td>';
			content += '<td>' + $("#keterangan").val(); + '</td>';
			content += '<td hidden>' + $("#stwhatsapp").val(); + '</td>';
			content += '<td>' + ($("#stwhatsapp").val() == 1 ? "Aktif" : "Tidak Aktif") + '</td>';
      content += '<td><div class="btn-group mb-2"><button type="button" class="btn btn-primary waves-effect rowTeleponEdit"><i class="fa fa-pencil"></i> Ubah</button><button type="button" class="btn btn-danger waves-effect rowTeleponRemove"><i class="fa fa-trash-o"></i> Hapus</button></div></td>';

			if ($("#teleponRowIndex").val() != '') {
				$('#teleponList tbody tr:eq(' + $("#teleponRowIndex").val() + ')').html(content);
			} else {
				content += "</tr>";
				$('#teleponList tbody').append(content);
			}

			teleponClear();
		});

		$(document).on("click", ".rowTeleponEdit", function() {
			$("#teleponRowIndex").val($(this).closest('tr')[0].sectionRowIndex);
			$("#teleponNumber").val($(this).closest('tr').find("td:eq(0)").html());
			$("#notelepon").val($(this).closest('tr').find("td:eq(1)").html());
			$("#keterangan").val($(this).closest('tr').find("td:eq(2)").html());
			$("#stwhatsapp").val($(this).closest('tr').find("td:eq(3)").html());

			if ($(this).closest('tr').find("td:eq(3)").html() == '1') {
				$('#stwhatsapp').prop('checked', true);
			} else {
				$('#stwhatsapp').prop('checked', false);
			}

			return false;
		});

		$(document).on("click", ".rowTeleponRemove", function() {
			if (confirm("Hapus data ?") == true) {
				$(this).closest('td').parent().remove();
			}
			return false;
		});

		// REKENING
		$("#rekeningAdd").click(function() {
			var valid = rekeningValidate();
			if (!valid) return false;

			if ($("#rekeningNumber").val() != '') {
				var number = $("#rekeningNumber").val();
				var content = "";
			} else {
				var number = $('#rekeningList tr').length;
				var content = "<tr>";
				$('#rekeningList tbody tr').filter(function() {
					var $cells = $(this).children('td');
				});
			}

			content += '<td hidden>' + number + '</td>';
			content += '<td>' + $("#namabank").val(); + '</td>';
			content += '<td>' + $("#cabangbank").val(); + '</td>';
			content += '<td>' + $("#kotabank").val(); + '</td>';
			content += '<td>' + $("#norekening").val(); + '</td>';
			content += '<td>' + $("#atasnama").val(); + '</td>';
      content += '<td><div class="btn-group mb-2"><button type="button" class="btn btn-primary waves-effect rowRekeningEdit"><i class="fa fa-pencil"></i> Ubah</button><button type="button" class="btn btn-danger waves-effect rowRekeningRemove"><i class="fa fa-trash-o"></i> Hapus</button></div></td>';

			if ($("#rekeningRowIndex").val() != '') {
				$('#rekeningList tbody tr:eq(' + $("#rekeningRowIndex").val() + ')').html(content);
			} else {
				content += "</tr>";
				$('#rekeningList tbody').append(content);
			}

			rekeningClear();
		});

		$(document).on("click", ".rowRekeningEdit", function() {
			$("#rekeningRowIndex").val($(this).closest('tr')[0].sectionRowIndex);
			$("#rekeningNumber").val($(this).closest('tr').find("td:eq(0)").html());
			$("#namabank").val($(this).closest('tr').find("td:eq(1)").html());
			$("#cabangbank").val($(this).closest('tr').find("td:eq(2)").html());
			$("#kotabank").val($(this).closest('tr').find("td:eq(3)").html());
			$("#norekening").val($(this).closest('tr').find("td:eq(4)").html());
			$("#atasnama").val($(this).closest('tr').find("td:eq(5)").html());

			return false;
		});

		$(document).on("click", ".rowRekeningRemove", function() {
			if (confirm("Hapus data ?") == true) {
				$(this).closest('td').parent().remove();
			}
			return false;
		});

		// ASURANSI
		$("#asuransiAdd").click(function() {
			var valid = asuransiValidate();
			if (!valid) return false;

			if ($("#asuransiNumber").val() != '') {
				var number = $("#asuransiNumber").val();
				var content = "";
			} else {
				var number = $('#asuransiList tr').length;
				var content = "<tr>";
				$('#asuransiList tbody tr').filter(function() {
					var $cells = $(this).children('td');
				});
			}

			content += '<td hidden>' + number + '</td>';
			content += '<td>' + $("#noasuransi").val(); + '</td>';
			content += '<td>' + $("#namaasuransi").val(); + '</td>';
      content += '<td><div class="btn-group mb-2"><button type="button" class="btn btn-primary waves-effect rowAsuransiEdit"><i class="fa fa-pencil"></i> Ubah</button><button type="button" class="btn btn-danger waves-effect rowAsuransiRemove"><i class="fa fa-trash-o"></i> Hapus</button></div></td>';

			if ($("#asuransiRowIndex").val() != '') {
				$('#asuransiList tbody tr:eq(' + $("#asuransiRowIndex").val() + ')').html(content);
			} else {
				content += "</tr>";
				$('#asuransiList tbody').append(content);
			}

			asuransiClear();
		});

		$(document).on("click", ".rowAsuransiEdit", function() {
			$("#asuransiRowIndex").val($(this).closest('tr')[0].sectionRowIndex);
			$("#asuransiNumber").val($(this).closest('tr').find("td:eq(0)").html());
			$("#noasuransi").val($(this).closest('tr').find("td:eq(1)").html());
			$("#namaasuransi").val($(this).closest('tr').find("td:eq(2)").html());

			return false;
		});

		$(document).on("click", ".rowAsuransiRemove", function() {
			if (confirm("Hapus data ?") == true) {
				$(this).closest('td').parent().remove();
			}

			return false;
		});

		// SUBMIT
		$(document).on("click", "#form", function() {
			if ($("#namapegawai").val() == "") {
				sweetAlert("Maaf...", "Nama Pegawai tidak boleh kosong!", "error");
				return false;
			}

			if ($("#noktp").val() == "") {
				sweetAlert("Maaf...", "Nomor KTP tidak boleh kosong!", "error");
				return false;
			}

			if ($("#idjabatan").val() == "#") {
				sweetAlert("Maaf...", "Jabatan belum dipilih!", "error");
				return false;
			}

			if ($("#agama").val() == "#") {
				sweetAlert("Maaf...", "Agama belum dipilih!", "error");
				return false;
			}

			if ($("#pendidikanterakhir").val() == "") {
				sweetAlert("Maaf...", "Pendidikan Terakhir tidak boleh kosong!", "error");
				return false;
			}

			if ($("#tipepegawai").val() == "#") {
				sweetAlert("Maaf...", "Tipe Pegawai belum dipilih!", "error");
				return false;
			}

			var alamatTabel = $('table#alamatList tbody tr').get().map(function(row) {
				return $(row).find('td').get().map(function(cell) {
					return $(cell).html();
				});
			});

			var teleponTabel = $('table#teleponList tbody tr').get().map(function(row) {
				return $(row).find('td').get().map(function(cell) {
					return $(cell).html();
				});
			});

			var rekeningTabel = $('table#rekeningList tbody tr').get().map(function(row) {
				return $(row).find('td').get().map(function(cell) {
					return $(cell).html();
				});
			});

			var asuransiTabel = $('table#asuransiList tbody tr').get().map(function(row) {
				return $(row).find('td').get().map(function(cell) {
					return $(cell).html();
				});
			});

			$("#alamatData").val(JSON.stringify(alamatTabel));
			$("#teleponData").val(JSON.stringify(teleponTabel));
			$("#rekeningData").val(JSON.stringify(rekeningTabel));
			$("#asuransiData").val(JSON.stringify(asuransiTabel));
		});

	});

	function alamatClear() {
		$("#alamatRowIndex").val('');
		$("#alamatNumber").val('');
		$(".alamatDetail").val('');
	}

	function teleponClear() {
		$("#teleponRowIndex").val('');
		$("#teleponNumber").val('');
		$(".teleponDetail").val('');
		$('#stwhatsapp').prop('checked', false);
	}

	function rekeningClear() {
		$("#rekeningRowIndex").val('');
		$("#rekeningNumber").val('');
		$(".rekeningDetail").val('');
	}

	function asuransiClear() {
		$("#asuransiRowIndex").val('');
		$("#asuransiNumber").val('');
		$(".asuransiDetail").val('');
	}

	function alamatValidate() {
		if ($("#kota").val() == "") {
			sweetAlert("Maaf...", "Kota tidak boleh kosong!", "error");
			return false;
		}
		if ($("#alamat").val() == "#") {
			sweetAlert("Maaf...", "Alamat tidak boleh kosong!", "error");
			return false;
		}
		if ($("#kodepos").val() == "") {
			sweetAlert("Maaf...", "Kode POS tidak boleh kosong!", "error");
			return false;
		}

		return true;
	}

	function teleponValidate() {
		if ($("#notelepon").val() == "") {
			sweetAlert("Maaf...", "Nomor Telepon tidak boleh kosong!", "error");
			return false;
		}
		if ($("#keterangan").val() == "#") {
			sweetAlert("Maaf...", "Keterangan tidak boleh kosong!", "error");
			return false;
		}

		return true;
	}

	function rekeningValidate() {
		if ($("#namabank").val() == "") {
			sweetAlert("Maaf...", "Bank tidak boleh kosong!", "error");
			return false;
		}
		if ($("#cabangbank").val() == "#") {
			sweetAlert("Maaf...", "Cabang Bank tidak boleh kosong!", "error");
			return false;
		}
		if ($("#kotabank").val() == "#") {
			sweetAlert("Maaf...", "Kota Bank tidak boleh kosong!", "error");
			return false;
		}
		if ($("#norekening").val() == "#") {
			sweetAlert("Maaf...", "Nomor Rekening tidak boleh kosong!", "error");
			return false;
		}
		if ($("#atasnama").val() == "#") {
			sweetAlert("Maaf...", "Atas Nama tidak boleh kosong!", "error");
			return false;
		}

		return true;
	}

	function asuransiValidate() {
		if ($("#noasuransi").val() == "") {
			sweetAlert("Maaf...", "Nomor Asuransi tidak boleh kosong!", "error");
			return false;
		}
		if ($("#namaasuransi").val() == "#") {
			sweetAlert("Maaf...", "Nama Asuransi tidak boleh kosong!", "error");
			return false;
		}

		return true;
	}
</script>
