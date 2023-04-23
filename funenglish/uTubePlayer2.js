// Load the IFrame Player API code asynchronously.
function startyoutube(videoId,startSeconds,endSeconds){
	var tag = document.createElement('script');
	tag.src = "https://www.youtube.com/player_api";
	var firstScriptTag = document.getElementsByTagName('script')[0];
	firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);


	// Replace the 'ytplayer' element with an <iframe> and
	// YouTube player after the API code downloads.
	var player;

	


	var playerConfig = {
	  height: '360',
	  width: '100%',
	  videoId: videoId,
	  playerVars: {
		autoplay: 1, // Auto-play the video on load
		controls: 1, // Show pause/play buttons in player
		showinfo: 0, // Hide the video title
		modestbranding: 1, // Hide the Youtube Logo
		fs: 1, // Hide the full screen button
		cc_load_policy: 0, // Hide closed captions
		iv_load_policy: 3, // Hide the Video Annotations
		start: startSeconds,
		end: endSeconds,
		autohide: 0, // Hide video controls when playing
	  },
	  events: {
		'onStateChange': onStateChange
	  }
	};
}
function onYouTubePlayerAPIReady() {
  player = new YT.Player('ytplayer', playerConfig);
}

function onStateChange(state) {
  if (state.data === YT.PlayerState.ENDED) {
    player.loadVideoById({
      videoId: videoId,
      startSeconds: startSeconds,
      endSeconds: endSeconds
    });
  }
}
function playYoutube(){
   player.playVideo();
}
function pauseYoutube(){
   player.pauseVideo();
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
  var Id =  document.getElementById('video').value;
  var start = document.getElementById('start').value;
  var end =  document.getElementById('end').value;
  player.loadVideoById({'videoId': Id,
               'startSeconds': start,
               'endSeconds': end,
               'suggestedQuality': 'large'});
 
}
