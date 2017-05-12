 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <div id="curatorId" value="<?php echo $curator_id?>" class="container-fluid">
      <div class="row">
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Artist database</h1>
          <h4 class="sub-header"><?php echo "All artists"?></h4>
          <div class="table-responsive">          
            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Favorite</th>
                  <th>Artist Name</th>
                  <th>Category</th>
                  <th>Tumblr URL</th>
                  <th>Email</th>
                </tr>
              </thead>
              <tfoot>
                <tr> 
                  <p><?php echo $links; ?></p>
                </tr>
              </tfoot>
              <tbody>
                <?php foreach ($artists as $artist) {?>
                  <tr>
                    <td>
                      <?php if($this->curator_model->isFollowing($curator_id,$artist['artist']->id)){?>
                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                      <?php }else {?>
                      <div id="<?php echo 'artist_'.$artist['artist']->id ?>">
                        <button onClick="setFavorite(this)" value="<?php echo $artist['artist']->id ?>" type="button" class="btn btn-default btn-lg">
                          <span class="glyphicon glyphicon-star" aria-hidden="true"></span> Favorite
                        </button>
                      </div>     
                 <?php } ?>
                    </td>
                    <td>
                      <?php echo $artist['artist']->nickname ?>
                    </td>
                    <td>
                      <?php foreach($artist['categories'] as $category){?>
                        <a onClick="setCategory(this);" id = "<?php echo $category?>" href="/app/index.php/dashboard/category"><span class="badge"><?php echo $category ?></span></a>
                        <?php } ?>
                    </td>
                    <td>
                      <?php echo $artist['user']->websitelink ?>
                    </td>
                    <td>
                      <?php echo $artist['user']->email ?>
                    </td>
                  </tr>       
               <?php }?>
               
              </tbody>
            </table>
            </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div id="work_description" class="modal-body">
          <p>Some text in the modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div></div>
 <!-- BEGIN VENDOR JS -->
    <script src="../../assets/plugins/nvd3/lib/d3.v3.js" type="text/javascript"></script>
    <script src="../../assets/plugins/nvd3/nv.d3.min.js" type="text/javascript"></script>
    <script src="../../assets/plugins/nvd3/src/utils.js" type="text/javascript"></script>
    <script src="../../assets/plugins/nvd3/src/tooltip.js" type="text/javascript"></script>
    <script src="../../assets/plugins/nvd3/src/interactiveLayer.js" type="text/javascript"></script>
    <script src="../../assets/plugins/nvd3/src/models/axis.js" type="text/javascript"></script>
    <script src="../../assets/plugins/nvd3/src/models/line.js" type="text/javascript"></script>
    <script src="../../assets/plugins/nvd3/src/models/lineWithFocusChart.js" type="text/javascript"></script>
    <script src="../../assets/plugins/mapplic/js/hammer.js"></script>
    <script src="../../assets/plugins/mapplic/js/jquery.mousewheel.js"></script>
    <script src="../../assets/plugins/mapplic/js/mapplic.js"></script>
    <script src="../../assets/plugins/rickshaw/rickshaw.min.js"></script>
    <script src="../../assets/plugins/jquery-metrojs/MetroJs.min.js" type="text/javascript"></script>
    <script src="../../assets/plugins/jquery-sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <script src="../../assets/plugins/skycons/skycons.js" type="text/javascript"></script>
    <script src="../../assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
    <!-- END VENDOR JS -->
    <!-- BEGIN CORE TEMPLATE JS -->
    <script src="../../pages/js/pages.min.js"></script>
    <!-- END CORE TEMPLATE JS -->
    <!-- BEGIN PAGE LEVEL JS -->
    <script src="../../assets/js/dashboard.js" type="text/javascript"></script>
    <script src="../../assets/js/scripts.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL JS -->

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
    <script src="../../assets/plugins/jquery-metrojs/MetroJs.min.js" type="text/javascript"></script>
    <script src="../../assets/plugins/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="../../assets/plugins/jquery-isotope/isotope.pkgd.min.js" type="text/javascript"></script>
    <script src="../../assets/plugins/codrops-dialogFx/dialogFx.js" type="text/javascript"></script>
    <script src="../../assets/plugins/owl-carousel/owl.carousel.min.js" type="text/javascript"></script>
    <script src="../../assets/plugins/jquery-nouislider/jquery.nouislider.min.js" type="text/javascript"></script>
    <script src="../../assets/plugins/jquery-nouislider/jquery.liblink.js" type="text/javascript"></script>
    <!-- END VENDOR JS -->
    <!-- BEGIN CORE TEMPLATE JS -->
    <script src="../../pages/js/pages.min.js"></script>
    <!-- END CORE TEMPLATE JS -->
    <!-- BEGIN PAGE LEVEL JS -->
    <script src="../../assets/js/gallery.js" type="text/javascript"></script>
  </body>
</html>
<script type="text/javascript">
  function setFavorite(elem){
      var curatorId = document.getElementById('curatorId').getAttribute('value');
      var artistId = elem.value;
      console.log(curatorId);
      $.ajax({
                url: "<?php echo 'https://'.site_url('index.php/dashboard/curator/')?>",
                type: 'POST',
                data: {curator: curatorId,artist: artistId},
                dataType: "text",
                cache:false,
                success: function(){  
                  $('#artist_'+artistId).html('<span class="glyphicon glyphicon-star" aria-hidden="true"></span>');
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    alert("no"); alert("Error: " + errorThrown); 
                }  
            });
  }

</script>
<script type="text/javascript">
function setProfile(elem){
     
      $.ajax({
                url: "<?php echo 'http://'.site_url('index.php/dashboard/setProfile')?>",
                type: 'POST',
                data: {profile: elem.id},
                dataType: "text",
                cache:false
          });
    }
</script>
<script type="text/javascript">
function setCategory(elem){
     
      $.ajax({
                url: "<?php echo 'http://'.site_url('index.php/dashboard/setCategory')?>",
                type: 'POST',
                data: {categoryInitials: elem.id},
                dataType: "text",
                cache:false
          });
    }
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
.table-responsive{
  background-color: white;
}

/*
 * Global add-ons
 */

.sub-header {
  padding-bottom: 10px;
  color: white;
  text-align: center;
  text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;
  background-color: darkcyan;
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
  color: #fff;
  background-color: #428bca;
}
.sidebar{

  background-color: #2c3a4c;
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
  color: white;
  background-color: cadetblue;
  text-align: center;
  text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;
}


/*
 * Placeholder dashboard ideas
 */

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
  border-radius: 50%;
}
</style>