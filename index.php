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
        xhttp.onreadystatechange = function(event) {
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

    function deletePhoto(photo_id) {
        var xhttp = new XMLHttpRequest();

        var postObj = {
            action: "delete_photo",
            photo_id : photo_id
        }
        xhttp.open("POST", "gallery_handler.php");
        xhttp.setRequestHeader("Content-type", "application/json");
        console.log(postObj);
        
        xhttp.onreadystatechange = function(data) {
            if (this.readyState == 4 && this.status == 200) {
                console.log("photo deleted");
                return ;
            } 
        };
        xhttp.send(JSON.stringify(postObj));
 
        var element = document.getElementById("post-wrapper-"+photo_id);
        element.parentNode.removeChild(element);
    }

    window.addEventListener("DOMContentLoaded",function() {
       
        var forms = document.getElementsByClassName("comment-form");
        var i;
        for (i = 0; i < forms.length; i++) {
            forms[i].addEventListener("submit", function () {
            event.preventDefault();           
            PostCommentForm(this.id, "comment_handler.php");
            
         // sort out the updating of the comments
            p = document.createElement('p');
            p.innerHTML = "comment added refresh to view";
            comment_box = document.getElementById(this.id);
            comment_box.insertBefore(p, comment_box.firstElementChild);
           
        }); // end comment form listeners
    } // end for
    }); // end DOM loaded listener

</script>
<?php
    if (!isset($_GET["page"])){
        $_GET["page"] = 0;
    }
    $db = new DB;
    $num_posts = $db->CountPosts($_GET["page"]);
    $photos = $db->SelectAllPhotos($_GET["page"] * 5);
    $user_id = $_SESSION["id"];
    echo "<div id='gallery-wrapper'>";
    while (($row = $photos->fetch(PDO::FETCH_ASSOC))) {
        $photo_id = $row["id"];
        $photo_user_id = $row["user_id"];
            echo "<div class=post-wrapper id='post-wrapper-$photo_id'>
                    <div class=photo-wrapper id='photo-wrapper-$photo_id'>
                        <img src='".$row["photo_data"]."'>
                    </div>";
            echo "<div class='comment-wrapper' id='comment-wrapper-$photo_id'>
                    <p><b>Comments:</b></p>";
            $comments = $db->SelectComments($photo_id);
            while ($row = $comments->fetch(PDO::FETCH_ASSOC)) {
                $comment = htmlspecialchars($row["comment"], ENT_QUOTES, 'UTF-8');
                echo "<p><b>".$row["username"].":</b> $comment</p>";
            }
            echo "</div>"; // comment wrapper

            if ($_SESSION["logged_on"])
            {
                echo "<form action='' method='post' id='comment-form-$photo_id' class='comment-form'>
                    <div class='container'>
                        <label for='comment'><b>Comment</b></label>
                        <input type='text' placeholder='Type comment' name='comment' required>
                        <input type='hidden' name='photo_id' value=$photo_id>
                        <input type='hidden' name='user_id' value=$user_id> 
                        <input type='hidden' name='photo_user_id' value=$photo_user_id>
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

                if ($photo_user_id == $user_id) {
                    echo "<button class='del-but' class='del-but-$photo_id' onclick='deletePhoto($photo_id)'>delete</button>";
                }
            }
       // $like_count = ($row["likes"] == null) ? -1 : $row["likes"];
       // echo "<p>likes:<span id='photo-id-$photo_id'>$like_count</span></p>
          echo   "</div>"; //post wrapper
    }
    echo "</div>"; //gallery wrapper

    echo "<p>Select Page</p>";
    echo "<form action='index.php' method='get'>";
    for ($i = 0; $i < $num_posts / 5; $i++) {
        echo "<button name='page' type='submit' value='$i'>Go to page $i</button>";
    }
    echo "</form>";
?>
<?php require $_SERVER["DOCUMENT_ROOT"]."/camagru/shared/footer.php"; ?>