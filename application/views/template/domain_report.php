<!-- Jquery Package End -->
<script type="text/javascript">
$(document).ready(function() {
	$(function() {
		$( "#autocomplete" ).autocomplete({
			source: function(request, response) {
				$.ajax({ url: "<?php echo site_url('report/domain_report_autoComplete'); ?>",
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

<h1>Domain Report</h1>
<form action ="<?php echo site_url('report/domain_report'); ?>" method="post" id="searchform">
	Domain Name <input type="text" id="autocomplete" name='domain' value="<?php echo $domainname; ?>"/>
	<input type="submit" value="Search >>" id="submit"/>
</form>
<?php
	print_r($results); 
?>
<p><?php echo $links; ?></p>
