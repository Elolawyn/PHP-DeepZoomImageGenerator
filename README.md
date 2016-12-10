# PHP-DeepZoomImageGenerator
A PHP Script to generate a Deep Zoom Image. It includes OpenSeaDragon as a viewer to load the image.

## It was tested with

1. PHP 7.0.8 (It should work as well with lowers versions)
2. Ubuntu 16.04.1 LTS
3. OpenSeadragon 2.2.1 (It is already included)

## Functionality

1. **Create a Deep Zoom Image tree:** it creates a tree of files containing diferents levels of zoom. This way you can use a viewer to see the whole picture loading smaller files depending on zoom level and position.
2. **Create a viewer:** it makes a viewer using OpenSeadragon in order to view the deep zoom image.

## Usage

1. Unzip the repository
2. Customize parameters in **generate_deep_image.php**
3. Execute:

```
php generate_deep_image.php
```

## Parameters

1. **image**: image to load by using the function **imagecreatefromjpeg**. The script will save the tree as jpeg. Be aware that original image size must be (X = Cell X * 2 ^ zoom, Y = Cell Y * 2 ^ zoom)
2. **tree_name**: the name of the resulting folder and viewer.
3. **zoom**: level of zoom.
4. **cell X**: cell X size.
5. **cell Y**: cell Y size.

## How does it works?

Given an image and the right parameters, the program will produce the following tree of images:

![Image Tree](https://github.com/Elolawyn/PHP-DeepZoomImageGenerator/blob/master/doc/tree.png)

1. **tree_name_folder/**
    1. **tile_0_0-0.jpg**
    2. **tile_1_0-0.jpg**
    3. **tile_1_0-1.jpg**
    4. **tile_1_1-0.jpg**
    5. **tile_1_1-1.jpg**
    6. **tile_ZOOM_X-Y.jpg**

The tree allows OpenSeadragon to serve smaller pieces of the image depending on the level of zoom and the position the user is looking at. The first level of zoom (0) is the original image reduced to cell size.

## Files

1. **lib_php/:** PHP functionality
    1. **generate_viewer.php:** function to make a new viewer by using OpenSeaDragon 2.2.1
    2. **generate_tree.php:** function to make the tree.
2. **css/:** bootstrap
3. **fonts/:** glyphicons
4. **images/:** openseadragon images
5. **js/:** jquery, bootstrap and openseadragon js
6. **generate_deep_image.php:** main program. **Customize parameters here.**

## More information

1. [OpenSeadragon](https://openseadragon.github.io/)
