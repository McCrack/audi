// detect Safari using jQuery
var safari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);

// only for desktop version
if (window.innerWidth > 768 && !safari) {
	var frameNumber = 0, // start video at frame 0

			// lower numbers = faster playback
			playbackConst = 2000, // set to 1000 to make the playback slower

			// get page height from video duration
			setHeight = document.getElementById("container-video"),

			// select video element
			video = document.getElementById("video");

	// dynamically set the page height according to video length
	video.addEventListener("loadedmetadata", function () {
	  setHeight.style.height = Math.floor(video.duration) * playbackConst + "px";
	});

	// use requestAnimationFrame for smooth playback
	function scrollPlay() {
	  var frameNumber = window.pageYOffset / playbackConst;
	  		video.currentTime = frameNumber;

	  window.requestAnimationFrame(scrollPlay);
	}

	window.requestAnimationFrame(scrollPlay);
}
