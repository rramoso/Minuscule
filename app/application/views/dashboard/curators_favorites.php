 <?php if(is_null($this->session->userdata('typeuser'))){?>
 <?php header("Location:".'../../login/view',TRUE,301); } ?>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="../../assets/plugins/modernizr.custom.js" type="text/javascript"></script>
    <script src="../../assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <!-- END VENDOR JS -->
    <!-- BEGIN CORE TEMPLATE JS -->
    <script src="../../pages/js/pages.min.js"></script>

    <div class="container-fluid">
      <div class="row">
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Your Favorites</h1>
          <div > 
            <div class="row placeholders">
              <?php foreach($artists as $artist){?>
              <div class="row">
                <a onClick="setProfile(this)" id="<?php echo $artist['artist']['id']?>" href="profile">
                  <h1><?php echo $artist['artist']['nickname'] ?></h1>
                </a>
                <?php foreach($artist['gallery'] as $image){?>
                  <div data-id="<?php echo $image->id ?>" class="col-xs-6 col-sm-3 placeholder" id="getInfo" data-toggle="modal" data-target="#myModal">
                    <div class="artwork">
                      <img src="../../assets/uploads/<?php echo $image->name ?>" style="height: 200px;"width="200px" height="200px" class="img-responsive" alt="Generic placeholder thumbnail">
                      <div class="crop"><?php echo $image->description ?></div>
                    </div>
                  </div>
                <?php } ?> 
              </div>
              <?php } ?>
              </div>
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
        </div>
        <div id="work_image">

        </div>
        <div id="work_description" class="modal-body">
          
        </div>
      </div>
      
    </div>
  </div>

<script type="text/javascript">
function setFavorite(elem){
      var curatorId = document.getElementById('curatorId').getAttribute('value');
      $.ajax({
                url: "<?php echo 'http://'.site_url('index.php/dashboard/curator/')?>",
                type: 'POST',
                data: {curator: curatorId,artist: elem.value},
                dataType: "text",
                cache:false
          });
    }
</script>
<script type="text/javascript">
function setProfile(elem){
     
      $.ajax({
                url: "<?php echo 'https://'.site_url('index.php/dashboard/setProfile')?>",
                type: 'POST',
                data: {profile: elem.id},
                dataType: "text",
                cache:false
          });
    }
</script>
<script type="text/javascript">
$(document).ready(function(){

    $(document).on('click', '#getInfo', function(e){
    e.preventDefault();
  
     var piece_id = $(this).data('id'); // get id of clicked row
      console.log($(this).data('id'));
     $('#dynamic-content').html(''); // leave this div blank
     $('#modal-loader').show();      // load ajax loader on button click
 
     $.ajax({
          url: "<?php echo 'http://'.site_url('index.php/dashboard/ajaxArtWork/')?>" + piece_id,
          type: 'GET',
          dataType: 'JSON'
     })
     .done(function(data){
          console.log(data); 
          $('#work_image').html("<img src='../../assets/uploads/"+data.name+"'>");
          $('#work_description').html(''); // blank before load.
          $('#work_description').html("<p>"+data.description+"</p>"); // load here
          // $('#modal-loader').hide(); // hide loader  
     })
     .fail(function(){
          alert('Error get data from ajax');
     });

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
  background-color: #ffb747;
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
.placeholders .row{
  background: #fcf8e3;
  margin-bottom: 15px;
   border-radius: 25px;
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