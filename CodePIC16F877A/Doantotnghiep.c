
#include <main.h>
#use I2C(master, I2C1 , FAST = 100000, STREAM = I2C_LCD)  
#include <I2C_LCD.c>
#use I2C(master, scl=PIN_C3, sda=PIN_C4 , FAST = 100000)

#use rs232(uart1, baud=9600,ERRORS)
#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include"dht11.h"
#include "BH1750.c"

unsigned int8 t,T_byte2, h,RH_byte2, CheckSum ;
unsigned int16 adc_value;
unsigned int8 w; 
unsigned int16 lux = 0;   
short q = 0, d = 0 ,b = 0, p = 0;

//define button
#define BACK      pin_b6
#define ONOFF     pin_b5
#define DW        pin_b4
#define RIGHT     pin_b3
#define GO        pin_b2
#define LEFT      pin_b1
#define UP        pin_b0
        
//define device 
#define FAN     pin_a1
#define LED     pin_a2
#define BOMB    pin_a3
#define SPRAY   pin_a4
   
char *SSID="UZI";                  
char *PASS="QQQ123456";             
char *WEBSITE="192.168.137.1";      

void ESP8266_init()
      {
       printf("AT\r\n");delay_ms(500);
       printf("ATE0\r\n");delay_ms(500);
       printf("AT+CWMODE=1\r\n");delay_ms(500);
       printf("AT+CWJAP=\"%s\",\"%s\"\r\n",SSID,PASS);delay_ms(2000); 
       printf("AT+CIPMUX=0\r\n");delay_ms(500);
      }
void ConnectWithWebServer(){
       int length; 
       char mang[90];
       sprintf(mang,"GET /fix/last.php?update&v1=%i&v2=%i&v3=%i&v4=%05lu HTTP/1.1\r\nHost: 192.168.137.1\r\n\r\n",t,h,w,lux);
       printf("AT+CIPSTART=\"TCP\",\"%s\",80\r\n",WEBSITE);delay_ms(150);  //wait connect
       length=strlen(mang);
       printf("AT+CIPSEND=%i\r\n",length);delay_ms(150);
       printf(mang);delay_ms(150);
       printf("AT+CIPCLOSE\r\n");delay_ms(150);
      }
   
short button_state;
char time[] = "TIME:     :  :  ";
char calendar[] = "  /  /20  ";
char alarm1[] = "P_ON  : 00:00:00";
char alarm2[] = "P_OFF : 00:00:00";
unsigned int8 second, second10, minute, minute10,
               hour, hour10, date, date10, month, month10,
               year, year10, day, alarm1_minute=0, alarm1_hour=0,
               alarm2_minute=0, alarm2_hour=0, i, j;
void ds1307_display(){
  second10  =  (second & 0x70) >> 4;
  second = second & 0x0F;
  minute10  =  (minute & 0x70) >> 4;
  minute = minute & 0x0F;
  hour10  =  (hour & 0x30) >> 4;
  hour = hour & 0x0F;
  date10  =  (date & 0x30) >> 4;
  date = date & 0x0F;
  month10  =  (month & 0x10) >> 4;
  month = month & 0x0F;
  year10  =  (year & 0xF0) >> 4;
  year = year & 0x0F;
  time[15]  = second  + 48;
  time[14]  = second10  + 48;
  time[12]  = minute  + 48;
  time[11]  = minute10  + 48;
  time[9]  = hour  + 48;
  time[8]  = hour10  + 48;
  calendar[9]  = year  + 48;
  calendar[8]  = year10  + 48;
  calendar[4]  = month + 48;
  calendar[3]  = month10 + 48;
  calendar[1]  = date + 48;
  calendar[0]  = date10 + 48;
  lcd_goto(1, 1);                             
  printf(lcd_out, time);                        
  lcd_goto(1, 2);                              
  switch(day){
    case 1: lcd_out("DATE:Su"); break;
    case 2: lcd_out("DATE:Mo"); break;
    case 3: lcd_out("DATE:Tu"); break;
    case 4: lcd_out("DATE:We"); break;
    case 5: lcd_out("DATE:Th"); break;
    case 6: lcd_out("DATE:Fr"); break;
    case 7: lcd_out("DATE:Sa"); break;}
  lcd_goto(9, 2);                             
  printf(lcd_out, calendar);                   
}

