<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.1.9/p5.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.1.9/addons/p5.sound.min.js"></script>
  <script src="https://unpkg.com/ml5@0.5.0/dist/ml5.min.js"></script>
  <title>Object Detection with COCO-SSD (From Video)</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
</head>

<body class="bg-dark vh-100 d-flex justify-content-center align-items-center text-white">
  <video id="videoInput" class="img-fluid rounded-5 d-none" controls></video>
  <img id="videoOutput" class="img-fluid rounded-5" />
  <h1 id="countPeople"></h1>
  <script>
    // var countPeopleElement = document.getElementById("countPeople").innerHTML;
    let video;
    let detector;
    let detections = [];

    function preload() {
      detector = ml5.objectDetector("cocossd");
    }

    function gotDetections(error, results) {
      if (error) {
        console.error(error);
        return;
      }
      detections = results;

      // Update the content of the element with id "countPeople"
      var countPeopleElement = document.getElementById("countPeople");
      countPeopleElement.textContent = detections.length;

      console.log(detections); // Print detections to the console
      console.log(detections.length);
      detector.detect(video, gotDetections);
      setInterval(updateStatus(detections.length), 10000);
    }

    function setup() {
      createCanvas(640, 480);

      // Replace with your video URL (or use a file input element)
      // const videoSrc = "https://www.youtube.com/watch?v=dQw4w9WgXcQ"; // Replace with your video URL
      const videoSrc = "videotest.mp4"; // Replace with your video URL

      video = createVideo(videoSrc, onVideoLoaded);
      video.size(640, 480);
      // video.size(160, 90);
      video.hide();

      // Hide the canvas after the model has loaded
      document.getElementById("defaultCanvas0").classList.toggle("d-none");
    }

    function onVideoLoaded() {
      video.loop();
      video.volume(0); // Mute the video (optional)
      video.play();
      detector.detect(video, gotDetections);
    }

    function draw() {
      image(video, 0, 0, 640, 480);

      for (let i = 0; i < detections.length; i++) {
        let object = detections[i];
        // console.log(object.label);
        if (object.label === "person") {
          stroke(0, 255, 0);
          strokeWeight(4);
          noFill();
          rect(object.x, object.y, object.width, object.height);
          noStroke();
          fill(255);
          textSize(24);
          text(object.label, object.x + 10, object.y + 24);
        }
      }

      // Display the video stream on the img element
      document.getElementById("videoOutput").src = video.elt.currentTime > 0 ? canvas.toDataURL("image/jpeg") : "";
    }

    // Function to call PHP script with AJAX
    function updateStatus() {
      detStat = document.getElementById('countPeople').innerHTML;
      // Ajax untuk mengubah status relay di MySQL
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
          // Get respon from web after change value
          document.getElementById('countPeople').innerHTML = xmlhttp.responseText;
        }
      }

      // Execute PHP file to change value on database
      xmlhttp.open("GET", "database/updateDet.php?detStat=" + detStat, true);

      // Send data
      xmlhttp.send();
    }

    
  </script>
</body>

</html>