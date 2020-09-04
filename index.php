<?php

/*-- 
    Name:           Rahulkumar Patel
    File:           index.php
    Date:           31/08/2020
    Description:    index page of web application, to get login-url. 
--*/

//$title, to get title of web-page
$title = "Chatt";
session_start();                           //session start    
require 'autoload.php';                    //TO load page
use Abraham\TwitterOAuth\TwitterOAuth;     // Abrahaam Libraries 
include ("./header.php");                  // Print Title
include ("./function.php");                // predefined functions
?>

<!-- body Start -->
<div class="about-c" id="container">
     <section id="hero" class="s-hero">
        <div class="s-hero__bg">
            <div class="gradient-overlay"></div>
        </div>

        <div class="row s-hero__content">
            <div class="column">
                <div class="s-hero__content-about">
                    <p>
                    This is a Twitt -Chatt <br>
                    building great  <br>
                    digital experiences.
                    </p>
                    <?php if (!isset($_SESSION['access_token'])) {    // Conditin to check session, and display button
                    ?>
                   <button onclick="myLogin()">Login</button>
                    <?php }
                        // session_destroy();                         // To manually end the session
                     ?> 
                  
                </div>
            </div>
        </div>
  
    </section> 
 
</div>
<script>
        // Function to redirect to the  Twitter login page
        function myLogin() {
           $ul= "<?php echo login();?>";
           window.close();      // Close current window
           window.open($ul);    // Open new Window
           // window.close();
        }
</script>

<!--body end-->

<?php
include ("./footer.php");
?>