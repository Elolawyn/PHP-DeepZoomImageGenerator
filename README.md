# PHP-DeepZoomImageGenerator
A PHP Script to generate a Deep Zoom Image. It includes OpenSeaDragon as a viewer to load the image.

## It was tested with

1. PHP 7.0.8 (It should work as well with lowers versions)
2. Ubuntu 16.04.1 LTS
3. OpenSeadragon 2.2.1 (It is already included)

## Functionality

1. **Create a Deep Zoom Image tree:** it creates a tree of files containing diferents levels of zoom. This way you can use a viewer to see the whole picture loading smaller files depending on zoom level and position.
2. **Create a viewer:** it makes a viwer using OpenSeadragon so you can open the deep zoom image.

## How does it works?

Write this section

## Usage

Write this section

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
