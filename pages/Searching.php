<?php 
    //Define root path
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
    //Include header
    require_once $root.'/pages/header.php';
    //Resrtrict to GAP24/7 Users
    include $root.'/assets/php/auth/branchUsers.php';
    //Include required classes
	
?>
<!-- Load common scripts and call specific scripts -->
<!-- <script src="/assets/js/custom/commonScripts.js"></script> -->
<!-- <script src="/assets/js/custom/callScripts.js"></script> -->
<script src="/assets/js/custom/searching.js"></script>

<style type="text/css">
    #searchForm {
        padding-top: 100px;
    }
    .call {
        padding-top: 100px;
    }
</style>
<!-- Start Open Web Analytics Tracker -->
<script type="text/javascript">
//<![CDATA[
var owa_baseUrl = 'http://nightline/assets/Open-Web-Analytics/';
var owa_cmds = owa_cmds || [];
owa_cmds.push(['setSiteId', 'a892d08052dfe7355501b456aef1e8e1']);
owa_cmds.push(['trackPageView']);
owa_cmds.push(['trackClicks']);
owa_cmds.push(['trackDomStream']);

(function() {
    var _owa = document.createElement('script'); _owa.type = 'text/javascript'; _owa.async = true;
    owa_baseUrl = ('https:' == document.location.protocol ? window.owa_baseSecUrl || owa_baseUrl.replace(/http:/, 'https:') : owa_baseUrl );
    _owa.src = owa_baseUrl + 'modules/base/js/owa.tracker-combined-min.js';
    var _owa_s = document.getElementsByTagName('script')[0]; _owa_s.parentNode.insertBefore(_owa, _owa_s);
}());
//]]>
</script>
<!-- End Open Web Analytics Code -->
<!-- Start main content of the page -->
<div class="row form">
	<div class="col-sm-6 col-md-6 col-lg-6">
            <form id="searchForm" method="GET" action="/assets/php/slideRecall.php">
                <fieldset>
                    <div class="col-sm-6 labright">
                        <label for="search">Temp Search:</label>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" name="tempSearch" id="tempSearch" class="form-control input" />
                        <div id="tempResult" style="z-index: 10000;">
                            <?php if(isset($_SESSION['form']['tempList'])) {
                                foreach ($_SESSION['form']['tempList'] as $key) { ?>
                                    <p onclick="tempID($(this).attr('id'))" class="resultList" id="<?php echo htmlspecialchars($key['tempID'], ENT_QUOTES); ?>"><?php echo ucwords(htmlspecialchars($key['firstName'], ENT_QUOTES)).' '.ucwords(htmlspecialchars($key['lastName'], ENT_QUOTES)).' - '.htmlspecialchars($key['landline'], ENT_QUOTES).' - '.htmlspecialchars($key['mobile'], ENT_QUOTES).' - '.htmlspecialchars($key['postcode'], ENT_QUOTES); ?></p>
                            <?php } } ?>
                        </div>
                    </div>

                    <div class="col-sm-6 labright">
                        <label for="clientNameSearch">Client Name Search:</label>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" name="clientNameSearch" id="clientNameSearch" class="form-control input" />
                        <div id="clientNameResult" style="z-index: 10000;">
                            <?php if(isset($_SESSION['form']['clientList'])) {
                                foreach ($_SESSION['form']['clientList'] as $key) { ?>
                                    <p onclick="clientNameID($(this).attr('id'))" class="resultList" id="<?php echo htmlspecialchars($key['clientNameID'], ENT_QUOTES); ?>"><?php echo htmlspecialchars($key['clientName'], ENT_QUOTES); ?></p>
                            <?php } } ?>
                        </div>
                    </div>  

                    <div class="col-sm-6" style="height: 50px;">
                    </div>
                    <div class="col-sm-6" style="height: 50px;">
                    </div>

                    <div class="col-sm-6 labright">
                        <label>Instructions</label>
                    </div>
                    <div class="col-sm-6">
                        <p>Use the search inputs above to search for either a temp worker or a company name, use name, mobile, landline or postcode the select the result from the list displayed.</p>
                        <hr />
                        <p>Use the input below to search for a specific call, enter the call ID into the box and press submit, you will be taken to the correct page and the call will be displayed.</p>
                    </div>

                    <div class="col-sm-6" style="height: 50px;">
                    </div>
                    <div class="col-sm-6" style="height: 50px;">
                    </div>
                    
                    <div class="col-sm-6 labright">
                        <label>Call Search</label>
                    </div>
                    <div class="col-sm-6">
                        <input class="form-control input" name="select" id="select" type="number" value="" required />
                    </div>
                    <div class="col-sm-6 labright"></div>
                    <div class="col-sm-6">
                        <button id="submit" name="submit" type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    
                </fieldset>
            </form>
            <!-- <div class="result"></div> -->
    </div>
    <div class="col-sm-10 col-md-10 col-lg-10">
        <div id="result">
            <?php 
                //if(isset($_SESSION['search']) && ($_SESSION['search']['type'] == 'temp')) {
                    //foreach ($_SESSION['search']['result'] as $key) { ?>
                        
                <?        
                    //}
                //}
            ?>
        </div>
    </div>
</div>

<?php
if($_SESSION['login']['branchID'] == 27 ) {
    require_once $root.'/pages/footer.php';
}
?>

<script type="text/javascript">
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

$('body').click(function(){
    var select = $('#select').val();
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
    })
})

function clientID(elem) {
    var id = elem;
    $('#clientSearch').val('');
    $('.result').hide();
    $.ajax({       
        url: '/assets/php/Searching.php',
        data: {id: id},
        type: 'POST',
        dataType: 'json',
        success: function(data)
        {
            if(data == 'success')
            {
                $("#result").load("/pages/SearchResults.php");
            }
        }
    });
};

function clientNameID(elem) {
    var id = elem;
    var type = "clientname";
    $('#clientSearch').val('');
    $('.result').hide();
    $.ajax({       
        url: '/assets/php/Searching.php',
        data: {id: id, type: type},
        type: 'POST',
        dataType: 'json',
        success: function(data)
        {
            if(data == 'success')
            {
                $("#result").load("/pages/SearchResults.php");
            }
        }
    });
};

function tempID(elem) {
    var id = elem;
    var type = "temp";
    $('#tempSearch').val('');
    $('.result').hide();
    $.ajax({       
        url: '/assets/php/Searching.php',
        data: {id: id, type: type},
        type: 'POST',
        dataType: 'json',
        success: function(data)
        {
            if(data == 'success')
            {
                $("#result").load("/pages/SearchResults.php");
            }
        }
    });
};

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
</script>