<!-- Jquery Package End -->
<script type="text/javascript">
$(document).ready(function() {
	$(function() {
		$( "#autocomplete" ).autocomplete({
			source: function(request, response) {
				$.ajax({ url: "<?php echo site_url('report/dc_report_autoComplete'); ?>",
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
<?php print_r($dcname); ?>
<?php print_r($arg); ?>
<h1>Data Center Report</h1>
<form action ="<?php echo site_url('report/dc_report'); ?>" method="post" id="searchform">
	DC Name <input type="text" id="autocomplete" name='dc_name' value="<?php echo $dcname; ?>"/>
	<input type="submit" value="Search >>" id="submit"/>
</form>
<?php
	print_r($results); 
?>
<p><?php echo $links; ?></p>
