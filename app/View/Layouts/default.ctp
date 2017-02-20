<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>歌唱比賽分數查詢</title>
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable = no" />
	<link rel="apple-touch-icon-precomposed"
	      sizes="144x144"
	      href="<?php $this->Path->myroot(); ?>img/ios_icon.png">
	<link rel="stylesheet" href="<?php $this->Path->myroot(); ?>css/foundation.css" />
	<link rel="stylesheet" href="<?php $this->Path->myroot(); ?>css/web.css" />
    <script src="<?php $this->Path->myroot(); ?>js/modernizr.js"></script>
    
</head>
<body>

			<?php echo $this->fetch('content'); ?>
	
	<script src="<?php $this->Path->myroot(); ?>js/jquery.js"></script>
    <script src="<?php $this->Path->myroot(); ?>js/foundation.min.js"></script>
    <script>
      $(document).foundation();
    </script>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-48546260-1', 'puiching.edu.mo');
      ga('send', 'pageview');

    </script>
</body>
</html>
