// Capitalize a string
function capitalize(s)
{
    return s && s[0].toUpperCase() + s.slice(1);
}

//Capatilize each word in string
function capitalizeEachWord(str) {
    return str.replace(/\w\S*/g, function(txt) {
        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
    });
}

// Recall existing call and display procedure for branch
$(document).ready(function(){
	$('select[id=recall]').on('change', function() {var recallID = this.options[this.selectedIndex].id
		$.ajax({        
			url: '/assets/php/' + capitalizeEachWord(callType).replace(/ /g,'') + '.php',
			data: {recallID: recallID, callType: callType},
			type: 'POST',
			dataType: 'json',
			success: function(data)
			{
				if(data == 'success'){
    				location.reload();
				}
			}
		});
	});
	$("#procDisp").load("/assets/php/procDisp.php");

	// Display the procedures as the branch is selected
    $('select[name=branchNameShort]').on('change', function() {var branch = this.options[this.selectedIndex].value
        $.ajax({                                     
          url: '/assets/php/' + capitalizeEachWord(callType).replace(/ /g,'') + '.php',
          data: {branch: branch, callType: capitalizeEachWord(callType)},
          type: 'GET',
          dataType: 'json',
          success: function(data)
          {
            if(data == 'success'){
                  $("#procDisp").load("/assets/php/procDisp.php");
              }
          }
        });
      });

	// Restrict the booked and filled numbers for bookings and cancellations
	$('select[name="quantity"]').change(function(){
	    // Start by setting everything to disabled
	    $('select[name="quantity"] option').attr('disabled',false);
	    $('select[name="filled"] option').attr('disabled',false);
	    
	    // loop each select and set the selected value to disabled in all other selects
	    $('select[name="quantity"]').each(function(){
	        var $this = $(this);
	        $('select[name="filled"]').not($this).find('option').each(function(){
	           if(parseInt($(this).attr('value')) > parseInt($this.val())) {
	               $(this).attr('disabled',true);
	           }
	        });
	    });
	});
	var quantity = $('select[name="quantity"]').val();
	$('select[name="quantity"]').each(function(){
        var $this = $(this);
        $('select[name="filled"]').not($this).find('option').each(function(){
           if(parseInt($(this).attr('value')) > parseInt(quantity)) {
               $(this).attr('disabled',true);
           }
        });
    });
});

function clientID(elem) {
	var id = elem;
	$('#clientSearch').val('');
	$('.result').hide();
	$.ajax({       
		url: '/assets/php/clientRecall.php',
		data: {id: id},
		type: 'POST',
		dataType: 'json',
		success: function(data)
		{
			if(data == 'success')
			{
				$("#clientDetails").load(location.href+" #clientDetails>*","");
				// $("#clientDetails2").load(location.href+" #clientDetails2>*","");
			}
		}
	});
};

function clientNameID(elem) {
	var id = elem;
	$('#clientSearch').val('');
	$('.result').hide();
	$.ajax({       
		url: '/assets/php/clientNameRecall.php',
		data: {id: id},
		type: 'POST',
		dataType: 'json',
		success: function(data)
		{
			if(data == 'success')
			{
				$("#clientDetails").load(location.href+" #clientDetails>*","");
				// $("#clientDetails2").load(location.href+" #clientDetails2>*","");
			}
		}
	});
};

function tempID(elem) {
	var id = elem;
	$('#tempSearch').val('');
	$('.result').hide();
	$.ajax({       
		url: '/assets/php/tempRecall.php',
		data: {id: id},
		type: 'POST',
		dataType: 'json',
		success: function(data)
		{
			if(data == 'success')
			{
				$("#tempDetails").load(location.href+" #tempDetails>*","");
				// $("#clientDetails2").load(location.href+" #clientDetails2>*","");
			}
		}
	});
};

function branchCheckinRecall(select){
    $.ajax({                                     
      url: '/assets/php/branchadmin/Checkins.php',
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