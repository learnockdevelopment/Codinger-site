var fileVideoPlayer;

window.makeVideoPlayerHtml = function (path, storage, height, tagId) {
  console.log('makeVideoPlayerHtml called with:', { path, storage, height, tagId });
  var html = '';
  var options = {
    autoplay: false,
    preload: 'auto'
  };
  
  if (storage === 'youtube' || storage === 'vimeo') {
    console.log('Storage is YouTube or Vimeo');
    html = '<video id="' + tagId + '" class="video-js" width="100%" height="' + height + '"></video>';
    options = {
      controls: storage !== 'vimeo',
      ytControls: true,
      autoplay: false,
      preload: 'auto',
      techOrder: ['html5', storage],
      sources: [{
        src: path,
        type: "video/" + storage
      }]
    };
  } else if (storage === "secure_host") {
    console.log('Storage is secure_host');
    // Remove the ability to go fullscreen on secure_host iframes
    html = '<iframe src="' + path + '" class="img-cover bg-gray200" frameborder="0" loading="lazy" allow="accelerometer; gyroscope; autoplay; encrypted-media; picture-in-picture;"></iframe>';
  } else {
    console.log('Default storage method used');
    html = '<video id="' + tagId + '" oncontextmenu="return false;" controlsList="nodownload" class="video-js" controls preload="auto" width="100%" height="' + height + '"><source src="' + path + '" type="video/mp4"/></video>';
  }
  
  console.log('Generated HTML:', html);
  return {
    html: html,
    options: options
  };
};

window.handleVideoByFileId = function (fileId, $contentEl, callback) {
  console.log('handleVideoByFileId called with:', { fileId, $contentEl });
  closeVideoPlayer();
  var height = $(window).width() > 991 ? 426 : 264;
  console.log('Set video height:', height);

  $.post('/course/getFilePath', {
    file_id: fileId
  }, function (result) {
    console.log('Response from /course/getFilePath:', result);
    if (result && result.code === 200) {
      var storage = result.storage;
      var videoTagId = 'videoPlayer' + fileId;
      console.log('Storage:', storage, 'Video Tag ID:', videoTagId);
      
      var _makeVideoPlayerHtml = makeVideoPlayerHtml(result.path, storage, height, videoTagId),
        html = _makeVideoPlayerHtml.html,
        options = _makeVideoPlayerHtml.options;

      console.log('Generated HTML:', html, 'Options:', options);

      if ($contentEl) {
        $contentEl.html(html);
        console.log('Updated content element with HTML');
      }

      if (storage !== "secure_host") {
        console.log('Initializing Video.js player');
        fileVideoPlayer = videojs(videoTagId, options);

        // Disable pointer events on the fullscreen button
        fileVideoPlayer.ready(function () {
          var fullscreenButton = document.querySelector(`#${videoTagId} .vjs-fullscreen-control`);
          if (fullscreenButton) {
            console.log('Found fullscreen button, disabling pointer events');
            fullscreenButton.style.display = 'none';
            fullscreenButton.style.pointerEvents = 'none';
            var $tabs = $('.learning-page-tabs');
            console.log('Toggling tabs visibility');
            $tabs.toggleClass('show');
          }
        });
      }
      
      callback();
    } else {
      console.log('Error response from /course/getFilePath:', result);
      $.toast({
        heading: notAccessToastTitleLang,
        text: notAccessToastMsgLang,
        bgColor: '#f63c3c',
        textColor: 'white',
        hideAfter: 10000,
        position: 'bottom-right',
        icon: 'error'
      });
    }
  }).fail(function (err) {
    console.error('Error occurred during AJAX request:', err);
    $.toast({
      heading: notAccessToastTitleLang,
      text: notAccessToastMsgLang,
      bgColor: '#f63c3c',
      textColor: 'white',
      hideAfter: 10000,
      position: 'bottom-right',
      icon: 'error'
    });
  });
};
