<?php

/*-- 
    Name:           Rahulkumar Patel
    File:           logout.php
    Date:           31/08/2020
    Description:    logout page, Session end and ridect to index.php page. 
--*/
 session_start();             //  To call Session Token
 session_destroy();           //  To end Token Seesion and user logout
 //echo 'welll';
 header('location: ./');      //  To redirect to the home page
 
 ?>