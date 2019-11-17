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
		calculateTotal();

    $("#idRekanan").change(function () {
			if($("#idRekanan option:selected") != '' && $("#idTerm option:selected") != ''){
				$(".formProduk").show();
			} else{
				$(".formProduk").hide();
			}
		});

    $("#idTerm").change(function () {
			if ($(this).val() == 1) {
				$(".formTermKredit").hide();
			} else{
				$(".formTermKredit").show();
			}
		});

		$("#produkNonBonus").click(function () {
				$("#statusBonus").val(0);

				$("#produkNonBonus").addClass("active");
				$("#produkBonus").removeClass("active");
				$("#formCashback").show();
				$("#formDiscount").show();
		});

    $("#produkBonus").click(function () {
				$("#statusBonus").val(1);

				$("#produkNonBonus").removeClass("active");
				$("#produkBonus").addClass("active");
				$("#formCashback").hide();
				$("#formDiscount").hide();
		});

    $("#idProdukKemasan").change(function () {
      var idProdukKemasan = $("#idProdukKemasan option:selected").val();

      getSatuanProduk(idProdukKemasan);
		});

		$("#idSatuan").change(function () {
			var nilaiKonversi = $('#idSatuan option:selected').data('kuantitaskonversi');
			var kuantitasKonversi = parseFloat(nilaiKonversi) * parseFloat($("#kuantitasProduk").val());

			$("#kuantitasKonversi").val(kuantitasKonversi);
			$("#subTotal").val(kuantitasKonversi * $("#hargaBeli").val());
		});

		$("#hargaBeli").keyup(function () {
			var nilaiKonversi = $('#idSatuan option:selected').data('kuantitaskonversi');
			var kuantitasKonversi = parseFloat(nilaiKonversi) * parseFloat($("#kuantitasProduk").val());

			$("#kuantitasKonversi").val(kuantitasKonversi);
			$("#subTotal").val(kuantitasKonversi * $(this).val());
		});

		$("#kuantitasProduk").keyup(function () {
			var nilaiKonversi = $('#idSatuan option:selected').data('kuantitaskonversi');
			var kuantitasKonversi = parseFloat(nilaiKonversi) * parseFloat($("#kuantitasProduk").val());

			$("#kuantitasKonversi").val(kuantitasKonversi);
			$("#subTotal").val(kuantitasKonversi * $("#hargaBeli").val());
		});

		$("#produkAdd").click(function () {
			var valid = produkValidate();
			if (!valid) return false;
			if ($("#number").val() != '') {
				var number = $("#number").val();
				var content = "";
			} else {
				var number = $('#produkList tr').length;
				var content = "<tr>";
				$('#produkList tbody tr').filter(function () {
					var $cells = $(this).children('td');
				});
			}

			var idProdukKemasan = $("#idProdukKemasan  option:selected").val();
			var namaSatuan = $("#idSatuan option:selected").text();
			var statusBonus = ($("#statusBonus").val() == 1 ? 'Bonus' : 'Non Bonus');
			var discount = $("#discount").val();
			var cashback = $("#cashback").val();

			content += '<td hidden>' + number + '</td>';
			content += '<td colspan="2">' + getInfoTempProduk(idProdukKemasan, namaSatuan, statusBonus, discount, cashback) + '</td>';
			content += '<td hidden>' + idProdukKemasan; + '</td>';
      content += '<td hidden>' + $("#idSatuan option:selected").val(); + '</td>';
      content += '<td>' + $.number($("#hargaBeli").val()); + '</td>';
			content += '<td>' + $.number($("#kuantitasProduk").val()); + '</td>';
			content += '<td hidden>' + $.number($("#kuantitasKonversi").val()); + '</td>';
			content += '<td>' + $.number($("#subTotal").val()); + '</td>';
			content += '<td hidden>' + $.number(discount); + '</td>';
			content += '<td hidden>' + $.number(cashback); + '</td>';
			content += '<td hidden>' + $("#statusBonus").val(); + '</td>';
      content += '<td><div class="btn-group mb-2"><button type="button" class="btn btn-outline-primary waves-effect produkEdit"><i class="fa fa-pencil"></i> Ubah</button><button type="button" class="btn btn-outline-danger waves-effect produkRemove"><i class="fa fa-trash-o"></i> Hapus</button></div></td>';

			if ($("#rowindex").val() != '') {
				$('#produkList tbody tr:eq(' + $("#rowindex").val() + ')').html(content);
			} else {
				content += "</tr>";
				$('#produkList tbody').append(content);
			}

			calculateTotal();
			clearForm();
		});

		$(document).on("click", ".produkEdit", function () {
			getSatuanProduk($(this).closest('tr').find("td:eq(2)").html(), $(this).closest('tr').find("td:eq(3)").html());

			$("#rowindex").val($(this).closest('tr')[0].sectionRowIndex);
			$("#number").val($(this).closest('tr').find("td:eq(0)").html());
			$("#idProdukKemasan").select2('val', $(this).closest('tr').find("td:eq(2)").html());
			$("#idSatuan").select2('val', $(this).closest('tr').find("td:eq(3)").html());
      $("#hargaBeli").val($(this).closest('tr').find("td:eq(4)").html());
			$("#kuantitasProduk").val($(this).closest('tr').find("td:eq(5)").html());
			$("#kuantitasKonversi").val($(this).closest('tr').find("td:eq(6)").html());
			$("#subTotal").val($(this).closest('tr').find("td:eq(7)").html());
			$("#discount").val($(this).closest('tr').find("td:eq(8)").html());
			$("#cashback").val($(this).closest('tr').find("td:eq(9)").html());
			$("#statusBonus").val($(this).closest('tr').find("td:eq(10)").html());

			return false;
		});

		$(document).on("click", ".produkRemove", function () {
			if (confirm("Hapus data ?") == true) {
				$(this).closest('td').parent().remove();
			}
			calculateTotal();

			return false;
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

	function getSatuanProduk(idProdukKemasan, selected=0) {
    $("#idSatuan").html('<option value="0" data-kuantitaskonversi="0">Pilih Satuan</option>');

    $.ajax({
			url: '{base_url}Pembelian/Pemesanan/getSatuanProduk/' + idProdukKemasan,
      success: function (data) {
        $("#idSatuan").append(data);
      }
    });
	}

	function getInfoTempProduk(idProdukKemasan, namaSatuan, statusBonus, discount, cashback) {
    var content = '';

    $.ajax({
			url: '{base_url}Penjualan/SalesOrder/getInfoTempProduk/' + idProdukKemasan,
			async: false,
      dataType: 'json',
      success: function (data) {
        content += '<div class="card text-white bg-product">';
        content += '  <div class="card-body">';
        content += '    <blockquote class="card-bodyquote text-dark mb-0">';
        content += '      <div class="product-name"><strong><i class="fi-box"></i> ' + data.namaproduk + '</strong> <i>(' + data.namaperusahaan + ')</i></div>';
        content += '      <footer class="blockquote-footer text-dark small">Kemasan : ' + data.namakemasan + '</footer>';
        content += '      <footer class="blockquote-footer text-dark small">Satuan : ' + namaSatuan + '</footer>';
        content += '      <hr class="mt-1 mb-1">';
				content += '      <footer class="blockquote-footer text-dark small">Status : ' + statusBonus + '</footer>';

				if(statusBonus == 'Bonus') {
					content += '      <footer class="blockquote-footer text-dark small">Cashback : ' + cashback + '</footer>';
					content += '      <footer class="blockquote-footer text-dark small">Discount : ' + discount + '%</footer>';
				}

				content += '    </blockquote>';
        content += '  </div>';
        content += '</div>';
      }
    });

		return content;
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

	function clearForm() {
		$("#rowindex").val('');
		$("#number").val('');

		$("#idProdukKemasan").select2("val", "0");
		$("#idSatuan").select2("val", "0");
		$(".detail").val('');
	}

	function produkValidate() {
		if ($("#idRekanan").val() == "#") {
			sweetAlert("Maaf...", "Rekanan belum dipilih!", "error");
			return false;
		}

		if ($("#idTerm").val() == "#") {
			sweetAlert("Maaf...", "Term belum dipilih!", "error");
			return false;
		}
		return true;
	}
</script>
