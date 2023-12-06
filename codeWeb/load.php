<?php


 header("Access-Control-Allow-Origin: *");
 header("Content-Type: application/json; charset=UTF-8");

//Creating Array for JSON response
$response = array();
 
// Check if we got the field from the user
if (isset($_GET['id']) && isset($_GET['status'])) {
 
    $id = $_GET['id'];
    $status= $_GET['status'];
    
 
    // Include data base connect class
    $conn=mysqli_connect("localhost","root","","greenhouse");
    mysqli_set_charset($conn, "UTF8");
 
    // Fire SQL query to update weather data by id
    $result = mysqli_query($conn,"UPDATE control_led SET status= '$status' WHERE id = '$id'");
 
    // Check for succesfull execution of query and no results found
    if ($result) {
        // successfully updation of temp (temperature)
        $response["success"] = 1;
        $response["message"] = "Led successfully updated.";
 
        // Show JSON response
        echo json_encode($response);
    } else {
 
    }
} else {
    // If required parameter is missing
    $response["success"] = 0;
    $response["message"] = "Parameter(s) are missing. Please check the request";
 
    // Show JSON response
    echo json_encode($response);
}

// Toi day


// //Creating Array for JSON response
// $response = array();
 
// // Check if we got the field from the user
//  if (isset($_GET['id']) && isset($_GET['tt1']) && isset($_GET['tt2'])&& isset($_GET['tt3'])&& isset($_GET['tt4']) )


//     //isset($_GET['nhietdo'])|| isset($_GET['doam']))
//     //,nhietdo= '$nhietdo',doam= '$doam'
// //if(isset($_GET["update"]))
//  {
//     $conn=mysqli_connect("localhost","root","","greenhouse");
//     mysqli_set_charset($conn, "UTF8");
    
//     $id = $_GET['id'];
//     $tt1= $_GET['tt1'];
//     $tt2= $_GET['tt2'];
//     $tt3= $_GET['tt3'];
//     $tt4= $_GET['tt4'];
//     // $nhietdo=$_GET["nhietdo"];
//     // $doam=$_GET["doam"];

//     date_default_timezone_set('Asia/Ho_Chi_Minh');  
    
 
//     // // Include data base connect class
// 	// $conn=mysqli_connect("localhost","root","","test_data");
//     // mysqli_set_charset($conn, "UTF8");
 
// 	// Fire SQL query to update weather data by id
//     $result = mysqli_query($conn,"UPDATE gom SET tt1= '$tt1',tt2= '$tt2',tt3= '$tt3',tt4= '$tt4'");

  
    
//     // Check for succesfull execution of query and no results found
//     if ($result) {
//         // successfully updation of temp (temperature)
//         $response["success"] = 1;
//         $response["message"] = "Led successfully updated.";
 
//         // Show JSON response
//         echo json_encode($response);
//     } else {
 
//     }
// } else {
//     // If required parameter is missing
//     $response["success"] = 0;
//     $response["message"] = "Parameter(s) are missing. Please check the request";
 
//     // Show JSON response
//     echo json_encode($response);
// }



  // if (isset($_GET['v1']) && isset($_GET['v2']) ) {
  //     $conn=mysqli_connect("localhost","root","","greenhouse");
  //     mysqli_set_charset($conn, "UTF8");
     

  //      $nhietdo=$_GET["v1"];
  //      $doam=$_GET["v2"];

  //      $result = mysqli_query($conn,"UPDATE monitoring SET nhietdo= '$nhietdo',doam= '$doam' ");

  // }

  // if ($result) {
  //       // successfully updation of temp (temperature)
  //       $response["success"] = 1;
  //       $response["message"] = "Giamsat successfully updated.";
 
  //       // Show JSON response
  //       echo json_encode($response);
  //   }





 //  // if(isset($_GET["update"]))
 // if (isset($_GET['v1']) && isset($_GET['v2']) )
 // {
 //  $conn=mysqli_connect("localhost","root","","greenhouse");
 //  mysqli_set_charset($conn, "UTF8");
  
 //  $nhietdo=$_GET["v1"];
 //  $doam=$_GET["v2"];
 //  /*
 //  $gio=$_GET["v3"];
 //  $apsuat=$_GET["v4"];
 //  $co=$_GET["v5"];
 //  $so2=$_GET["v6"];
 //  */
 //  date_default_timezone_set('Asia/Ho_Chi_Minh');  // lay thoi gian online
  // them du lieu vao bang   
 //  $trave=mysqli_query($conn,"update giamsat set nhietdo='$nhietdo',doam='$doam',t='1'");
 // }
 // else if(isset($_GET["check"]))
 // {
 //   $conn=mysqli_connect("localhost","root","","greenhouse");  
 //   mysqli_set_charset($conn, "UTF8");
 //   if($_GET["dem"] == "30")$trave=mysqli_query($conn,"update giamsat set t='0'");
 //   $trave=mysqli_query($conn,"select * from giamsat"); //truy cap vao database de lay thong tin lich su moi nhat
 //   $data=mysqli_fetch_assoc($trave);
 //   $on="";
 //   if($data["t"]=="1")$on="Online";
 //   else $on="Offline";
 //   $res = array(
 //         "v1" => $data["nhietdo"],
 //         "v2" => $data["doam"],
 //         "online" => $data["t"]
 //       );
 //    echo json_encode($res);
 // }


?>


