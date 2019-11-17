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
		$('#idPemesanan').val(<?= $this->uri->segment(4) ?>);
		$('#idPemesanan').trigger("change");

		$("#idPemesanan").change(function() {
			getDetailPemesanan($(this).val());

			$("#noPemesanan").val($("#idPemesanan option:selected").text());
			$("#idRekanan").val($("#idPemesanan option:selected").data('idrekanan'));
			$("#idTerm").val($("#idPemesanan option:selected").data('idterm'));
			$("#kreditMaxBayar").val($("#idPemesanan option:selected").data('kreditmaxbayar'));
			$("#idTemplatePajak").val($("#idPemesanan option:selected").data('idtemplatepajak'));
		}).change();

		$(document).on("keyup", ".kuantitasProduk", function() {
			var kuantitas = parseFloat($(this).val().replace(/\,/g, ""));
			var hargaBeli = parseFloat($(this).closest('tr').find('td:eq(4)').text().replace(/\,/g, ""));

			$(this).closest('tr').find("td:eq(7)").html($.number(parseFloat(kuantitas) * parseFloat(hargaBeli)));
		});

		$(document).on("click", ".produkSplit", function() {
			var $tr = $(this).closest('tr');
	    var $clone = $tr.clone().find('td:last-child').remove().end();

			$('#produkList2 tbody').append($clone);

			// // Process Split
			var hargaBeli = $(this).closest('tr').find("td:eq(4)").html().replace(/\,/g, "");
			var kuantitasBefore = $(this).closest('tr').find("td:eq(5)").html().replace(/\,/g, "");
			var kuantitasAfter = $(this).closest('tr').find("td:eq(6) input").val().replace(/\,/g, "");

			$(this).closest('tr').find("td:eq(6) input").val($.number(parseFloat(kuantitasBefore)-parseFloat(kuantitasAfter)));
			$(this).closest('tr').find("td:eq(7)").html($.number(parseFloat(hargaBeli) * (parseFloat(kuantitasBefore)-parseFloat(kuantitasAfter))));

			$('#produkList2 tbody tr').find("td:eq(7)").html($.number(parseFloat(hargaBeli) * parseFloat(kuantitasAfter)));

			calculateTotal1();
			calculateTotal2();
		});

		document.querySelector('#form').addEventListener('submit', function (e) {
			var form = this;

			if ($("#tanggal").val() == "") {
				e.preventDefault();
				sweetAlert("Maaf...", "Tanggal Transaksi tidak boleh kosong!", "error");
				return false;
			}

			var produkTable1 = $('table#produkList1 tbody tr').get().map(function (row) {
				return $(row).find('td').get().map(function(cell) {
					if($(cell).find("input").length >= 1){
							return $(cell).find("input").val();
					}else{
							return $(cell).html();
					}
				});
			});

			var produkTable2 = $('table#produkList2 tbody tr').get().map(function (row) {
				return $(row).find('td').get().map(function(cell) {
					if($(cell).find("input").length >= 1){
							return $(cell).find("input").val();
					}else{
							return $(cell).html();
					}
				});
			});

			$("#produkValue1").val(JSON.stringify(produkTable1));
			$("#produkValue2").val(JSON.stringify(produkTable2));

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
				url: "{base_url}Pembelian/Pemesanan/getDetailPemesanan/" + idpemesanan + '/1',
				success: function (response) {
					$("#produkList1").append(response);
          $(".number").number( true, 0 );
					calculateTotal1();
				}
		});
	}

	function calculateTotal1() {
		var totalProduk = 0;
		var totalPemesanan = 0;
		var totalDiskonPemesanan = 0;
		var totalDiskonBonus = 0;
		var totalCashback = 0;
		var grandTotal = 0;

		$('#produkList1 tbody tr').each(function () {
			totalProduk += parseFloat($(this).find('td:eq(6) input').val().replace(/\,/g, ""));
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

		console.log(totalProduk);
		console.log(totalPemesanan);
		console.log(totalDiskonPemesanan);
		console.log(totalDiskonBonus);
		console.log(totalCashback);
		console.log(grandTotal);

		$("#totalProduk1").val($.number(totalProduk));
		$("#totalPemesanan1").val($.number(totalPemesanan));
		$("#totalDiskonPemesanan1").val($.number(totalDiskonPemesanan));
		$("#totalDiskonBonus1").val($.number(totalDiskonBonus));
		$("#totalCashback1").val($.number(totalCashback));
		$("#grandTotal1").val($.number(grandTotal));

		$("#summaryTotalProduk1").html($.number(totalProduk));
		$("#summaryTotalPemesanan1").html($.number(totalPemesanan));
		$("#summaryTotalDiskonPemesanan1").html($.number(totalDiskonPemesanan));
		$("#summaryTotalDiskonBonus1").html($.number(totalDiskonBonus));
		$("#summaryTotalCashback1").html($.number(totalCashback));
		$("#summaryGrandTotal1").html($.number(grandTotal));
	}

	function calculateTotal2() {
		var totalProduk = 0;
		var totalPemesanan = 0;
		var totalDiskonPemesanan = 0;
		var totalDiskonBonus = 0;
		var totalCashback = 0;
		var grandTotal = 0;

		$('#produkList2 tbody tr').each(function () {
			totalProduk += parseFloat($(this).find('td:eq(6) input').val().replace(/\,/g, ""));
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

		$("#totalProduk2").val($.number(totalProduk));
		$("#totalPemesanan2").val($.number(totalPemesanan));
		$("#totalDiskonPemesanan2").val($.number(totalDiskonPemesanan));
		$("#totalDiskonBonus2").val($.number(totalDiskonBonus));
		$("#totalCashback2").val($.number(totalCashback));
		$("#grandTotal2").val($.number(grandTotal));

		$("#summaryTotalProduk2").html($.number(totalProduk));
		$("#summaryTotalPemesanan2").html($.number(totalPemesanan));
		$("#summaryTotalDiskonPemesanan2").html($.number(totalDiskonPemesanan));
		$("#summaryTotalDiskonBonus2").html($.number(totalDiskonBonus));
		$("#summaryTotalCashback2").html($.number(totalCashback));
		$("#summaryGrandTotal2").html($.number(grandTotal));
	}
</script>