void alarm_display(){                           
  alarm1[12]  = alarm1_minute % 10  + 48;
  alarm1[11]  = alarm1_minute/10 + 48;
  alarm1[9]  = alarm1_hour%10  + 48;
  alarm1[8]  = alarm1_hour/10  + 48;
  lcd_goto(21, 1);                             
  printf(lcd_out, alarm1);
  lcd_goto(38, 1);
  
  alarm2[12]  = alarm2_minute % 10  + 48;
  alarm2[11]  = alarm2_minute/10 + 48;
  alarm2[9]  = alarm2_hour%10  + 48;
  alarm2[8]  = alarm2_hour/10  + 48;
  lcd_goto(21, 2);                            
  printf(lcd_out, alarm2);
  lcd_goto(38, 2);
   
}

void ds1307_write(unsigned int8 address, data_){
  i2c_start();                                   
  i2c_write(0xD0);                              
  i2c_write(address);                            
  i2c_write(data_);                              
  i2c_stop();                                    
}

void ds1307_read(){
   i2c_start();                                 
   i2c_write(0xD0);                             
   i2c_write(0);                                
   i2c_start();                                 
   i2c_write(0xD1);                             
   second =i2c_read(1);                         
   minute =i2c_read(1);                         
   hour = i2c_read(1);                          
   day = i2c_read(1);                           
   date = i2c_read(1);                          
   month = i2c_read(1);                         
   year = i2c_read(0);                          
   i2c_stop();                                  
}

void alarm_check(){
 if((alarm1_minute == ((minute & 0x0F) + (minute >> 4) * 10)) &&
 (alarm1_hour == ((hour & 0x0F) + (hour >> 4) * 10)) && (second == 0))
   output_high(SPRAY);                          // Alarm1 ON
 if((alarm2_minute == ((minute & 0x0F) + (minute >> 4) * 10)) &&
 (alarm2_hour == ((hour & 0x0F) + (hour >> 4) * 10)) && (second == 0))
   output_low(SPRAY);                           // Alarm1 OFF
}

int8 edit(int8 parameter, int8 xx, int8 yy){
  while(TRUE){
    if(input(LEFT) && input(RIGHT)) button_state = 0;
    while(!input(UP)){
      parameter++;
      if(((i == 1) || (i == 6)) && parameter > 23)
        parameter = 0;
      if(((i == 2) || (i == 7)) && parameter > 59)
        parameter = 0;
      if(i == 3 && parameter > 31)
        parameter = 1;
      if(i == 4 && parameter > 12)
        parameter = 1;
      if(i == 5 && parameter > 99)
        parameter = 0;
      lcd_goto(xx, yy);
    printf(lcd_out,"%02u", parameter);
    if((i == 6) || (i == 7)){
      ds1307_read();
      ds1307_display();}
      delay_ms(200);}
    lcd_goto(xx, yy);
    lcd_out("  ");
    j = 0;
    while((input(LEFT) || button_state || (i==6) || (i==7)) && (input(RIGHT) || 
      button_state || ((i != 6) && (i != 7))) && input(UP) && j < 5){
      j++;
     delay_ms(100);}
    lcd_goto(xx, yy);
    printf(lcd_out,"%02u", parameter);
    j = 0;
    while((input(LEFT)||button_state||(i == 6) || (i == 7)) && (input(RIGHT) || 
      button_state || ((i != 6) && (i != 7))) && input(UP) && j < 5){
      j++;
      delay_ms(100);}
    if((i != 6) && (i != 7) && !input(LEFT) && !button_state){
      button_state = 1; return parameter;}
    if((i == 6) || (i == 7)){
      if(!input(RIGHT) && (!button_state)){
        button_state = 1; return parameter;}
      ds1307_read();
      ds1307_display();
    }
  } 
}

