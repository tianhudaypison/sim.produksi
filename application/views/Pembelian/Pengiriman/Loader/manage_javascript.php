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
	$(document).ready(function() {

		$("#pengirimanAdd").click(function(){
			var valid = pengirimanValidate();
			if(!valid) return false;
			if($("#number").val() != ''){
				var number = $("#number").val();
				var content = "";
			}else{
				var number = $('#pengirimanList tr').length;
				var content = "<tr>";
				$('#pengirimanList tbody tr').filter(function (){
					var $cells = $(this).children('td');
				});
			}

			content += "<td hidden>" + number + "</td>";
			content += "<td>" + $("#keterangan").val(); + "</td>";
			content += "<td>" + $("#noresi").val(); + "</td>";
			content += "<td>" + $.number($("#biaya").val()); + "</td>";
			content += '<td><div class="btn-group mb-2"><button type="button" class="btn btn-outline-primary waves-effect pengirimanEdit"><i class="fa fa-pencil"></i> Ubah</button><button type="button" class="btn btn-outline-danger waves-effect pengirimanRemove"><i class="fa fa-trash-o"></i> Hapus</button></div></td>';

			if($("#rowindex").val() != ''){
				$('#pengirimanList tbody tr:eq(' + $("#rowindex").val() + ')').html(content);
			}else{
				content += "</tr>";
				$('#pengirimanList tbody').append(content);
			}

			calculateTotal();
			clearForm();
		});

		$(document).on("click",".pengirimanEdit",function(){
			$("#rowindex").val($(this).closest('tr')[0].sectionRowIndex);
			$("#number").val($(this).closest('tr').find("td:eq(0)").html());

			$("#keterangan").val($(this).closest('tr').find("td:eq(1)").html());
			$("#noresi").val($(this).closest('tr').find("td:eq(2)").html());
			$("#biaya").val($(this).closest('tr').find("td:eq(3)").html());

			return false;
		});

		$(document).on("click",".pengirimanRemove",function(){
			if(confirm("Hapus data ?") == true){
				$(this).closest('td').parent().remove();
			}
			return false;
		});

		document.querySelector('#from').addEventListener('submit', function(e) {
			var form = this;

			if($("#idPenerimaan").val() == "0"){
				e.preventDefault();
				sweetAlert("Maaf...", "No. Penerimaan Pusat belum dipilih!", "error");
				return false;
			}

			var pengirimanTabel = $('table#pengirimanList tbody tr').get().map(function(row) {
				return $(row).find('td').get().map(function(cell) {
				return $(cell).html();
				});
			});

			$("#pengirimanValue").val(JSON.stringify(pengirimanTabel));

			swal({
				title: "Berhasil!",
				text: "Proses penyimpanan data.",
				type: "success",
				timer: 1500,
				showConfirmButton: false
			});
		});

		function clearForm(){
			$("#rowindex").val('');
			$("#number").val('');
			$(".detail").val('');
		}

		function pengirimanValidate(){
			if($("#keterangan").val() == ""){
				sweetAlert("Maaf...", "Keterangan tidak boleh kosong!", "error");
				return false;
			}
			if($("#noresi").val() == ""){
				sweetAlert("Maaf...", "No. Resi tidak boleh kosong!", "error");
				return false;
			}
			if($("#biaya").val() == ""){
				sweetAlert("Maaf...", "Biaya tidak boleh kosong!", "error");
				return false;
			}
			return true;
		}

		function calculateTotal() {
			var totalpengiriman = 0;
			$('#pengirimanList tbody tr').each(function() {
				totalpengiriman += parseFloat($(this).find('td:eq(3)').html().replace(/,/g, ''));
			});
			$("#totalPengiriman").val($.number(totalpengiriman));
		}

	});
</script>
