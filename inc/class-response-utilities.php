<?php
/**
 * Class containing utility functions for working with WordPress HTTP responses.
 *
 * @package BluehostWordPressPlugin
 */

/**
 * Class Bluehost_Response_Utilities
 *
 */
class Bluehost_Response_Utilities {

	/**
	 * Parse a WordPress response for JSON data.
	 *
	 * @param array $response WordPress request response
	 * @param bool  $assoc_array Whether or not to convert objects into associative arrays.
	 *
	 * @return array An array of data
	 */
	public static function parse_json_response( $response, $assoc_array = false ) {
		$data = array();

		if ( 200 === wp_remote_retrieve_response_code( $response ) ) {
			$body = wp_remote_retrieve_body( $response );
			if ( $body ) {
				$payload = json_decode( $body, $assoc_array );
				if ( $payload && is_array( $payload ) ) {
					$data = (array) $payload;
				}
			}
		}

		return $data;
	}

	/**
	 * Get response timestamp.
	 *
	 * @param array $response WordPress request response
	 *
	 * @return int
	 */
	public static function get_response_timestamp( $response ) {
		$timestamp = time();
		try {
			$date      = wp_remote_retrieve_header( $response, 'date' );
			$date_time = new DateTime( $date );
			$timestamp = (int) $date_time->format( 'U' );
		} catch ( Exception $e ) {
			trigger_error( $e->getMessage() ); // phpcs:ignore
		}

		return $timestamp;
	}

}
