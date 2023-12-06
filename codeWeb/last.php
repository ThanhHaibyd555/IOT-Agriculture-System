<?php 

	// header("Access-Control-Allow_Origin: *");
	// header("Content-Type: application/json; charset=UTF-8");
   
   header_remove();
  


   $conn=mysqli_connect("localhost","root","","greenhouse") or die("Just keep going");
 	mysqli_set_charset($conn, "UTF8");

	if($result = mysqli_query($conn,"SELECT id,status FROM control_led LIMIT 1 ")){
      
      foreach ($result as $row1 ) {
				// code...
				//print_r($row);
            //print_r($row1) ;
			}
	}

   if($result = mysqli_query($conn,"SELECT id,status FROM control_led LIMIT 1 OFFSET 1")){   

      foreach ($result as $row2 ) {
				// code...
				//print_r($row);
            //print_r($row2) ;
			}	
	}

   if($result = mysqli_query($conn,"SELECT id,status FROM control_led LIMIT 1 OFFSET 2")){   

      foreach ($result as $row3 ) {
				// code...
				//print_r($row);
            //print_r($row3) ;
			}	
	}

   if($result = mysqli_query($conn,"SELECT id,status FROM control_led LIMIT 1 OFFSET 3")){   

      foreach ($result as $row4 ) {
				// code...
				//print_r($row);
            //print_r($row4) ;
			}	
	}

 
 


	// $conn=mysqli_connect("localhost","root","","greenhouse") or die("Just keep going");
 	// mysqli_set_charset($conn, "UTF8");

	// if($result = mysqli_query($conn,"SELECT id,tt1,tt2,tt3,tt4 FROM gom")){

	// 		foreach ($result as $row ) {
				
	// 		}
		
	// }

				//dang table

//     if (isset($_GET['v1']) && isset($_GET['v2']) ) {
//       $conn=mysqli_connect("localhost","root","","greenhouse");
//       mysqli_set_charset($conn, "UTF8");
     

//        $nhietdo=$_GET["v1"];
//        $doam=$_GET["v2"];

//        $result = mysqli_query($conn,"UPDATE monitoring SET nhietdo= '$nhietdo',doam= '$doam' ");

//   }

//   if ($result) {
//         // successfully updation of temp (temperature)
//         $response["success"] = 1;
//         $response["message"] = "Giamsat successfully updated.";
 
//         // Show JSON response
//         echo json_encode($response);
//     }


//     if($result = mysqli_query($conn,"SELECT nhietdo,doam FROM monitoring")){

// 			foreach ($result as $row ) {
// 				// code...
// 				print_r($row);
// 			}
		
// 	}



			//	dang table

//     if (isset($_GET['v1']) && isset($_GET['v2']) ) {
//       $conn=mysqli_connect("localhost","root","","greenhouse");
//       mysqli_set_charset($conn, "UTF8");
     

//        $nhietdo=$_GET["v1"];
//        $doam=$_GET["v2"];

//        $result = mysqli_query($conn,"UPDATE monitoring SET nhietdo= '$nhietdo',doam= '$doam' ");
	  


//   }

//   if ($result) {
//         // successfully updation of temp (temperature)
//         $response["success"] = 1;
//         $response["message"] = "Giamsat successfully updated.";
 
//         // Show JSON response
//         echo json_encode($response);
//     }


//     if($result = mysqli_query($conn,"SELECT nhietdo,doam FROM monitoring")){
           

// 			// foreach ($result as $row ) {
// 			// 	// code...
// 			// 	print_r($row);
// 			// }

// 			$data=mysqli_fetch_assoc($result);
// 			$res = array(
// 			 "v1" => $data["nhietdo"],
// 			 "v2" => $data["doam"],
			 
// 			 );
// 			  echo json_encode($res);
	 
		
// 	}



//         // if(isset($_GET["update"]))
//  if (isset($_GET['v1']) && isset($_GET['v2']) )
//  {
//   $conn=mysqli_connect("localhost","root","","greenhouse");
//   mysqli_set_charset($conn, "UTF8");
  
//   $nhietdo=$_GET["v1"];
//   $doam=$_GET["v2"];
//   /*
//   $gio=$_GET["v3"];
//   $apsuat=$_GET["v4"];
//   $co=$_GET["v5"];
//   $so2=$_GET["v6"];
//   */
//   date_default_timezone_set('Asia/Ho_Chi_Minh');  // lay thoi gian online
//   //them du lieu vao bang   
//   $trave=mysqli_query($conn,"update giamsat set nhietdo='$nhietdo',doam='$doam',t='1'");
//   $data=mysqli_fetch_assoc($trave);
//   $res = array(
// 	"v1" => $data["nhietdo"],
// 	"v2" => $data["doam"],
// 	"online" => $data["t"]
//     );
//      echo json_encode($res);
//  }

 
//  else if(isset($_GET["check"]))
//  {
//    $conn=mysqli_connect("localhost","root","","greenhouse");  
//    mysqli_set_charset($conn, "UTF8");
//    if($_GET["dem"] == "30")$trave=mysqli_query($conn,"update giamsat set t='0'");
//    $trave=mysqli_query($conn,"select * from giamsat"); //truy cap vao database de lay thong tin lich su moi nhat
//    $data=mysqli_fetch_assoc($trave);
//    $on="";
//    if($data["t"]=="1")$on="Online";
//    else $on="Offline";
//    $res = array(
//          "v1" => $data["nhietdo"],
//          "v2" => $data["doam"],
//          "online" => $data["t"]
//        );
//     echo json_encode($res);
//  }

        //dang fix
// if(isset($_GET["update"]))
//  {
//   $conn=mysqli_connect("localhost","root","","greenhouse");
//   mysqli_set_charset($conn, "UTF8");
  
