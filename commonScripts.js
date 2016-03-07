// Check is user wants to email call
$(document).ready(function(){
	$("#emailConfirm").easyconfirm({locale: { title: 'Are you sure you wish to email this call?', button: ['No','Yes']}});
	$("#emailConfirm").click(function() {
		window.location.href = "/assets/php/Email.php";
	});
});

// Check if user wants to clear form
$(document).ready(function(){
	$("#clearConfirm").easyconfirm({locale: { title: 'Are you sure you wish to clear this call?', button: ['No','Yes']}});
	$("#clearConfirm").click(function() {
		window.location.href = "/assets/php/clearForm.php";
	});
});

//Check if client or temp fields are populated.  Remove read only if populated, wait for search to be completed otherwise.
$(document).ready(function(){

if($('#tempSearch').length){  //Check is the search field is displayed on the form
	if($('#tempDetails input').val().length === 0) {
		$('#tempDetails input').prop('readonly', true);  
			$('#tempSearch').keyup(function(){
				var key = $(this).val();
				if((key=='') && (checked=='0')){
					$('#tempDetails input').prop('readonly', true);
					var checked = 0;
				}
				else {
					$('#tempDetails input').prop('readonly', false);
					var checked = 1;
				}
			});
		}
		else {
			$('#tempDetails input').prop('readonly', false);
		}
}

if($('#clientSearch').length){  //Check is the search field is displayed on the form
	if($('#clientDetails input').val().length === 0) {
		$('#clientDetails input').prop('readonly', true);
			$('#clientSearch').keyup(function(){
				var key = $(this).val();
				if((key=='') && (checked=='0')){
					$('#clientDetails input').prop('readonly', true);
					var checked = 0;
				}
				else {
					$('#clientDetails input').prop('readonly', false);
					var checked = 1;
				}
			});
		}
		else {
			$('#clientDetails input').prop('readonly', false);
		}
}

if($('#clientNameSearch').length){  //Check is the search field is displayed on the form
	if($('#clientDetails input').val().length === 0) {
		$('#clientDetails input').prop('readonly', true);
			$('#clientNameSearch').keyup(function(){
				var key = $(this).val();
				if((key=='') && (checked=='0')){
					$('#clientDetails input').prop('readonly', true);
					var checked = 0;
				}
				else {
					$('#clientDetails input').prop('readonly', false);
					var checked = 1;
				}
			});
		}
		else {
			$('#clientDetails input').prop('readonly', false);
		}
}

});

//Restrict input to letters only.
$(document).ready(function () {
	$(".letters").keydown(function(e) {
		if(e.which >= 48 /* 0 */ && e.which <= 57 /* 9 */) {
			e.preventDefault();
		}
	});
});

//Restrict to numbers only
$(document).ready(function () {
	//called when key is down
	$(".number").bind("keydown", function (event) {
		if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 ||
			// Allow: Ctrl+A
			(event.keyCode == 65 && event.ctrlKey === true) || 

			// Allow: home, end, left, right
			(event.keyCode >= 35 && event.keyCode <= 39)) {
			// let it happen, don't do anything
			return;
		} else {
			// Ensure that it is a number and stop the keypress
			if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
				event.preventDefault();
			}
		}
	});
});

//Indicate possible wrong phone number
$(document).ready(function(){
	$("#landline").blur(function() {
	    var length = $(this).val().length
		if(length == 11) {
			$('#landline').css("background-color", "rgba(255,255,255,1");
			$('#landline').css("color", "rgba(0,0,0,1");
		}
		else {
			$('#landline').css("background-color", "rgba(255,0,0,0.25");
			$('#landline').css("color", "rgba(255,255,255,1");
		}
	});
	$("#mobile").blur(function() {
	    var length = $(this).val().length
		if(length == 11) {
			$('#mobile').css("background-color", "rgba(255,255,255,1");
			$('#mobile').css("color", "rgba(0,0,0,1");
		}
		else {
			$('#mobile').css("background-color", "rgba(255,0,0,0.25");
			$('#mobile').css("color", "rgba(255,255,255,1");
		}
	});
});

$(document).ready(function(){
    $('#clientResult').hide();
    $('#clientNameResult').hide();
    $('#tempResult').hide();
    // Remove the client and temp results windows when the mouse is clicked on the screen
    $('body').click(function(){
        $('#clientResult').hide();
        $('#clientNameResult').hide();
        $('#tempResult').hide();
    })
    // Remove the client and temp results windows when the tab key is pressed
    $('body').keydown('keypress', function(e) {
    	var code = e.KeyCode || e.which;
    	if(code === 9) {
    		$('#clientResult').hide();
    		$('#clientNameResult').hide();
        	$('#tempResult').hide();
    	}
    })
});

function msieversion() {

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer, return version number
        // alert(parseInt(ua.substring(msie + 5, ua.indexOf(".", msie))));
    	$('textarea').resizable();
    else                 // If another browser, return 0
        // alert('otherbrowser');

   return false;
}

//Provide textarea resizing on Internet Explorer
$(document).ready(function() {
	//msieversion();
	// $('textarea').resizable();
});

//Slide recall script
function slideRecall(select){
    $.ajax({                                     
      url: '/assets/php/slideRecall.php',
      data: {select: select},
      type: 'GET',
      dataType: 'json',
      success: function(data)
      {
        if(data != ''){
              window.location.href = data;
          }
      }
    });
};

//Holiday recall script
function holidayRecall(select){
    $.ajax({                                     
      url: '/assets/php/Holiday.php',
      data: {select: select},
      type: 'POST',
      dataType: 'json',
      success: function(data)
      {
        if(data != ''){
              window.location.href = data;
          }
      }
    });
};

//Holiday recall script
function cvRecall(select){
	console.log(select);
    $.ajax({                                     
      url: '/assets/php/Cvsearch.php',
      data: {select: select},
      type: 'POST',
      dataType: 'json',
      success: function(data)
      {
        if(data != ''){
              window.location.href = data;
          }
      }
    });
};