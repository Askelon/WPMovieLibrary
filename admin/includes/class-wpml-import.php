<?php
/**
 * WPMovieLibrary Import Class extension.
 * 
 * Import Movies
 *
 * @package   WPMovieLibrary
 * @author    Charlie MERLAND <charlie.merland@gmail.com>
 * @license   GPL-3.0
 * @link      http://www.caercam.org/
 * @copyright 2014 CaerCam.org
 */

if ( ! class_exists( 'WPML_Import' ) ) :

	class WPML_Import extends WPML_Module {

		/**
		 * Constructor
		 *
		 * @since    1.0.0
		 */
		public function __construct() {
			$this->register_hook_callbacks();
		}

		/**
		 * Register callbacks for actions and filters
		 * 
		 * @since    1.0.0
		 */
		public function register_hook_callbacks() {

			add_action( 'admin_init', array( $this, 'init' ) );

			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

			add_action( 'load-movie_page_import', __CLASS__ . '::wpml_import_movie_list_add_options' );
			add_filter( 'set-screen-option', __CLASS__ . '::wpml_import_movie_list_set_option', 10, 3 );

			add_action( 'wp_ajax_wpml_delete_movie', __CLASS__ . '::wpml_delete_movie_callback' );
			add_action( 'wp_ajax_wpml_import_movies', __CLASS__ . '::wpml_import_movies_callback' );
			add_action( 'wp_ajax_wpml_fetch_imported_movies', __CLASS__ . '::wpml_fetch_imported_movies_callback' );
		}

		public function admin_enqueue_scripts( $hook ) {

			if ( 'movie_page_import' != $hook )
				return;

			wp_enqueue_script( WPML_SLUG . '-importer', WPML_URL . '/admin/assets/js/wpml.importer.js', array( WPML_SLUG . '-admin-script' ), WPML_VERSION, true );
		}

		public static function wpml_fetch_imported_movies_callback() {

			check_ajax_referer( 'wpml-fetch-imported-movies-nonce', 'wpml_fetch_imported_movies_nonce' );

			$wp_list_table = new WPML_Import_Table();
			$wp_list_table->ajax_response();
		}

		public static function wpml_import_movies_callback() {

			check_ajax_referer( 'wpml-movie-import', 'wpml_ajax_movie_import' );
			self::wpml_import_movies();
		}

		/**
		 * Display a custom WP_List_Table of imported movies
		 *
		 * @since     1.0.0
		 * 
		 * @param     array     $movies Array of imported movies
		 * @param     array     $meta Array of imported movies' metadata
		 */
		public static function wpml_display_import_movie_list() {

			$list = new WPML_Import_Table();
			$list->prepare_items();
	?>
				<form method="post">
					<input type="hidden" name="page" value="import" />

	<?php
			$list->search_box('search', 'search_id'); 
			$list->display();

	?>
				</form>
	<?php
		}

		/**
		 * Process the submitted movie list
		 *
		 * @since     1.0.0
		 * 
		 * @return     boolean     false on failure, true else
		 */
		public static function wpml_import_movies() {

			$errors = array();
			$_notice = '';

			$_ajax = ( defined( 'DOING_AJAX' ) && DOING_AJAX );

			if ( ! isset( $_POST['wpml_import_list'] ) || '' == $_POST['wpml_import_list'] )
				return false;

			if ( ! $_ajax )
				check_admin_referer( 'wpml-movie-import', 'wpml_movie_import' );

			$movies = explode( ',', esc_textarea( $_POST['wpml_import_list'] ) );
			$movies = array_map( __CLASS__ . '::wpml_prepare_movie_import', $movies );

			foreach ( $movies as $i => $movie ) {
				$import = self::wpml_import_movie( $movie['movietitle'] );
				if ( is_string( $import ) ) {
					$errors[] = $import;
				}
			}

			// @TODO: i18n plural
			if ( empty( $errors ) )
				$_notice = sprintf( __( '%d Movie%s added successfully.', 'wpml' ), count( $movies ), ( count( $movies ) > 1 ? 's' : '' ) );
			else if ( ! empty( $errors ) )
				$_notice = sprintf( '<strong>%s</strong> <ul>%s</ul>', __( 'The following error(s) occured:', 'wpml' ), implode( '', array_map( create_function( '&$e', 'return "<li>$e</li>";' ), $errors ) ) );

			if ( $_ajax )
				wp_die( $_notice );

			return true;
		}

		/**
		 * Save a temporary 'movie' post type for submitted title.
		 * 
		 * This is used to save movies submitted from a list before any
		 * alteration is made by user. Posts will be kept as 'import-draft'
		 * for 24 hours and then destroyed on the next plugin init.
		 *
		 * @since     1.0.0
		 * 
		 * @param     string     $title Movie title.
		 * 
		 * @return    int        Newly created post ID if everything worked, 0 if no post created.
		 */
		private static function wpml_import_movie( $title ) {

			$post_date     = current_time('mysql');
			$post_date     = wp_checkdate( substr( $post_date, 5, 2 ), substr( $post_date, 8, 2 ), substr( $post_date, 0, 4 ), $post_date );
			$post_date_gmt = get_gmt_from_date( $post_date );
			$post_author   = get_current_user_id();
			$post_content  = null;
			$post_title    = apply_filters( 'the_title', $title );

			$page = get_page_by_title( $post_title, OBJECT, 'movie' );

			if ( ! is_null( $page ) ) {

				return sprintf(
					'%s − <span class="edit"><a href="%s">%s</a> |</span> <span class="view"><a href="%s">%s</a></span>',
					sprintf( __( 'Movie "%s" already imported.', 'wpml' ), "<em>" . get_the_title( $page->ID ) . "</em>" ),
					get_edit_post_link( $page->ID ),
					__( 'Edit', 'wpml' ),
					get_permalink( $page->ID ),
					__( 'View', 'wpml' )
				);
			}
			else {
				$_ID = '';
			}

			$_post = array(
				'ID'             => $_ID,
				'comment_status' => 'closed',
				'ping_status'    => 'closed',
				'post_author'    => $post_author,
				'post_content'   => $post_content,
				'post_date'      => $post_date,
				'post_date_gmt'  => $post_date_gmt,
				'post_name'      => sanitize_title( $post_title ),
				'post_status'    => 'import-draft',
				'post_title'     => $post_title,
				'post_type'      => 'movie'
			);

			$id = wp_insert_post( $_post, true );

			if ( is_wp_error( $id ) )
				return $id->get_error_message();
			else
				return $id;
		}

		/**
		 * Delete movie
		 * 
		 * Remove imported movies draft and attachment from database
		 *
		 * @since     1.0.0
		 * 
		 * @return     boolean     deletion status
		 */
		public static function wpml_delete_movie_callback() {

			check_ajax_referer( 'wpml-callbacks-nonce', 'wpml_check' );

			$post_id = ( isset( $_GET['post_id'] ) && '' != $_GET['post_id'] ? $_GET['post_id'] : '' );

			echo self::wpml_delete_movie( $post_id );
			die();
		}

		/**
		 * Delete imported movie
		 * 
		 * Triggered by the 'Delete' link on imported movies WP_List_Table.
		 * Delete the specified movie from the list of movie set for further
		 * import. Automatically delete attached images such as featured image.
		 *
		 * @since     1.0.0
		 * 
		 * @param     int    $post_id    Movie's post ID.
		 * 
		 * @return    string    Error status if post/attachment delete failed
		 */
		private static function wpml_delete_movie( $post_id ) {

			if ( false === wp_delete_post( $post_id, true ) )
				return vsprintf( __( 'An error occured trying to delete Post #%s', 'wpml' ), $post_id );

			$thumb_id = get_post_thumbnail_id( $post_id );

			if ( '' != $thumb_id )
				if ( false === wp_delete_attachment( $thumb_id ) )
					return vsprintf( __( 'An error occured trying to delete Attachment #%s', 'wpml' ), $thumb_id );

			return true;
		}

		/**
		 * Set the default values for imported movies list
		 *
		 * @since     1.0.0
		 * 
		 * @param     string    $title    Movie title
		 * 
		 * @return    array    Default movie values
		 */
		public static function wpml_prepare_movie_import( $title ) {
			return array(
				'ID'         => 0,
				'poster'     => '--',
				'movietitle' => trim( $title ),
				'director'   => '--',
				'tmdb_id'    => '--'
			);
		}

		/**
		 * Get previously imported movies.
		 * 
		 * Fetch all posts with 'import-draft' status and 'movie' post type
		 *
		 * @since     1.0.0
		 * 
		 * @param     string    $title    Movie title
		 * 
		 * @return    array    Default movie values
		 */
		public static function wpml_get_imported_movies() {

			$columns = array();

			$args = array(
				'posts_per_page' => -1,
				'post_type'   => 'movie',
				'post_status' => 'import-draft'
			);

			query_posts( $args );

			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					if ( 'import-draft' == get_post_status() ) {
						$columns[ get_the_ID() ] = array(
							'ID'         => get_the_ID(),
							'poster'     => get_post_meta( get_the_ID(), '_wp_attached_file', true ),
							'movietitle' => get_the_title(),
							'director'   => get_post_meta( get_the_ID(), '_wpml_tmdb_director', true ),
							'tmdb_id'    => get_post_meta( get_the_ID(), '_wpml_tmdb_id', true )
						);
					}
				}
			}

			//array_unique( $columns );

			return $columns;
		}

		/**
		 * Add a Screen Option panel on Movie Import Page.
		 *
		 * @since     1.0.0
		 */
		public static function wpml_import_movie_list_add_options() {

			$option = 'per_page';
			$args = array(
				'label'   => __( 'Import Drafts', 'wpml' ),
				'default' => 30,
				'option'  => 'drafts_per_page'
			);

			add_screen_option( $option, $args );
		}

		/**
		 * Save newly set Movie Drafts number in Movie Import Page.
		 *
		 * @since     1.0.0
		 */
		public static function wpml_import_movie_list_set_option( $status, $option, $value ) {
			return $value;
		}

		/**
		 * Render movie import page
		 *
		 * @since    1.0.0
		 */
		public static function wpml_import_page() {

			$errors = array();
			$_notice = '';
			$_section = '';

			if ( isset( $_POST['wpml_save_imported'] ) && '' != $_POST['wpml_save_imported'] && isset( $_POST['tmdb'] ) && count( $_POST['tmdb'] ) ) {

				check_admin_referer('wpml-movie-save-import');

				foreach ( $_POST['tmdb'] as $tmdb_data ) {
					if ( 0 != $tmdb_data['tmdb_id'] ) {
						WPML_Edit_Movies::wpml_save_tmdb_data( $tmdb_data['post_id'], $tmdb_data );
					}
				}

				if ( empty( $errors ) )
					$_notice = sprintf( __( '%d Movies imported successfully!', 'wpml' ), count( $_POST['tmdb'] ) );
			}

			if ( isset( $_REQUEST['wpml_section'] ) && in_array( $_REQUEST['wpml_section'], array( 'tmdb', 'wpml', 'uninstall', 'restore' ) ) )
				$_section =  $_REQUEST['wpml_section'];

			include_once( WPML_PATH . '/admin/views/import.php' );
		}

		/**
		 * Prepares sites to use the plugin during single or network-wide activation
		 *
		 * @since    1.0.0
		 *
		 * @param bool $network_wide
		 */
		public function activate( $network_wide ) {}

		/**
		 * Rolls back activation procedures when de-activating the plugin
		 *
		 * @since    1.0.0
		 */
		public function deactivate() {}

		/**
		 * Initializes variables
		 *
		 * @since    1.0.0
		 */
		public function init() {}

	}

endif;