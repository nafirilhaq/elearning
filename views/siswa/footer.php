
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?php echo base_url();?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url();?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script>
  $(function () {
    $('#example1').DataTable({
      "language":{
        "url":"//cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
        "sEmptyTable":"Tidak Ada Data"
      }
    })
    $('#pesan_all').DataTable({
      "aaSorting": [[2, "desc"]],
      "columnDefs": [
            {
                "targets": [ 2 ],
                "visible": false,
                "searchable": false
            },
            {
                "orderable": false,
                "targets": "_all"
            }
        ],

      "language":{
        "url":"//cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
        "sEmptyTable":"Tidak Ada Data"
      }
    })
    $('#pesan_detail').DataTable({
      "aaSorting": [[2, "asc"]],
      "columnDefs": [
            {
                "targets": [ 2 ],
                "visible": false,
                "searchable": false
            },
            {
                "orderable": false,
                "targets": "_all"
            }
        ],

      "language":{
        "url":"//cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
        "sEmptyTable":"Tidak Ada Data"
      }
    })
  })
</script>

<!-- Sweetalert -->

  <!-- Sweetalert -->
<script src="<?php echo base_url();?>assets/dist/sweetalert.min.js"></script>

<script>
  $('.AlertaEliminarCliente').on("click", function(e) {
  e.preventDefault();
  var url = $(this).attr('href');
  swal({
      title: "Anda Yakin?",
      text: "Data yang sudah dihapus tidak dapat dikembalikan",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: '#DD6B55',
      confirmButtonText: 'Ya',
      cancelButtonText: "Batal",
      confirmButtonClass: "btn-danger",
      closeOnConfirm: false,
      closeOnCancel: false
    },
    function(isConfirm) {
      if (isConfirm) {
        swal("Berhasil!", "Data Berhasil Dihapus", "success");
        window.location.replace(url);
      } else {
        swal("Gagal!", "Data Gagal Dihapus", "error");
      }
    });
});
</script>
<!-- SlimScroll -->
<script src="<?php echo base_url();?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- CK Editor -->
<script src="<?php echo base_url();?>assets/bower_components/ckeditor/ckeditor.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url();?>assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url();?>assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->

<script src="<?php echo base_url();?>assets/dist/jquery_zoom/jquery.zoom.min.js"></script>
<script src="<?php echo base_url();?>assets/dist/countdown/jquery.countdownTimer.js"></script>
<script src="<?php echo base_url();?>assets/dist/js/aplikasi10.js"></script>

<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })
</script>
</body>
</html>
