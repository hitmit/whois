<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<link rel="stylesheet" href="/resources/demos/style.css">
	<script>
		  $(document).ready(function(){
        $( "#button" ).click(function() {
					/* var tabdata = $('#tab2').val();
					if(tabdata === '') {
						alert('hi');
						$("#tab2").val("facebook.com");
						$.ajax({
							type: "POST",
							url: <?php echo site_url('welcome/web_info'); ?>,
							data: { term: 'facebook.com'},
							success: function(msg){
								alert(msg);
								$('#tabs2').html(msg);
							}
						}); 
					} */	
					var tabdata = $('#tab2').val();
					if(tabdata === '') {
						$("#tab2").val("facebook.com");
							$.ajax({
					type: "POST",
					url: "<?php echo site_url('welcome/history'); ?>",
					data: 'term = facebook.com',
					success: function(msg){
							$('#tabs2').append(msg);
					}
							}); 
					}
				});
			});
		/*$(function() {
			 $( "#tabs" ).tabs({
				beforeLoad: function( event, ui ) {
				ui.jqXHR.error(function() {
					ui.panel.html(
					"Couldn't load this tab. We'll try to fix this as soon as possible. " +
					"If this wouldn't be a demo." );
				});
			}
		}); 
	
		});*/
	</script>
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Preloaded</a></li>
		<li><input type="button" id="button" value="click"/></li>
		<li><a href="<?php echo site_url('welcome/history/facebook.com'); ?>">Tab 2</a></li>
		<li><a href="<?php echo site_url('welcome/history/neerja.com'); ?>">Tab 3 (slow)</a></li>
		<li><a href="<?php echo site_url('welcome/history/redstartsw.com'); ?>">Tab 4 (broken)</a></li>
	</ul>
	<div id="tabs-1">
			<p>Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo. Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vitae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius sollicitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tempus lectus.</p>
	</div>
	<div id="tabs2">
		<input type='hidden' id="tab2" value="" />
	</div>
	
</div>
