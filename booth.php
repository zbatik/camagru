<?php   require $_SERVER["DOCUMENT_ROOT"]."/camagru/shared/header.php"; 
        require_once './classes/db.class.php';
?>

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
        canvas.width = video.width;
        canvas.height = video.height;
        context.drawImage(video, 0, 0, 400, 300);    
    });
    document.getElementById("save-but").addEventListener('click', function(){
        
        currentpic = canvas.toDataURL();
        photo = document.createElement('img');
        photo.setAttribute("src", currentpic);
        camera_roll = document.getElementById("photo-reel");
        camera_roll.insertBefore(photo, camera_roll.firstElementChild);
        photo.setAttribute("style", "transform: rotateY(180deg);-webkit-transform:rotateY(180deg); -moz-transform:rotateY(180deg);");
        PostPhoto(currentpic);
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
            
            <label>Upload File:</label>
            <input type="file" id="upload-but" name="upload-but"/>
            <button id="save-but">save photo</button>
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
