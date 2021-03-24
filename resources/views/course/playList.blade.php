@extends('layouts.app')
@section('content')
<style>
    .youtube-player {
        position: relative;
        padding-bottom: 56.23%;
        height: 0;
        overflow: hidden;
        max-width: 100%;
        background: #000;
        margin: 5px;
    }
    .mini-sidebar .sidebar-nav #sidebarnav li {
        position: relative;
    }
    .navbar-header {
      width:60px;
    }
    .page-wrapper {
        margin-left: 60px;
    }
    .left-sidebar {
      width:60px;
    }
    .youtube-player iframe,
    .youtube-player object,
    .youtube-player embed {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 100;
        background: transparent;
    }

    .youtube-player img {
        bottom: 0;
        display: block;
        left: 0;
        margin: auto;
        max-width: 100%;
        width: 100%;
        position: absolute;
        right: 0;
        top: 0;
        border: none;
        height: auto;
        cursor: pointer;
        -webkit-transition: .4s all;
        -moz-transition: .4s all;
        transition: .4s all;
    }

    .youtube-player img:hover {
        -webkit-filter: brightness(75%);
    }
    .mini-sidebar .sidebar-nav #sidebarnav > li > a {
        padding: 9px 15px;
        width: 50px;
    }
    .mini-sidebar .sidebar-nav {
        background: transparent;
        padding: 5px;
    }
    .youtube-player .play {
        height: 72px;
        width: 72px;
        left: 50%;
        top: 50%;
        margin-left: -36px;
        margin-top: -36px;
        position: absolute;
        background: url("//i.imgur.com/TxzC70f.png") no-repeat;
        cursor: pointer;
    }

    .page-wrapper {
        padding-bottom: 25%;
    }
    .card-title::after {
      content: "\f107";
      color: #333;
      top: 20px;
      right: 20px;
      position: absolute;
      font-family: "FontAwesome"
    }
    .paratext {
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      max-width: 24ch;
    }
    .card-title[aria-expanded="true"]::after {
      content: "\f106";
    }
</style>
<?php 
 //var_dump($videos); exit;