//   $nhietdo=$_GET["v1"];
//   $doam=$_GET["v2"];
//   /*
//   $gio=$_GET["v3"];
//   $apsuat=$_GET["v4"];
//   $co=$_GET["v5"];
//   $so2=$_GET["v6"];
//   */
//   date_default_timezone_set('Asia/Ho_Chi_Minh');  // lay thoi gian online
//   // them du lieu vao bang   
//   $trave=mysqli_query($conn,"update giamsat set nhietdo='$nhietdo',doam='$doam',t='1'");
//  }
//  else if(isset($_GET["check"]))
//  {
//    $conn=mysqli_connect("localhost","root","","greenhouse");  
//    mysqli_set_charset($conn, "UTF8");
//    // if($_GET["dem"] == "30")$trave=mysqli_query($conn,"update giamsatmoitruong set t='0'");
//    $trave=mysqli_query($conn,"select * from giamsat"); //truy cap vao database de lay thong tin lich su moi nhat
//    $data=mysqli_fetch_assoc($trave);
//    // $on="";
//    // if($data["t"]=="1")$on="Online";
//    // else $on="Offline";
//    $res = array(
//          "v1" => $data["nhietdo"],
//          "v2" => $data["doam"],
//          "online" => $data["t"]
//        );
//     echo json_encode($res);
//  }

// dang test 

// if(isset($_GET["update"]))
//  {
//   $conn=mysqli_connect("localhost","root","","greenhouse");
//   mysqli_set_charset($conn, "UTF8");
  
//   $nhietdo=$_GET["v1"];
//   $doam=$_GET["v2"];
//   /*
//   $gio=$_GET["v3"];
//   $apsuat=$_GET["v4"];
//   $co=$_GET["v5"];
//   $so2=$_GET["v6"];
//   */
//   date_default_timezone_set('Asia/Ho_Chi_Minh');  // lay thoi gian online
//   // them du lieu vao bang   
//   $trave=mysqli_query($conn,"update giamsat set nhietdo='$nhietdo',doam='$doam',t='1'");
//  }
//  else if(isset($_GET["check"]))
//  {
//    $conn=mysqli_connect("localhost","root","","greenhouse");  
//    mysqli_set_charset($conn, "UTF8");

//   //  $result = mysqli_query($conn,"SELECT id,status FROM control_led");


//    // if($_GET["dem"] == "30")$trave=mysqli_query($conn,"update giamsatmoitruong set t='0'");
//    $trave=mysqli_query($conn,"select * from giamsat"); //truy cap vao database de lay thong tin lich su moi nhat
//    $data=mysqli_fetch_assoc($trave);
 
//    // $on="";
//    // if($data["t"]=="1")$on="Online";
//    // else $on="Offline";
//    $res = array(
//          "v1" => $data["nhietdo"],
//          "v2" => $data["doam"],
//          "online" => $data["t"],
//          $row1,
//          $row2,
//          $row3,
//          $row4,   
//        );
//     echo json_encode($res);
//  }



if(isset($_GET["update"]))
 {
  $conn=mysqli_connect("localhost","root","","greenhouse");
  mysqli_set_charset($conn, "UTF8");
  
  $nhietdo=$_GET["v1"];
  $doam=$_GET["v2"];
  //tu doan nay
  $doamdat=$_GET["v3"];
  $anhsang=$_GET["v4"];

  /*
  $gio=$_GET["v3"];
  $apsuat=$_GET["v4"];
  $co=$_GET["v5"];
  $so2=$_GET["v6"];
  */
  date_default_timezone_set('Asia/Ho_Chi_Minh');  // lay thoi gian online
  // them du lieu vao bang   
  $trave=mysqli_query($conn,"update giamsat set nhietdo='$nhietdo',doam='$doam',doamdat='$doamdat',anhsang='$anhsang',t='1'");


  $conn=mysqli_connect("localhost","root","","greenhouse");  
  mysqli_set_charset($conn, "UTF8");

 //  $result = mysqli_query($conn,"SELECT id,status FROM control_led");


  // if($_GET["dem"] == "30")$trave=mysqli_query($conn,"update giamsatmoitruong set t='0'");
  $trave=mysqli_query($conn,"select * from giamsat"); //truy cap vao database de lay thong tin lich su moi nhat

  $data=mysqli_fetch_assoc($trave);
 
  // $on="";
  // if($data["t"]=="1")$on="Online";
  // else $on="Offline";
  $res = array(
        "v1" => $data["nhietdo"],
        "v2" => $data["doam"],
        "v3" => $data["doamdat"],
        "v4" => $data["anhsang"],
        "online" => $data["t"],
        $row1,
        $row2,
        $row3,
        $row4,   
      );
   echo json_encode($res);


 }

 else if(isset($_GET["check"]))
 {
   $conn=mysqli_connect("localhost","root","","greenhouse");  
   mysqli_set_charset($conn, "UTF8");

  //  $result = mysqli_query($conn,"SELECT id,status FROM control_led");


   // if($_GET["dem"] == "30")$trave=mysqli_query($conn,"update giamsatmoitruong set t='0'");
   $trave=mysqli_query($conn,"select * from giamsat"); //truy cap vao database de lay thong tin lich su moi nhat
   $data=mysqli_fetch_assoc($trave);
 
   // $on="";
   // if($data["t"]=="1")$on="Online";
   // else $on="Offline";
   $res = array(
         "v1" => $data["nhietdo"],
         "v2" => $data["doam"],
         "v3" => $data["doamdat"],
         "v4" => $data["anhsang"],
         "online" => $data["t"],
         $row1,
         $row2,
         $row3,
         $row4,   
       );
    echo json_encode($res);
 }



 ?>