unsigned int8 pos_x=1,pos_y=1,pos_go=1,pos=1;
int1 status=0;

void xoa_LCD()
{
      lcd_putc('\f');
}

void xoa_pos_LCD()
{
   lcd_goto(1,1);  lcd_out(" ");
   lcd_goto(1,2);  lcd_out(" ");
   lcd_goto(21,1); lcd_out(" ");
   lcd_goto(21,2); lcd_out(" ");
   lcd_goto(7,1);  lcd_out(" ");
   lcd_goto(7,2);  lcd_out(" ");
   lcd_goto(27,1); lcd_out(" ");
   lcd_goto(27,2); lcd_out(" ");
   lcd_goto(12,1); lcd_out(" ");
   lcd_goto(12,2); lcd_out(" ");
   lcd_goto(32,1); lcd_out(" ");
   lcd_goto(32,2); lcd_out(" ");
}

int phim_ONOFF(int1 status)
{
   int1 mode = status;
   if(input(ONOFF)==0)
   {
      delay_ms(20);
      if(input(ONOFF)==0)
      {
         xoa_LCD();
         mode = !mode;
         if(pos_go==2 && pos == 3 ){
            mode = 1; } 
         while(input(ONOFF)==0);
      }
   }
   
   return mode;
}

int phim_LEFT(unsigned int8 pos_x)
{
   unsigned int8 pos_temp = pos_x;
   if(input(LEFT)==0)
   {
      delay_ms(20);
      if(input(LEFT)==0)
      {
         xoa_pos_LCD();
         pos_temp--;
         if(pos_temp<1)   pos_temp=1;
         while(input(LEFT)==0);
      }
   }
   
   return pos_temp;
}

int phim_RIGHT(unsigned int8 pos_x)
{
   unsigned int8 pos_temp = pos_x;
   if(input(RIGHT)==0)
   {
      delay_ms(20);
      if(input(RIGHT)==0)
      {
         xoa_pos_LCD();
         pos_temp++;
         if(pos_temp>2)   pos_temp=2;
         while(input(RIGHT)==0);
      }
   }
   
   return pos_temp;
}

int phim_UP(unsigned int8 pos_y)
{
   unsigned int8 pos_temp = pos_y;
   if(input(UP)==0)
   {
      delay_ms(20);
      if(input(UP)==0)
      {
         xoa_pos_LCD();
         pos_temp--;
         if(pos_temp<1)   pos_temp=1;
         while(input(UP)==0);
      }
   }
   
   return pos_temp;
}

int phim_DW(unsigned int8 pos_y)
{
   unsigned int8 pos_temp = pos_y;
   if(input(DW)==0)
   {
      delay_ms(20);
      if(input(DW)==0)
      {
         xoa_pos_LCD();
         pos_temp++;
         if(pos_temp>4)   pos_temp=4;
         if(pos_go==1 && pos == 3 ){
            pos_temp = 3; } 
         while(input(DW)==0);
      }
   }
   return pos_temp;
}

int phim_GO(unsigned int8 pos_go)
{
   unsigned int8 pos_temp = pos_go;
   if(input(GO)==0)
   {
      delay_ms(20);
      if(input(GO)==0)
      {
         xoa_LCD();
         pos_temp++;
         if(pos_temp>2)
         {   
            pos_temp=2;
               //Mode Manual
               if((pos==1) && (pos_y==1) && (pos_x == 1)){
                        output_high(FAN); q=1 ;   //FAN ON
               }else if ((pos==1) && (pos_y==1) && (pos_x==2)){
                        output_low(FAN); q=0;   //FAN OFF   
               }else if ((pos==1) && (pos_y==2) && (pos_x==1)){
                        output_high(LED); d=1;   //LED ON
               }else if ((pos==1) && (pos_y==2) && (pos_x==2)){
                        output_low(LED); d=0;    //LED OFF
               }else if ((pos==1) && (pos_y==3) && (pos_x==1)){
                        output_high(BOMB); b=1;  //BOMB ON
               }else if ((pos==1) && (pos_y==3) && (pos_x==2)){
                        output_low(BOMB); b=0;   //BOMB OFF
               }else if ((pos==1) && (pos_y==4) && (pos_x==1)){
                        output_high(SPRAY); p=1; //SPRAY ON
               }else if ((pos==1) && (pos_y==4) && (pos_x==2)){
                        output_low(SPRAY); p=0;  //SPRAY OFF
               }   
         }
         while(input(GO )==0);
      }
   }
   
   return pos_temp;
}

