
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" href="<?php echo base_url();?>assets/comp/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="<?php echo base_url();?>assets/comp/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link type="text/css" href="<?php echo base_url();?>assets/themes/default/css/theme.css" rel="stylesheet">
    <link type="text/css" href="<?php echo base_url();?>assets/comp/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link type="text/css" href="<?php echo base_url();?>assets/comp/pace/flash.css" rel="stylesheet">
    <link type="text/css" href="<?php echo base_url();?>assets/comp/offline/offline-theme-chrome.css" rel="stylesheet">
    <link type="text/css" href="<?php echo base_url();?>assets/comp/jcounter/css/jquery.jCounter-iosl.css" rel="stylesheet">
    <link type="text/css" href="<?php echo base_url();?>assets/comp/RichFilemanager/styles/dialog.css" rel="stylesheet">
    <link type="text/css" href="<?php echo base_url();?>assets/comp/ckeditor/plugins/codesnippet/lib/highlight/styles/monokai.css" rel="stylesheet">

    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>assets/images/favicon.ico">
    <link type="text/css" href="<?php echo base_url();?>assets/themes/default/css/read.css" rel="stylesheet">
    <link type="text/css" href="<?php echo base_url();?>assets/themes/default/css/ujian.css" rel="stylesheet">
    <script src="<?php echo base_url();?>assets/bower_components/jquery/dist/jquery-3.3.1.min" type="text/javascript"></script>

    <script>
window.addEventListener("beforeunload", function(event) {
    event.returnValue = "Write something clever here..";
});
</script>
</head>

<body>
    
    <div id="wrap">
    <div class="container">
        <div class="row-fluid">
            <div class="span9">
                <h1 class="title">Tugas</h1>
            </div>
            <div class="span3">
                <ul class="unstyled inline pull-right user-info">
                    <li><b>Alfa</b></li>
                    <li><img src="<?php echo base_url();?>userfiles/images/default_siswa.png" class="nav-avatar img-polaroid img-circle" /></li>
                </ul>
            </div>
        </div>

        <hr class="hr-top">
        <div class="wrap-content">
            <div class="content">
                <div class="row-fluid">
                    <div class="span8">
                        <b>Informasi : </b><br>
                        <p>Apakah</p>

                    </div>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Pertanyaan  dan Pilihan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($soal->result_array() as $soal) {
                        ?>
                        <tr id="pertanyaan">
                            <td><b>1.</b></td>
                            <td>
                                <div class="pertanyaan">
                                    <p><?php echo $soal['pertanyaan']; ?></p>
                                </div>

                                <div id="pilihan">
                                <table class="table table-condensed table-striped">
                                    <tbody>
                                        <tr>
                                            <td width="5%"><label class="label-radio"><input type="radio" name="pilihan-2" value="1"> A</label></td>
                                            <td>
                                                <p><?php echo $soal['pil_a']; ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="5%"><label class="label-radio"><input type="radio" name="pilihan-2" value="1"> A</label></td>
                                            <td>
                                                <p><?php echo $soal['pil_b']; ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="5%"><label class="label-radio"><input type="radio" name="pilihan-2" value="1"> A</label></td>
                                            <td>
                                                <p><?php echo $soal['pil_c']; ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="5%"><label class="label-radio"><input type="radio" name="pilihan-2" value="1"> A</label></td>
                                            <td>
                                                <p><?php echo $soal['pil_d']; ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="5%"><label class="label-radio"><input type="radio" name="pilihan-2" value="1"> A</label></td>
                                            <td>
                                                <p><?php echo $soal['pil_e']; ?></p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <div class="well well-sm">
                    <p class="p-info">Periksa kembali jawaban anda sebelum mengahiri pengerjaan tugas ini.</p>
                    <button type="button" class="btn btn-large btn-primary" data-toggle="modal" data-target="#selesai-mengerjakan">
                        Selesai Mengerjakan
                    </button>
                </div>

                <div class="modal fade" id="selesai-mengerjakan" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                Anda yakin ingin mengahiri pengerjaan tugas ini?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Nanti dulu</button>
                                <a class="btn btn-primary" href="<?php echo base_url();?>index.php/tugas/finish/2/10b4950f1941b963b7d6b9a5302140ea46975" id="btn-submit">Ya, saya sudah selesai</a>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
<br><br>
<!--/.wrapper-->
<div class="footer">
    <div class="container">
        <center>
            <b class="copyright">Copyright &copy; 2014 - 2018 SMP Tunas Unggul by Almazari - <a href="http://www.dokumenary.net">dokumenary.net</a> </b> All rights reserved.<br>
            <a href="https://github.com/almazary/skripsi">versi 2.0</a> | Page loaded in 0.2819 seconds.
        </center>
    </div>
</div>


<script>
window.onbeforeunload = function() {
   if (data_needs_saving()) {
       return "Do you really want to leave our brilliant application?";
   } else {
      return;
   }
};
</script>

<script src="<?php echo base_url();?>assets/comp/jquery/jquery.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/comp/jquery/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
<script data-pace-options='{ "ajax": false }' src="<?php echo base_url();?>assets/comp/pace/pace.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/comp/offline/offline.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/comp/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/comp/jcounter/js/jquery.jCounter-0.1.4.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/comp/jquery/ujian.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/comp/ckeditor/plugins/codesnippet/lib/highlight/highlight.pack.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/comp/ckeditor/plugins/ckeditor_wiris/integration/WIRISplugins.js?viewer=image" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/comp/timeago/jquery.timeago.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/comp/jquery/app.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>assets/themes/default/scripts/script.js" type="text/javascript"></script>


</body>
</html>
