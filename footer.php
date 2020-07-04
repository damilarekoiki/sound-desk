<footer style="position:relative">
      <div class="container">
        <p>&copy; Koiki Damilare Final Year Project - SOUNDESK <?php echo date("Y");?>. All Rights Reserved.</p>
        <ul class="list-inline">
          <li class="list-inline-item">
          <a href="#">Privacy</a>
          </li>
          <li class="list-inline-item">
          <a href="#">Terms</a>
          </li>
          <li class="list-inline-item">
          <a href="#">FAQ</a>
          </li>
        </ul>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="assets/jquery/jquery.min.js"></script>
    <script src="assets/jquery-ui/jquery-ui.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="assets/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="assets/js/new-age.min.js"></script>
    <script src="assets/js/date-picker.js"></script>
    <script src="assets/js/jquery.custom-scrollbar.js"></script>
    <script src="assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="assets/js/select2.min.js"></script>
    <script src="assets/js/select2.full.min.js"></script>
    <script type="text/javascript" src="assets/tooltipster/dist/js/tooltipster.bundle.min.js"></script>
    <script src="assets/js/jquery.cropit.js"></script>
    <script src="audiojs/audiojs/audio.min.js"></script>
    <script src="assets/js/sweetalert.min.js"></script>
    <script src="assets/rateYo/src/jquery.rateyo.js"></script>
    <script src="assets/js/datatables.min.js"></script>
    <!-- <script src="assets/js/datatable-responsive.min.js"></script> -->


    <!-- <script src="assets/audio_player/demo/javascripts/all.js" type="text/javascript"></script> -->

    <script>
    $("#navSearchBtn").click(function() {
      $(".nav-text").hide(function(){
        $(".nav-search").show()
      })
    })

    $("#searchCancel").click(function(){
      $(".nav-search").hide(function(){
        $(".nav-text").show()
      })
    })
  </script>
