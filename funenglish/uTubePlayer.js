/*made by geon
 * 20170407*/

done = false;
var player;
var uTubePlayer = {
		settingVideo : function(playerId, videoId, height, width){
			player = new YT.Player(playerId, {
			    height: height,
			    width: width,
			    videoId: videoId, //'rht_uiteReE',
                 playerVars: {'playsinline':'1','autoplay':'1','autohide':'1','theme':'light','color':'white','modestbranding':1,'rel':0},
			    events: {
			      'onReady': uTubePlayer.onPlayerReady,
			      'onStateChange': uTubePlayer.onPlayerStateChange
			    }
		  });
		},
		onPlayerReady : function(event) {
			event.target.playVideo();
		},
		onPlayerStateChange : function(event) {
			if (event.data == YT.PlayerState.PLAYING && !done) {
//			    setTimeout(stopVideo, 6000);
				done = true;
			}
		},
		stopVideo : function() {
			player.stopVideo();
		},
        
};
function playYoutube() {
            // 플레이어 자동실행 (주의: 모바일에서는 자동실행되지 않음)
            player.playVideo();
};
