<?php

	/*
		Author: Raúl Arroyo
		Date: 29/11/2016
		Version: 1
		
		Generate a deep image tree. This allow you to show a extremely big image by sending
		parts of it depending on where is the user looking at. It would be advisable to use
		this when seeing an image through mobile connection.
		
		Tree explanation
		----------------
		
		  - Zoom 0 (Original image escalated to cell size)
		  - Zoom 1 (Original image is divided into 4 cells with size = cell size)
			
						2 * Cell X
						-----
						|1|2|
			2 * Cell Y	-----
						|3|4|
						-----
				
		  - Zoom 2 (Original image is divided into 16 cells with size = cell size)
		  
						4 * Cell X
						-------------
						| 1| 2| 3| 4|
						-------------
						| 5| 6| 7| 8|
			4 * Cell Y	-------------
						| 9|10|11|12|
						-------------
						|13|14|15|16|
						-------------
				
		  - And so on...

		Parameters:
		
			$image			Image resource	E.g. imagecreatefromjpeg('image.jpg')
			$tree_name		String			Name of the tree. E.g. "tree_1"
			$zoom			Integer			Zoom. Min: 0, Max: ?
											There is no maximum but be aware that zoom 5 require
											an image with size = (2^5 * Cell X, 2^5 * Cell Y)
			$cell_x			Integer			Cell X
			$cell_y			Integer			Cell Y
			$debug = false	Boolean			Show log during execution
			
		Results:
		
			It will make a directory where the main program is executed. That directory contains
			the tree.
		
		Exceptions:
		
			Exception	When image's size is wrong
			Exception	When cell size is wrong
			Exception	When zoom is wrong
			Exception	When output directory cannot be made
	*/
	function generate_tree($image, $tree_name, $zoom, $cell_x, $cell_y, $debug = false) {
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
		
		// Getting optimal image size
		$image_max_x = pow(2, $zoom) * $cell_x;
		$image_max_y = pow(2, $zoom) * $cell_y;
		
		// Size of image
		$image_x = imagesx($image);
		$image_y = imagesy($image);
		
		if ($debug) {
			echo "Zoom = ".($zoom).PHP_EOL;
			echo "Cell size = (".$cell_x." x ".$cell_y.")".PHP_EOL;
		}
		
		// Check image size
		if ($image_x != $image_max_x or $image_y != $image_max_y) {
			throw new Exception("You must provide an image with size = (".$image_max_x." x ".$image_max_y.")".PHP_EOL);
		} else {
			if ($debug) {
				echo "Image size = (".$image_max_x." x ".$image_max_y.")".PHP_EOL;
			}
		}
		
		$dir = $tree_name . "/";
		
		if ($debug) {
			echo "Output directory: ".$dir.PHP_EOL;
		}
		
		// Directory do not exists
		if (!is_dir($dir)) {
			if (!mkdir($dir, 0777, true)) {
				throw new Exception('I could not make '.$dir.PHP_EOL);
			} else {
				echo "Creating directory".PHP_EOL;
			}
		// Directory exists
		} else {
			// Delete all content
			exec('rm -f '.$dir.'*');
			if ($debug) {
				echo "Deleting all content in directory".PHP_EOL;
			}
		}
		
		if ($debug) {
			echo "Starting loop to make tree".PHP_EOL;
		}
		
		// Loop from zoom to 0. (if zoom = 2 -> 2, 1, 0, end)
		for ($z = $zoom; $z >= 0; $z--) {
			$lines							= pow(2, $z);
			$x_to_take_from_original_image	= $image_x / $lines;
			$y_to_take_from_original_image	= $image_y / $lines;
			
			if ($debug) {
				echo "-----------------------------------".PHP_EOL;
				echo "Zoom: ".$z.PHP_EOL;
				echo "Nº lines: ".$lines.PHP_EOL;
				echo "X size to take from original image: ".$x_to_take_from_original_image.PHP_EOL;
				echo "Y size to take from original image: ".$y_to_take_from_original_image.PHP_EOL;
			}
			
			// Loop to iterate original image
			for ($i = 0; $i < $lines; $i++) {
				for ($j = 0; $j < $lines; $j++) {
					$new_image = imagecreatetruecolor($cell_x, $cell_y);
					imagecopyresampled($new_image, $image, 0, 0, $i * $x_to_take_from_original_image, $j * $y_to_take_from_original_image, $cell_x, $cell_y, $x_to_take_from_original_image, $y_to_take_from_original_image);
					$filename = "tile_".$z."_".$i."-".$j.".jpg";
					imagejpeg($new_image, $dir.$filename, 100);
					if ($debug) {
						echo "Creating file: ".$filename."\n";
					}
				}
			}
		}
	}
?>