<div class="w3-container w3-teal ">
   <h1  class="w3-animate-zoom w3-panel w3-center">WhatWhat!</h1>
   <?php
       if(isset($_SESSION['loggedin'])) {
           echo '
           <div class="nav-opt"><a href="index.php" class="set">Alll the Gallery</a></div>
           <div class="nav-opt"><a href="#" class="set">My Gallery</a></div>
           <div class="nav-opt"><a href="booth.php" class="set">Photo Booth</a></div>
           <div class="nav-opt"><a href="#">Logout</a></div>
           <div class="nav-opt"><a href="#">My Profile</a></div>';
       }
       else {
           echo '
           <div class="nav-opt"><a href="index.php" class="set">Alll the Gallery</a></div>
           <div class="nav-opt"><a href="signup.php">Sign Up</a></div>
           <div class="nav-opt"><a href="login.php">Login</a></div>';
       }
   ?>
</div>