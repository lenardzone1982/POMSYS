  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <div class="row p-3">
      <div class="col-lg-4 col-md-6 col-sm-6 col-12 bg-white">
        <label>Barangay Mission</label>
        <p class="text-sm text-justify text-muted">Barangay Calapacuan is dedicated to deliver effective, efficient, & respectful public service with pride, integrity, & accountability by involving our constituents and stakeholders towards the  accomplishments of our goals.</p>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-6 col-12 bg-white">
        <label>Barangay Vision</label>
        <p class="text-sm text-justify text-muted">We envisioned to be a Clean and Green, Organized, Peaceful, God-Fearing and a Progressive Barangay.</p>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-6 col-12 bg-white">
        <label>Contact Us</label>
        <p class="text-sm text-justify text-muted"><i class="fa-solid fa-phone"></i> +63 9776032531</p>
        <p class="text-sm text-justify text-muted"><i class="fa-solid fa-envelope"></i> admin@gmail.com</p>
      </div>
    </div>
    <div class="dropdown-divider"></div>
    <strong>Copyright &copy; 2025 <a href="#">POMSYS</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="dist/js/demo.js"></script> -->
<!-- jquery-validation -->
<script src="plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="plugins/jquery-validation/additional-methods.min.js"></script>
</body>
</html>

<?php include 'sweetalert_messages.php'; ?>

<!-- AUTO LOGOUT AFTER 5 MINS // OTHER CODE CAN BE SEEN IN NAVBAR.PHP(USER_AUTH.PHP)-->
<script>
  setInterval(function(){
    check_user();
  },1000);
  function check_user(){
    jQuery.ajax({
      url:'user_auth.php',
      type:'post',
      data:'type=ajax',
      success:function(result){
        if(result=='logout'){
          window.location.href='logout.php?page=exit';
        }
      }
      
    });
  }
</script>
<!-- AUTO LOGOUT AFTER 5 MINS // OTHER CODE CAN BE SEEN IN NAVBAR.PHP(USER_AUTH.PHP)-->