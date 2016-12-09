<?php
	include_once 'lib_php/generate_tree.php';
	include_once 'lib_php/generate_viewer.php';
	
	// Example
	$image = imagecreatefromjpeg('image_input/imagen.jpg');	// Image to use to generate the tree
	$tree_name = 'image_2';									// Name of tree and viewer
	$zoom = 5;												// Zoom establish total number of cells and image size
															//	if zoom = 2 then
															//		zoom 0 -> (Cell X * 2 ^ 0, Cell Y * 2 ^ 0) -> Image size = (CellX, CellY)
															//		zoom 1 -> (Cell X * 2 ^ 1, Cell Y * 2 ^ 1) -> Image size = (2CellX, 2CellY)
															//		zoom 2 -> (Cell X * 2 ^ 2, Cell Y * 2 ^ 2) -> Image size = (4CellX, 4CellY)
															//		and so on if zoom is > 2
	$cell_x = 256;											// Cell X (Cell X does not need to be = Cell Y, is just an example)
	$cell_y = 256;											// Cell Y
	
	try {
		generate_tree($image, $tree_name, $zoom, $cell_x, $cell_y, true);
		generate_viewer($tree_name, $zoom, $cell_x, $cell_y, true);
	} catch (Exception $e) {
		echo "Error: ".$e->getMessage().PHP_EOL;
	}
?>