int phim_BACK(unsigned int8 pos_go)
{
   unsigned int8 pos_temp = pos_go;
   if(input(BACK)==0)
   {
      delay_ms(20);
      if(input(BACK)==0)
      {
         xoa_LCD();
         pos_temp--;
         if(pos_temp<1)   pos_temp=1;
         if(pos_go==2 && pos == 1){
            pos_y = 1;
             output_low(FAN) ; q = 0;
             output_low(LED); d = 0;
             output_low(BOMB); b = 0;
             output_low(SPRAY); p= 0;       
         } 
          if(pos_go==2 && pos == 2){
             output_low(FAN) ; q = 0;
             output_low(LED); d = 0;
             output_low(BOMB); b = 0;
             output_low(SPRAY); p= 0;       
         }
          if(pos_go==2 && pos == 3){
             output_low(SPRAY); 
             }
         while(input(BACK)==0);
      }
   }
   
   return pos_temp;
}

void pos_xy_current(unsigned int8 pos_x,pos_y,pos)
{
   if(pos_go==2&&(pos==1))
   { 
      if(pos_y&&(pos_x==1)){
         switch (pos_y)
         {
            case 1: 
               lcd_goto(7,1);  lcd_out(">");
               break;
            case 2:  
               lcd_goto(7,2);  lcd_out(">");
               break;
            case 3:  
               lcd_goto(27,1); lcd_out(">");
               break;   
            default:
               lcd_goto(27,2); lcd_out(">");
               break;      
         }
      }
      else if((pos_y)&&(pos_x==2)){
         switch (pos_y)
         {
            case 1: 
               lcd_goto(12,1); lcd_out(">");
               break;
            case 2:  
               lcd_goto(12,2); lcd_out(">");
               break;
            case 3:  
               lcd_goto(32,1); lcd_out(">");
               break;             
            default:
               lcd_goto(32,2); lcd_out(">");
               break;      
         }
      }
       
  }
  else if(pos_go==2&&pos==2){
    
  }
  else if(pos_go==2&&pos==3){
           
  }
  else
   {
      switch (pos_y)
      {
         case 1: 
            lcd_goto(1,1);  lcd_out(">");   
            break;
         case 2:  
            lcd_goto(1,2);  lcd_out(">");      
            break;
         case 3:  
            lcd_goto(21,1); lcd_out(">");    
            break;           
         default:
            lcd_goto(21,2); lcd_out(">");
            break;
      }
   }   
}

void mode_ON()
{
   lcd_goto(2,1);   lcd_out("TAY");
   lcd_goto(2,2);   lcd_out("AUTO");
   lcd_goto(22,1);  lcd_out("CLOCK");    
}
void pos_relay_2()
{
   lcd_goto(2,1); lcd_out("QUAT");
   lcd_goto(2,2); lcd_out("DEN");
   lcd_goto(22,1);lcd_out("BOM"); 
   lcd_goto(22,2);lcd_out("PHUN");
   lcd_goto(8,1); lcd_out("ON");
   lcd_goto(8,2); lcd_out("ON");
   lcd_goto(28,1);lcd_out("ON"); 
   lcd_goto(28,2);lcd_out("ON");
   lcd_goto(13,1); lcd_out("OFF");
   lcd_goto(13,2); lcd_out("OFF");
   lcd_goto(33,1);lcd_out("OFF"); 
   lcd_goto(33,2);lcd_out("OFF");
}

