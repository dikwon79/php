<!DOCTYPE html> 
<html>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8;">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1;">
<head>
	<title>개발자 최고</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    
     <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

 

	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
    <script>
	 $(document).ready(function(){
     
          $("[id^=text]").hide();
     });
     function repeat(num){
        document.getElementById('start').value = ScriptTime[num];
		document.getElementById('end').value = ScriptTime[num+1]; 
		document.getElementById('sequence').value = num;
		sectionRepeat();

	 }
	 function next(){
		 var num = parseInt(document.getElementById('sequence').value);
		 
		 if (!num && num!='0')
		 {
			 num =0;
		 }
		 else  num = num+1;
		
		 if (ScriptTime.length-1 < num)
		 {
			 alert('자막기록 끝입니다.');
			 document.getElementById('start').value = '';
			 document.getElementById('end').value = '';
			 document.getElementById('sequence').value = 0;
			 return;
		 }
		 else{
			
			 document.getElementById('start').value = ScriptTime[num];
			 document.getElementById('end').value = ScriptTime[num+1]; 
			 document.getElementById('sequence').value = num;
			 player.seekTo(ScriptTime[num]);
			 sectionRepeat();
		 }

	 }
	 function previous(){
	     var num = parseInt(document.getElementById('sequence').value);
		 
		 if (!num && num!='0')
		 {
			 num =0;
		 }
		 else  num = num-1;
		 if (num < 0)
		 {
			 alert('처음입니다.');
			 
			 return;
		 }
		 else{

         document.getElementById('start').value = ScriptTime[num];
		 document.getElementById('end').value = ScriptTime[num+1]; 
		 document.getElementById('sequence').value = num;
		 player.seekTo(ScriptTime[num]); 
         sectionRepeat();
		 }
	 }
    
    // F12 버튼 방지
    $(document).ready(function(){
        $(document).bind('keydown',function(e){
            if ( e.keyCode == 123 /* F12 */) {
                e.preventDefault();
                e.returnValue = false;
            }
        });
    });
    // 우측 클릭 방지
    document.onmousedown=disableclick;
    status="Right click is not available.";
    
    function disableclick(event){
        if (event.button==2) {
            alert(status);
            return false;
        }
    }
    </script>
	<style>
    .col-8{
       font-size:20px;


	}
    li{

      list-style:none;
	}


	</style>
</head>

<body oncontextmenu='return false' onselectstart='return false' ondragstart='return false'>

<?
     
  $youtubeCode = $_GET[code];
 
  $connect = mysqli_connect("localhost","dikwon79","ab0612abcD!@","dikwon79");
 
  $sql = "SELECT * FROM tbl_funenglish where youtubeid='$youtubeCode' order by number asc ";
  $result = mysqli_query($connect,$sql);

  $total = mysqli_num_rows($result);
 

  $listvalue=array();    
 

  
?>

<div data-role="header" data-positon="fixed" data-theme="b">
 <h1>조은경의 어순감각스피킹</h1>
 <a href="../panel/" data-rel="back" class="ui-btn ui-btn-left ui-alt-icon ui-nodisc-icon ui-corner-all ui-btn-icon-notext ui-icon-carat-l">Back</a>
 <a class="ui-btn-right ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-right ui-icon-gear" href="#" id="favorite" title="즐겨찾기 등록">즐겨찾기</a>
 </div>
<div id="content">
<div id="ytplayer" wmode=’opaque’><div style="position:absolute;top:10px;left:50px;font-color:white"> 
1980.05.31 
</div></div>
<div class="row" style="position:relative; margin:2px; height:150px; border:2px solid #2C3E50"> 
  <div class="col-2"  style=" position: relative ;top: 50px;">
  
    <a href="#" class="btn btn-primary" onclick ="previous()">이전</a>
  </div>
  <div class="col-8" align="left">
    
    <div id="contents" class="card-block">
    
	<?
	    for($i=0; $i<$total; $i++){
		  
		  $row = mysqli_fetch_assoc($result); 
		  $list=$row[second];
	
	
          array_push($listvalue,$list);   
    ?>
	<div id="text<? echo $row[number]+1 ?>" onclick="repeat(<? echo $row[number] ?>);"><li><? echo $row[script]; ?></li>
	                <!--  <li class="text"></li>
				    <li></li> --> </div>
    <?
	   }	
	?>

   
