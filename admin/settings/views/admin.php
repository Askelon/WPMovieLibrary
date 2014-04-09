<style type="text/css">th>label{font-size:0.9em;}</style>

<div id="wpml-settings" class="wrap">
	<h2><?php _e( 'Plugin Options', 'wpml' ); ?></h2>

	<?php if ( ! WPML_Settings::wpml_get_api_key() ) WPML_Utils::admin_notice( sprintf( __( 'Congratulation, you successfully installed WPMovieLibrary. You need a valid <acronym title="TheMovieDB">TMDb</acronym> API key to start adding your movies. Go to the <a href="%s">WPMovieLibrary Settings page</a> to add your API key.', 'wpml' ), admin_url( 'edit.php?post_type=movie&page=settings' ) ), 'wpml' ); ?>

	<?php WPML_Utils::admin_notice( $_notice ); ?>

	<div id="wpml-tabs">

		<form method="post">

			<?php wp_nonce_field('wpml-admin' ); ?>

			<ul class="wpml-tabs-nav">
			    <li class="wpml-tabs-nav<?php if ( 'tmdb' == $_section || '' == $_section ) echo ' active'; ?>"><a href="#tmdb_settings" data-section="&amp;wpml_section=tmdb"><h4><?php _e( 'TMDb API', 'wpml' ); ?></h4></a></li>
			    <li class="wpml-tabs-nav<?php if ( 'wpml' == $_section ) echo ' active'; ?>"><a href="#wpml_settings" data-section="&amp;wpml_section=wpml"><h4><?php _e( 'WPMovieLibrary', 'wpml' ); ?></h4></a></li>
			    <li class="wpml-tabs-nav<?php if ( 'uninstall' == $_section ) echo ' active'; ?>"><a href="#uninstall_settings" data-section="&amp;wpml_section=uninstall"><h4><?php _e( 'Deactivate/Uninstall', 'wpml' ); ?></h4></a></li>
			    <li class="wpml-tabs-nav<?php if ( 'restore' == $_section ) echo ' active'; ?>"><a href="#restore_settings" data-section="&amp;wpml_section=restore"><h4><?php _e( 'Restore', 'wpml' ); ?></h4></a></li>
			</ul>

			<div id="tmdb_settings" class="wpml-tabs-panel hide-if-js<?php if ( 'tmdb' == $_section || '' == $_section ) echo ' active'; ?>">

				<!-- WPML Poster Settings -->
				<h3><?php _e( 'TheMovieDB API Settings', 'wpml' ); ?></h3>
				<table class="form-table wpml-settings">
					<tbody>
						<tr valign="top">
							<th scope="row">
								<label for="APIKey"><?php _e( 'API Key', 'wpml' ); ?></label>
							</th>
							<td>
								<input id="APIKey" type="text" name="tmdb_data[tmdb][APIKey]" value="<?php echo ( WPML_Settings::wpml_get_api_key() ? WPML_Settings::wpml_get_api_key() : '' ); ?>" size="40" maxlength="32" />
								<input id="APIKey_check" type="button" name="APIKey_check" class="button button-secondary" value="<?php _e( 'Check API Key', 'wpml' ); ?>" />
								<p class="description"><?php _e( 'You need a valid TMDb API key in order to fetch informations on the movies you add to WPMovieLibrary. You can get an individual API key by registering on <a href="https://www.themoviedb.org/">TheMovieDB</a>. If you don&rsquo;t want to get your own API Key, WPMovieLibrary will use a dummy, more restricted API. <a href="http://tmdb.caercam.org/">Learn more about the dummy API</a>.', 'wpml' ); ?></p>
								<label><input type="radio" name="tmdb_data[tmdb][dummy]" value="1"<?php checked( WPML_Settings::wpml_o( 'tmdb-settings-dummy' ), 1 ); ?>/> <?php _e( 'Use dummy API', 'wpml' ); ?></label>
								<label><input type="radio" name="tmdb_data[tmdb][dummy]" value="0"<?php checked( WPML_Settings::wpml_o( 'tmdb-settings-dummy' ), 0 ); ?>/> <?php _e( 'Don&rsquo;t', 'wpml' ); ?></label>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label for="lang"><?php _e( 'API Language', 'wpml' ); ?></label>
							</th>
							<td>
								<select id="lang" name="tmdb_data[tmdb][lang]">
									<option value="en"<?php selected( WPML_Settings::wpml_o( 'tmdb-settings-lang' ), 'en' ); ?>><?php _e( 'English', 'wpml' ); ?></option>
									<option value="fr"<?php selected( WPML_Settings::wpml_o( 'tmdb-settings-lang' ), 'fr' ); ?>><?php _e( 'French', 'wpml' ); ?></option>
								</select>
								<p class="description"><?php _e( 'Default language to use when fetching informations from TMDb. Default is english. You can always change this manually when add a new movie.', 'wpml' ); ?></p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label for="scheme"><?php _e( 'API Scheme', 'wpml' ); ?></label>
							</th>
							<td>
								<select id="scheme" name="tmdb_data[tmdb][scheme]">
									<option value="http"<?php selected( WPML_Settings::wpml_o( 'tmdb-settings-scheme' ), 'http' ); ?>><?php _e( 'HTTP', 'wpml' ); ?></option>
									<option value="https"<?php selected( WPML_Settings::wpml_o( 'tmdb-settings-scheme' ), 'https' ); ?>><?php _e( 'HTTPS', 'wpml' ); ?></option>
								</select>
								<p class="description"><?php _e( 'Default scheme used to contact TMDb API. Default is HTTPS.', 'wpml' ); ?></p>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div id="wpml_settings" class="wpml-tabs-panel hide-if-js<?php if ( 'wpml' == $_section ) echo ' active'; ?>">

				<!-- WPML Poster Settings -->
				<h3><?php _e( 'Poster Settings', 'wpml' ); ?></h3>
				<table class="form-table wpml-settings">
					<tbody>
						<tr valign="top">
							<th scope="row">
								<label for="poster_size"><?php _e( 'Posters Default Size', 'wpml' ); ?></label>
							</th>
							<td>
								<select id="poster_size" name="tmdb_data[tmdb][poster_size]">
									<option value="small"<?php selected( WPML_Settings::wpml_o( 'tmdb-settings-poster_size' ), 'small' ); ?>><?php _e( 'Small', 'wpml' ); ?></option>
									<option value="medium"<?php selected( WPML_Settings::wpml_o( 'tmdb-settings-poster_size' ), 'medium' ); ?>><?php _e( 'Medium', 'wpml' ); ?></option>
									<option value="full"<?php selected( WPML_Settings::wpml_o( 'tmdb-settings-poster_size' ), 'full' ); ?>><?php _e( 'Full', 'wpml' ); ?></option>
									<option value="original"<?php selected( WPML_Settings::wpml_o( 'tmdb-settings-poster_size' ), 'original' ); ?>><?php _e( 'Original', 'wpml' ); ?></option>
								</select>
								<p class="description"><?php _e( 'Movie Poster size. Default is TMDb&rsquo;s original size.', 'wpml' ); ?></p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label><?php _e( 'Add Posters As Thumbnails', 'wpml' ); ?></label>
							</th>
							<td>
								<label><input type="radio" name="tmdb_data[tmdb][poster_featured]" value="1"<?php checked( WPML_Settings::wpml_o( 'tmdb-settings-poster_featured' ), 1 ); ?>/> <?php _e( 'Use Posters as Movies Thumbnails', 'wpml' ); ?></label>
								<label><input type="radio" name="tmdb_data[tmdb][poster_featured]" value="0"<?php checked( WPML_Settings::wpml_o( 'tmdb-settings-poster_featured' ), 0 ); ?>/> <?php _e( 'Don&rsquo;t', 'wpml' ); ?></label>
								<p class="description"><?php _e( 'Using posters as movies thumbnails will automatically import new movies&rsquo; poster and set them as post featured image. This setting doesn’t affect movie import by list where posters are automatically saved and set as featured image.', 'wpml' ); ?></p>
							</td>
						</tr>
					</tbody>
				</table>

				<!-- WPML Images Settings -->
				<h3><?php _e( 'Images Settings', 'wpml' ); ?></h3>
				<table class="form-table wpml-settings">
					<tbody>
						<tr valign="top">
							<th scope="row">
								<label for="images_size"><?php _e( 'Images Default Size', 'wpml' ); ?></label>
							</th>
							<td>
								<select id="images_size" name="tmdb_data[tmdb][images_size]">
									<option value="small"<?php selected( WPML_Settings::wpml_o( 'tmdb-settings-images_size' ), 'small' ); ?>><?php _e( 'Small', 'wpml' ); ?></option>
									<option value="medium"<?php selected( WPML_Settings::wpml_o( 'tmdb-settings-images_size' ), 'medium' ); ?>><?php _e( 'Medium', 'wpml' ); ?></option>
									<option value="full"<?php selected( WPML_Settings::wpml_o( 'tmdb-settings-images_size' ), 'full' ); ?>><?php _e( 'Full', 'wpml' ); ?></option>
									<option value="original"<?php selected( WPML_Settings::wpml_o( 'tmdb-settings-images_size' ), 'original' ); ?>><?php _e( 'Original', 'wpml' ); ?></option>
								</select>
								<p class="description"><?php _e( 'Movie Poster size. Default is TMDb&rsquo;s original size.', 'wpml' ); ?></p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label for="images_max"><?php _e( 'Maximum Images To Fetch', 'wpml' ); ?></label>
							</th>
							<td>
								<input id="images_max" type="text" name="tmdb_data[tmdb][images_max]" value="<?php echo WPML_Settings::wpml_o( 'tmdb-settings-images_max' ); ?>" size="4" maxlength="2" />
								<p class="description"><?php _e( 'Maximum amount of images to fetch. Especially useful if you activated automatic images import. Default is12, set at 0 to fetch all images.', 'wpml' ); ?></p>
							</td>
						</tr>
					</tbody>
				</table>

				<!-- WPML Posts Settings -->
				<h3><?php _e( 'Posts Settings', 'wpml' ); ?></h3>
				<table class="form-table wpml-settings">
					<tbody>
						<tr valign="top">
							<th scope="row">
								<label><?php _e( 'Show Movies in Home Page', 'wpml' ); ?></label>
							</th>
							<td>
								<label><input type="radio" name="tmdb_data[wpml][show_in_home]" value="1"<?php checked( WPML_Settings::wpml_o( 'wpml-settings-show_in_home' ), 1 ); ?>/> <?php _e( 'Show Movies', 'wpml' ); ?></label>
								<label><input type="radio" name="tmdb_data[wpml][show_in_home]" value="0"<?php checked( WPML_Settings::wpml_o( 'wpml-settings-show_in_home' ), 0 ); ?>/> <?php _e( 'Don&rsquo;t', 'wpml' ); ?></label>
								<p class="description"><?php _e( 'If enable, movies will appear among other Posts in the Home Page.', 'wpml' ); ?></p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label for="meta_in_posts"><?php _e( 'Show basic movie metadata', 'wpml' ); ?></label>
							</th>
							<td>
								<select id="meta_in_posts" name="tmdb_data[wpml][meta_in_posts]">
									<option value="everywhere"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-meta_in_posts' ), 'everywhere' ); ?>><?php _e( 'Everywhere', 'wpml' ); ?></option>
									<option value="posts_only"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-meta_in_posts' ), 'posts_only' ); ?>><?php _e( 'Only In Post Read', 'wpml' ); ?></option>
									<option value="nowhere"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-meta_in_posts' ), 'nowhere' ); ?>><?php _e( 'Don&rsquo;t Show', 'wpml' ); ?></option>
								</select>
								<p class="description"><?php _e( 'Add metadata to posts&rsquo; content: director, genres, runtime…', 'wpml' ); ?></p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label for="default_movie_meta"><?php _e( 'Movie metadata', 'wpml' ); ?></label>
							</th>
							<td>
