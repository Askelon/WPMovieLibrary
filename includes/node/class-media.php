<?php
/**
 * Define the media class.
 *
 * @link       http://wpmovielibrary.com
 * @since      3.0
 *
 * @package    WPMovieLibrary
 * @subpackage WPMovieLibrary/includes/core
 */

namespace wpmoly\Node;

use wpmoly\Node\Image;
use wpmoly\Collection\Images;

/**
 * 
 *
 * @since      3.0
 * @package    WPMovieLibrary
 * @subpackage WPMovieLibrary/includes/core
 * @author     Charlie Merland <charlie@caercam.org>
 */
class Media extends Node {

	/**
	 * Movie Backdrops collection
	 * 
	 * @since    3.0
	 * 
	 * @var      Backdrops
	 */
	protected $backdrops;

	/**
	 * Movie Posters collection
	 * 
	 * @since    3.0
	 * 
	 * @var      Posters
	 */
	protected $posters;

	/**
	 * Initialize the Node.
	 * 
	 * Set collections and related Movie instance.
	 * 
	 * @since    3.0
	 * 
	 * @return   null
	 */
	public function make() {

		$this->backdrops = new Images;
		$this->backdrops->type = 'backdrops';

		$this->posters   = new Images;
		$this->posters->type = 'posters';
	}

	/**
	 * Simple accessor for Backdrops collection.
	 * 
	 * @since    3.0
	 * 
	 * @param    boolean    $load Try to load images if empty
	 * 
	 * @return   Posters
	 */
	public function get_backdrops( $load = false ) {

		if ( ! $this->backdrops->has_items() && true === $load ) {
			$this->load_backdrops();
		}

		return $this->backdrops;
	}

	/**
	 * Simple accessor for Posters collection.
	 * 
	 * @since    3.0
	 * 
	 * @param    boolean    $load Try to load images if empty
	 * 
	 * @return   Posters
	 */
	public function get_posters( $load = false ) {

		if ( ! $this->posters->has_items() && true === $load ) {
			$this->load_posters();
		}

		return $this->posters;
	}

	/**
	 * Load media: backdrops and posters for the current Movie.
	 * 
	 * @since    3.0
	 * 
	 * @param    string    $type Images type to load: 'backdrops', 'posters' or 'both'
	 * @param    string    $language Language to filter images
	 * @param    int       $number Number of images to fetch
	 * 
	 * @return   array
	 */
	public function load( $type = 'both', $language = '', $number = -1 ) {

		if ( 'both' == $type ) {
			$this->load_backdrops( $language, $number );
			$this->load_posters( $language, $number );
		} elseif ( 'backdrops' == $type ) {
			$this->load_backdrops( $language, $number );
		} elseif ( 'posters' == $type ) {
			$this->load_posters( $language, $number );
		}

		return array( 'backdrops' => $this->backdrops, 'posters' => $this->posters );
	}

	/**
	 * Load backdrops for the current Movie.
	 * 
	 * @since    3.0
	 * 
	 * @param    string    $language Language to filter images
	 * @param    int       $number Number of images to fetch
	 * 
	 * @return   Backdrops
	 */
	public function load_backdrops( $language = '', $number = -1 ) {

		global $wpdb;

		$attachments = get_posts( array(
			'post_type'   => 'attachment',
			'numberposts' => -1,
			'post_status' => null,
			'post_parent' => $this->id,
			'meta_key'    => '_wpmoly_image_related_tmdb_id'
		) );

		foreach ( $attachments as $i => $attachment ) {

			$meta = \wp_get_attachment_metadata( $attachment->ID, $unfiltered = true );
			$image = array(
				'id'          => $attachment->ID,
				'title'       => $attachment->post_title,
				'description' => $attachment->post_content,
				'excerpt'     => $attachment->post_excerpt,
				'image_alt'   => \get_post_meta( $attachment->ID, '_wp_attachment_image_alt', $single = true )
			);
			$image = new Backdrop( $image );
			$image->set_sizes( $meta );

			$image->edit_link   = get_edit_post_link( $attachment->ID );
			$image->delete_link = get_delete_post_link( $attachment->ID );

			$this->backdrops->add( $image );
		}

		return $this->backdrops;
	}

	/**
	 * Load posters for the current Movie.
	 * 
	 * @since    3.0
	 * 
	 * @param    string    $language Language to filter images
	 * @param    int       $number Number of images to fetch
	 * 
	 * @return   null
	 */
	public function load_posters( $language = '', $number = -1 ) {

		global $wpdb;

		$attachments = get_posts( array(
			'post_type'   => 'attachment',
			'numberposts' => -1,
			'post_status' => null,
			'post_parent' => $this->id,
			'meta_key'    => '_wpmoly_poster_related_tmdb_id'
		) );

		foreach ( $attachments as $i => $attachment ) {

			$meta = \wp_get_attachment_metadata( $attachment->ID, $unfiltered = true );
			$image = array(
				'id'          => $attachment->ID,
				'title'       => $attachment->post_title,
				'description' => $attachment->post_content,
				'excerpt'     => $attachment->post_excerpt,
				'image_alt'   => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', $single = true )
			);
			$image = new Poster( $image );
			$image->set_sizes( $meta );

			$image->edit_link   = get_edit_post_link( $attachment->ID );
			$image->delete_link = get_delete_post_link( $attachment->ID );

			$this->posters->add( $image );
		}

		return $this->posters;
	}

	/**
	 * Fetch backdrops from TMDb for the current Movie.
	 * 
	 * @since    3.0
	 * 
	 * @param    string    $language Language to filter images
	 * @param    int       $number Number of images to fetch
	 * 
	 * @return   null
	 */
	public function fetch_backdrops( $language = '', $number = -1 ) {

		$this->fetch( 'backdrops', $language, $number );
	}

	/**
	 * Fetch posters from TMDb for the current Movie.
	 * 
	 * @since    3.0
	 * @param    string    $language Language to filter images
	 * @param    int       $number Number of images to fetch
	 * 
	 * @return   null
	 */
	public function fetch_posters( $language = '', $number = -1 ) {

		$this->fetch( 'posters', $language, $number );
	}

	/**
	 * Fetch images from TMDb for the current Movie.
	 * 
	 * @since    3.0
	 * 
	 * @param    string    $type Type of media to fetch: 'backdrops' or 'posters'
	 * @param    string    $language Language to filter images
	 * @param    int       $number Number of images to fetch
	 * 
	 * @return   null
	 */
	protected function fetch( $type = 'backdrops', $language = '', $number = -1 ) {

		$tmdb_id = $this->movie->get( 'tmdb_id' );
	}

	/**
	 * Make the Node.
	 * 
	 * Nothing to do for details at this stage.
	 * 
	 * @since    3.0
	 * 
	 * @return   null
	 */
	public function init() {}
}