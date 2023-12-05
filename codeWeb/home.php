<?php 
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {

 ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trang Giam Sat</title>
    <link rel="stylesheet" type="text/css" href="homee.css" /> 

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.js" type="text/javascript">
    </script>

    <script>
        var dem=0;
        setInterval(function()
        {
            $(document).ready(function(){ 
            $.ajax({
                url:"last.php",
                type:"get",
                data:"check=ok&dem="+dem,
                async:false,
                success:function(kq)
                {
                    
                  var data = $.parseJSON(kq); 
                  
                  var nhietdo=data["v1"];
                  var doam=data["v2"];
    
                  var online=data["online"];
                  
                  $('#nhietdo_v').html(nhietdo + "°C");
                  $('#doam_v').html(doam + "%");
                  
                  if(online=="1")$('#tieude').html("Hệ thống giám sát môi trường - Online");
                  else $('#tieude').html("Hệ thống giám sát môi trường - Offline");
                }
            })  
        
            });dem++;if(dem>30)dem=0;
        }, 500);
     
</script> 
</head>
<body>  
  <section class="section-heading">
    <div class="heading">

       <div class="heading-img-box">
           <img src="image/utc2.png" class="logo-utc" alt="logo utc2" />
       </div>

       <div class="heading-text-box">
          <h4 class="heading-primary">TRƯỜNG ĐẠI HỌC GIAO THÔNG VẬN TẢI</h4>
          <h1 class="heading-second">PHÂN HIỆU TẠI TP. HỒ CHÍ MINH</h1>
          <h1 class="heading-third">KHOA ĐIỆN - ĐIỆN TỬ </h1>
          
       </div>   
       <div class="heading-mm">
          <h1 class="heading-main">ĐỒ ÁN TỐT NGHIỆP </h1>
          <p class="heading-term">  Năm học 2022-2023 </p>
       </div>  
    </div>  
  </section>

  <section class = "body-pro">
    <div class="body-cl">
        <h1 class ="text-grh">Green House</h1>
      
      <div class="monitoring">
        <div class="item1" style="border: red solid 2px;">
            <div class="tieude" style="background-color: red;"> <div class="tieude_text"> <span id="dk">Nhiệt độ</span> </div></div>
                  <div style="float:left"><img src="image/nhietdo.png" class="img_ico"/></div>
                  <div id="nhietdo_v" style="float:right" class="thongso">---</div>
        </div>

        <div class="item1" style="border: #00bcd4 solid 2px;">
            <div class="tieude" style="background-color: #00bcd4;"> <div class="tieude_text"> <span id="dk">Độ ẩm</span> </div></div>
                  <div style="float:left"><img src="image/doam.png" class="img_ico"/></div>
                  <div id="doam_v" style="float:right" class="thongso">---</div>
        </div> 

        <div class="item1" style="border: #00bcd4 solid 2px;">
            <div class="tieude" style="background-color: #00bcd4;"> <div class="tieude_text"> <span id="dk">Độ ẩm đất</span> </div></div>
                <div style="float:left"><img src="image/doamdat.png" class="img_ico"/></div>
                <div id="doamdat_v" style="float:right" class="thongso">---</div>
        </div>

        <div class="item1" style="border: #00bcd4 solid 2px;">
            <div class="tieude" style="background-color: #00bcd4;"> <div class="tieude_text"> <span id="dk">Ánh sáng</span> </div></div>
                <div style="float:left"><img src="image/anhsang.png" class="img_ico"/></div>
                <div id="anhsang_v" style="float:right" class="thongso">---</div>
        </div> 
      </div>
      <div class="mode">
        <!-- <h1 class="text-grh">Mode</h1>
        <form action="" method="get">
            <button type="button" id="Auto" class="button button1">Auto</button>
            <button type="button" id="Manual" class="button button1">Manual</button>
        </form> -->
      </div>

      <div class="control-device">
        <div class ="control">
          <img src="image/quat.png" alt="Girl in a jacket" class="img-device">
          <div class="btn">
          <!-- <button type="button" id="Auto" class="button button1">Quat ON</button>
          <button type="button" id="Auto" class="button button1">Quat OFF</button> -->
              <label class="switch">
                <input type="checkbox" id="togBtn1">
                <div class="slider round">
                <!--ADDED HTML -->
                <span class="on">ON</span>
                <span class="off">OFF</span>
                <!--END-->
                </div>
              </label>

          </div>  
        </div>

        <div class ="control">
          <img src="image/den.png" alt="Girl in a jacket" class="img-device">
          <div class="btn">
          <!-- <button type="button" id="Auto" class="button button1">Quat ON</button>
          <button type="button" id="Auto" class="button button1">Quat OFF</button> -->
              <label class="switch">
                <input type="checkbox" id="togBtn2">
                <div class="slider round">
                <!--ADDED HTML -->
                <span class="on">ON</span>
                <span class="off">OFF</span>
                <!--END-->
                </div>
              </label>
          </div>  
        </div>

        <div class ="control">
          <img src="image/bom.png" alt="Girl in a jacket" class="img-device">
          <div class="btn">
          <!-- <button type="button" id="Auto" class="button button1">Quat ON</button>
          <button type="button" id="Auto" class="button button1">Quat OFF</button> -->
              <label class="switch">
                <input type="checkbox" id="togBtn3">
                <div class="slider round">
                <!--ADDED HTML -->
                <span class="on">ON</span>
                <span class="off">OFF</span>
                <!--END-->
                </div>
              </label>
          </div>  
        </div>

        <div class ="control">
          <img src="image/phunsuong.png" alt="Girl in a jacket" class="img-device">
          <div class="btn">
          <!-- <button type="button" id="Auto" class="button button1">Quat ON</button>
          <button type="button" id="Auto" class="button button1">Quat OFF</button> -->
              <label class="switch">
                <input type="checkbox" id="togBtn4">
                <div class="slider round">
                <!--ADDED HTML -->
                <span class="on">ON</span>
                <span class="off">OFF</span>
                <!--END-->
                </div>
              </label>
          </div>  
        </div>
  
      </div>   
    </div> 
  </section>

  <section class="section-footer">
    <div class="footer-cl">

          <h1 class="footer-gv">GVHD: Ths Lê Mạnh Tuấn </h1>
          <p class="footer-sv">  SVTH: Châu Thanh Hải </p>

         
          <a href="logout.php">Logout</a>
       <!-- </div>   -->
    </div>  
  </section>
    
</body>
    <script src="home.js"></script>
   
        
 
<!-- 
//Monitoring
       
       
$(document).ready(function(){ 
            $.ajax({
                url:"last.php",
                type:"get",
                data:"last.php?v1=33&v2=45",
                async:false,
                success:function(kq)
                {
                    
                  var data = $.parseJSON(kq); 
                  
                  var nhietdo=data["v1"];
                  var doam=data["v2"];
    
                  //var online=data["online"];
                  console.log(nhietdo);
                  
                  $('#nhietdo_v').html(nhietdo + "°C");
                  $('#doam_v').html(doam + "%");
                  
                  // if(online=="1")$('#tieude').html("Hệ thống giám sát môi trường - Online");
                  // else $('#tieude').html("Hệ thống giám sát môi trường - Offline");
                }
            })  
        
            });
            -->
           


<script>
         document.getElementById('togBtn1').addEventListener('click', function(){
              if(this.checked) {
                  var url = "http://127.0.0.1/greenhouset/load.php?id=1&status=qwe";
                  $.getJSON(url, function(data){
                  console.log(data);
                  });
              } else {
                  var url = "http://127.0.0.1/greenhouset/load.php?id=1&status=rty";
                  $.getJSON(url, function(data){
                  console.log(data);
                  });
              }
         });


         document.getElementById('togBtn2').addEventListener('click', function(){
              if(this.checked) {
                  var url = "http://127.0.0.1/greenhouset/load.php?id=2&status=uio";
                  $.getJSON(url, function(data){
                  console.log(data);
                  });
              } else {
                  var url = "http://127.0.0.1/greenhouset/load.php?id=2&status=pas";
                  $.getJSON(url, function(data){
                  console.log(data);
                  });
              }
         });

         document.getElementById('togBtn3').addEventListener('click', function(){
              if(this.checked) {
                  var url = "http://127.0.0.1/greenhouset/load.php?id=3&status=dfg";
                  $.getJSON(url, function(data){
                  console.log(data);
                  });
              } else {
                  var url = "http://127.0.0.1/greenhouset/load.php?id=3&status=hjk";
                  $.getJSON(url, function(data){
                  console.log(data);
                  });
              }
         });

         document.getElementById('togBtn4').addEventListener('click', function(){
              if(this.checked) {
                  var url = "http://127.0.0.1/greenhouset/load.php?id=4&status=lzx";
                  $.getJSON(url, function(data){
                  console.log(data);
                  });
              } else {
                  var url = "http://127.0.0.1/greenhouset/load.php?id=4&status=cvb";
                  $.getJSON(url, function(data){
                  console.log(data);
                  });
              }
         });

    </script>
</html>


<?php 
}else{
     header("Location: index.php");
     exit();
}
 ?>