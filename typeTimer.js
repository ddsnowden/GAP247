//setup before functions
var typingTimer;                //timer identifier
var doneTypingInterval = 600000;  //time in ms, 5 second for example

var $input = $('html');

$('document').ready(function() {
  	clearTimeout(typingTimer);
  	typingTimer = setTimeout(doneTyping, doneTypingInterval);
});

//on keyup, start the countdown
$input.on('keyup', function () {
	clearTimeout(typingTimer);
  	typingTimer = setTimeout(doneTyping, doneTypingInterval);
});

//on keydown, clear the countdown 
$input.on('keydown', function () {
  	clearTimeout(typingTimer);
    typingTimer = setTimeout(doneTyping, doneTypingInterval);
});

$input.mousedown(function () {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(doneTyping, doneTypingInterval);
});

//user is "finished typing," do something
function doneTyping () {
  	//do something
    console.log("Logged Out");
  	$.ajax({        
      url: '/assets/php/autoLogout.php',
      dataType: 'json',
      success: function(data)
      {
        if(data == 'destroy')
        {
              window.location.href = 'http://nightline/';
        }
      }
    });
  	alert("You have been logged out of the web server, please reload the page and log back in when ready.");
}
