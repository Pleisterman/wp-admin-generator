<?php
/*
 *  @package        pleisterman/pleisterman-wp-admin-generator
 *
 *  file:           pleisterman-wp-admin-generator.php
 *  function:       main file for the plugin
 * 
 *  website:        https://www.pleisterman.nl/
 *  github:         https://github.com/Pleisterman
 *  description:    Unit test landing page
 *  version:        1.0.0
 *  Author:         Rob Wolters
 *  license:        GPLv2 or later
 *  text domain:    pleisterman-wp-admin-generator
 * 
 *  last-update     26-12-2017
 * 
 */


/*
Plugin Name: pleisterman-wp-admin-generator
Plugin URI: https://pleisterman.nl/
Description: Generator for admin menus and pages
Version: 1.0.0
Author: Rob Wolters
Author URI: https://pleisterman.nl
License: GPLv2 or later
Text Domain: pleisterman-wp-admin-generator
*/

/*
    Project description:
        This project is a plugin for Wordpress that generates admin menus and pages;
            the data for the menus and pages are defined in json files
            one main menu and multiple submenus can be defined
            multiple pages can be defined
            menus and pages can be linked
            pages can contain multiple tabs
            pages can contain multiple sections
            sections can contain multiple rows
            rows can contain multiple fields
        
    Project work:
        30-12-2017: created basic directory structure
                    created json for menus and pages
                    created getTranslations for menus and pages
                    
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2017-2020 Pleisterman.
*/

// Make sure we don't expose any info if called directly
if ( ! defined( 'WPINC' ) ) {
    // done with error
	exit;
}
// Make sure we don't expose any info if called directly

// autoloader exists
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
    // add autoloader
    require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}
// autoloader exists

use PleistermanWpAdminGenerator\Admin\Main;

// create main
$main = new Main( );