</div>
  </div>
  <div class="col-2" style=" position: relative ;top: 50px;">
  
   <div align="right"><a href="#" class="btn btn-primary" onclick="next();">다음</a></div>
  </div>
 
</div>
<div class="ui-grid-b">
<div class="ui-block-a"><div class="button-wrap"><button class="ui-shadow ui-btn ui-corner-all" onclick="playYoutube();">play</button></div></div>
<div class="ui-block-b"><div class="button-wrap"><button class="ui-shadow ui-btn ui-corner-all" onclick="pauseYoutube();">Pause</button></div></div>
<div class="ui-block-c"><div class="button-wrap"><button class="ui-shadow ui-btn ui-corner-all" onclick="stopYoutube();">Stop</button></div></div>
</div>

<div class="ui-grid-b">
<div class="ui-block-a"><div class="button-wrap"><button class="ui-shadow ui-btn ui-corner-all" onclick="BackSeconds(7);">7초전</button></div></div>
<div class="ui-block-b"><div class="button-wrap"><button class="ui-shadow ui-btn ui-corner-all" onclick="BackSeconds(5);">5초전</button></div></div>
<div class="ui-block-c"><div class="button-wrap"><button class="ui-shadow ui-btn ui-corner-all" onclick="BackSeconds(2);">2초전</button></div></div>
</div>
<div class="btn-group btn-group-justified" role="group" aria-label="...">
  <div class="btn-group" role="group">
    <button type="button" class="btn btn-default" onclick="speedChange(0.5);">0.5</button>
  </div>
  <div class="btn-group" role="group">
    <button type="button" class="btn btn-default" onclick="speedChange(0.7);">0.7</button>
  </div>
  <div class="btn-group" role="group">
    <button type="button" class="btn btn-default" onclick="speedChange(0.9);">0.9</button>
  </div>
  <div class="btn-group" role="group">
    <button type="button" class="btn btn-default" onclick="speedChange(1);">1</button>
  </div>
  <div class="btn-group" role="group">
    <button type="button" class="btn btn-default" onclick="speedChange(1.3);">1.3</button>
  </div>
  <div class="btn-group" role="group">
    <button type="button" class="btn btn-default" onclick="speedChange(1.5);">1.5</button>
  </div>
  <div class="btn-group" role="group">
    <button type="button" class="btn btn-default" onclick="speedChange(1.7);">1.7</button>
  </div>
</div>


<div class="ui-grid-a">
<div class="ui-block-a"><input  type="text" id ="start" value=""/></div>
<div class="ui-block-b"><input  type="text" id ="end" value=""/>
<input type="hidden" id="video" value=""/></div>
<input type="text" id ="sequence" value=""/>
</div>

<div class="ui-grid-b">
<div class="ui-block-a"><div class="button-wrap"><button type="button" onclick="utubetime(1);">StartTimeRecord</button></div></div><div class="ui-block-b"><div class="button-wrap"><button type="button" onclick="utubetime(2);">EndTimeRecord</button></div></div>
<div class="ui-block-c"><div class="button-wrap"><button type="button" onclick="utubetime(3);">repeat off</button></div></div>
</div>
</div>
</body>

<script>
// Load the IFrame Player API code asynchronously.
var tag = document.createElement('script');
var ScriptTime =<?php echo json_encode($listvalue)?>;
tag.src = "https://www.youtube.com/player_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var videoId = '<?php echo $youtubeCode; ?>';
document.getElementById('video').value = videoId;
//var startSeconds ='<?= $str ?>';
//var endSeconds = 30;

// Replace the 'ytplayer' element with an <iframe> and
// YouTube player after the API code downloads.
var player,time_update_interval = 0;

var playerConfig = {
  height: '300',
  width: '100%',
  videoId: videoId,
  playerVars: {
    playsinline: 1,
    autoplay: 1, // Auto-play the video on load
    controls: 1, // Show pause/play buttons in player
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
function speedChange(thisObj) {
        var speed = thisObj;
        player.setPlaybackRate(speed);
        //document.getElementById('result').innerHTML = '';
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
<?
   $result->free();
  
?>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>





