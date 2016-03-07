<!-- Blinking Alert -->
$(document).ready(function(){
var autoLoad = setInterval(
  function() {
    $.ajax({        
      url: '/assets/php/alerts/checkinCheck.php',
      dataType: 'json',
      success: function(data)
      {
        if(data == 'exists'){
            $('#checkAlert').addClass('blink');
            setInterval(function(){blink()}, 1000);
            
            function blink() {
                $("#checkAlert").fadeTo(500, 0).fadeTo(500, 0.4);
            }
        }
        else if(data == 'empty'){
            $("#checkAlert").removeClass("blink");
        }
      }
    });
  
  }, 60000); // refresh page every minute
});

<!-- Blinking Alert -->
$(document).ready(function(){
var outAlert = setInterval(
  function() {
    $.ajax({        
      url: '/assets/php/alerts/outAlert.php',
      dataType: 'json',
      success: function(data)
      {
        if(data == 'exists'){
            $('.outAlert').addClass('alert');
            setInterval(function(){alert()}, 1000);
            
            function alert() {
                $(".outAlert").fadeTo(500, 0).fadeTo(500, 1);
            }
        }
        else if(data == 'empty'){
            $(".outAlert").removeClass('alert');
        }
      }
    });
  }, 60000); // refresh page every minute
});

<!-- Blinking Alert -->
$(document).ready(function(){
var mailAlert = setInterval(
  function() {
    $.ajax({        
      url: '/assets/php/alerts/mailAlert.php',
      dataType: 'json',
      success: function(data)
      {
        if(data == 'exists'){
              $('.mailAlert').addClass('alert');
              setInterval(function(){alert()}, 1000);
              
              function alert() {
                  $(".mailAlert").fadeTo(500, 0).fadeTo(500, 1);
              }
          }
        else if(data == 'empty'){
            $(".mailAlert").removeClass('alert');
        }
      }
    });
  }, 60000); // refresh page every minute
});