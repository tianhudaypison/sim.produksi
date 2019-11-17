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
  $("#jumlahMesin").keyup(function() {
    var html = '';
    var length = $(this).val();
    for (var i = 0; i < length; i++) {
      html += '<div class="form-group row">';
      html += ' <label class="col-2 col-form-label">Mesin ' + (i+1) + '</label>';
      html += '   <div class="col-10">';
      html += '     <input type="hidden" class="form-control" placeholder="Keterangan Mesin ' + (i+1) + '" name="namamesin[]" value="">';
      html += '     <input type="text" class="form-control kapasitasMesin" placeholder="Kapasitas Mesin ' + (i+1) + '" name="kapasitasmesin[]" value="">';
      html += ' </div>';
      html += '</div>';

      $(".groupContent").html(html);
    }
  });

  $(document).on('keyup', ".kapasitasMesin", function() {
    console.log($(this).val());
    var sum = 0;
    $('.kapasitasMesin').each(function(){
        sum += parseFloat(this.value);
    });
    $("#totalKapasitas").val(sum);
  });
</script>