<?php
//TODO transfer this in model. Use hooks?
$movie_meta = WPML_Settings::wpml_get_supported_movie_meta();
$selected = WPML_Settings::wpml_o( 'wpml-settings-default_movie_meta' );
$selectable = array_diff( array_keys( $movie_meta ), $selected );

$draggable = '';
$droppable = '';
$options = '';

foreach ( $selected as $meta ) :
	if ( isset( $movie_meta[ $meta ] ) )
		$draggable .= '<li data-movie-meta="' . $meta . '" class="default_movie_meta_selected">' . __( $movie_meta[ $meta ]['title'], 'wpml' ) . '</li>';
endforeach;
foreach ( $selectable as $meta ) :
	$droppable .= '<li data-movie-meta="' . $meta . '" class="default_movie_meta_droppable">' . __( $movie_meta[ $meta ]['title'], 'wpml' ) . '</li>';
endforeach;
?>
								<div class="default_movie_meta_sortable hide-if-no-js">
									<ul id="draggable" class="droptrue"><?php echo $draggable ?></ul>
									<ul id="droppable" class="dropfalse"><?php echo $droppable ?></ul>
									<input type="hidden" id="default_movie_meta_sorted" name="tmdb_data[wpml][default_movie_meta_sorted]" value="" />
								</div>
