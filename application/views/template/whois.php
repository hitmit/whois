<?php //print_r($whois); ?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script>
$(document).ready(function(){
	$(document).ajaxStart(function(){
    $("#loading").html('<img src = "<?php echo base_url(); ?>/assets/images/home.png"/>');
  });
	var domain = '<?php echo $whois['domain_name'];  ?>';
	$('#loading').hide();
	$("#tab2").hide();
	$("#tab3").hide();
	$("#tab4").hide();
	$( "#uitab1").click(function() {
		$("#uitab1").addClass("active ui-state-disabled");
		$("#uitab2").removeClass("active ui-state-disabled");
		$("#uitab3").removeClass("active ui-state-disabled");
		$("#uitab4").removeClass("active ui-state-disabled");
		$("#tab1").show();
		$("#tab2").hide();
		$("#tab3").hide();
		$("#tab4").hide();
	});
	$( "#uitab2").click(function() {
		$("#uitab2").addClass("active ui-state-disabled");
		$("#uitab1").removeClass("active ui-state-disabled");
		$("#uitab3").removeClass("active ui-state-disabled");
		$("#uitab4").removeClass("active ui-state-disabled");
		$("#tab2").show();
		$("#tab1").hide();
		$("#tab3").hide();
		$("#tab4").hide();
		var tabs2 = $('#tabs2').val();
		if(tabs2 === '') {
			$("#tabs2").val(domain);
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('welcome/web_info'); ?>",
				data: 'term = '+ domain,
				success: function(msg){
					$('#tab2').append(msg);
					$('#loading').html('<img src="loading.gif"> loading...');
				}
			}); 
		}
	});
	$( "#uitab3").click(function() {
		$("#uitab3").addClass("active ui-state-disabled");
		$("#uitab1").removeClass("active ui-state-disabled");
		$("#uitab2").removeClass("active ui-state-disabled");
		$("#uitab4").removeClass("active ui-state-disabled");
		$("#tab3").show();
		$("#tab1").hide();
		$("#tab2").hide();
		$("#tab4").hide();
		var tabs3 = $('#tabs3').val();
		if(tabs3 === '') {
			$("#tabs3").val(domain);
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('welcome/history'); ?>",
				data: 'term='+ domain,
				success: function(msg){
					$('#tab3').append(msg);
				}
			}); 
		}
	});
	$( "#uitab4").click(function() {
		$("#uitab4").addClass("active ui-state-disabled");
		$("#uitab1").removeClass("active ui-state-disabled");
		$("#uitab2").removeClass("active ui-state-disabled");
		$("#uitab3").removeClass("active ui-state-disabled");
		$("#tab4").show();
		$("#tab1").hide();
		$("#tab2").hide();
		$("#tab3").hide();
		var tabs4 = $('#tabs4').val();
		if(tabs4 === '') {
			$("#tabs4").val(domain);
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('welcome/dns_fetched'); ?>",
				data: 'domain='+ domain,
				success: function(msg){
					$('#tab4').append(msg);
				}
			}); 
		}
	});
});
</script>
<div id="domain-data" class="box alexa-success dns-success whois-success premium_domains-success suggested_domains-success">
<header>
		<ul class="tabs btn-group clearfix">
			<li><a class="btn pjax-btn active ui-state-disabled  " id="uitab1" href="#">Whois</a></li>
			<li><a class="btn pjax-btn " id="uitab2" href="#">Website Info</a></li>
			<li><a class="btn pjax-btn " id="uitab3" href="#">History</a></li>
			<li><a class="btn pjax-btn " id="uitab4" href="#">DNS Records</a></li>
			<li><a class="btn pjax-btn ">Diagnostics</a></li>
		</ul>                  
	</header>
	
