<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  </head>
  <?
     $youtubeCode = $_POST['youtube'];
	
  ?>
    <div class="container">
   
	<form class="navbar" role="search" method="post" action="input.php">
	<nav class="navbar fixed-top border-bottom flex-shrink-0 navbar-light bg-white navbar-expand">
	<input type="text" name='youtube' value='<?=$youtubeCode?>'><button  type="submit" class="btn btn-primary">검색</button></div></form> 
	<ul class="navbar-nav ml-auto px-3"></nav> 
	<nav class="topic-edit-sidebar" data-v-0326476a>
	<input type="hidden" id="video" value=""/>
	
	<div class="topic-edit-content" data-v-0326476a><div class="d-flex h-100" data-v-eb9ee7b8 data-v-0326476a data-v-0326476a><div class="flex-shrink-0 mr-2 overflow-auto" style="max-width: 50%;" data-v-eb9ee7b8><div class="card mb-2" data-v-eb9ee7b8><!----><!----><div class="card-body"><h5 class="card-title">미디어 컨트롤</h5><h6 class="card-subtitle text-muted mb-2">190822_6_minute_english_age_and_politics_DOWNLOAD</h6><div class="border" data-v-eb9ee7b8><div data-v-eb9ee7b8><div class="text-center py-3"><div style="display:inline-block;" data-v-5c6577c3><div class="no-ssr-placeholder" data-v-5c6577c3 data-v-5c6577c3><div id="ytplayer" wmode=’opaque’></div>

