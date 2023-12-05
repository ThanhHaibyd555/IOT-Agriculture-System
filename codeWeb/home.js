
var dem=0;
setInterval(function()
{
    $(document).ready(function(){ 
    $.ajax({
        url:"last.php",
        type:"get",
        data:"check",
        async:false,
        success:function(kq)
        {
          //alert(kq);
          var data = $.parseJSON(kq); 
          
          var nhietdo=data["v1"];
          var doam=data["v2"];
          var doamdat=data["v3"];
          var anhsang=data["v4"];
          //alert(nhietdo) ;
          //alert(doam) ;
          
          // var online=data["online"];
          
          $('#nhietdo_v').html(nhietdo + "°C");
          $('#doam_v').html(doam + "%");
          $('#doamdat_v').html(doamdat + "%");
          $('#anhsang_v').html(anhsang);
          
          // if(online=="1")$('#tieude').html("Hệ thống giám sát môi trường - Online");
          // else $('#tieude').html("Hệ thống giám sát môi trường - Offline");
        }

     
    })  

    });

  }, 500);



 

// Monitoring
       
       
        //     $(document).ready(function(){ 
        //     $.ajax({
        //         url:"last.php",
        //         type:"get",
        //         data:{ nhietdo: "v1", doam: "v2" },
        //         async:false,
        //         success:function(kq) 
        //         {
                    
        //           var data = $.parseJSON(kq); 
                  
        //           var nhietdo=data["v1"];
        //           var doam=data["v2"];
    
        //           //var online=data["online"];
        //           //console.log(nhietdo);
                  
        //           $('#nhietdo_v').html(nhietdo + "°C");
        //           $('#doam_v').html(doam + "%");
                  
        //           // if(online=="1")$('#tieude').html("Hệ thống giám sát môi trường - Online");
        //           // else $('#tieude').html("Hệ thống giám sát môi trường - Offline");
        //         }
        //       });
        
        //     });
       

        //  var nhietdo=20;
        //  var doam= 10;
        //   $('#nhietdo_v').html(nhietdo + "°C");
        //    $('#doam_v').html(doam + "%");
        
           
//Control Device
document.getElementById('togBtn1').addEventListener('click', function(){
  if(this.checked) {
      var url = "http://localhost/house/load.php?id=1&status=~";
      $.getJSON(url, function(data){
      console.log(data);
      });
  } else {
      var url = "http://localhost/house/load.php?id=1&status=!";
      $.getJSON(url, function(data){
      console.log(data);
      });
  }
});


document.getElementById('togBtn2').addEventListener('click', function(){
  if(this.checked) {
      var url = "http://localhost/house/load.php?id=2&status=@";
      $.getJSON(url, function(data){
      console.log(data);
      });
  } else {
      var url = "http://localhost/house/load.php?id=2&status=*";
      $.getJSON(url, function(data){
      console.log(data);
      });
  }
});

document.getElementById('togBtn3').addEventListener('click', function(){
  if(this.checked) {
      var url = "http://localhost/house/load.php?id=3&status=$";
      $.getJSON(url, function(data){
      console.log(data);
      });
  } else {
      var url = "http://localhost/house/load.php?id=3&status=%";
      $.getJSON(url, function(data){
      console.log(data);
      });
  }
});

document.getElementById('togBtn4').addEventListener('click', function(){
  if(this.checked) {
      var url = "http://localhost/house/load.php?id=4&status=^";
      $.getJSON(url, function(data){
      console.log(data);
      });
  } else {
      var url = "http://localhost/house/load.php?id=4&status=z";
      $.getJSON(url, function(data){
      console.log(data);
      });
  }
});


 

        
   
   