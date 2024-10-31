<?php 

function rigorousweb_insta_feeds( $access_token, $image_num, $disable_cache ) {	

	if( '1' == $disable_cache ){
		$cached = false;
	} else{

		$cached = get_transient( 'rigorousweb_instagram_feeds' );

	}	

	if ( false !== $cached ) {

		return $cached;

	}

	$count = $image_num;

	$url              = 'https://api.instagram.com/v1/users/self/media/recent/?access_token=' . trim( $access_token ). '&count=' . trim( $count );

	$feeds_json         = wp_remote_fopen( $url );

	$feeds_obj          = json_decode( $feeds_json, true );	

	$feeds_images_array = array();


	if ( 200 == $feeds_obj['meta']['code'] ) {

		if ( ! empty( $feeds_obj['data'] ) ) {

			foreach ( $feeds_obj['data'] as $data ) {
				array_push( $feeds_images_array, array( $data['images']['thumbnail']['url'], $data['link'] ) );
			}

			foreach ( $feeds_images_array as $key => $value ) {
				$feeds_images_array[ $key ] = preg_replace( '/s150x150/', 's320x320', $value );
			}

			$ending_array = array(
				'link'   => $feeds_obj['data'][0]['user']['username'],
				'images' => $feeds_images_array,
				);

			set_transient( 'rigorousweb_instagram_feeds', $ending_array, 1 * HOUR_IN_SECONDS );

			return $ending_array;
		}
	}
}




