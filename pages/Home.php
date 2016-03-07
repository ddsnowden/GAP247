<?php 
  //Define root path
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
  //Include header
	require_once $root.'/pages/header.php';
  //Include required classes
  require_once $root.'/assets/php/class/infoBox.class.php';
  $infoPanel = new infoPanel();
?>
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
<script src="/assets/js/custom/commonScripts.js"></script>

<div class="row">
  <div class="col-sm-3 col-md-3 col-lg-3">

  </div>

  <div class="col-sm-10 col-md-10 col-lg-10">
    <div id="infoPanel">
      <div id="infoBox">
        <br />
        <h1>Site Information and Changes</h1>
        <br />
        <?php 
        foreach ($infoPanel->pull($DBH) as $key) { ?>
          <div class="infoPost">
            <div class="left">
              <span class="title">
                <?php 
                  if($key['postType'] == 'SiteInfo'){ $title = 'Site Information';}
                  if($key['postType'] == 'Upgrade'){ $title = 'Site Upgrade';}
                  if($key['postType'] == 'Issue'){ $title = 'Site Issue';}
                  
                  echo htmlspecialchars($title, ENT_QUOTES); 
                ?>
              </span>
              <br />
              <span class="dateTime">
                <?php echo date('d-m-Y H:i', strtotime(htmlspecialchars($key['dateTime'], ENT_QUOTES))); ?>
              </span>
            </div>
            <div class="right">
              <pre class="info"><?php echo htmlspecialchars($key['info'], ENT_QUOTES); ?></pre>
            </div>
          </div>
        <?php } ?>

      </div>
    </div>
  </div>

  <div class="col-sm-3 col-md-3 col-lg-3">

  </div>
</div>

<?php
if($_SESSION['login']['branchID'] == 27 ) {
  require_once $root.'/pages/footer.php';
}
?>