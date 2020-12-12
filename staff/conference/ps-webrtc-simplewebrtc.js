window.onload = function(){

  // Grab the room name from the URL
  var room = location.search && location.search.split('?')[1];

  // Create our WebRTC Connection
  var webrtc = new SimpleWebRTC({
      // the element that will hold local video
      localVideoEl: 'localVideo',
      remoteVideosEl: 'remotes',
      autoRequestMedia: true;
      log: true;
  });


  // When it's ready, and we have a room from the URL, join the Call
  webrtc.on('readyToCall', function(){
      if (room) webrtc.joinRoom(room);
  });

  if there's a room show it in the UI
  if (room){
    setRoom(room);
  }else{
    $('form').submit(function(){
      var val = $('#sessionInput').val().toLowerCase().replace(/\s/g,'-');
      webrtc.createRoom(val, function(err, name){
          var newUrl = location.pathname + '?' + name;

          if (!err){
            history.replaceState({foo: bar}, null, newUrl);
            setRoom(name);
          }
      });
      return false;
    })
  }



}
