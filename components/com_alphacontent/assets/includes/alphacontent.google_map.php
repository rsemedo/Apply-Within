<!DOCTYPE html "-//W3C//DTD XHTML 1.0 Strict//EN" 
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Google Maps</title>
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?php echo $_GET['google_map_key']; ?>&sensor=false"
            type="text/javascript"></script>
    <script type="text/javascript">
	
    function initialize() {
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map_canvas"));
        map.setCenter(new GLatLng(<?php echo $_GET['latitude']; ?>, <?php echo $_GET['longitude']; ?>), <?php echo $_GET['zoom']; ?>);		
		<?php if($_GET['control_map']=='1'){?>
        map.addControl(new GSmallMapControl());
		<?php } ?>
		<?php if($_GET['menu_map']=='1'){?>
        map.addControl(new GMapTypeControl());
		<?php } ?>		
        map.openInfoWindow(map.getCenter(),
                           document.createTextNode("<?php echo $_GET['messag']; ?>"));
      }
    }

    </script>
  </head>
  <body onload="initialize()" onunload="GUnload()">
    <div id="map_canvas" style="width: <?php echo $_GET['map_width'];?>px; height: <?php echo $_GET['map_height']; ?>px;padding:0;margin:0;"></div>
  </body>
</html>