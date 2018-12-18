
    <!-- jQuery 2.1.4 -->
    <script src="<?php echo private_url() ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
   <!--  <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
 -->    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

    <script src="<?php echo private_url() ?>plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo private_url() ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">
      $(".datatable").DataTable();
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo private_url() ?>bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo private_url() ?>plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="<?php echo private_url() ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="<?php echo private_url() ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo private_url() ?>plugins/fastclick/fastclick.min.js"></script>
    
    <!-- AdminLTE App -->
    <script src="<?php echo private_url() ?>dist/js/app.min.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script type="text/javascript">
        function readURL(input, selector) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(selector).attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        
    </script>