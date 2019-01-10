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
        var unlikebut = document.getElementById("unlike-but-" + photo_id);
        likebut.style.display = "none";
        unlikebut.style.display = "block";
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
        var unlikebut = document.getElementById("unlike-but-" + photo_id);
        likebut.style.display = "block";
        unlikebut.style.display = "none";


        var count = document.getElementById("photo-id-" + photo_id);
        count.innerHTML = parseInt(count.innerHTML) - 1;
 
        console.log("like removed");
    }
    
    function PostCommentForm(form_id, post_to) {
        PostForm(form_id, post_to, function(event) {
            if (event.target.responseText == 1) {
                
            } else {
                console.log(event.target.responseText);
            }
        });
    }

    window.addEventListener("DOMContentLoaded",function() {
       
        var forms = document.getElementsByClassName("comment-form");
        var i;
        for (i = 0; i < forms.length; i++) {
            forms[i].addEventListener("submit", function () {
            event.preventDefault();
            // console.log(this.id);
           PostCommentForm(this.id , "comment_handler.php");
        });
        }
        // // document.getElementById("comment-form").addEventListener("submit", function (event) {
        //     event.preventDefault();
        //     PostCommentForm("comment-form", "comment_handler.php");
        // });
    });

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
                    </div>";
        if ($_SESSION["logged_on"])
        {
            echo "<form action='' method='post' id='comment-form-$photo_id' class='comment-form'>
                    <div class='container'>
                        <label for='comment'><b>Comment</b></label>
                        <input type='text' placeholder='Type comment' name='comment' required>
                        <input type='hidden' name='photo_id' value=$photo_id>
                        <input type='hidden' name='user_id' value=$user_id> 
                        <button type='submit'>Add Comment</button>
                    </div>
                </form>";
            if ($db->IsLiked($user_id, $photo_id)) {
                $unlike = "block";
                $like = "none";
            } else {
                $unlike = "none";
                $like = "block";
            }
            echo "<button id='unlike-but-$photo_id' onclick='removeLike($user_id, $photo_id)' style='background-color: grey; display: $unlike'>unlike</button>";
            echo "<button id='like-but-$photo_id' onclick='addLike($user_id, $photo_id)' style='display: $like'>like</button>";
            if ($row["username"] == $_SESSION["username"]) {
                echo "<button id='del-but' onclick='deletePhoto()' style='background-color: pink;'>delete</button>";
            }
        }
        $like_count = ($row["likes"] == null) ? 0 : $row["likes"];
        echo "<p>likes:<span id='photo-id-$photo_id'>$like_count</span></p>
            </div>";
        
    }
?>
<?php require $_SERVER["DOCUMENT_ROOT"]."/camagru/shared/footer.php"; ?>