$para = Request::get('video');
$video_id='';
$video_seen = $student_info->video_seen;
$title = '';
$description = '';
if($para==1) {
  $playToVideo = $videos[0];
  $title = $playToVideo->title;
  $description = $playToVideo->description;
  $video_type = $playToVideo->video_type;
  $video_id = substr(parse_url($playToVideo->youtube_link, PHP_URL_PATH), 1);
} else {
  foreach ($videos as $key => $value) {
    if($value->id==$para) {
      $title = $value->title;
      $video_type = $value->video_type;
      $description = $value->description;
      if($value->video_type==1) {
        $video_id = substr(parse_url($value->youtube_link, PHP_URL_PATH), 1);
      } else if($value->video_type==2) {
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $value->youtube_link, $match);
        $video_id =$match[1];
      }
    } else {
      $video_id = $value->youtube_link;
    }
  }
}
// var_dump($video_id); exit;?>
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0"><?= $videos[0]->name; ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/student/dashboard">Home</a></li>
                    <li class="breadcrumb-item"><a href="/allcourse">Courses</a></li>
                    <li class="breadcrumb-item"><?= $videos[0]->name; ?></li>
                </ol>
            </div>
        </div>
      
        <div id="rowplayer" class="row">
            <div class="col-sm-8 first-column col-xs-12">
                <?php if($video_type == 1) { ?>
                <div class="plyr__video-embed" id="vimeoplayer">
                  <iframe
                    id="viemoiframe"
                    src="https://player.vimeo.com/video/<?= $video_id;?>?loop=false&amp;byline=false&amp;portrait=true&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media&amp;quality=auto"
                    allowfullscreen
                    allowtransparency
                    allow="autoplay"
                  ></iframe>
                </div>
                <?php } else if($video_type==2) { ?>
                  <div class="plyr__video-embed" id="vimeoplayer">
                    <iframe
                      src="https://www.youtube.com/embed/<?= $video_id; ?>?origin=https://plyr.io&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1&fs=0"
                      allowfullscreen
                      allowtransparency
                      allow="autoplay"
                    ></iframe>
                  </div>
                <?php } else if($video_type==3){ ?>
                  <video id="vimeoplayer" playsinline controls>
                    <source src="<?= $video_id; ?>" type="video/mp4" />
                  </video>
                <?php } else { ?>
                  <audio id="vimeoplayer" controls>
                    <source src="<?= $video_id; ?>" type="audio/mp3" />
                  </audio>
                <?php } ?>
                <div class="card mt-3">
                    <div class="card-block">
                        <h4 class="card-title" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne"><?= $title; ?></h4>
                        <div id="collapseOne" class="collapse " aria-labelledby="headingOne" data-parent="#accordionExample">
                          <p><?= $description; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 second-column mt-3 col-xs-12">
              <div class="list-group">
              <?php foreach($videos as $key => $vid) { ?>
                <div class="media" <?php if($para==$vid->id) { echo 'style="background: white;"'; }?>>
                  <div class="media-left">
                    <a href="?video=<?= $vid->id;?>">
                      <img class="media-object" src="{{ asset('assets/images/logo.png') }}" width="100px" alt="<?= $vid->title; ?>">
                    </a>
                  </div>
                  <div class="media-body pl-3">
              <h4 class="media-heading "><a href="?video=<?= $vid->id;?>"><?= $vid->title; ?></a> <?php if(in_array($vid->id,$video_seen)) { ?><i class="mdi mdi-checkbox-marked-circle-outline mdi-24px"></i><?php } ?></h4>                
                      <p class="paratext"><?= empty($vid->description) ? '' : $vid->description; ?></p>
                    </div>
                  </div>
                </div>
              <?php } ?>
              </div>
            </div> 
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/plyr.polyfilled.js') }}"></script>
<script>
$(function(){
  if (window.matchMedia("(max-width: 767px)").matches) 
    { 
        $('#rowplayer').addClass('row-fluid');
        $('#rowplayer').removeClass('row');
        // The viewport is less than 768 pixels wide 
        console.log("This is a mobile device."); 
    } else { 
        
        // The viewport is at least 768 pixels wide 
        console.log("This is a tablet or desktop."); 
    } 
  $('.sidebar-nav').addClass('mini-sidebar');
  $('.sidebar-nav').css('padding','5px');
})
      // 2. This code loads the IFrame Player API code asynchronously.
      var tag = document.createElement('script');

      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      // 3. This function creates an <iframe> (and YouTube player)
      //    after the API code downloads.
      var player;
      function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
          height: '390',
          width: '640',
          videoId: 'M7lc1UVf-VE',
          playerVars:{
            'modestbranding':1,
            'autoplay': 0,
            'controls': 1, 
            'pip' : 1,
            'fs' : 1,
          },
          events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange,
          }
        });
      }

      // 4. The API will call this function when the video player is ready.
      function onPlayerReady(event) {
          $(document).find('.ytp-chrome-top-buttons').css('display','none');
        //event.target.playVideo();
        
      }

      // 5. The API calls this function when the player's state changes.
      //    The function indicates that when playing a video (state=1),
      //    the player should play for six seconds and then stop.
      var done = false;
      function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.PLAYING && !done) {
          setTimeout(stopVideo, 6000);
          done = true;
        }
      }
      function stopVideo() {
        player.stopVideo();
      }
    </script>
    <script>
  //const player1 = new Plyr('#youtubeplayer');
  const player2 = new Plyr('#vimeoplayer');
  player2.on('ended', event => {
  const instance = event.detail.plyr;
  console.log(instance);
  console.log('ended');
  $.ajax({
    url:'<?= route('student.videoseen',['uuid'=> Request::segment(2),'id'=>$para]);?>',
    method: 'GET',
    success:function(response) {
      if(response.success) {
        Swal.fire("Success", "Congratulations! You have completed one more topic.","success");
      }
    }
  })
});
</script>
@endsection