</div></div></div></div></div><div class="text-center py-3" data-v-eb9ee7b8>오디오 토픽</div></div> <div class="d-flex align-items-center" data-v-eb9ee7b8><button type="button" class="btn position-relative text-dark py-1 px-2 btn-link" data-v-eb9ee7b8><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="icon" data-v-eb9ee7b8><path d="M8 5v14l11-7z" data-v-eb9ee7b8></path><path d="M0 0h24v24H0z" fill="none" data-v-eb9ee7b8></path></svg>  <div class="shortcut-btn-badge" data-v-eb9ee7b8><span class="badge badge-info" data-v-eb9ee7b8><small data-v-eb9ee7b8>space</small></span></div></button> <button type="button" class="btn position-relative text-dark py-1 px-2 btn-link" data-v-eb9ee7b8><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="icon" data-v-eb9ee7b8><path d="M0 0h24v24H0z" fill="none" data-v-eb9ee7b8></path><path d="M6 6h12v12H6z" data-v-eb9ee7b8></path></svg>  <div class="shortcut-btn-badge" data-v-eb9ee7b8><span class="badge badge-info" data-v-eb9ee7b8><small data-v-eb9ee7b8>backspace</small></span></div></button> <div class="flex-grow-1 d-flex align-items-center px-2" data-v-eb9ee7b8><div paused="true" class="flex-grow-1 d-flex align-items-center px-2 font-weight-light" data-v-eb9ee7b8><span class="px-2">00:00</span> <div class="px-2 flex-grow-1"><input type="range" min="0" max="100" step="1" value="0" class="w-100"></div> <span class="px-2">00:00</span></div></div></div></div></div><!----><!----></div> <div class="card mb-2" data-v-eb9ee7b8><!----><!----><div class="card-body"><h5 class="card-title">자막 불러오기</h5><!----><div data-v-eb9ee7b8><div class="d-flex" data-v-eb9ee7b8><div class="dropdown btn-group b-dropdown" data-v-eb9ee7b8><!----><button aria-haspopup="true" aria-expanded="false" type="button" class="btn dropdown-toggle btn-outline-secondary btn-sm">txt</button><ul role="menu" tabindex="-1" class="dropdown-menu"><li data-v-eb9ee7b8><a role="menuitem" target="_self" href="#" class="dropdown-item active">
              txt
            </a></li><li data-v-eb9ee7b8><a role="menuitem" target="_self" href="#" class="dropdown-item">
              srt
            </a></li></ul></div> <div class="dropdown btn-group b-dropdown" data-v-eb9ee7b8><!----><button aria-haspopup="true" aria-expanded="false" type="button" class="btn dropdown-toggle btn-outline-secondary btn-sm">영어</button><ul role="menu" tabindex="-1" class="dropdown-menu"><li data-v-eb9ee7b8><a role="menuitem" target="_self" href="#" class="dropdown-item active">
              영어
            </a></li></ul></div> <label for="subtitle-file-btn" class="btn ml-auto btn-sm btn-primary" data-v-6f23a03c data-v-eb9ee7b8>
            파일 선택
           <div id="subtitle-file-btn__BV_file_outer_" class="custom-file b-form-file d-none" data-v-6f23a03c><input type="file" id="subtitle-file-btn" accept=".txt" class="custom-file-input"><label for="subtitle-file-btn" data-browse="Browse" class="custom-file-label">No file chosen</label></div></label></div> <div role="alert" aria-live="polite" aria-atomic="true" size="sm" class="alert small p-1 mt-2 alert-danger" data-v-eb9ee7b8><!----><strong data-v-eb9ee7b8>주의!</strong> 현재 자막이 지워질 수 있습니다.
        </div></div></div><!----><!----></div> <div class="card mb-2" data-v-eb9ee7b8><!----><!----><div class="card-body"><h5 class="card-title">자막 컨트롤</h5><!----><div class="mb-2" data-v-eb9ee7b8><h6 data-v-eb9ee7b8>기본조작</h6> <div role="group" class="btn-group btn-group-sm" data-v-eb9ee7b8><button type="button" class="btn btn-outline-secondary" data-v-eb9ee7b8>
            이전 자막
           <span class="badge badge-info">↑</span></button> <button type="button" class="btn btn-outline-secondary" data-v-eb9ee7b8>
            이전 자막
           <span class="badge badge-info">↓</span></button> <button type="button" class="btn btn-outline-secondary" data-v-eb9ee7b8>
            현재 자막 재생
           <span class="badge badge-info">enter</span></button> <button type="button" class="btn btn-outline-secondary" data-v-eb9ee7b8>
            현재 자막부터 재생
           <span class="badge badge-info">ctrl+enter</span></button></div></div> <div class="mb-2" data-v-eb9ee7b8><h6 data-v-eb9ee7b8>자막 추가&amp;삭제&amp;수정</h6> <div role="group" class="btn-group btn-group-sm" data-v-eb9ee7b8><button type="button" class="btn btn-outline-secondary" data-v-eb9ee7b8>
            추가
           <span class="badge badge-info">+</span></button> <button type="button" class="btn btn-outline-secondary" data-v-eb9ee7b8>
            삭제
           <span class="badge badge-info">-</span></button> <button type="button" class="btn btn-outline-secondary" data-v-eb9ee7b8>
            수정
           <span class="badge badge-info">F2</span></button></div></div> <div class="mb-2" data-v-eb9ee7b8><h6 data-v-eb9ee7b8>시작&amp;종료 시간 설정</h6> <div role="group" class="btn-group btn-group-sm" data-v-eb9ee7b8><button type="button" class="btn btn-outline-secondary" data-v-eb9ee7b8>
            시작시간
           <span class="badge badge-info">←</span></button> <button type="button" class="btn btn-outline-secondary" data-v-eb9ee7b8>
            종료시간
           <span class="badge badge-info">→</span></button></div></div> <div class="mb-2" data-v-eb9ee7b8><h6 data-v-eb9ee7b8>시작 시간 미세 조정</h6> <div role="group" class="btn-group btn-group-sm" data-v-eb9ee7b8><button type="button" class="btn btn-outline-secondary" data-v-eb9ee7b8>
            -0.2초
           <span class="badge badge-info">ctrl+←</span></button> <button type="button" class="btn btn-outline-secondary" data-v-eb9ee7b8>
            +0.2초
           <span class="badge badge-info">ctrl+→</span></button> <button type="button" class="btn btn-outline-secondary" data-v-eb9ee7b8>
            -0.05초
           <span class="badge badge-info">ctrl+shift+←</span></button> <button type="button" class="btn btn-outline-secondary" data-v-eb9ee7b8>
            -0.05초
           <span class="badge badge-info">ctrl+shift+→</span></button></div></div> <div data-v-eb9ee7b8><h6 data-v-eb9ee7b8>종료 시간 미세 조정</h6> <div role="group" class="btn-group btn-group-sm" data-v-eb9ee7b8><button type="button" class="btn btn-outline-secondary" data-v-eb9ee7b8>
            -0.2초
           <span class="badge badge-info">alt+←</span></button> <button type="button" class="btn btn-outline-secondary" data-v-eb9ee7b8>
            +0.2초
           <span class="badge badge-info">alt+→</span></button> <button type="button" class="btn btn-outline-secondary" data-v-eb9ee7b8>
            -0.05초
           <span class="badge badge-info">alt+shift+←</span></button> <button type="button" class="btn btn-outline-secondary" data-v-eb9ee7b8>
            -0.05초
           <span class="badge badge-info">alt+shift+→</span></button></div></div></div><!----><!----></div></div> <div class="h-100" style="flex: 1;" data-v-eb9ee7b8><div class="card h-100" data-v-eb9ee7b8 data-v-eb9ee7b8><!----><!----><div class="card-body d-flex flex-column h-100" data-v-eb9ee7b8 data-v-eb9ee7b8><h5 class="card-title" data-v-eb9ee7b8 data-v-eb9ee7b8>자막</h5><!----><div class="text-center py-5" data-v-eb9ee7b8><div style="display:inline-block;" data-v-5c6577c3><div class="no-ssr-placeholder" data-v-5c6577c3 data-v-5c6577c3>loading...</div></div></div></div><span class="pull-right clickable" data-effect="fadeOut"><i class="fa fa-times"></i></span><!----><!----></div></div></div></div></div> <!----></div></div></div>
		   <div class="card card-outline-danger text-center">
  <span class="pull-right clickable close-icon" data-effect="fadeOut"><i class="fa fa-times"><svg class="bi bi-chevron-right" width="32" height="32" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6.646 3.646a.5.5 0 01.708 0l6 6a.5.5 0 010 .708l-6 6a.5.5 0 01-.708-.708L12.293 10 6.646 4.354a.5.5 0 010-.708z" clip-rule="evenodd"/></svg></i></span>
  <div class="card-block">
    <blockquote class="card-blockquote">
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
      <footer>Someone famous in <cite title="Source Title">Source Title</cite></footer>
    </blockquote>
  </div>