<?php
foreach ( $movie_meta as $slug => $meta ) :
	$check = in_array( $slug, WPML_Settings::wpml_o( 'wpml-settings-default_movie_meta' ) ) || in_array( $slug, WPML_Settings::wpml_o( 'wpml-settings-default_movie_meta' ) );
	$options .= '<option value="' . $slug . '"' . selected( $check, true, false ) . '>' . __( $meta['title'], 'wpml' ) . '</option>';
endforeach;
?>
								<select id="default_movie_meta" name="tmdb_data[wpml][default_movie_meta][]" class="hide-if-js" style="min-height:<?php echo count( $movie_meta ) ?>em;min-width:16em;" multiple>
									<?php echo $options ?>
								</select>
								<p class="description">
									<?php _e( 'Which metadata to display in posts: director, genres, runtime, rating…', 'wpml' ); ?>
									<span class="hide-if-js"><?php _e( 'Javascript seems to be deactivated; please active it to customize your Movie metadata order.', 'wpml' ); ?></span>
								</p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label for="details_as_icons"><?php _e( 'Show details as icons', 'wpml' ); ?></label>
							</th>
							<td>
								<label><input type="radio" name="tmdb_data[wpml][details_as_icons]" value="1"<?php checked( WPML_Settings::wpml_o( 'wpml-settings-details_as_icons' ), 1 ); ?>/> <?php _e( 'Use icons', 'wpml' ); ?></label>
								<label><input type="radio" name="tmdb_data[wpml][details_as_icons]" value="0"<?php checked( WPML_Settings::wpml_o( 'wpml-settings-details_as_icons' ), 0 ); ?>/> <?php _e( 'Use default labels', 'wpml' ); ?></label>
								<p class="description"><?php _e( 'If enable, movie details will appear in the form of icons rather than default colored labels.', 'wpml' ); ?></p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label for="details_in_posts"><?php _e( 'Show movie details', 'wpml' ); ?></label>
							</th>
							<td>
								<select id="details_in_posts" name="tmdb_data[wpml][details_in_posts]">
									<option value="everywhere"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-details_in_posts' ), 'everywhere' ); ?>><?php _e( 'Everywhere', 'wpml' ); ?></option>
									<option value="posts_only"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-details_in_posts' ), 'posts_only' ); ?>><?php _e( 'Only In Post Read', 'wpml' ); ?></option>
									<option value="nowhere"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-details_in_posts' ), 'nowhere' ); ?>><?php _e( 'Don&rsquo;t Show', 'wpml' ); ?></option>
								</select>
								<p class="description"><?php _e( 'Add details to posts&rsquo; content: movie status, media…', 'wpml' ); ?></p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label for="default_movie_details"><?php _e( 'Movie details', 'wpml' ); ?></label>
							</th>
							<td>
								<select id="default_movie_details" name="tmdb_data[wpml][default_movie_details][]" multiple>
