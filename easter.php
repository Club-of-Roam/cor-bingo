<?php

/*
Plugin Name: Club of Roam | Easter-Hitch-Days | Bingo
Plugin URI: http://tramprennen.org
Description: Prints the PDF playing board
Version: 1.0
Author: Ole Roentgen, Johannes Pilkahn
Author URI: http://tramprennen.org
License: GPL3
*/

/*  Copyright 2014  	Ole Roentgen (email: ole@tramprennen.org)
						Johannes Pilkahn (email: pille@tramprennen.org)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 3, as
    published by the Free Software Foundation.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * Holds the absolute location of this plugin
 *
 * @since 1.0
 */
if ( ! defined( 'H3_EASTER_ABSPATH' ) )
	define( 'H3_EASTER_ABSPATH', dirname( __FILE__ ) );

/**
 * Holds the URL of this plugin
 *
 * @since 1.0
 */
if ( ! defined( 'H3_EASTER_RELPATH' ) )
	define( 'H3_EASTER_RELPATH', plugin_dir_url( __FILE__ ) );

/**
 * Holds the name of his plugin's directory
 *
 * @since 1.0
 */
if ( !defined( 'H3_EASTER_DIRNAME' ) )
	define( 'H3_EASTER_DIRNAME', basename( H3_EASTER_ABSPATH ) );

if ( ! class_exists( 'H3_EASTER' ) ) :

class H3_EASTER
{

	public function pdf_link( $atts )
	{
		extract(
			shortcode_atts(
				array(
					'title' => 'Download your individual playing field as a .pdf file.',
					'text' => 'Dowload playing field!',
					'lang' => 'en',
					'columns' => 7,
					'rows' => 7
				),
				$atts
			)
		);

		return '<a class="pdf_link button" title="' . $title . '" href="' . H3_EASTER_RELPATH . 'generate.php?lang=' . $lang . '&columns=' . $columns . '&rows=' . $rows . '">&rarr; ' . $text . '</a>';
	}

	public function __construct() {
		add_shortcode( 'pdf_link', array( $this, 'pdf_link' ) );
	}
}

$h3_easter = new H3_EASTER;

endif;

?>