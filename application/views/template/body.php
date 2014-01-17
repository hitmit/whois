<!DOCTYPE html>
<html class="domains-index">
<head>
  <title>WHOIS Search, Domain Name, Website, and IP Tools - Who.is</title>
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
  <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
  <meta name='description' content='Find information on any domain name or website. Large database of whois information, DNS, domain names, name servers, IPs, and tools for searching and monitoring domain names.'>
  <meta name='keywords' content='dns, name servers, dns tool, domain name, whois, tld, cctld, gtld, lookup, web, website, hosting, email, dns, internet'>
  
</head>
<body data-twttr-rendered="true">
<header class='masthead'>
	<div class='container'>
		<nav class='user-navigation'>
		<ul class='default-hidden' data-user-signed-in>
            <li><a href="/dashboard">Dashboard</a><!--<sup class='unread_alerts'></sup>--></li>
			<li><a href="/account/edit">My Account</a></li>
			<!-- li><a href="/who.is/help">Help</a></li -->
			<li><a href="/users/sign_out" data-method="delete" rel="nofollow">Log Out</a></li>
		</ul>
		<ul class='' data-user-signed-out>
			<li><a href="/overview">New Features</a></li>
			<!-- li><a href="/who.is/help">Help</a></li -->
			<li><a href="/users/sign_in">Log In</a></li>
			<li><a href="/users/sign_up" class="btn primary">Sign Up</a></li>
		</ul>
		
		</nav>
	</div><!--/container-->
</header>


<div data-just-created="false" id="main">
  <div  >
    <div  >


   
	<style>
		#main {padding-top: 0;}
		.container{margin: 0 auto;width: 90%;}
	</style>
	
	<div id='flash'>
		<span class='message'></span>
		<a class='icon-delete close' href='#' title='close'></a>
	</div>
</div>
<div class='search-wrapper'>
	<img alt="Who.is" class="logo" src="<?php echo base_url(); ?>assets/images/home.png">
	<h1 class='callout'>WHOIS Search, <a href="http://www.name.com/" target="_blank" rel="dofollow">Domain Name</a>, Website, and IP Tools</h1>
	<?php 
		$attributes = array('class' => 'search', 'id' => 'domain-search-form');
		echo form_open('welcome/searchwhois', $attributes); 
	?>
<?php 
	$data = array('name' => 'domain', 'type' => 'search', 'id' => 'terms', 'placeholder' => 'Search Domain name or IP address');
	echo form_input($data);
	$data1 = array('name' => 'commit', 'type' => 'submit', 'value' => 'Search', 'class' => 'btn primary');
	echo form_input($data1);
 ?>
<?php echo form_close(); ?>
<p class="clear your-ip"><i class="icon-map-marker" style="opacity: 0.4;"></i> Your IP address is <a href="/whois-ip/ip-address/202.0.103.50">202.0.103.50</a></p>
<br>
	<h1 class='call-to-action'>Domain data at your fingertips. What's on your dashboard? <a href="/users/sign_up" class="btn primary">Sign up now &raquo;</a></h1>
	<p class='learn-more'>
	or
	<a href="/overview">Learn More About The New Features</a>
	</p>
</div><!--/search-wrapper-->

<div class='features'>
	<div class='container'>
		<div class='feature'>
			<img alt="search" src="/images/home/icon-search-home.png" />
			<h2>See Website Information</h2>
			<p>Search the whois database, look up domain and IP owner information, and check out dozens of other statistics.</p>
		</div><!--/feature-->
		<div class='feature'>
			<img alt="star" src="/images/home/icon-star.png" />
			<h2>Save and Follow Domains</h2>
			<p>Organizing domains across multiple registrars for quick reference has never been so easy.</p>
		</div><!--/feature-->
		<div class='feature'>
			<img alt="clock" src="/images/home/icon-clock.png" />
			<h2>On Demand Domain Data</h2>
			<p>Get all the data you need about a domain and everything associated with that domain anytime with a single search.</p>
		</div><!--/feature-->
		<div class='feature'>
			<img alt="eye" src="/images/home/icon-eye.png" />
			<h2><a href="https://www.name.com/account/ntld/watcher" target="_blank" class="nolinkstyles">New TLD Watcher</a></h2>
			<p>New endings to the right of the dot like .Blog, .Web, and .App are coming soon. <a href="https://www.name.com/account/ntld/watcher" target="_blank">Stay informed with Name.com's nTLD Watcher.</a></p>
		</div><!--/feature-->
	</div><!--/container-->
</div><!--/features-->




		
		</div><!--/content-->




	</div><!--/container-->




</body>
</html>
