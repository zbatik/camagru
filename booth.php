<?php require $_SERVER["DOCUMENT_ROOT"]."/camagru/shared/header.php"; ?>

<script>
    window.addEventListener("DOMContentLoaded",function() {

    var video = document.getElementById("video"),
    canvas = document.getElementById("canvas"),
    context = canvas.getContext("2d"),

    vendorUrl = window.URL || window.webkitURL;

    navigator.getMedia =    navigator.getUserMedia ||
                        navigator.webkitGetUserMedia ||
                        navigator.mozGetusermedia ||
                        navigator.msGetUserMedia;

    navigator.getMedia({
    video: true,
    audio: false
    }, function(stream) {
    video.srcObject = stream;
    video.play();
    }, function(error) {
    has_webcam = false;
    // cap_btn.hidden = true;
    });
    document.getElementById("capture-but").addEventListener('click', function(){
        context.drawImage(video, 0, 0, 400, 300);
        
        currentpic = canvas.toDataURL();
        photo = document.createElement('img');
        photo.setAttribute("src", currentpic);
        camera_roll = document.getElementById("photo-reel");
        camera_roll.insertBefore(photo, camera_roll.firstElementChild);
        photo.setAttribute("style", "transform: rotateY(180deg);-webkit-transform:rotateY(180deg); -moz-transform:rotateY(180deg);");
        PostPhoto(currentpic);
    });
    });
</script>

<?php 
    if ($_SESSION['logged_on'])
    {
        echo '
        <div id="upload-wrapper">
        <video style=""id="video" width="400" height="300" src=""></video>
        <canvas id="canvas" width="400" height="300"> </canvas>
        <div id="overlay-wrapper">
        <img class="overlays" src="https://cdn140.picsart.com/273126276018201.png?r1024x1024">
        <img class="overlays" src="https://cdn130.picsart.com/257922923008212.png?r1024x1024">
        <img class="overlays" src="https://cdn140.picsart.com/285330915029211.png?r1024x1024">
        <img class="overlays" src="https://cdn131.picsart.com/285334351024211.png?r1024x1024">
        <img class="overlays" src="https://cdn130.picsart.com/285330963028211.png?r1024x1024">
        <img class="overlays" src="https://cdn131.picsart.com/285259587044211.png?r1024x1024">
        <img class="overlays" src="https://cdn131.picsart.com/285255134024211.png?r1024x1024">
        <img class="overlays" src="https://cdn130.picsart.com/285243888034211.png?r1024x1024">
        </div>
        <img alt="" id="upload_2" style="width : 400px; position : absolute; z-index: -20;" hidden="true"src="">
        <button id="capture-but">take photo</button>
        <div id="photo-reel"></div>
        ';
    } else {
        header("Location: login.php");
    }



require $_SERVER["DOCUMENT_ROOT"]."/camagru/shared/footer.php"; 
?>
