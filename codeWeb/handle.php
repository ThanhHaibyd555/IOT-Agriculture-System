 <?php
 if(isset($_GET["update"]))
 {
  $conn=mysqli_connect("localhost","root","","test_data");
  mysqli_set_charset($conn, "UTF8");
  
  $nhietdo=$_GET["v1"];
  $doam=$_GET["v2"];
  /*
  $gio=$_GET["v3"];
  $apsuat=$_GET["v4"];
  $co=$_GET["v5"];
  $so2=$_GET["v6"];
  */
  date_default_timezone_set('Asia/Ho_Chi_Minh');  // lay thoi gian online
  // them du lieu vao bang   
  $trave=mysqli_query($conn,"update giamsatmoitruong set nhietdo='$nhietdo',doam='$doam',t='1'");
 }
 else if(isset($_GET["check"]))
 {
   $conn=mysqli_connect("localhost","root","","test_data");  
   mysqli_set_charset($conn, "UTF8");
   if($_GET["dem"] == "30")$trave=mysqli_query($conn,"update giamsatmoitruong set t='0'");
   $trave=mysqli_query($conn,"select * from giamsatmoitruong"); //truy cap vao database de lay thong tin lich su moi nhat
   $data=mysqli_fetch_assoc($trave);
   $on="";
   if($data["t"]=="1")$on="Online";
   else $on="Offline";
   $res = array(
         "v1" => $data["nhietdo"],
         "v2" => $data["doam"],
         "online" => $data["t"]
       );
    echo json_encode($res);
 }
?>
 