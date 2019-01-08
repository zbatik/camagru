<?php 
    require $_SERVER["DOCUMENT_ROOT"]."/camagru/shared/header.php"; 
    require_once './classes/db.class.php';

    $db = new DB;
    $photos = $db->SelectAllPhotos();

    while (($row = $photos->fetch(PDO::FETCH_ASSOC))) {
    // foreach ($photos as $photo)
    // {
        echo "<img src='".$row["photo_data"]."'>";
    }
?>
<?php require $_SERVER["DOCUMENT_ROOT"]."/camagru/shared/footer.php"; ?>