<div id="loading">	</div>
<div id="tab1">	
	<div class="box-inset">
	<div class="registrar-information domain-data">
		<header>
			<span style="display:block" class="fetch-success" rel="tooltip" title="This data has been fetched."></span>
			<h5>Registrar Info</h5>
		</header>
		<table>
			<tbody>
				<tr>
					<th>Name</th>
					<td><span data-bind-domain="registrar_name"><?php echo $whois['registrarname']; ?></span></td>
				</tr>
				<tr>
					<th>Referral URL</th>
					<td><span data-bind-domain="referral_url"><?php echo $whois['reffername']; ?></span></td>
				</tr>
				<tr>
					<th>Status</th>
					<td><span data-bind-domain="referral_url"><?php echo $whois['status_info']; ?></span></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="important-dates domain-data">
		<header>
			<span style="display:block" class="fetch-success" rel="tooltip" title="This data has been fetched."></span>
			<h5>Important Dates</h5>
		</header>
		<table>
			<tbody>
				<?php if($whois['expire'] != '') {?>
					<tr>
						<th>Expires On</th>
						<td><span style="visibility: visible;" data-bind-domain="expiration_date"><?php echo $whois['expire']; ?></span></td>
					</tr>
				<?php } ?>
				<?php if($whois['created'] != '') {?>
				<tr>
					<th>Registered On</th>
					<td><span style="visibility: visible;" data-bind-domain="expiration_date"><?php echo $whois['created']; ?></span></td>
				</tr>
				<?php } ?>
				<?php if($whois['updatedon'] != '') {?>
				<tr>
					<th>Updated On</th>
					<td><span style="visibility: visible;" data-bind-domain="expiration_date"><?php echo $whois['updatedon']; ?></span></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="name-servers domain-data">
		<header>
			<span style="display:block" class="fetch-success" rel="tooltip" title="This data has been fetched."></span>
			<h5>Name Servers</h5>
		</header>
		<table>
			<tbody style="visibility: visible;" data-bind-domain="nameservers">
				<?php if($whois['ns1'] != '') {?>
				<tr>
					<td>
						<a href="/nameserver/ns51.1and1.com/"><?php echo $whois['ns1']; ?></a>
					</td>
					<td>
						<a href="/whois-ip/ip-address/217.160.80.164/"><?php echo $whois['nsip1']; ?></a><br>
					</td>
				</tr>
				<?php } ?>
				<?php if($whois['ns2'] != '') {?>
				<tr>
					<td>
						<a href="/nameserver/ns51.1and1.com/"><?php echo $whois['ns2']; ?></a>
					</td>
					<td>
						<a href="/whois-ip/ip-address/217.160.80.164/"><?php echo $whois['nsip2']; ?></a><br>
					</td>
				</tr>
				<?php } ?>
				<?php if($whois['ns3'] != '') {?>
				<tr>
					<td>
						<a href="/nameserver/ns51.1and1.com/"><?php echo $whois['ns3']; ?></a>
					</td>
					<td>
						<a href="/whois-ip/ip-address/217.160.80.164/"><?php echo $whois['nsip3']; ?></a><br>
					</td>
				</tr>
				<?php } ?>
				<?php if($whois['ns4'] != '') {?>
				<tr>
					<td>
						<a href="/nameserver/ns51.1and1.com/"><?php echo $whois['ns4']; ?></a>
					</td>
					<td>
						<a href="/whois-ip/ip-address/217.160.80.164/"><?php echo $whois['nsip4']; ?></a><br>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	</div>
	<div style="padding-right:10px" class="section" id="registrar_whois">
			
		<div class="domain-data-wrapper">
			<div class="col force-page-break">
				<div class="box-inset">
					<div class="raw-registrar-data domain-data">
						<header>
							<span style="display:block;" class="fetch-success" rel="tooltip" data-original-title="This data has been fetched."></span>
							<h5>Raw Registrar Data</h5>
						</header>
						<div class="raw_data">
							<span data-bind-domain="raw_registrar_lookup">


							<?php
							$rawdata = explode("*",$whois['rawdata']);
							if(!empty($rawdata)) {
								foreach($rawdata as $value){
									echo stripslashes($value).'<br/>';
								}
							}
							?>


							</span>

						</div>
					</div>
				</div>
			</div>
		</div>    <!-- /span -->
	</div>
</div>
<div id="tab2">
<input type="hidden" id="tabs2" value=""/>
tab2
</div>
<div id="tab3">
<input type="hidden" id="tabs3" value=""/>
tab3
</div>
<div id="tab4">
<input type="hidden" id="tabs4" value=""/>
tab4
</div>
<?php 
//   print_r($whois);
?>
</div>