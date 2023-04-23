<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script>

	function add_info(x) {
    // 원본 찾아서 pre_set으로 저장.
    var pre_set = document.getElementById('pre_set');

    // last-id 속성에서 필드ID르 쓸값 찾고
    var fieldid = pre_set.getAttribute('last-id');
	var valueID = parseInt(fieldid);
	
    // 다음에 필드ID가 중복되지 않도록 1 증가.
    pre_set.setAttribute('last-id', valueID + 1 );

    // 복사할 div 엘리먼트 생성
    var div = document.createElement('div');
    // 내용 복사
    div.innerHTML = pre_set.innerHTML;
    // 복사된 엘리먼트의 id를 'field-data-XX'가 되도록 지정.
    div.id = 'field-data-' + fieldid;
    // selection_content 영역에 내용 변경.
    var temp = div.getElementsByClassName('selection_content')[0];
    temp.innerText = x;
    // delete_box에 삭제할 fieldid 정보 건네기
    var deleteBox = div.getElementsByClassName('delete_box')[0];
   
    
	document.getElementById('numbering').value= div.id;
    // target이라는 속성에 삭제할 div id 저장
    deleteBox.setAttribute('target',div.id);
	temp.setAttribute('target',div.id);
	
    // #field에 복사한 div 추가.
    document.getElementById('field').appendChild(div);
    utubetime(1);
	
	}
   function delete_info(obj) {
   // 삭제할 ID 정보 찾기
   var target = obj.parentNode.getAttribute('target');
   alert(target);
   // 삭제할 element 찾기
   var field = document.getElementById(target);
   // #field 에서 삭제할 element 제거하기
   document.getElementById('field').removeChild(field);
  
   }
   function whatid(obj){
    
  
   document.getElementById('numbering').value= obj.getAttribute('target');
}
function test(){
      
   var a =document.querySelectorAll('[id*="field-data-"]');  
   var youid = document.getElementById('youtube').value;

   //JSON형태로 데이타 만들어서 넘길거야....^^ 
   var testList = new Array() ;
   for (var i=0;i<a.length;i++){ 
	   
       var jbSplit = a[i].innerText.split('X');

      // 객체 생성
       var data = new Object() ;    
       data.youtubeID = youid;     
	   data.title = document.getElementById('title').value;
       data.sortof = document.getElementById('sortof').value;

	   data.number = i ;
	   data.seconds =jbSplit[0].trim();
	   data.write = jbSplit[1].trim();

			   
	// 리스트에 생성된 객체 삽입
	   testList.push(data) ;

         
       // String 형태로 변환	   
  }
  
  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'input_post.php');
 
  xhr.setRequestHeader("Content-Type", "application/json");
  xhr.send(JSON.stringify(testList)); 
   
  // var jsonData = JSON.stringify(testList) ;
         
  // alert(jsonData) ;
    
}
function modify_info(){
    
	 var a =document.querySelectorAll('[id*="field-data-"]');
     var inputdata =  document.getElementById('datainput').value.split('/');
	 if (a.lenth <> inputdata.lenth)
	 { 
		 alert('노드수가 맞지 않습니다.');

	 }
	 else{
	     alert('맞습니다');
	 }

	 alert(a[0].getElementById.value);
	//var id = document.getElementById('numbering').value;
	
	//alert(id);
    //document.getElementById(id).getElementsByClassName('selection_content')[0].innerHTML= document.getElementById('datainput').value;
    //alert(a);
	
}

