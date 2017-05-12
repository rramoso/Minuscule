 <?php if(is_null($this->session->userdata('typeuser'))){?>
 <?php header("Location:".'../../login/view',TRUE,301); } ?>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <!-- BEGIN VENDOR JS -->
    <script src="../../assets/plugins/modernizr.custom.js" type="text/javascript"></script>
    <script src="../../assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <!-- END VENDOR JS -->
    <!-- BEGIN CORE TEMPLATE JS -->
    <script src="../../pages/js/pages.min.js"></script>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">ALL CATEGORIES</h1>
          <div > 
            <div class="row placeholders">
              <div class="row">
                <?php foreach($categories as $category){?>
                <a onClick="setCategory(this);" id = "<?php echo $category->initials?> "href="/app/index.php/dashboard/category">
                  <div class="hvr-radial-in box">
                    <h1><?php echo $category->name ?></h1>
                  </div>
                </a>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
     

<script type="text/javascript">
function setCategory(elem){
     
      $.ajax({
                url: "<?php echo 'https://'.site_url('index.php/dashboard/setCategory')?>",
                type: 'POST',
                data: {categoryInitials: elem.id},
                dataType: "text",
                cache:false
          });
    }
</script>
<script type="text/javascript">
$(document).ready(function() {
    var myColors = [
        '#ffc247', '#47ffa5', '#c547ff',
        '#47afff','#ece3fc', '#fce3e3',
        '#b0ffb4','#fffd27'
    ];
    var i = 0;
    $('div.box').each(function() {
        $(this).css('background-color', myColors[i]);
        i = (i + 1) % myColors.length;
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
.box{
  width: auto;
  min-width: 233px;
  padding-top: 50px;
  height: 200px;
}
.hvr-radial-in {
  display: inline-block;
  vertical-align: middle;
  -webkit-transform: translateZ(0);
  transform: translateZ(0);
  box-shadow: 0 0 1px rgba(0, 0, 0, 0);
  -webkit-backface-visibility: hidden;
  backface-visibility: hidden;
  -moz-osx-font-smoothing: grayscale;
  position: relative;
  overflow: hidden;
  background: #2098d1;
  -webkit-transition-property: color;
  transition-property: color;
  -webkit-transition-duration: 0.3s;
  transition-duration: 0.3s;
}
.hvr-radial-in:before {
  content: "";
  position: absolute;
  z-index: -1;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: #e1e1e1;
  border-radius: 100%;
  -webkit-transform: scale(2);
  transform: scale(2);
  -webkit-transition-property: transform;
  transition-property: transform;
  -webkit-transition-duration: 0.3s;
  transition-duration: 0.3s;
  -webkit-transition-timing-function: ease-out;
  transition-timing-function: ease-out;
}
.hvr-radial-in:hover, .hvr-radial-in:focus, .hvr-radial-in:active {
  color: white;
}
.hvr-radial-in:hover:before, .hvr-radial-in:focus:before, .hvr-radial-in:active:before {
  -webkit-transform: scale(0);
  transform: scale(0);
}

/*
 * Global add-ons
 */

.sub-header {
  padding-bottom: 10px;
  border-bottom: 1px solid #eee;
  color: white;
  text-align: center;
  text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;
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
.crop {width:100px;overflow:hidden;height:50px;line-height:50px;color:white;}​
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
.nickname{
  color: white;
}
.manifesto{
  color: antiquewhite;
}
.main {
  padding: 20px;
}
@media (min-width: 768px) {
  .main {
    padding-right: 40px;
    padding-left: 40px;
  }
}
.modal-title{
  text-align: center;
}
.modal-content{
  position: relative;
    overflow-y: auto;
    padding: 15px;
}
#work_image img{
  display:block;
  margin:auto;
}

.main .page-header {
  color: white;
  background-color: tomato;
  text-align: center;
  margin-top: 0;
  border-bottom: 1px solid #35465c;
}
.artist-info{
    background-color: cadetblue;
}

.artwork{
  background-color: cadetblue;
}
/*
 * Placeholder dashboard ideas
 */

.placeholders {
  margin-bottom: 30px;
  text-align: center;
}


.placeholders a{
  color: black;
  text-align: center; 
  text-decoration: none;
}
.placeholders h4 {
  margin-bottom: 0;
}
.placeholder {

    padding-left: 20px;
    padding-right: 0px;
  margin-top: 20px;
  margin-bottom: 20px;
}
.placeholder img {
  display: inline-block;
  border-radius: 50%;
}
</style>