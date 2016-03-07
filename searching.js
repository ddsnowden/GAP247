$(function(){
    $('#clientSearch').keyup(function(){
    	var type = 'client';
        var key = $(this).val();
        var string = 'key=' + key;
        if(key!='')
		{
			$('#clientResult').show();
		    $.ajax({
			    type: "POST",
			    url: "/assets/php/search.php",
			    data: {type: type, key: key},
			    cache: false,
			    success: function(html)
			    {
			    	$("#clientResult").load(location.href+" #clientResult>*","");
			    }
		    });
		}    
		else if(key==''){
			$('#clientResult').hide();
		}return false;
	});
});

$(function(){
    $('#clientNameSearch').keyup(function(){
    	var type = 'clientName';
        var key = $(this).val();
        var string = 'key=' + key;
        if(key!='')
		{
			$('#clientNameResult').show();
		    $.ajax({
			    type: "POST",
			    url: "/assets/php/search.php",
			    data: {type: type, key: key},
			    cache: false,
			    success: function(html)
			    {
			    	$("#clientNameResult").load(location.href+" #clientNameResult>*","");
			    }
		    });
		}    
		else if(key==''){
			$('#clientResult').hide();
		}return false;
	});
});

$(function(){
    $('#tempSearch').keyup(function(){
    	var type = 'temp';
        var key = $(this).val();
        var string = 'key=' + key;
        if(key!='')
		{
			$('#tempResult').show();
		    $.ajax({
			    type: "POST",
			    url: "/assets/php/search.php",
			    data: {type: type, key: key},
			    cache: false,
			    success: function(html)
			    {
			    	$("#tempResult").load(location.href+" #tempResult>*","");
			    }
		    });
		}    
		else if(key==''){
			$('#tempResult').hide();
		}return false;
	});
});