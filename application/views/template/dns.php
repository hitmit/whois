<?php //print_r($dns_result); ?>
<section data-pjax-container="" class="tab-pane">
	<header class="tab-header">
		<div class="title">
			<h3>DNS for facebook.com</h3>
		</div><!--/title-->
	</header>
	<section class="clearfix">
		<div class="box-inset">
			<?php 
				if(!empty($dns_result)) {
					$soa_record = str_replace("	", "|", $dns_result);
					$soa_record = str_replace(" ", "|", $soa_record);
					$soa_record = str_replace("	", "|", $soa_record);
					$soa = explode("|", $soa_record);
					//print_r($soa);	
			?>
			<div class="soa-record domain-data">
				<header>
					<span rel="tooltip" class="fetch-waiting" data-original-title="We are still waiting for this data to be fetched."></span>
					<span rel="tooltip" class="fetch-success" data-original-title="This data has been fetched."></span>
					<span rel="tooltip" class="fetch-fail" data-original-title="We were unable to fetch this data."></span>
					<h5 data-original-title="Authoritative information about facebook.com">SOA Record &ndash; facebook.com</h5>
				</header>
				<table id="soa_record" data-bind-domain="start_of_authority">
					<tbody>
						<tr>
							<th>Name Server</th>
							<td><?php echo $soa[4]; ?></td>
						</tr>
						<tr>
							<th>Email</th>
							<td><?php echo $soa[5]; ?></td>
						</tr>
						<tr>
							<th>Serial Number</th>
							<td><?php echo $soa[6]; ?></td>
						</tr>
						<tr>
							<th>Refresh</th>
							<td><?php echo number_format($soa[7]/3600,0,",",""); ?> hour</td>
						</tr>
						<tr>
							<th>Retry</th>
							<td><?php echo number_format($soa[8]/3600,0,",",""); ?> hour</td>
						</tr>
						<tr>
							<th>Expiry</th>
							<td><?php echo number_format($soa[9]/3600,0,",",""); ?> hour</td>
						</tr>
						<tr>
							<th>Minimum</th>
							<td><?php echo number_format($soa[10]/3600,0,",",""); ?> hour</td>
						</tr>
					</tbody>
				</table>
			</div><!--/soa-record domain-data-->
		<?php } ?>
		</div><!--/box-inset-->

		<div class="box-inset">
			<div class="dns-records domain-data">
				<header>
					<span rel="tooltip" class="fetch-waiting" data-original-title="We are still waiting for this data to be fetched."></span>
					<span rel="tooltip" class="fetch-success" data-original-title="This data has been fetched."></span>
					<span rel="tooltip" class="fetch-fail" data-original-title="We were unable to fetch this data."></span>
					<h5 data-original-title="DNS Records for facebook.com">DNS Records &ndash; FACEBOOK.COM</h5>
				</header>
				<?php echo $results; ?>	
			</div><!--/dns-records domain-data-->
		</div><!--/box-inset-->
	</section>
</section>