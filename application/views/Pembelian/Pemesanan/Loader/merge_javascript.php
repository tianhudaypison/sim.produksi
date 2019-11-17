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
		$('#idPemesanan1').val(<?= $this->uri->segment(4) ?>);
		$('#idPemesanan1').trigger("change");

		$("#idPemesanan1").change(function() {
			$("#produkList tbody").html('');
			getDetailPemesanan($(this).val());

			$("#noPemesanan1").val($("#idPemesanan1 option:selected").text());
			$("#idRekanan").val($("#idPemesanan1 option:selected").data('idrekanan'));
			$("#idTerm").val($("#idPemesanan1 option:selected").data('idterm'));
			$("#kreditMaxBayar").val($("#idPemesanan1 option:selected").data('kreditmaxbayar'));
			$("#idTemplatePajak").val($("#idPemesanan1 option:selected").data('idtemplatepajak'));

			$.ajax({
	        type: "POST",
	        url: "{base_url}Pembelian/Pemesanan/getPemesananDraft2",
	        data: {
	          idpemesanan: $("#idPemesanan1 option:selected").val(),
	          idrekanan: $("#idPemesanan1 option:selected").data('idrekanan'),
	          idtemplatepajak: $("#idPemesanan1 option:selected").data('idtemplatepajak'),
	          idterm: $("#idPemesanan1 option:selected").data('idterm')
	        },
	        success: function (response) {
							$("#idPemesanan2").html(response);
	        }
	    });
		}).change();

		$("#idPemesanan2").change(function() {
			$("#produkList tbody").html('');
			getDetailPemesanan($("#idPemesanan1 option:selected").val());

			$("#noPemesanan2").val($("#idPemesanan2 option:selected").text());
			getDetailPemesanan($(this).val());
		});

		document.querySelector('#form').addEventListener('submit', function (e) {
			var form = this;

			if ($("#tanggal").val() == "") {
				e.preventDefault();
				sweetAlert("Maaf...", "Tanggal Transaksi tidak boleh kosong!", "error");
				return false;
			}

			var produkTable = $('table#produkList tbody tr').get().map(function (row) {
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

	function getDetailPemesanan(idpemesanan) {
		$.ajax({
				type: "GET",
				url: "{base_url}Pembelian/Pemesanan/getDetailPemesanan/" + idpemesanan,
				success: function (response) {
					$("#produkList").append(response);
					calculateTotal();
				}
		});
	}

	function calculateTotal() {
		var totalProduk = 0;
		var totalPemesanan = 0;
		var totalDiskonPemesanan = 0;
		var totalDiskonBonus = 0;
		var totalCashback = 0;
		var grandTotal = 0;

		$('#produkList tbody tr').each(function () {
			totalProduk += parseFloat($(this).find('td:eq(6)').text().replace(/\,/g, ""));
			totalPemesanan += parseFloat($(this).find('td:eq(7)').text().replace(/\,/g, ""));

			var discount = parseFloat($(this).find('td:eq(8)').text().replace(/\,/g, ""));
			totalDiskonPemesanan += totalPemesanan * (discount/100);

			var statusBonus = $(this).find('td:eq(10)').text();
			if(statusBonus == 1){
				totalDiskonBonus += parseFloat($(this).find('td:eq(7)').text().replace(/\,/g, ""));
			}

			var cashback = parseFloat($(this).find('td:eq(9)').text().replace(/\,/g, ""));
			totalCashback += totalProduk * cashback;

			grandTotal = totalPemesanan - totalDiskonPemesanan - totalDiskonBonus - totalCashback;
		});

		$("#totalProduk").val($.number(totalProduk));
		$("#totalPemesanan").val($.number(totalPemesanan));
		$("#totalDiskonPemesanan").val($.number(totalDiskonPemesanan));
		$("#totalDiskonBonus").val($.number(totalDiskonBonus));
		$("#totalCashback").val($.number(totalCashback));
		$("#grandTotal").val($.number(grandTotal));

		$("#summaryTotalProduk").html($.number(totalProduk));
		$("#summaryTotalPemesanan").html($.number(totalPemesanan));
		$("#summaryTotalDiskonPemesanan").html($.number(totalDiskonPemesanan));
		$("#summaryTotalDiskonBonus").html($.number(totalDiskonBonus));
		$("#summaryTotalCashback").html($.number(totalCashback));
		$("#summaryGrandTotal").html($.number(grandTotal));
	}
</script>
