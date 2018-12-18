<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- <script src="<?php echo base_url() ?>public/vendor/jquery/jquery.min.js"></script> -->
    <script src="<?php echo private_url() ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="<?php echo base_url() ?>public/vendor/popper/popper.min.js"></script>
    <script src="<?php echo base_url() ?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>public/bootstrap/js/material.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="<?php echo base_url() ?>public/bootstrap/js/holder.min.js"></script>
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
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
        // disable mousewheel on a input number field when in focus
        // (to prevent Cromium browsers change the value when scrolling)
        $('form').on('focus', 'input[type=number]', function (e) {
          $(this).on('mousewheel.disableScroll', function (e) {
            e.preventDefault()
          })
        })
        $('form').on('blur', 'input[type=number]', function (e) {
          $(this).off('mousewheel.disableScroll')
        })
    </script>