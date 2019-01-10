<?php 
    require $_SERVER["DOCUMENT_ROOT"]."/camagru/shared/header.php"; 
    require_once './classes/db.class.php';
?>

<script>
    function addLike(user_id, photo_id) {
        // POST ADD LIKE
        var xhttp = new XMLHttpRequest();
        var postObj = {
            action: "add",
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
        // ADD TO THE LIKE COUNT
        var count = document.getElementById("photo-id-" + photo_id);
        if (count.innerHTML == "")
        {
            count.innerHTML = 1;
        } else {
            count.innerHTML = parseInt(count.innerHTML) + 1;
        }
        var likebut = document.getElementById("like-but-" + photo_id);
        // CHANGE THE BUTTON FN TO REMOVE THE LIKE
        likebut.onclick = removeLike;
        // CHANGE THE TEXT AND COLOUR
        likebut.innerHTML = "unlike";
        likebut.style.backgroundColor = "grey";
        console.log("like added");
    }

    function removeLike(user_id, photo_id) {
        // POST DELETE LIKE
        var xhttp = new XMLHttpRequest();
        var postObj = {
            action: "remove",
            user_id: user_id,
            photo_id : photo_id
        }
        xhttp.open("POST", "like_handler.php");
        xhttp.setRequestHeader("Content-type", "application/json");
        xhttp.onreadystatechange = function(data) {
            if (this.readyState == 4 && this.status == 200) {
                console.log('del like'+this.responseText);
                return ;
            } 
        };
        xhttp.send(JSON.stringify(postObj));
        
        var likebut = document.getElementById("like-but-" + photo_id);
        // CHANGE THE BUTTON FN TO REMOVE THE LIKE
        likebut.onclick = addLike;
        // CHANGE THE TEXT AND COLOUR
        likebut.innerHTML = "like";
        likebut.style.backgroundColor = "green";


        var count = document.getElementById("photo-id-" + photo_id);
        count.innerHTML = parseInt(count.innerHTML) - 1;
 
        console.log("like removed");
    }
</script>
<?php
    $db = new DB;
    $photos = $db->SelectAllPhotos();
    $user_id = $_SESSION["id"];
    while (($row = $photos->fetch(PDO::FETCH_ASSOC))) {
        $photo_id = $row["id"];
        echo "<div class=post-wrapper>
                <div class=photo-wrapper>
                    <img src='".$row["photo_data"]."'>
                </div>
                <p>".$row["comment"]."</p>";
        echo "<form action='' method='post' id='comment-form'>
                <div class='container'>
                    <label for='comment'><b>Comment</b></label>
                    <input type='text' placeholder='Type comment' name='comment' required>
                    <button type='submit'>Add Comment</button>
                </div>
            </form>";
        if ($db->IsLiked($user_id, $photo_id))
            echo "<button id='like-but-$photo_id' onclick='removeLike($user_id, $photo_id)' style='background-color: grey'>unlike</button>";
        else
            echo "<button id='like-but-$photo_id' onclick='addLike($user_id, $photo_id)'>like</button>";
        echo "<p>likes:<span id='photo-id-$photo_id'>".$row["likes"]."</span></p>";
        echo "</div>";
    }
?>
<?php require $_SERVER["DOCUMENT_ROOT"]."/camagru/shared/footer.php"; ?>