void pos_auto_2()
{
   lcd_goto(9,2);   lcd_out("Auto");
   lcd_goto(27,1);  lcd_out("Running");   
}

void pos_tmr_2()
{  
    ds1307_read();                      
    alarm_check();                      
    ds1307_display();                   
    alarm_display();                    
    delay_ms(50); 
}

int choice_mode(unsigned int8 pos_go,pos_x,pos)
{
   unsigned int8 mode = pos;
   if(pos_go==1)
   {
      switch(pos_y)
      {
         case 1:
            mode=1;
            break;
         case 2:
            mode=2;
            break;
         case 3:
            mode=3;
            break;   
      }
   }
   
   return mode;
}

void pos_current(unsigned int8 mode,pos_go)
{
   if(mode==1)
   {
      switch (pos_go)
      {
         case 1:
            mode_ON();
            break;
         case 2:  
            pos_relay_2();
            break;
      }
   }
   else if(mode==2)
   {
      switch (pos_go)
      {
         case 1:
            mode_ON();
            break;
         case 2: 
            pos_auto_2();
            break;
      }
   }
   else if(mode==3)
   {
      switch (pos_go)
      {
         case 1:
            mode_ON();
            break;
         case 2: 
            pos_tmr_2();
            break; 
      }
   }

}

void mode_OFF()
{  
    if(pos_go == 1){
    lcd_goto(21,1);
    lcd_out("MODE:NONE");
    } 
    else if((pos_go==2) && (pos==1 )) {    
         lcd_goto(26,1);
         lcd_out("MODE:MANUAL");
    }else if ((pos_go==2) && (pos==2)){
         lcd_goto(26,1);
         lcd_out("MODE:AUTO");        
    }  
      lcd_goto(1, 1);                     
      printf(lcd_out,"Temp = %u",t);      
      lcd_goto(1, 2);                     
      printf(lcd_out,"Humid = %u",h);     
      lcd_goto(12, 1);
      printf(lcd_out,"W = %u", w);
      lcd_goto(12, 2);  
      printf(lcd_out,"L = %05lu", lux);
      lcd_goto(21,2);
      printf(lcd_out,"Q:%d D:%d B:%d P:%d", q,d,b,p);
}
 
