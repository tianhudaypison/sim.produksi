<script src="{plugins_path}switchery/switchery.min.js"></script>
<script src="{plugins_path}bootstrap-tagsinput/js/bootstrap-tagsinput.min.js"></script>
<script src="{plugins_path}select2/js/select2.min.js" type="text/javascript"></script>
<script src="{plugins_path}bootstrap-select/js/bootstrap-select.js" type="text/javascript"></script>
<script src="{plugins_path}bootstrap-filestyle/js/bootstrap-filestyle.min.js" type="text/javascript"></script>
<script src="{plugins_path}bootstrap-maxlength/bootstrap-maxlength.js" type="text/javascript"></script>

<!-- plugin js -->
<script src="{plugins_path}moment/moment.js"></script>
<script src="{plugins_path}bootstrap-timepicker/bootstrap-timepicker.js"></script>
<script src="{plugins_path}bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="{plugins_path}clockpicker/js/bootstrap-clockpicker.min.js"></script>
<script src="{plugins_path}bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="{plugins_path}bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

<!-- Modal-Effect -->
<script src="{plugins_path}custombox/js/custombox.min.js"></script>
<script src="{plugins_path}custombox/js/legacy.min.js"></script>

<!-- Init Js file -->
<script src="{assets_path}pages/jquery.form-pickers.init.js"></script>
<script type="text/javascript" src="{assets_path}pages/jquery.form-advanced.init.js"></script>
<script type="text/javascript">
	$(document).ready(function () {

		$(document).on("click", ".produkEdit", function () {
      var idProdukKemasan = $(this).data('idprodukkemasan');
      var kuantitasPemesanan = $(this).data('kuantitasmax');
      var stBonus = $(this).data('stbonus');

			$("#idProdukKemasanDetail").val(idProdukKemasan);
			$("#kuantitasPemesanan").val(kuantitasPemesanan);
			$("#stBonus").val(stBonus);

      getSatuanProduk(idProdukKemasan);
		});

		$("#idSatuan").change(function () {
			var nilaiKonversi = $('#idSatuan option:selected').data('kuantitaskonversi');
			var kuantitasKonversi = parseFloat(nilaiKonversi) * parseFloat($("#kuantitasProduk").val());

			$("#kuantitasKonversi").val(kuantitasKonversi);
		});

		$("#kuantitasProduk").keyup(function () {
			var nilaiKonversi = $('#idSatuan option:selected').data('kuantitaskonversi');
			var kuantitasKonversi = parseFloat(nilaiKonversi) * parseFloat($("#kuantitasProduk").val());

			$("#kuantitasKonversi").val(kuantitasKonversi);
		});

		$("#produkDetailAdd").click(function () {
			var idProdukKemasan = $('#idProdukKemasanDetail').val();
			var kuantitasPenerimaan = $("#kuantitasKonversi").val();
			var kuantitasPemesanan = $('#kuantitasPemesanan').val();

			var valid = produkDetailValidate(idProdukKemasan, kuantitasPemesanan, kuantitasPenerimaan);
			if (!valid) return false;
			if ($("#numberDetail").val() != '') {
				var number = $("#numberDetail").val();
				var content = "";
			} else {
				var number = $('#produkDetailList tr').length;
				var content = "<tr>";
				$('#produkDetailList tbody tr').filter(function () {
					var $cells = $(this).children('td');
				});
			}

			var idProdukKemasan = $("#idProdukKemasanDetail").val();

			content += '<td hidden>' + number + '</td>';
			content += '<td hidden>' + idProdukKemasan + '</td>';
      content += '<td hidden>' + $("#idSatuan option:selected").val(); + '</td>';
      content += '<td>' + $("#idSatuan option:selected").text(); + '</td>';
			content += '<td>' + $.number($("#kuantitasProduk").val()); + '</td>';
			content += '<td hidden>' + $.number($("#kuantitasKonversi").val()); + '</td>';
			content += '<td hidden>' + $("#stBonus").val(); + '</td>';
      content += '<td><div class="btn-group mb-2"><button type="button" class="btn btn-outline-danger waves-effect produkDetailRemove"><i class="fa fa-trash-o"></i> Hapus</button></div></td>';

			if ($("#rowIndexDetail").val() != '') {
				$('#produkDetailList tbody tr:eq(' + $("#rowIndexDetail").val() + ')').html(content);
			} else {
				content += "</tr>";
				$('#produkDetailList tbody').append(content);
			}

			clearFormDetail();
		});

		$(document).on("click", ".produkDetailRemove", function () {
			if (confirm("Hapus data ?") == true) {
				$(this).closest('td').parent().remove();
			}

			return false;
		});

		document.querySelector('#form').addEventListener('submit', function (e) {
			var form = this;

			if ($("#tanggal").val() == "") {
				e.preventDefault();
				sweetAlert("Maaf...", "Tanggal Transaksi tidak boleh kosong!", "error");
				return false;
			}

			if ($("#idGudang").val() == "") {
				e.preventDefault();
				sweetAlert("Maaf...", "Gudang belum dipilih!", "error");
				return false;
			}

			var produkTable = $('table#produkDetailList tbody tr').get().map(function (row) {
				return $(row).find('td').get().map(function (cell) {
					return $(cell).html();
				});
			});

			$("#produkValue").val(JSON.stringify(produkTable));

			swal({
				title: "Berhasil!",
				text: "Proses penyimpanan data.",
				type: "success",
				timer: 1500,
				showConfirmButton: false
			});
		});
  });

	function getSatuanProduk(idProdukKemasan, selected=0) {
    $("#idSatuan").html('<option value="0" data-kuantitaskonversi="0">Pilih Satuan</option>');

    $.ajax({
			url: '{base_url}Pembelian/Pemesanan/getSatuanProduk/' + idProdukKemasan,
      success: function (data) {
        $("#idSatuan").append(data);
      }
    });
	}

	function clearFormDetail() {
		$("#rowIndexDetail").val('');
		$("#numberDetail").val('');

		$("#kuantitasProduk").val(0);
		$("#kuantitasKonversi").val(0);
	}

	function produkDetailValidate(idProdukKemasan, kuantitasPemesanan, kuantitasPenerimaan) {
		var xkuantitasPenerimaan = 0;

		$('#produkDetailList tbody tr').each(function () {
			if($(this).find('td:eq(1)').text().replace(/\,/g, "") == idProdukKemasan){
				xkuantitasPenerimaan += parseFloat($(this).find('td:eq(5)').text().replace(/\,/g, ""));
			}
		});

		var totalPenerimaan = (parseFloat(kuantitasPenerimaan) + parseFloat(xkuantitasPenerimaan));

		// if(totalPenerimaan > kuantitasPemesanan) {
		// 	sweetAlert("Maaf...", "Produk melebihi kuantitas pemesanan!", "error");
		// 	return false;
		// }

		if($("#kuantitasProduk").val() == "" || $("#kuantitasProduk").val() == 0){
			sweetAlert("Maaf...", "Kuantitas Produk tidak boleh kosong!", "error");
			return false;
		}

		return true;
	}
</script>
