 <?php if(is_null($this->session->userdata('typeuser'))){?>
 <?php header("Location:".'../../login/view',TRUE,301); } ?>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li><a href="/app/index.php/dashboard/artist">Profile</a></li>
            <li><a href="/app/index.php/dashboard/uploadArtWork">Upload <span class="sr-only">(current)</span></a></li>
            <li><a href="/app/index.php/dashboard/categories">Categories</a></li>
          </ul>
         
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <form  class="form-signup" name="upload" method="post" enctype="multipart/form-data">
             <br>
             <br>
            <div id="image-holder" class="placeholder">
            </div>
            <label class="control-label">Select file:</label>
            <br>
            <label class="btn btn-default btn-file">
                Browse <input id="image" name="work" type="file" hidden>
             </label>
             <br>
             <br>
             <br>
             <label>Description:</label>
             <textarea class="form-control" rows="2"  id="work_description" name="work_description"></textarea>
             <br>
            <input type="submit" class="btn btn-primary btn-file" value="Upload" name="submit">
          </form>
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
  <style type="text/css">
  /*
 * Base structure
 */

/* Move down content because we have a fixed navbar that is 50px tall */
body {
  padding-top: 50px;
  background-color: #35465c;
}


/*
 * Global add-ons
 */

.sub-header {
  padding-bottom: 10px;
  border-bottom: 1px solid #eee;
}
label{
  color: white;
}
/*
 * Top navigation
 * Hide default border to remove 1px line.
 */
.navbar-fixed-top {
  border: 0;
}


/*
 * Sidebar
 */

/* Hide for mobile, show later */
.sidebar {
  display: none;
}
@media (min-width: 768px) {
  .sidebar {
    position: fixed;
    top: 51px;
    bottom: 0;
    left: 0;
    z-index: 1000;
    display: block;
    padding: 20px;
    overflow-x: hidden;
    overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
    background-color: #f5f5f5;
  }
}

/* Sidebar navigation */
.nav-sidebar {
  margin-right: -21px; /* 20px padding + 1px border */
  margin-bottom: 20px;
  margin-left: -20px;
}
.nav-sidebar > li > a {
  padding-right: 20px;
  padding-left: 20px;
  color: white;
}
.nav-sidebar > .active > a,
.nav-sidebar > .active > a:hover,
.nav-sidebar > .active > a:focus {
  background-color: #428bca;
}
.sidebar{

  background-color: #2c3a4c;
}
.image-description{
  color:white;
}


/*
 * Main content
 */

.main {
  padding: 20px;
}
@media (min-width: 768px) {
  .main {
    padding-right: 40px;
    padding-left: 40px;
  }
}
.main .page-header {
  margin-top: 0;
}

.btn-file {
    position: relative;
    overflow: hidden;
    background-color:#FF5733;
    color:white;
}
.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background-color:#FF5733;
    cursor: inherit;
    display: block;
}

/*
 * Placeholder dashboard ideas
 */
li{
  color: white;
}
.placeholders {
  margin-bottom: 30px;
  text-align: center;
}
.placeholders h4 {
  margin-bottom: 0;
}
.placeholder {
  margin-bottom: 20px;
}
.placeholder img {
  display: inline-block;
}
/* leave this part out */
body{text-align:center; padding-top:30px;}
/* leave this part out */

</style>