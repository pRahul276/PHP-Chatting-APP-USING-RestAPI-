<?php

/*-- 
    Name:           Rahulkumar Patel
    File:           Display.php
    Date:           01/09/2020
    Description:    This is a page, which is display user's timeline and hometimeline twitt, and profile info
                    and also allow user to search twitt by hastag. 
--*/
    $title = "Display";
    include ("./predefine.php");       
    require 'autoload.php'; 
    use Abraham\TwitterOAuth\TwitterOAuth;

use Abraham\TwitterOAuth\TwitterOAuth;
    session_start();               //Session for token
    //echo 'wellcome'; 
 
    $access_token = $_SESSION['access_token'];
 
    // $connection, To get the connection with Twitter API
     $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
 
    // $user, To get the user Information
    $user = $connection->get("account/verify_credentials");
    // print_r ($user);

    // $user_homtime, To get home timeline twitt
    $user_homtime =$connection->get("statuses/home_timeline");
    //print_r($user_homtime);

    /* declaration of empty arrays to store
     * $text, for a twitt
     * $id, for an id of user who commit twitt
     * $time, for a twitt real time
     * $all, to store all in a single array, 
     * $nim, to store one user detail as an array, and then I converted in JSON and after,
     *       that in JavaScript to use in front-end.
     */
    $text = array();
    $id = array();
    $time = array ();
    $all = array();
    $min =array();
    foreach ($user_homtime as $uh){
        foreach ($uh as $key=>$value){
            if($key == "created_at"){
                array_push($time,$value); ;     
            }  
        }
    }       

    foreach ($user_homtime as $uh){  
        foreach ($uh as $key=>$value){
            if($key == "id"){
                array_push($id,$value); ;     
            }  
        }
    }

    foreach ($user_homtime as $uh){  
        foreach ($uh as $key=>$value){
            if($key == "text"){
                array_push($text,$value); ;     
            }  
        }
    }
    
    for($i=0; $i< count($id); $i++){
         $all[] = [$id[$i],$text[$i],$time[$i]];
     }

     //$user_timeline, to get user name 
    $user_timeline= $connection ->get ("statuses/user_timeline",["screen_name"=> $user->screen_name]);
    //print_r($user_homtime);
          
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
    <head>
<!--use J Query to Display data In a Data Table -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"/> 
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

        <title>"<?php echo $title;?>"</title>
        <style type="text/css">
		table 
		{
		  border-collapse: collapse;
		  width: 20%;
		}

		th, td 
		{
		  text-align: center;
		  padding: 10px;
		}


		th {
		  background-color: #808080;
		  color: white;
         }
	    </style>

    </head>  
    <body>
        <h3>Well come: <?php echo $user->screen_name;?></h3>
        <img src="<?php echo $user->profile_image_url; ?>"></img>
        <h1>Home Time Line</h1>
        <table id="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Twit</th>
                    <th>Time</th>
                <tbody></tbody>
                </tr>
            </thead>
        </table>
        <form method="post" action="" >
            <table border="0" cellpadding="10" style="margin-left:auto; margin-right:auto;background-color:#fafad2;">
                <label>Search : <input type="text" name="keyword"></label> <br/> 
                <a href="./logout.php">Log Out</a> <br/>
               <?php 
               if( isset($_POST['keyword'])){
                    $search = isset($_POST["keyword"])?trim($_POST["keyword"]):"";
                    $query = "#".(string)$search;
        
                    $c = $connection ->get ("search/tweets",["q"=>$query ,"include_entities"=>true]);
                    print_r($c);
                     foreach ($c as $key => $value) {
                        if($key == "statuses"){
                            foreach ($value as $z){
                                foreach ($z as $key => $value_2) {
                                    if($key == "text"){
                                     //echo $value_2 .'<br>.';
                                    }

                                }
                            }
                        }
                        //else{                echo 'noooo';}
                       }
                }
               ?> 
            </table>    
        </form>
    </body>
    <script>
        <?php
              // Converting all array in JSON 
              $j_text= json_encode($text);
              $j_id = json_encode($id); 
              $j_time = json_encode($time);
              $j_all = json_encode($all);
        ?>
            
        // Converting Php variable into JS    
        var text = <?php echo $j_text;?>;
        var id = <?php echo $j_id;?>;
        var time = <?php echo $j_time;?>;
        var all = <?php  echo $j_all;?>;
       
        //Script to call DATA TABLE
        var table = $('#table').DataTable( {
        data: all,                     // Assigning ALl array's data to the DATATABLE data array to diplay those fields.
        columns: [
            { title: "ID" },
            { title: "Twit" },
            { title: "Time" }
          
        ]
    } );
    
    </script>
</html>
        
        
       
              
       
        