void main() {
   set_tris_B(0b00111111);
   port_b_pullups(TRUE);             // Enable PORTB internal pull-ups
   setup_adc(ADC_CLOCK_DIV_32);      // Set ADC conversion time to 32Tosc
   setup_adc_ports(SAN0);            // Configure AN0 as analog
   set_adc_channel(0);               // Select channel 0 input
   delay_ms(50);                   

   lcd_begin(0x4E);                  // Initialize LCD module with I2C address = 0x4E 
   BH1750_init();
   ENABLE_INTERRUPTS(INT_RDA);       //enable interrupt uart
   ENABLE_INTERRUPTS(GLOBAL);        //enable interrupt global
   ESP8266_init();
 
  while(TRUE) {
        ConnectWithWebServer(); 
        Time_out = 0;
        Start_signal();
        if(check_response()){               
           h = Read_Data();                 
           RH_byte2 = Read_Data();          
           t = Read_Data();                 
           T_byte2 = Read_Data();           
           Checksum = Read_Data();          
          }
        adc_value = read_adc();
        w = 100-(adc_value*100.00)/1023.00;
        lux = get_lux_value(cont_H_res_mode1, 180); 
 
      status = phim_ONOFF(status);
      
      if(status==0) {
            mode_OFF();}
      else
      {
         pos_go = phim_GO(pos_go);
         pos_go = phim_BACK(pos_go);
         pos_x = phim_LEFT(pos_x);
         pos_x = phim_RIGHT(pos_x);
         pos_y = phim_UP(pos_y);
         pos_y = phim_DW(pos_y);
         pos = choice_mode(pos_go,pos_x,pos);
         pos_xy_current(pos_x,pos_y,pos);
         pos_current(pos,pos_go); 
      }
        if((pos_go == 2) && (pos == 2 )){
              // Mode Auto
                   if( w < 55 ){
                      output_high(BOMB); b=1;   
                   }else {
                      output_low(BOMB); b=0;        
                   }
                   if( t > 35){
                      {output_high(SPRAY); p=1;   
                       output_high(FAN);  q=1;}   
                   }else {
                      {output_low(SPRAY); p=0;   
                      output_low(FAN);  q=0;}        
                   }
                   if( lux < 30 ){
                      output_high(LED); d=1;   
                   }else {
                      output_low(LED); d=0;         
                   }   
           
         }
        if((pos_go == 2) && (pos == 3 )){
             // Mode Timer
              if(input(LEFT) && input(RIGHT)) button_state = 0;
              if(!input(LEFT) && (!button_state)){
               button_state = 1;
               minute = minute + minute10 * 10;
               hour = hour + hour10 * 10;
               date = date + date10 * 10;
               month = month + month10 * 10;
               year = year + year10 * 10;
               i=1;
               hour = edit(hour, 9, 1);
               i=2;
               minute = edit(minute, 12, 1);
               while(TRUE){
                 if(input(LEFT)) 
                   button_state = 0;
                 while(!input(UP)){
                   day++;
                   if(day > 7)
                     day = 1;
                   lcd_goto(6, 2);                 
                   switch(day){
                     case 1: lcd_out("Su"); break;
                     case 2: lcd_out("Mo"); break;
                     case 3: lcd_out("Tu"); break;
                     case 4: lcd_out("We"); break;
                     case 5: lcd_out("Th"); break;
                     case 6: lcd_out("Fr"); break;
                     case 7: lcd_out("Sa"); break;}
                   delay_ms(200);
                 }
                 lcd_goto(6, 2);
                 lcd_out("   ");
                 j = 0;
                 while((input(LEFT)||button_state) && input(UP) && j < 5){
                   j++;
                   delay_ms(200);}
                 lcd_goto(6, 2);
                 switch(day){
                   case 1: lcd_out("Su"); break;
                   case 2: lcd_out("Mo"); break;
                   case 3: lcd_out("Tu"); break;
                   case 4: lcd_out("We"); break;
                   case 5: lcd_out("Th"); break;
                   case 6: lcd_out("Fr"); break;
                   case 7: lcd_out("Sa"); break;}
                 if(!input(LEFT) && (!button_state)){
                   button_state = 1;
                   break;}
                 j = 0;
                 while((input(PIN_B2)||button_state) && input(UP) && j < 5){
                   j++;
                   delay_ms(200);}
               }
               i=3;
               date = edit(date, 9, 2); 
               i=4;
               month = edit(month, 12, 2);
               i=5;
               year = edit(year, 17, 2);
               minute = ((minute/10) << 4) + (minute % 10);
               hour = ((hour/10) << 4) + (hour % 10);
               date = ((date/10) << 4) + (date % 10);
               month = ((month/10) << 4) + (month % 10);
               year = ((year/10) << 4) + (year % 10);
               ds1307_write(1, minute);
               ds1307_write(2, hour);
               ds1307_write(3, day);
               ds1307_write(4, date);
               ds1307_write(5, month);
               ds1307_write(6, year);
               ds1307_write(0, 0);
               }
             if(!input(RIGHT) && (!button_state)){
               button_state = 1;
               i=6;
               alarm1_hour = edit(alarm1_hour, 29, 1);
               i=7;
               alarm1_minute = edit(alarm1_minute, 32, 1);
               i=6;
               alarm2_hour = edit(alarm2_hour, 29, 2);
               i=7;
               alarm2_minute = edit(alarm2_minute, 32, 2);
               delay_ms(200); 
             }
        }
    }
}
 

