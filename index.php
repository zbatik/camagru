<?php 
    require $_SERVER["DOCUMENT_ROOT"]."/camagru/shared/header.php"; 
    require_once './classes/db.class.php';

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
        echo "<button onClick=#>like</button>";
        echo "<p> likes:".$row["likes"]."</p>";
        echo "</div>";
    }
?>
<?php require $_SERVER["DOCUMENT_ROOT"]."/camagru/shared/footer.php"; ?>