<?php
foreach ( WPML_Settings::wpml_get_supported_movie_details() as $slug => $detail ) :
	$check = in_array( $slug, WPML_Settings::wpml_o( 'wpml-settings-default_movie_details' ) ) || in_array( $detail['title'], WPML_Settings::wpml_o( 'wpml-settings-default_movie_details' ) );
?>
									<option value="<?php echo $slug; ?>"<?php selected( $check, true ); ?>><?php _e( $detail['title'], 'wpml' ); ?></option>
<?php endforeach; ?>
								</select>
								<p class="description"><?php _e( 'Which detail to display in posts: movie status, media…', 'wpml' ); ?></p>
							</td>
						</tr>
					</tbody>
				</table>

				<!-- WPML Taxonomy Settings -->
				<h3><?php _e( 'Taxonomy Settings', 'wpml' ); ?></h3>
				<table class="form-table wpml-settings">
					<tbody>
						<tr valign="top">
							<th scope="row">
								<label><?php _e( 'Enable Custom Taxonomies', 'wpml' ); ?></label>
							</th>
							<td>
								<label><input type="radio" name="tmdb_data[wpml][enable_collection]" value="1"<?php checked( WPML_Settings::wpml_o( 'wpml-settings-enable_collection' ), 1 ); ?>/> <?php _e( 'Enable Collections', 'wpml' ); ?></label>
								<label><input type="radio" name="tmdb_data[wpml][enable_collection]" value="0"<?php checked( WPML_Settings::wpml_o( 'wpml-settings-enable_collection' ), 0 ); ?>/> <?php _e( 'Don&rsquo;t', 'wpml' ); ?></label>
								<br />

								<label><input type="radio" name="tmdb_data[wpml][enable_genre]" value="1"<?php checked( WPML_Settings::wpml_o( 'wpml-settings-enable_genre' ), 1 ); ?>/> <?php _e( 'Enable Genres', 'wpml' ); ?></label>
								<label><input type="radio" name="tmdb_data[wpml][enable_genre]" value="0"<?php checked( WPML_Settings::wpml_o( 'wpml-settings-enable_genre' ), 0 ); ?>/> <?php _e( 'Don&rsquo;t', 'wpml' ); ?></label>
								<br />

								<label><input type="radio" name="tmdb_data[wpml][enable_actor]" value="1"<?php checked( WPML_Settings::wpml_o( 'wpml-settings-enable_actor' ), 1 ); ?>/> <?php _e( 'Enable Actors', 'wpml' ); ?></label>
								<label><input type="radio" name="tmdb_data[wpml][enable_actor]" value="0"<?php checked( WPML_Settings::wpml_o( 'wpml-settings-enable_actor' ), 0 ); ?>/> <?php _e( 'Don&rsquo;t', 'wpml' ); ?></label>

								<p class="description"><?php _e( 'Enable Custom Taxonomies to group movies. If enabled, three new Taxonomie will be active to help sort your movies: Collections, Actors and Genres. To learn more about WPML Taxonomies please refer to the documentation.', 'wpml' ); ?></p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label><?php _e( 'Automatic Taxonomy', 'wpml' ); ?></label>
							</th>
							<td>
								<label><input type="radio" name="tmdb_data[wpml][taxonomy_autocomplete]" value="1"<?php checked( WPML_Settings::wpml_o( 'wpml-settings-taxonomy_autocomplete' ), 1 ); ?>/> <?php _e( 'Add Taxonomy on import', 'wpml' ); ?></label>
								<label><input type="radio" name="tmdb_data[wpml][taxonomy_autocomplete]" value="0"<?php checked( WPML_Settings::wpml_o( 'wpml-settings-taxonomy_autocomplete' ), 0 ); ?>/> <?php _e( 'Don&rsquo;t', 'wpml' ); ?></label>
								<p class="description"><?php _e( 'Automatically add custom taxonomies when adding/importing movies. If enabled, each added/imported movie will be automatically added to the collection corresponding to the director. Actors and Genres tags will be filled automatically as well. Unexisting Taxonomies will be created. Ex: adding the movie <em>Fight Club</em> will add the movie to a "David Fincher" collection and the movie will be tagged with tags like "Edward Norton", "Brad Pitt", "Drama"...', 'wpml' ); ?></p>
							</td>
						</tr>
					</tbody>
				</table>

				<!-- WPML Cache Settings -->
				<h3><?php _e( 'Cache Settings', 'wpml' ); ?></h3>
				<table class="form-table wpml-settings">
					<tbody>
						<tr valign="top">
							<th scope="row">
								<label><?php _e( 'Enable Caching', 'wpml' ); ?></label>
							</th>
							<td>
								<label><input type="radio" name="tmdb_data[tmdb][caching]" value="1"<?php checked( WPML_Settings::wpml_o( 'tmdb-settings-caching' ), 1 ); ?>/> <?php _e( 'Enable caching', 'wpml' ); ?></label>
								<label><input type="radio" name="tmdb_data[tmdb][caching]" value="0"<?php checked( WPML_Settings::wpml_o( 'tmdb-settings-caching' ), 0 ); ?>/> <?php _e( 'Don&rsquo;t', 'wpml' ); ?></label>
								<p class="description"><?php _e( 'When enabled, WPML will store for a variable time the data fetched from TMDb. This prevents WPML from generating excessive, useless duplicate queries to the API. This is especially useful if you’re using the dummy API. <a href="http://www.caercam.org/wpmovielibrary/">Learn more about WPML Caching</a>', 'wpml' ); ?></p>
								<br />
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label><?php _e( 'Caching Time', 'wpml' ); ?></label>
							</th>
							<td>
								<input type="text" name="tmdb_data[tmdb][caching_time]" value="<?php echo WPML_Settings::wpml_o( 'tmdb-settings-caching_time' ); ?>" size="4" maxlength="2" />
								<p class="description"><?php _e( 'Time of validity for Cached data, in days.', 'wpml' ); ?></p>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div id="uninstall_settings" class="wpml-tabs-panel hide-if-js<?php if ( 'uninstall' == $_section ) echo ' active'; ?>">

				<!-- WPML Deactivation -->
				<h3><?php _e( 'Deactivation Options', 'wpml' ); ?></h3>
				<p class="description"><?php _e( 'When deactivated or uninstalled, WPML can adopt specific behaviors to handle the contents created by its use: cached data, movies, images, collections… Default behavior is to conserve everything as it is when WPML is simply deactivated, and to convert contents to standard WordPress contents when uninstalled. Learn more on the deactive/uninstall options on <a href="http://www.caercam.org/wpmovielibrary/documentation.html#deactivate-uninstall">WPML Docs</a>, especially about content restoration after uninstallation.', 'wpml' ); ?></p>
				<table class="form-table wpml-settings">
					<tbody>
						<tr valign="top">
							<th scope="row">
								<label for=""><?php _e( 'Movie Post Type', 'wpml' ); ?></label>
							</th>
							<td>
								<select id="deactivate_movies" name="tmdb_data[wpml][deactivate][movies]">
									<option value="conserve"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-deactivate-movies' ), 'conserve' ); ?>><?php _e( 'Conserve (recommended)', 'wpml' ); ?></option>
									<option value="convert"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-deactivate-movies' ), 'convert' ); ?>><?php _e( 'Convert to Posts', 'wpml' ); ?></option>
									<option value="remove"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-deactivate-movies' ), 'remove' ); ?>><?php _e( 'Delete (irreversible)', 'wpml' ); ?></option>
									<option value="delete"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-deactivate-movies' ), 'delete' ); ?>><?php _e( 'Delete Completely (irreversible)', 'wpml' ); ?></option>
								</select>
								<p class="description"><?php _e( 'How to handle Movies when WPML is deactivated.', 'wpml' ); ?></p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label><?php _e( 'Collections Taxonomy', 'wpml' ); ?></label>
							</th>
							<td>
								<select id="deactivate_collections" name="tmdb_data[wpml][deactivate][collections]">
									<option value="conserve"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-deactivate-collections' ), 'conserve' ); ?>><?php _e( 'Conserve (recommended)', 'wpml' ); ?></option>
									<option value="convert"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-deactivate-collections' ), 'convert' ); ?>><?php _e( 'Convert to Category', 'wpml' ); ?></option>
									<option value="remove"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-deactivate-collections' ), 'remove' ); ?>><?php _e( 'Delete (irreversible)', 'wpml' ); ?></option>
									<option value="delete"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-deactivate-collections' ), 'delete' ); ?>><?php _e( 'Delete Completely (irreversible)', 'wpml' ); ?></option>
								</select>
								<p class="description"><?php _e( 'How to handle Collections Taxonomy when WPML is deactivated.', 'wpml' ); ?></p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label><?php _e( 'Genres Taxonomy', 'wpml' ); ?></label>
							</th>
							<td>
								<select id="deactivate_genres" name="tmdb_data[wpml][deactivate][genres]">
									<option value="conserve"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-deactivate-genres' ), 'conserve' ); ?>><?php _e( 'Conserve (recommended)', 'wpml' ); ?></option>
									<option value="convert"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-deactivate-genres' ), 'convert' ); ?>><?php _e( 'Convert to Tags', 'wpml' ); ?></option>
									<option value="remove"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-deactivate-genres' ), 'remove' ); ?>><?php _e( 'Delete (irreversible)', 'wpml' ); ?></option>
									<option value="delete"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-deactivate-genres' ), 'delete' ); ?>><?php _e( 'Delete Completely (irreversible)', 'wpml' ); ?></option>
								</select>
								<p class="description"><?php _e( 'How to handle Genres Taxonomy when WPML is deactivated.', 'wpml' ); ?></p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label><?php _e( 'Actors Taxonomy', 'wpml' ); ?></label>
							</th>
							<td>
								<select id="deactivate_actors" name="tmdb_data[wpml][deactivate][actors]">
									<option value="conserve"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-deactivate-actors' ), 'conserve' ); ?>><?php _e( 'Conserve (recommended)', 'wpml' ); ?></option>
									<option value="convert"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-deactivate-actors' ), 'convert' ); ?>><?php _e( 'Convert to Tags', 'wpml' ); ?></option>
									<option value="remove"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-deactivate-actors' ), 'remove' ); ?>><?php _e( 'Delete (irreversible)', 'wpml' ); ?></option>
									<option value="delete"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-deactivate-actors' ), 'delete' ); ?>><?php _e( 'Delete Completely (irreversible)', 'wpml' ); ?></option>
								</select>
								<p class="description"><?php _e( 'How to handle Actors Taxonomy when WPML is deactivated.', 'wpml' ); ?></p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label><?php _e( 'Cache', 'wpml' ); ?></label>
							</th>
							<td>
								<select id="deactivate_cache" name="tmdb_data[wpml][deactivate][cache]">
									<option value="conserve"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-deactivate-cache' ), 'conserve' ); ?>><?php _e( 'Conserve', 'wpml' ); ?></option>
									<option value="empty"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-deactivate-cache' ), 'empty' ); ?>><?php _e( 'Empty (recommended)', 'wpml' ); ?></option>
								</select>
								<p class="description"><?php _e( 'How to handle Cached data when WPML is deactivated.', 'wpml' ); ?></p>
							</td>
						</tr>
					</tbody>
				</table>

				<!-- WPML Uninstall -->
				<h3><?php _e( 'Uninstall Options', 'wpml' ); ?></h3>
				<table class="form-table wpml-settings">
					<tbody>
						<tr valign="top">
							<th scope="row">
								<label for=""><?php _e( 'Movie Post Type', 'wpml' ); ?></label>
							</th>
							<td>
								<select id="uninstall_movies" name="tmdb_data[wpml][uninstall][movies]">
									<option value="conserve"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-uninstall-movies' ), 'conserve' ); ?>><?php _e( 'Conserve', 'wpml' ); ?></option>
									<option value="convert"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-uninstall-movies' ), 'convert' ); ?>><?php _e( 'Convert to Posts (recommended)', 'wpml' ); ?></option>
									<option value="remove"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-uninstall-actors' ), 'remove' ); ?>><?php _e( 'Delete (irreversible)', 'wpml' ); ?></option>
									<option value="delete"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-uninstall-actors' ), 'delete' ); ?>><?php _e( 'Delete Completely (irreversible)', 'wpml' ); ?></option>
								</select>
								<p class="description"><?php _e( 'How to handle Movies when WPML is uninstalled.', 'wpml' ); ?></p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label><?php _e( 'Collections Taxonomy', 'wpml' ); ?></label>
							</th>
							<td>
								<select id="uninstall_collections" name="tmdb_data[wpml][uninstall][collections]">
									<option value="conserve"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-uninstall-collections' ), 'conserve' ); ?>><?php _e( 'Conserve', 'wpml' ); ?></option>
									<option value="convert"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-uninstall-collections' ), 'convert' ); ?>><?php _e( 'Convert to Category (recommended)', 'wpml' ); ?></option>
									<option value="remove"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-uninstall-actors' ), 'remove' ); ?>><?php _e( 'Delete (irreversible)', 'wpml' ); ?></option>
									<option value="delete"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-uninstall-actors' ), 'delete' ); ?>><?php _e( 'Delete Completely (irreversible)', 'wpml' ); ?></option>
								</select>
								<p class="description"><?php _e( 'How to handle Collections Taxonomy when WPML is uninstalled.', 'wpml' ); ?></p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label><?php _e( 'Genres Taxonomy', 'wpml' ); ?></label>
							</th>
							<td>
								<select id="uninstall_genres" name="tmdb_data[wpml][uninstall][genres]">
									<option value="conserve"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-uninstall-genres' ), 'conserve' ); ?>><?php _e( 'Conserve', 'wpml' ); ?></option>
									<option value="convert"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-uninstall-genres' ), 'convert' ); ?>><?php _e( 'Convert to Tags (recommended)', 'wpml' ); ?></option>
									<option value="remove"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-uninstall-actors' ), 'remove' ); ?>><?php _e( 'Delete (irreversible)', 'wpml' ); ?></option>
									<option value="delete"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-uninstall-actors' ), 'delete' ); ?>><?php _e( 'Delete Completely (irreversible)', 'wpml' ); ?></option>
								</select>
								<p class="description"><?php _e( 'How to handle Genres Taxonomy when WPML is uninstalled.', 'wpml' ); ?></p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label><?php _e( 'Actors Taxonomy', 'wpml' ); ?></label>
							</th>
							<td>
								<select id="uninstall_actors" name="tmdb_data[wpml][uninstall][actors]">
									<option value="conserve"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-uninstall-actors' ), 'conserve' ); ?>><?php _e( 'Conserve', 'wpml' ); ?></option>
									<option value="convert"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-uninstall-actors' ), 'convert' ); ?>><?php _e( 'Convert to Tags (recommended)', 'wpml' ); ?></option>
									<option value="remove"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-uninstall-actors' ), 'remove' ); ?>><?php _e( 'Delete (irreversible)', 'wpml' ); ?></option>
									<option value="delete"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-uninstall-actors' ), 'delete' ); ?>><?php _e( 'Delete Completely (irreversible)', 'wpml' ); ?></option>
								</select>
								<p class="description"><?php _e( 'How to handle Actors Taxonomy when WPML is uninstalled.', 'wpml' ); ?></p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label><?php _e( 'Cache', 'wpml' ); ?></label>
							</th>
							<td>
								<select id="uninstall_cache" name="tmdb_data[wpml][uninstall][cache]">
									<option value="conserve"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-uninstall-cache' ), 'conserve' ); ?>><?php _e( 'Conserve', 'wpml' ); ?></option>
									<option value="empty"<?php selected( WPML_Settings::wpml_o( 'wpml-settings-uninstall-cache' ), 'empty' ); ?>><?php _e( 'Empty (recommended)', 'wpml' ); ?></option>
								</select>
								<p class="description"><?php _e( 'How to handle Cached data when WPML is uninstalled.', 'wpml' ); ?></p>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div id="restore_settings" class="wpml-tabs-panel hide-if-js<?php if ( 'restore' == $_section ) echo ' active'; ?>">

				<h3><?php _e( 'Restore Default Settings', 'wpml' ); ?></h3>
				<p class="update-nag">
					<span class="ui-icon ui-icon-alert"></span>
					<?php _e( 'You may want to restore WPMovieLibrary default settings.', 'wpml' ); ?>
					<?php _e( '<strong>Caution!</strong> Doing this you will erase permanently all your custom settings. Don&rsquo;t do this unless you are positively sure of what you&rsquo;re doing!', 'wpml' ); ?>
				</p>
				<p style="text-align:center">
					<input id="restore_default" type="submit" name="restore_default" class="button button-secondary button-large" value="<?php _e( 'Restore', 'wpml' ) ?>" />
				</p>
			</div>

			<p class="submit">
				<input type="submit" id="submit" name="submit" class="button-primary" value="<?php _e( 'Save Changes', 'wpml' ) ?>" />
			</p>

		</form>

	</div>

	<?php include_once( plugin_dir_path( __FILE__ ) . '../../common/views/help.php' ); ?>

</div>