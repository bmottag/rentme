<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Signature Pad</title>
  <meta name="description" content="Signature Pad - HTML5 canvas based smooth signature drawing using variable width spline interpolation.">

  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">

  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">

  <link rel="stylesheet" href="<?php echo base_url("assets/signature_pad/css/signature-pad.css"); ?>">

  <script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-39365077-1']);
    _gaq.push(['_trackPageview']);

    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
  </script>
</head>
<body onselectstart="return false">
	<form  name="form" id="form" method="post" >
		<div id="signature-pad" class="m-signature-pad">
      <div style='text-align: right'>
        <button type="button" class="button close">
          <a href="<?php echo base_url("external/review_rent/" . $idRent); ?>">X</a>
        </button>
      </div>
			<div class="m-signature-pad--body">
				<canvas></canvas>
			</div>
			<div class="m-signature-pad--footer">
				<div class="description">Sign above</div>
				<button type="button" class="button clear" data-action="clear">Clear</button>
				<button type="button" class="button save" data-action="save">Save</button>
			</div>
		</div>
		<input type="hidden" name="image" id="image">
	</form>
  <script src="<?php echo base_url("assets/signature_pad/js/signature_pad.js"); ?>"></script>
  <script src="<?php echo base_url("assets/signature_pad/js/app.js"); ?>"></script>
</body>
</html>