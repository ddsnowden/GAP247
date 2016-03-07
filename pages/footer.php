				
			</div> <!-- End col_16 -->
		</div>	<!-- End row -->
		<!-- ---------------------------------------------------------------------------------  End Main Content  --------------------------------------------------------------------- -->
		<style type="text/css">
			.footer {
				position: fixed;
				bottom: 0px;
				width: 18%;
				height: 2.0%;
			}
			.footer ul a{
				text-decoration: none;
				color: #FFF;
				padding: 0;
			}
			.footer ul li{
				display: inline;
				padding-right: 5px;
				padding-left: 5px;
				vertical-align: middle;
				border-right: 1px solid grey;
			}
		</style>
		<div class="row">
			<div class="col-lg-16">
				<div class="footer" style="width: 50%;">
					<ul>
						<li><a href="#0" class="cd-btn outAlert">Outstanding</a></li>
						<li><a href="#0" class="cd-btn2 mailAlert">Not Emailed</a></li>
						<li><a href="#0" class="cd-btn3">Messaging</a></li>
					</ul>
				</div>
			</div>
		</div>

		<?php
			// Load the classes
			require_once $root.'/assets/php/class/CallAlerts.class.php';
			require_once $root.'/assets/php/class/Chat.class.php';
			$calls = new CallAlerts();
			$chat = new Chat();

		?>
		<div class="row">
			<div class="col-lg-16">
				<div class="cd-panel from-right">
				    <header class="cd-panel-header">
						<h1>Outstanding Calls</h1>
						<h2 class="indivCalls">There are a total of <span class="red"><?php echo count($calls->outstanding($DBH)); ?></span> outstanding calls of which <span class="red"><?php echo count($calls->outstandingIndiv($DBH, $_SESSION['login']['staffID'])) ?></span> are yours.</h2>
				    </header>

				    <div class="cd-panel-container">
				      <div class="cd-panel-content">
				      <div class="slideTable">
					        <?php if ($_SESSION['login']['access'] == 0): ?>
					        <table>
					          <th>Call ID</th><th>Call Type</th><th>Client</th><th>Client Name</th><th>Temp</th><th>Branch</th>
					          <tbody>
					            <?php foreach($calls->outstandingIndiv($DBH, $_SESSION['login']['staffID']) as $key) { ?>
					            <tr>
					              <td><span style="cursor: pointer" onClick="slideRecall(this.innerHTML);"><?php echo $key['callID']; ?></span></td>
					              <td><?php echo ucwords($key['type']); ?></td>
					              <td><?php echo $key['clientName']; ?></td>
					              <td><?php echo $key['clientFirst'].' '.$key['clientLast']; ?></td>
					              <td><?php echo $key['firstName'].' '.$key['lastName']; ?></td>
					              <td><?php echo $key['branchName']; ?></td>
					            </tr>
					            <?php } ?>
					          </tbody>
					        </table>
					        <?php Endif; ?>
					        <?php if ($_SESSION['login']['access'] == 1 || $_SESSION['login']['access'] == 2): ?>
					        <table>
					          <th>Call ID</th><th>Call Type</th><th>Client</th><th>Client Name</th><th>Temp</th><th>Branch</th><th>Staff Name</th>
					          <tbody>
					          <?php foreach ($calls->outstanding($DBH) as $key) { ?>
					            <tr>
					              <td><span style="cursor: pointer" onClick="slideRecall(this.innerHTML);"><?php echo $key['callID']; ?></span></td>
					              <td><?php echo ucwords($key['type']); ?></td>
					              <td><?php echo $key['clientName']; ?></td>
					              <td><?php echo $key['clientFirst'].' '.$key['clientLast']; ?></td>
					              <td><?php echo $key['firstName'].' '.$key['lastName']; ?></td>
					              <td><?php echo $key['branchName']; ?></td>
					              <td><?php echo $key['staffNameFirst'].' '.$key['staffNameLast']; ?></td>
					            </tr>
					            <?php } ?>
					          </tbody>
					        </table>
					      <?php Endif; ?>
					    </div>
				      </div> <!-- cd-panel-content -->
				    </div> <!-- cd-panel-container -->
				  </div> <!-- cd-panel -->

				  <div class="cd-panel2 from-right">
				  <div class="slideTable">
					    <header class="cd-panel-header2">
					      <h1>Calls Not Emailed</h1>
					      <h2 class="indivCalls">There are a total of <span class="red"><?php echo count($calls->notEmailed($DBH)); ?></span> non-emailed calls of which <span class="red"><?php echo count($calls->notEmailedIndiv($DBH, $_SESSION['login']['staffID'])); ?></span> are yours.</h2>
					      <!-- <a href="#0" class="cd-panel-close2" style="color: red">Close</a> -->
					    </header>

					    <div class="cd-panel-container">
					      <div class="cd-panel-content">
					        <?php if ($_SESSION['login']['access'] == 0): ?>
					        <table>
					          <th>Call ID</th><th>Call Type</th><th>Branch</th><th>Date Inputted</th>
					          <tbody>
					            <?php foreach($calls->notEmailedIndiv($DBH, $_SESSION['login']['staffID']) as $key) { ?>
					            <tr>
					              <td><span style="cursor: pointer" onClick="slideRecall(this.innerHTML);"><?php echo $key['callID']; ?></span></td>
					              <td><?php echo ucwords($key['type']); ?></td>
					              <td><?php echo $key['branchName']; ?></td>
					              <td><?php echo $key['dateInputted']; ?></td>
					            </tr>
					            <?php } ?>
					          </tbody>
					        </table>
					        <?php Endif; ?>
					        <?php if ($_SESSION['login']['access'] == 1 || $_SESSION['login']['access'] == 2): ?>
					        <table>
					          <th>Call ID</th><th>Call Type</th><th>Branch</th><th>Date Inputted</th><th>Staff Name</th>
					          <tbody>
					          <?php foreach ($calls->notEmailed($DBH) as $key) { ?>
					            <tr>
					              <td><span style="cursor: pointer" onClick="slideRecall(this.innerHTML);"><?php echo $key['callID']; ?></span></td>
					              <td><?php echo ucwords($key['type']); ?></td>
					              <td><?php echo $key['branchName']; ?></td>
					              <td><?php echo $key['dateInputted']; ?></td>
					              <td><?php echo $key['staffNameFirst'].' '.$key['staffNameLast']; ?></td>
					            </tr>
					            <?php } ?>
					          </tbody>
					        </table>
					      <?php Endif; ?>  
					      </div> <!-- cd-panel-content -->
					    </div> <!-- cd-panel-container -->
					 </div>
				  </div> <!-- cd-panel -->

				  <div class="cd-panel3 from-right">
					  <div class="slideTable">
						    <header class="cd-panel-header3">
						      <h1>GAP24/7 Message System</h1>
						    </header>

						    <div class="cd-panel-container">
						      <div class="cd-panel-content">
							      <div class="row form">
									<div class="col-sm-8 col-md-8 col-lg-16">
								        
										<form method="POST" action="" role="form" class="form-horizontal" >
										    <div class="row">
										    	 <div class="col-sm-3 labright">
								                    <label for="message" style="color: #000">Message:</label>
								                </div>
								                <div class="col-sm-10">
								                	<textarea class="form-control input" rows="3" name="message" id="message" type="text"></textarea>
								            	</div>
								            	<div class="col-sm-3">
								                    <button onclick="insertMsg()" id="msgSubmit" class="btn btn-primary">Submit</button>
								                </div>
										    </div>
										</form>
									</div>
								</div>
								<?php if ($_SESSION['login']['access'] <= 2): ?>
								<table id="replies">
									<th>From</th><th>Message</th>
									<tbody>
									<?php foreach ($chat->show($DBH) as $key) { ?>
										<tr>
											<td class="from"><?php echo $key['username'].'<br /><span class="smallDT">'.$key['sent_on'].'</span>'; ?></td>
											<td class="msg"><pre><?php echo $key['message']; ?></pre></td>
										</tr>
									<?php } ?>
									</tbody>
								</table>
								<?php Endif; ?>
							</div> <!-- cd-panel-content -->
						</div> <!-- cd-panel-container -->
					</div>
				</div> <!-- cd-panel -->

			</div>
		</div>
		<script type="text/javascript">
			function insertMsg() {
				msg = $('textarea#message').val();
				$.ajax({       
					url: '/assets/php/messaging.php',
					data: {msg: msg},
					type: 'POST',
					dataType: 'json',
					success: function(data)
					{
						if(data == 'success'){
							$("#replies").load(location.href+" #replies>*","");
						}
					}
				});
				$('textarea#message').val('');
				event.preventDefault();
				$('.cd-panel3').addClass('is-visible');
			};
		</script>
	</body>
</html>