<header class="tab-header">
	<div class="title">
		<h3>Domain History Info for facebook.com</h3>
	</div><!--/title-->
</header>
<section class="clearfix">
	<div class="domain-data-wrapper">
		<div style="width: 50%;" class="col">
			<div class="box-inset">
			<?php	if($old != 'No History Found') { ?>
				<div class="registrar-information domain-data">
					<header>
						<h5>Old Registrar Info <?php echo date('Y-m-d', $old['adddate']); ?></h5>
					</header>
				<table>
					<tbody>
						<tr>
							<th>Name</th>
							<td><span data-bind-domain="registrar_name"><?php echo $old['registrarname']; ?></span></td>
						</tr>
						<tr>
							<th>Referral URL</th>
							<td><span data-bind-domain="referral_url"><?php echo $old['reffername']; ?></span></td>
						</tr>
						<tr>
							<th>Status</th>
							<td><span data-bind-domain="referral_url"><?php echo $old['status_info']; ?></span></td>
						</tr>
					</tbody>
				</table>
				</div>
				<div class="important-dates domain-data">
					<header>
						<span style="display:block" class="fetch-success" rel="tooltip" data-original-title="This data has been fetched."></span>
						<h5>Important Dates</h5>
					</header>
					<table>
						<tbody>
							<?php if($old['expire'] != '') {?>
								<tr>
									<th>Expires On</th>
									<td><span style="visibility: visible;" data-bind-domain="expiration_date"><?php echo $old['expire']; ?></span></td>
								</tr>
							<?php } ?>
							<?php if($old['created'] != '') {?>
							<tr>
								<th>Registered On</th>
								<td><span style="visibility: visible;" data-bind-domain="expiration_date"><?php echo $old['created']; ?></span></td>
							</tr>
							<?php } ?>
							<?php if($old['updatedon'] != '') {?>
							<tr>
								<th>Updated On</th>
								<td><span style="visibility: visible;" data-bind-domain="expiration_date"><?php echo $old['updatedon']; ?></span></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="name-servers domain-data">
					<header>
						<span style="display:block" class="fetch-success" rel="tooltip" data-original-title="This data has been fetched."></span>
						<h5>Name Servers</h5>
					</header>
					<table>
						<tbody style="visibility: visible;" data-bind-domain="nameservers">
							<?php if($old['ns1'] != '') {?>
							<tr>
								<td>
									<a href="/nameserver/ns51.1and1.com/"><?php echo $old['ns1']; ?></a>
								</td>
								<td>
									<a href="/whois-ip/ip-address/217.160.80.164/"><?php echo $old['nsip1']; ?></a><br>
								</td>
							</tr>
							<?php } ?>
							<?php if($old['ns2'] != '') {?>
							<tr>
								<td>
									<a href="/nameserver/ns51.1and1.com/"><?php echo $old['ns2']; ?></a>
								</td>
								<td>
									<a href="/whois-ip/ip-address/217.160.80.164/"><?php echo $old['nsip2']; ?></a><br>
								</td>
							</tr>
							<?php } ?>
							<?php if($old['ns3'] != '') {?>
							<tr>
								<td>
									<a href="/nameserver/ns51.1and1.com/"><?php echo $old['ns3']; ?></a>
								</td>
								<td>
									<a href="/whois-ip/ip-address/217.160.80.164/"><?php  $old['nsip3']; ?></a><br>
								</td>
							</tr>
							<?php } ?>
							<?php if($old['ns4'] != '') {?>
							<tr>
								<td>
									<a href="/nameserver/ns51.1and1.com/"><?php echo $old['ns4']; ?></a>
								</td>
								<td>
									<a href="/whois-ip/ip-address/217.160.80.164/"><?php echo $old['nsip4']; ?></a><br>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			<?php } else { echo $old; } ?>
			</div>    
		</div>
    <div style="width: 50%;" class="col">
			<div class="box-inset">
						<div class="registrar-information domain-data">
					<header>
						<h5>Registrar Info <?php echo date('Y-m-d', $new['adddate']); ?></h5>
					</header>
				<table>
					<tbody>
						<tr>
							<th>Name</th>
							<td><span data-bind-domain="registrar_name"><?php echo $new['registrarname']; ?></span></td>
						</tr>
						<tr>
							<th>Referral URL</th>
							<td><span data-bind-domain="referral_url"><?php echo $new['reffername']; ?></span></td>
						</tr>
						<tr>
							<th>Status</th>
							<td><span data-bind-domain="referral_url"><?php echo $new['status_info']; ?></span></td>
						</tr>
					</tbody>
				</table>
				</div>
				<div class="important-dates domain-data">
					<header>
						<span style="display:block" class="fetch-success" rel="tooltip" data-original-title="This data has been fetched."></span>
						<h5>Important Dates</h5>
					</header>
					<table>
						<tbody>
							<?php if($new['expire'] != '') { ?>
								<tr>
									<th>Expires On</th>
									<td><span style="visibility: visible;" data-bind-domain="expiration_date"><?php echo $new['expire']; ?></span></td>
								</tr>
							<?php } ?>
							<?php if($new['created'] != '') { ?>
							<tr>
								<th>Registered On</th>
								<td><span style="visibility: visible;" data-bind-domain="expiration_date"><?php echo $new['created']; ?></span></td>
							</tr>
							<?php } ?>
							<?php if($new['updatedon'] != '') { ?>
							<tr>
								<th>Updated On</th>
								<td><span style="visibility: visible;" data-bind-domain="expiration_date"><?php echo $new['updatedon']; ?></span></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="name-servers domain-data">
					<header>
						<span style="display:block" class="fetch-success" rel="tooltip" data-original-title="This data has been fetched."></span>
						<h5>Name Servers</h5>
					</header>
					<table>
						<tbody style="visibility: visible;" data-bind-domain="nameservers">
							<?php if($new['ns1'] != '') {?>
							<tr>
								<td>
									<a href="/nameserver/ns51.1and1.com/"><?php echo $new['ns1']; ?></a>
								</td>
								<td>
									<a href="/whois-ip/ip-address/217.160.80.164/"><?php echo $new['nsip1']; ?></a><br>
								</td>
							</tr>
							<?php } ?>
							<?php if($new['ns2'] != '') {?>
							<tr>
								<td>
									<a href="/nameserver/ns51.1and1.com/"><?php echo $new['ns2']; ?></a>
								</td>
								<td>
									<a href="/whois-ip/ip-address/217.160.80.164/"><?php echo $new['nsip2']; ?></a><br>
								</td>
							</tr>
							<?php } ?>
							<?php if($new['ns3'] != '') {?>
							<tr>
								<td>
									<a href="/nameserver/ns51.1and1.com/"><?php echo $new['ns3']; ?></a>
								</td>
								<td>
									<a href="/whois-ip/ip-address/217.160.80.164/"><?php $new['nsip3']; ?></a><br>
								</td>
							</tr>
							<?php } ?>
							<?php if($new['ns4'] != '') {?>
							<tr>
								<td>
									<a href="/nameserver/ns51.1and1.com/"><?php echo $new['ns4']; ?></a>
								</td>
								<td>
									<a href="/whois-ip/ip-address/217.160.80.164/"><?php echo $new['nsip4']; ?></a><br>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="domain-data-wrapper">
		<div style="width: 50%;" class="col">
			<div class="domain-data-wrapper">
				<div class="col force-page-break">
					<div class="box-inset">
						<?php	if($old != 'No History Found') { ?>
							<div class="raw-registrar-data domain-data">
								<header>
									<span style="display:block;" class="fetch-success" rel="tooltip" data-original-title="This data has been fetched."></span>
									<h5>Old Raw Registrar Data May 11, 2007</h5>
								</header>
								<div class="raw_data">
									<span data-bind-domain="raw_registrar_lookup">
										<?php
											$rawdata = explode("*", $old['rawdata']);
											if(!empty($rawdata)) {
												foreach($rawdata as $value){
													echo stripslashes($value).'<br/>';
												}
											}
										?>	
									</span>
								</div>
							</div>
						<?php } else { echo $old; } ?>
				</div>
				</div>
			</div>
		</div>
    <div style="width: 50%;" class="col">
			<div class="domain-data-wrapper">
				<div class="col force-page-break">
					<div class="box-inset">
						<div class="raw-registrar-data domain-data">
							<header>
								<span style="display:block;" class="fetch-success" rel="tooltip" data-original-title="This data has been fetched."></span>
								<h5>Raw Registrar Data <?php echo date('Y-m-d'); ?></h5>
							</header>
							<div class="raw_data">
								<span data-bind-domain="raw_registrar_lookup">
									<?php
											$rawdata1 = explode("*", $new['rawdata']);
											if(!empty($rawdata1)) {
												foreach($rawdata1 as $value){
													echo stripslashes($value).'<br/>';
												}
											}
										?>	
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>    
		</div>
	</div>
</section>
        
<div>

<?php 
	/* echo '------old--------<pre>';
   print_r($old);
	echo '</pre>------new--------<pre>';
	 print_r($new);
	echo '</pre>'; */
	 
 ?>
</div>