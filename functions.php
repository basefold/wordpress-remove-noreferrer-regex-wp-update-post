<?php
/**
 * Plugin Name: Remove noreferrer
 * Plugin URI: https://www.basefold.com/how-do-i-remove-noreferrer-in-wordpress/
 * Description: Removes noreferrer from the rel attribute for all posts and save the changes in the database.
 * Version: 1.0
 * Author: basefold
 */
 
// Remove extraneous whitespace
function basefold_remove_whitespace( $input ) {
    return trim( preg_replace( '#\s+#', ' ', $input ) );
}

// Replace noreferrer
function basefold_replace_rel ( $matches ) {
		// String '<a href="https://www.example.com" target="_blank" rel="noreferrer noopener">external example link</a>'
		$anchor_element_prefix = $matches[1]; // returns: '<a href="https://www.example.com" target="_blank" rel='
		$anchor_rel = basefold_remove_whitespace( str_ireplace( 'noreferrer', '', $matches[3] ) ); // returns: 'noopener'
		$anchor_element_suffix = $matches[4]; // returns: '>external example link</a>'
		
		return $anchor_element_prefix . $anchor_rel . $anchor_element_suffix;
};

// Sayonara noreferrer
function basefold_remove_noreferrer() {
    
    // Get all posts
    $query = new WP_Query( array (
        'post_type' => 'post',
        'posts_per_page' => -1,
        'status' => 'any',
    ) );
    
    $all_posts = $query->get_posts();
	
    $regex = '#(<a\s.*rel=)([\"\']??)(.+)(>.*<\/a>)#i';

    foreach ( $all_posts as $single_post ) {
        $post_id = $single_post->ID;
        $content = $single_post->post_content;
        
        $updated_content = preg_replace_callback( $regex, 'basefold_replace_rel', $content );
        
        $updated_post = array( 'ID' => $post_id, 'post_content' => $updated_content, );

        $update_post = wp_update_post( wp_slash( (array) $updated_post ) );
    }
}
add_action( 'admin_init' , 'basefold_remove_noreferrer' );
?>
