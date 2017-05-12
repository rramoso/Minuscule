 <?php if(is_null($this->session->userdata('typeuser'))){?>
 <?php header("Location:".'../../login/view',TRUE,301); } ?>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

      <!-- BEGIN VENDOR JS -->
    <script src="../../assets/plugins/pace/pace.min.js" type="text/javascript"></script>
    <script src="../../assets/plugins/jquery/jquery-1.11.1.min.js" type="text/javascript"></script>
    <script src="../../assets/plugins/modernizr.custom.js" type="text/javascript"></script>
    <script src="../../assets/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
    <script src="../../assets/plugins/bootstrapv3/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="../../assets/plugins/jquery/jquery-easy.js" type="text/javascript"></script>
    <script src="../../assets/plugins/jquery-unveil/jquery.unveil.min.js" type="text/javascript"></script>
    <script src="../../assets/plugins/jquery-bez/jquery.bez.min.js"></script>
    <script src="../../assets/plugins/jquery-ios-list/jquery.ioslist.min.js" type="text/javascript"></script>
    <script src="../../assets/plugins/jquery-actual/jquery.actual.min.js"></script>
    <script src="../../assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <script type="text/javascript" src="../../assets/plugins/select2/js/select2.full.min.js"></script>
    <script type="text/javascript" src="../../assets/plugins/classie/classie.js"></script>
    <script src="../../assets/plugins/switchery/js/switchery.min.js" type="text/javascript"></script>
    <script src="../../assets/plugins/bootstrap3-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <script type="text/javascript" src="../../assets/plugins/jquery-autonumeric/autoNumeric.js"></script>
    <script type="text/javascript" src="../../assets/plugins/dropzone/dropzone.min.js"></script>
    <script type="text/javascript" src="../../assets/plugins/bootstrap-tag/bootstrap-tagsinput.min.js"></script>
    <script type="text/javascript" src="../../assets/plugins/jquery-inputmask/jquery.inputmask.min.js"></script>
    <script src="../../assets/plugins/bootstrap-form-wizard/js/jquery.bootstrap.wizard.min.js" type="text/javascript"></script>
    <script src="../../assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
    <script src="../../assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
    <script src="../../assets/plugins/summernote/js/summernote.min.js" type="text/javascript"></script>
    <script src="../../assets/plugins/moment/moment.min.js"></script>
    <script src="../../assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="../../assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
    <script src="../../assets/plugins/bootstrap-typehead/typeahead.bundle.min.js"></script>
    <script src="../../assets/plugins/bootstrap-typehead/typeahead.jquery.min.js"></script>
    <script src="../../assets/plugins/handlebars/handlebars-v4.0.5.js"></script>
    <!-- END VENDOR JS -->
    <!-- BEGIN CORE TEMPLATE JS -->
    <script src="../../pages/js/pages.min.js"></script>
    <script src="../../assets/plugins/dropzone/dropzone.min.js" type="text/javascript"></script>
    <!-- END CORE TEMPLATE JS -->
    <!-- BEGIN PAGE LEVEL JS -->
    <script src="../../assets/js/form_elements.js" type="text/javascript"></script>
    <script src="../../assets/js/scripts.js" type="text/javascript"></script>
  
      <div class="page-content-wrapper ">
        <!-- START PAGE CONTENT -->
        <div class="content ">
          <div class="container-fluid container-fixed-lg">
            <div class="row">
              <div class="col-sm-12">
                <div class="panel panel-default">
                  <div class="panel-body">
                    <form name="upload" method="post" enctype="multipart/form-data">
                       <br>
                       <br>
                      <div id="image-holder" class="placeholder">
                      </div>
                      <br>
                      <label class="control-label">Select file:</label>
                      
                      <br>
                      <label class="btn btn-default btn-file">
                          Browse <input id="image" name="work" type="file" hidden>
                       </label>
                       <br>

                       <label>Description:</label>
                       <textarea class="form-control" rows="2"  id="work_description" name="work_description"></textarea>
                       <br>
                      <input type="submit" class="btn btn-primary btn-file" value="Upload" name="submit">
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
 
<script>
$(document).ready(function() {
        $("#image").on('change', function() {
          //Get count of selected files
          var countFiles = $(this)[0].files.length;
          var imgPath = $(this)[0].value;
          var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
          var image_holder = $("#image-holder");
          image_holder.empty();
          if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
            if (typeof(FileReader) != "undefined") {
              //loop for each file selected for uploaded.
              for (var i = 0; i < countFiles; i++) 
              {
                var reader = new FileReader();
                reader.onload = function(e) {
                  $("<img />", {
                    "src": e.target.result,
                    "class": "thumb-image",
                    "widht":"200px",
                    "height":"200px"
                  }).appendTo(image_holder);
                }
                image_holder.show();
                reader.readAsDataURL($(this)[0].files[i]);
              }
            } else {
              alert("This browser does not support FileReader.");
            }
          } else {
            alert("Pls select only images");
          }
        });
      });
</script>
