# wp-admin-generator
Adminstratie pagina generator for wordpress

This plugin will generate admin pages from json.

This is a research project and not ready for use.

completed:

the plugin when installed will generate a menu adminGenerator.
the menu items contain some example pages generated from JSON.
The plugin standard functions that handle data display and saving
Functions can be customised in a separate section.
The plugin could be updated without touching the custom functions
some research is still needed. 

to do:

build: json editor
handle multi-site
handle front end
testink

currently the only solution to create a plugin with a different name is a bit complex:

find and replace:

pleisterman in js
pleisterman in php
pleisterman in json
pleisterman in css

admin-generator in js
admin-generator in php
admin-generator in json
admin-generator in css


PleistermanWpAdminGenerator in php
PleistermanWpAdminGenerator in json

rename main file pleisterman-wp-admin-generator

change json in menu 
change json in pages

remove vendor / composer

run composer dump

