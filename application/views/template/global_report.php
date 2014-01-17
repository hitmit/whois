<!-- Jquery Package End -->
<script type="text/javascript">
$(document).ready(function() {
	$(function() {
		$( "#autocomplete" ).autocomplete({
			source: function(request, response) {
				$.ajax({ url: "<?php echo site_url('report/global_report_autoComplete'); ?>",
				data: { term: $("#autocomplete").val()},
				dataType: "json",
				type: "POST",
				success: function(data){
					response(data);
				}
			});
		},
		minLength: 1
		});
	});
});
</script>

<h1>Global Report</h1>
<form action ="<?php echo site_url('report/global_report'); ?>" method="post" id="searchform">
	Global Name <input type="text" id="autocomplete" name='country' value="<?php echo $country; ?>"/>
	<input type="submit" value="Search >>" id="submit"/>
</form>
<?php
	print_r($results); 
?>
<?php
	$query = $this->report_model->domain_count1('facebook.com'); 
	//$row = $query->result();
	print_r($query);
	//print_r($row);
?>
<p><?php echo $links; ?></p>