</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>


<?    
  echo $youtubeCode;
?>
<script>
// Load the IFrame Player API code asynchronously.
var tag = document.createElement('script');
var ScriptTime =[0,28,86,90.7,31,34,38,42,46,49,
                 53,61,64,68,87,92,95,99,102,105,
				 110,113,117,120,125,132,136,140,147,151,
				 155,159,163,167,170,174,179,182,187,190,
				 196,199,204,211,214,218,225,229,233,241,
				 244,248,252,256,257];
tag.src = "https://www.youtube.com/player_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var videoId = '<?php echo $youtubeCode; ?>';

alert(videoId);
document.getElementById('video').value = videoId;
//var startSeconds ='<?= $str ?>';
//var endSeconds = 30;

// Replace the 'ytplayer' element with an <iframe> and
// YouTube player after the API code downloads.
var player,time_update_interval = 0;

var playerConfig = {
  height: '100%',
  width: '100%',
  videoId: videoId,
  playerVars: {
    playsinline: 1,
    autoplay: 1, // Auto-play the video on load
    controls: 0, // Show pause/play buttons in player
    showinfo: 0, // Hide the video title
    modestbranding: 0, // Hide the Youtube Logo
    fs: 0, // Hide the full screen button
    cc_load_policy: 0, // Hide closed captions
    iv_load_policy: 0, // Hide the Video Annotations
    //start: startSeconds,
    //end: endSeconds,
    autohide: 0, // Hide video controls when playing
  },
  events: {
    'onStateChange': onStateChange,
	'onReady': initialize
  }
};

function onYouTubePlayerAPIReady() {
  player = new YT.Player('ytplayer', playerConfig);
}

function onStateChange(state) {
  if (state.data === YT.PlayerState.ENDED) {
    player.loadVideoById({
      videoId: videoId,
      //startSeconds: startSeconds,
      //endSeconds: endSeconds
    });
  }
}

function initialize(){

    // Update the controls on load
    updateTimerDisplay();
   

    // Clear any old interval.
    clearInterval(time_update_interval);

    // Start interval to update elapsed time display and
    // the elapsed part of the progress bar every second.
    time_update_interval = setInterval(function () {
        updateTimerDisplay();
         }, 1000);


   // $('#volume-input').val(Math.round(player.getVolume()));
}
function updateTimerDisplay(){
    // Update current time text display.
    $('#current-time').text(formatTime( player.getCurrentTime() ));
    $('#duration').text(formatTime( player.getDuration() ));
	updateScript(player.getCurrentTime());
}
function updateScript(a){
    for (var i=0;i<ScriptTime.length+1 ;i++ )
    {
       if (a < ScriptTime[i])
       {      
		   $("[id^=text]").hide();
		   
		   $('#text'+i).show();
		   break;
	   }
	
	}
	
     
}
function formatTime(time){
    time = Math.round(time);

    var minutes = Math.floor(time / 60),
    seconds = time - minutes * 60;

    seconds = seconds < 10 ? '0' + seconds : seconds;

    return minutes + ":" + seconds;
}
function playYoutube(){
   player.playVideo();
}
function pauseYoutube(){
   player.pauseVideo();
}
function stopYoutube(){
   clearTimeout(OnTimer);
   player.stopVideo();
}
function utubetime(point){
  var currentTIme = player.getCurrentTime();
  if (point===1)
  {
     document.getElementById('start').value = currentTIme;
  }
  if (point===2)
  {
     document.getElementById('end').value = currentTIme;
     sectionRepeat();
  }
  if (point===3)
  {
     document.getElementById('start').value=''
     document.getElementById('end').value=''

  }
  
  
}
function BackSeconds(seconds) {
  var current = player.getCurrentTime();
  var new_position = current - seconds;

  if (new_position < 0) {
    new_position = 0;
  }
  player.seekTo(new_position);
}
function sectionRepeat(){
 
  OnTimer(); 
}
function check_repeat() {
  var start = document.getElementById('start').value;
  var current = player.getCurrentTime();
  var range = document.getElementById('end').value;

  // repeat bar 오른쪽을 지나갔으면, 왼쪽 bar 로 보낸다

  if (current >= range) {
    player.seekTo(start);
  }
  
}

function OnTimer() {

  var myTimer = setTimeout(OnTimer, 500);

  if (!player) {
	return;
  }
  if (!player.getCurrentTime) {
	return;
  }
  var current = player.getCurrentTime();
  var start = document.getElementById('start').value;
  var end = document.getElementById('end').value;
  if(!end && !start) {
     //player.seekTo(current);
	 clearTimeout(myTimer);
     exit;
  }

  check_repeat();
 
}

//timer 해결할것
</script>