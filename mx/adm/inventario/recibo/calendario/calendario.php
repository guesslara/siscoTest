<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>JQ Calendario</title>
<link type="text/css" href="../../css/css_calendario.css" rel="stylesheet" />	
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../js_calendario.js"></script>
<script type="text/javascript">
	$(function(){

		// Datepicker
		$('#datepicker').datepicker({
			inline: true
		});
	});
</script>
</head>

<body>
<div class="demo">
  <p>Date: <input id="datepicker" type="text"></p>
</div>
</body>
</html>
