<?php

	/*
		Author: Raúl Arroyo
		Date: 29/11/2016
		Version: 1
		
		Generate a open sea dragon viewer to be able to load a deep image tree.
		
		Parameters:
		
			$tree_name		String			Name of the tree. E.g. "tree_1"
			$zoom			Integer			Zoom. Min: 0, Max: ?
			$cell_x			Integer			Cell X
			$cell_y			Integer			Cell Y
			$debug = false	Boolean			Show log during execution
			
		Results:
		
			It will make a html file with a OpenSeadragon viewer.
		
		Exceptions:
		
			Exception	When cell size is wrong
			Exception	When zoom is wrong
			Exception	When output file cannot be made
	*/
	function generate_viewer($tree_name, $zoom, $cell_x, $cell_y, $debug = false) {
		$filename = "viewer_" . $tree_name . ".html";
		$file = fopen($filename, "w");
		
		// Check zoom
		if (!is_int($zoom)) {
			throw new Exception("Zoom must be an integer".PHP_EOL);
		} else if ($zoom < 0) {
			throw new Exception("Zoom must be 0 or higher".PHP_EOL);
		}
		
		// Check cell size
		if (!is_int($cell_x)) {
			throw new Exception("Cell X must be an integer".PHP_EOL);
		} else if ($cell_x <= 0) {
			throw new Exception("Cell X must more than 0".PHP_EOL);
		}
		if (!is_int($cell_y)) {
			throw new Exception("Cell Y must be an integer".PHP_EOL);
		} else if ($cell_y <= 0) {
			throw new Exception("Cell Y must more than 0".PHP_EOL);
		}
		
		if (!$file) {
			throw new Exception("Cannot create ".($filename).PHP_EOL);
		} else {
			$viewer = "<!DOCTYPE html>
<html lang='en'>
	<head>
		<meta charset='UTF-8'>
		<meta http-equiv='X-UA-Compatible' content='IE=edge'>
		<meta name='viewport' content='width=device-width, initial-scale=1'>
		<meta name='description' content='Viewer to see a deep image'>
		<meta name='author' content='Raúl Arroyo'>
		<link rel='icon' href='../../favicon.ico'>
		<title>OpenSeadragon Example</title>
		<!-- Bootstrap 3.3.7 -->
		<link href='css/bootstrap.min.css' rel='stylesheet'>
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src='https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js'></script>
			<script src='https://oss.maxcdn.com/respond/1.4.2/respond.min.js'></script>
		<![endif]-->
		<style type=''>
			#viewer {
				width: 800px;
				height: 600px;
			}
			
			body {
				padding-top: 50px;
			}
			
			.starter-template {
				padding: 40px 15px;
				text-align: center;
			}
		</style>
	</head>
	<body>
		<!-- Header -->
		<nav class='navbar navbar-inverse navbar-fixed-top'>
			<div class='container'>
				<div class='navbar-header'>
					<button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='#navbar' aria-expanded='false' aria-controls='navbar'>
						<span class='sr-only'>Toggle navigation</span>
						<span class='icon-bar'></span>
						<span class='icon-bar'></span>
						<span class='icon-bar'></span>
					</button>
					<a class='navbar-brand' href='#'>OpenSeadragon 2.2.1</a>
				</div>
				<div id='navbar' class='collapse navbar-collapse'></div>
			</div>
		</nav>
		<!-- End Header -->
		<!-- Content -->
		<div class='container'>
			<div class='starter-template'>
				<div class='row'>
					<div class='col-md-8 col-md-offset-2'>
						<div id='viewer'></div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Content -->
		<!-- jQuery 3.1.1 -->
		<script type='text/javascript' src='js/jquery.min.js'></script>
		<!-- Bootstrap 3.3.7 -->
		<script type='text/javascript' src='js/bootstrap.min.js'></script>
		<!-- OpenSeadragon 2.2.1-->
		<script type='text/javascript' src='js/openseadragon.min.js'></script>
		<script>
			$(document).ready(function() {
				var cell_x	= " . $cell_x . ";			// Cell X
				var cell_y	= " . $cell_y . ";			// Cell Y
				var zoom	= " . $zoom . ";				// Selected Zoom
				var image_x	= Math.pow(2, zoom) * cell_x;	// Image X
				var image_y	= Math.pow(2, zoom) * cell_y;	// Image Y
				
				var viewer = OpenSeadragon({
					id: 'viewer',
					prefixUrl: 'images/',
					navigatorSizeRatio: 0.25,
					showNavigator: true,
					tileSources: {
						width:  image_x,
						height: image_y,
						tileWidth: cell_x,
						tileHeight: cell_y,
						minLevel: 0,
						maxLevel: zoom,	
						getTileUrl: function( level, x, y ){
							return '" . $tree_name . "/tile_'+(level)+'_'+x+'-'+y+'.jpg';
						}
					}
				});
			});
		</script>
	</body>
</html>";
			fwrite($file, $viewer);
			fclose($file);
			
			if ($debug) {
				echo "Viewer = ".($filename).PHP_EOL;
			}
		}
	}
?>