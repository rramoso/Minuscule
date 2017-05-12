 <?php if(is_null($this->session->userdata('typeuser'))){?>
 <?php header("Location:".'../../login/view',TRUE,301); } ?>
<div id="curatorId" value="<?php echo $curator_id?>" class="container-fluid">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <div class="page-content-wrapper ">

       <!-- START PAGE CONTENT -->
        <div class="content ">
          <div class="social-wrapper">
            <div class="social " data-pages="social">
              <!-- START JUMBOTRON -->
              <div class="jumbotron" data-pages="parallax" data-social="cover">
                <div class="cover-photo">
                  <img alt="Cover photo" src="../../assets/img/social/cover.png" />
                </div>
                <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
                  <div class="inner">
                    <div class="pull-bottom bottom-left m-b-40">

                      <?php if($artist_avatar != '') {?>
                      <img src="<?php echo '../../assets/uploads/avatars/'. $artist_avatar ?>" alt="Generic placeholder thumbnail" width="200" height="400">
                      <?php }else{?>
                      <img src="<?php echo '../../assets/images/'.$gender.'-profile.png'?>" width="200" height="400"class="img-responsive" alt="Generic placeholder thumbnail">
                      <?php }?>

                      <h1 class="text-white no-margin"><span class="semi-bold"><?php echo ucfirst($nickname); ?></span></h1>
                      <h5 class="text-white no-margin"><?php echo $manifesto ?></h5>
                    </div>
                    <div class="pull-bottom bottom-right m-b-40" id="<?php echo 'artist_'.$artist_id ?>">
                          <?php if($this->curator_model->isFollowing($curator_id,$artist_id)){?>
                              <span class="glyphicon glyphicon-star" width="100px"height="100px" aria-hidden="true"></span>
                            <?php }else {?>
                            <div id="<?php echo 'artist_'.$artist_id ?>">
                              <button onClick="setFavorite(this)" value="<?php echo $artist_id ?>" type="button" class="btn btn-default btn-lg">
                                <span class="glyphicon glyphicon-star" aria-hidden="true"></span> Favorite
                              </button>
                            </div>     
                       <?php } ?> 
                      </div>    

                  </div>
                </div>
              </div>
              <!-- END JUMBOTRON -->
            </div>
          </div>
           <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
            <!-- START CATEGORY -->
            <div class="gallery">
              <!-- START CATEGORY -->
            <div class="gallery">
              <div class="gallery-filters p-t-20 p-b-10">
                <ul class="list-inline text-right">
                  <li class="hint-text">Sort by: </li>
                  <li><a href="#" class="active text-master p-r-5 p-l-5">Name</a></li>
                  <li><a href="#" class="text-master hint-text p-r-5 p-l-5">Views</a></li>
                  <li><a href="#" class="text-master hint-text p-r-5 p-l-5">Cost</a></li>
                  
                </ul>
              </div>
              <!-- START GALLERY ITEM -->
              <!-- 
                    FOR DEMO PURPOSES, FIRST GALLERY ITEM (.first) IS HIDDEN 
                    FOR SCREENS <920px. PLEASE REMOVE THE CLASS 'first' WHEN YOU IMPLEMENT 
                -->
                <?php 
                  foreach ($gallery as $image) { ?>
                    <div data-id="<?php echo $image->id ?>" class="gallery-item " id="getInfo"data-toggle="modal" data-target="#myModal">
                      <!-- START PREVIEW -->
                      <img src="../../assets/uploads/<?php echo $image->name ?>" alt="" class="image-responsive-height">
                      <!-- END PREVIEW -->
                      <!-- START ITEM OVERLAY DESCRIPTION -->
                      <div class="overlayer bottom-left full-width">
                        <div class="overlayer-wrapper item-info ">
                          <div class="gradient-grey p-l-20 p-r-20 p-t-20 p-b-5">
                            <div class="">
                              <p class="pull-left bold text-white fs-14 p-t-10"><?php echo $image->description ?></p>
                              <div class="clearfix"></div>
                            </div>
                            <div class="m-t-10">
                              <div class="thumbnail-wrapper d32 circular m-t-5">
                                <?php if($avatar != '') {?>
                                  <img src="<?php echo '../../assets/uploads/avatars/'. $avatar ?>" alt="Generic placeholder thumbnail" width="40" height="40" >
                                <?php }else{?>
                                  <img src="<?php echo '../../assets/images/'.$gender.'-profile.png'?>" width="40" height="40" class="img-responsive" alt="Generic placeholder thumbnail">
                                <?php }?>
                              </div>
                              <div class="inline m-l-10">
                                <p class="no-margin text-white fs-12">Created by <?php echo $nickname ?></p>
                              </div>
                              <div class="clearfix"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
          </div>
        </div>
    </div>
    <!-- END OVERLAY -->
    <script type="text/javascript">
function setFavorite(elem){
      var curatorId = document.getElementById('curatorId').getAttribute('value');
      var artistId = elem.value;
      $.ajax({
                url: "<?php echo 'http://'.site_url('index.php/dashboard/curator/')?>",
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