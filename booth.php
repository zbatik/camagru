<?php   require $_SERVER["DOCUMENT_ROOT"]."/camagru/shared/header.php"; 
        require_once './classes/db.class.php';
        header("Access-Control-Allow-Origin: *");
?>

<script>
    
    window.addEventListener("DOMContentLoaded",function() {

    var video = document.getElementById("video"),
    canvas = document.getElementById("canvas"),
    context = canvas.getContext("2d"),
    canvas_hidden = document.getElementById("canvas-hidden"),
    context_hidden = canvas_hidden.getContext("2d"),

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
    overlay_imgs = document.querySelectorAll(".overlays")
    for (i = 0; i < overlay_imgs.length; i++) {
    
        overlay_imgs[i].addEventListener('click', function(){
        // overlay_obj = document.getElementById(this.id);
        //console.log(this.getAttribute("data-clicked"));
        if (this.getAttribute("data-clicked") == "false")
        {
            overlay = document.createElement('img');
            overlay.setAttribute("src", this.src);
            overlay.setAttribute("class", "overlays-selected");
            video.parentNode.insertBefore(overlay, video.nextSibling);
            this.setAttribute("data-clicked", true);
        }
    });
    }

    document.getElementById("capture-but").addEventListener('click', function(){
        canvas.width = video.width;
        canvas.height = video.height;
        context.drawImage(video, 0, 0, 400, 300);
        canvas_hidden.width = video.width;
        canvas_hidden.height = video.height;
        context_hidden.drawImage(video, 0, 0, 400, 300);
        overlay_imgs = document.querySelectorAll(".overlays-selected");
        for (i = 0; i < overlay_imgs.length; i++) {
            context.drawImage(overlay_imgs[i], 0, 0, 400, 300);
        }
    });
    document.getElementById("clear-but").addEventListener('click', function(){
        sel_overlay_imgs = document.querySelectorAll(".overlays-selected");
        for (i = 0; i < sel_overlay_imgs.length; i++) {
            sel_overlay_imgs[i].remove();
        }
        clickers = document.querySelectorAll(".overlays");
        for (i = 0; i < clickers.length; i++)
            clickers[i].setAttribute("data-clicked", "false");
    });
    document.getElementById("save-but").addEventListener('click', function(){
        currentpic = canvas.toDataURL();
        photo = document.createElement('img');
        photo.setAttribute("src", currentpic);
        camera_roll = document.getElementById("photo-reel");
        camera_roll.insertBefore(photo, camera_roll.firstElementChild);
        photo.setAttribute("style", "transform: rotateY(180deg);-webkit-transform:rotateY(180deg); -moz-transform:rotateY(180deg);");
        // build up array of overlays
        var overlay_src = new Array
        sel_overlay_imgs = document.querySelectorAll(".overlays-selected");
        for (i = 0; i < sel_overlay_imgs.length; i++) {
            overlay_src[i] = sel_overlay_imgs[i].src;
        }
        //console.log(overlay_src);
        PostPhoto(canvas_hidden.toDataURL(), overlay_src);
    });

    document.getElementById('upload-but').addEventListener('change', function(e){

            var reader = new FileReader();
            reader.onload = function(event){
                var img = new Image();
                img.onload = function(){
                    canvas.width = img.width;
                    canvas.height = img.height;
                    context.drawImage(img,0,0);
                }
                img.src = event.target.result;
            }
            reader.readAsDataURL(e.target.files[0]);    
    });
    
});
</script>

<?php 
    if ($_SESSION['logged_on'])
    {
        echo '
        <div id="upload-wrapper">
            
            <div class="overlays-container">
            <video style=""id="video" width="400" height="300" src=""></video>
            </div>
            <canvas id="canvas" width="400" height="300" > </canvas>
            <canvas id="canvas-hidden" width="400" height="300" style="display: none"> </canvas>
            <div id="overlay-wrapper">
                <img class="overlays" data-clicked="false" src="./img/273126276018201.png">
                <img class="overlays" data-clicked="false" src="./img/257922923008212.png">
                <img class="overlays" data-clicked="false" src="./img/285330915029211.png">
                <img class="overlays" data-clicked="false" src="./img/285334351024211.png">
                <img class="overlays" data-clicked="false" src="./img/285330963028211.png">
                <img class="overlays" data-clicked="false" src="./img/285259587044211.png">
                <img class="overlays" data-clicked="false" src="./img/285255134024211.png">
                <img class="overlays" data-clicked="false" src="./img/285243888034211.png">
            </div>
            <img alt="" id="upload_2" style="width : 400px; position : absolute; z-index: -20;" hidden="true"src="">
            <button id="capture-but">take photo</button>
            
            <label>Upload File:</label>
            <input type="file" id="upload-but" name="upload-but"/>
            <button id="save-but">save photo</button>
            <button id="clear-but">clear overlays</button>
        </div>
        <div id="photo-reel">';
        
        $db = new DB;
        $photos = $db->SelectUserPhotos($_SESSION["id"]);
        echo $_SESSION["id"];
        while (($row = $photos->fetch(PDO::FETCH_ASSOC))) {
            echo "<img src='".$row["photo_data"]."'>";
        }
        echo '</div>';
    } else {
        header("Location: login.php");
    }



require $_SERVER["DOCUMENT_ROOT"]."/camagru/shared/footer.php"; 
?>
