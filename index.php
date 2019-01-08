<?php 
    require $_SERVER["DOCUMENT_ROOT"]."/camagru/shared/header.php"; 
    require_once './classes/db.class.php';
?>

<script>
    function addLike(user_id, photo_id) {
        var xhttp = new XMLHttpRequest();

        var postObj = {
            user_id: user_id,
            photo_id : photo_id
        }
        xhttp.open("POST", "like_handler.php");
        xhttp.setRequestHeader("Content-type", "application/json");
        xhttp.onreadystatechange = function(data) {
            if (this.readyState == 4 && this.status == 200) {
                console.log('->'+this.responseText);
                return ;
            } 
        };
        xhttp.send(JSON.stringify(postObj));
        var count = document.getElementById("photo-id" + photo_id);
        if (count.innerHTML == "")
        {
            count.innerHTML = 1;
        } else {
            count.innerHTML = parseInt(count.innerHTML) + 1;
        }
    }
</script>
<?php
    $db = new DB;
    $photos = $db->SelectAllPhotos();
    while (($row = $photos->fetch(PDO::FETCH_ASSOC))) {
        echo "<div class=post-wrapper>";
        echo "<div class=photo-wrapper>";
        echo "<img src='".$row["photo_data"]."'>";
        echo "</div>";
        echo "<p>".$row["comment"]."</p>"; ?>
        <form action="" method="post" id="login-form">
            <div class="container">
                <label for="comment"><b>Comment</b></label>
                <input type="text" placeholder="Type comment" name="comment" required>
                <button type="submit">Add Comment</button>
            </div>
        </form>
        <?php
        echo "<button onclick='addLike(".$_SESSION["id"].", ".$row["id"].")'>like</button>";
        echo "<p> likes: <span id='photo-id".$row["id"]."'>".$row["likes"]."</span></p>";
        echo "</div>";
    }
?>
<?php require $_SERVER["DOCUMENT_ROOT"]."/camagru/shared/footer.php"; ?>