</script>


  </head>
  <?
     $youtubeCode = $_POST['youtube'];
	
  ?>
    <div>   
	<form class="navbar" role="search" method="post" action="test.php">
	<nav class="navbar fixed-top border-bottom flex-shrink-0 navbar-light bg-white navbar-expand">
	<input type="text" name='youtube' id="youtube" value='<?=$youtubeCode?>'><button  type="submit" class="btn btn-primary">검색</button></nav>
	</div>
	
	</form> 
    <div class="container" >
     <div class="row">
        <div class="col mt-5 ml-2">
            <div id="content">
            <div  class="col  ml-2" id="ytplayer" wmode=’opaque’><input type="hidden" id="video" value=""/></div><div class="delete_box"></div>
	        <div class="card-body"><h5 class="card-title">자막 컨트롤</h5><!----><div><h6>기본조작</h6> <div role="group" class="btn-group btn-group-sm" data-v-eb9ee7b8><button type="button" class="btn btn-outline-secondary" data-v-eb9ee7b8>
            이전 자막
           <span class="badge badge-info">↑</span></button> <button type="button" class="btn btn-outline-secondary" data-v-eb9ee7b8>
            이전 자막
           <span class="badge badge-info">↓</span></button> <button type="button" class="btn btn-outline-secondary" data-v-eb9ee7b8>
            현재 자막 재생
           <span class="badge badge-info">enter</span></button> <button type="button" class="btn btn-outline-secondary" data-v-eb9ee7b8>
            현재 자막부터 재생
           <span class="badge badge-info">ctrl+enter</span></button></div></div> <div class="mb-2" data-v-eb9ee7b8><h6 data-v-eb9ee7b8>자막 추가&amp;삭제&amp;수정</h6> <div role="group" class="btn-group btn-group-sm"><button type="button" class="btn btn-outline-secondary" onclick="add_info('시험테스트');">
            추가
           <span class="badge badge-info">+</span></button> <button type="button" class="btn btn-outline-secondary" onclick="remove_div(this);">
            삭제
           <span class="badge badge-info">-</span></button> <button type="button" class="btn btn-outline-secondary" data-v-eb9ee7b8>
            수정
           <span class="badge badge-info">F2</span></button></div></div> <div class="mb-2" data-v-eb9ee7b8><h6 data-v-eb9ee7b8>시작&amp;종료 시간 설정</h6> <div role="group" class="btn-group btn-group-sm" data-v-eb9ee7b8><button type="button" class="btn btn-outline-secondary" onclick="utubetime(1)";>
            시작시간
           <span class="badge badge-info">←</span></button> <button type="button" class="btn btn-outline-secondary" onclick="youtubeScript()">
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
           <span class="badge badge-info">alt+shift+→</span></button></div></div></div>
		   <input type="textarea" size =10>
         </div>
       </div>
       <div class="col mt-5">
	        <label>제 목  : </label><input id="title" type="text"  size="60px">
			<select id="sortof">
			<option value="news">뉴스</option>
            <option value="bbc">bbc</option>     
	        <option value="animation">애니메이션</option>
            <option value="drama">드라마</option>
			<option value="movie">영화</option>
			</select>
			<p></p>
	        <textarea rows="5" cols="62" id="datainput"></textarea><button onclick="modify_info(this)">수정</button> 
	        <div id="pre_set" style="display:none;" last-id="0">
				<div style="margin:2px; height:90px; border:2px solid #2C3E50">
					<div class="selection_title" style="float:left" >시작점 : 
						
					</div>
					<div class="delete_box" style="float:right">
						<button onclick="delete_info(this)" style="font-size:70%;align:right">X</button>
						
					</div>
				    <div class="selection_content" style="clear: both;"  onclick='whatid(this)'>
					
				    </div>
					
					
				
				 </div>
			 </div>

			<div id="field" style="max-height:770px; overflow:auto;">
			</div>

		

	   </div>

      
    </div>
    </div>
	<input id="numbering" type="text">
    <button onclick="test();" style="font-size:100%;align:right">X</button>

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


document.getElementById('video').value = videoId;
//var startSeconds ='<?= $str ?>';
//var endSeconds = 30;

// Replace the 'ytplayer' element with an <iframe> and
// YouTube player after the API code downloads.
var player,time_update_interval = 0;

var playerConfig = {
  height: '300',
  width: '360',
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
    
     var id = document.getElementById('numbering').value;
	 //alert(document.getElementById(id).getElementsByClassName('selection_title').innerHTML);
	 document.getElementById(id).getElementsByClassName('selection_title')[0].innerHTML= currentTIme.toFixed(2);
	 // id.innerHTML = currentTIme;
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
function youtubeScript(){
 
     var id = document.getElementById('numbering').value;
	 //alert(document.getElementById(id).getElementsByClassName('selection_title').innerHTML);
	 document.getElementById(id).getElementsByClassName('selection_content')[0].innerHTML= '코로나';
	 // id.innerHTML = currentTIme;
 
  
  
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


<!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>




