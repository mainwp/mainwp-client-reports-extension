<?php

class MainWP_CReport_Utility {

	public static function get_timestamp( $timestamp ) {
			$gmtOffset = get_option( 'gmt_offset' );

			return ($gmtOffset ? ($gmtOffset * HOUR_IN_SECONDS) + $timestamp : $timestamp);
	}

	public static function format_timestamp( $timestamp, $gmt = false ) {
		return date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), $timestamp, $gmt );
	}

	public static function format_datestamp( $timestamp, $gmt = false ) {
		return date_i18n( get_option( 'date_format' ), $timestamp, $gmt );
	}

    public static function format_date( $timestamp, $gmt = false  ) {
		return date_i18n( get_option( 'date_format' ), $timestamp, $gmt );
	}

	static function ctype_digit( $str ) {
		return (is_string( $str ) || is_int( $str ) || is_float( $str )) && preg_match( '/^\d+\z/', $str );
	}

	public static function map_site( &$website, $keys ) {
		$outputSite = array();
		foreach ( $keys as $key ) {
			$outputSite[ $key ] = $website->$key;
		}
		return $outputSite;
	}

	static function sec2hms( $sec, $padHours = false ) {

		// start with a blank string
		$hms = '';

		// do the hours first: there are 3600 seconds in an hour, so if we divide
		// the total number of seconds by 3600 and throw away the remainder, we're
		// left with the number of hours in those seconds
		$hours = intval( intval( $sec ) / 3600 );

		// add hours to $hms (with a leading 0 if asked for)
		$hms .= ($padHours) ? str_pad( $hours, 2, '0', STR_PAD_LEFT ) . ':' : $hours . ':';

		// dividing the total seconds by 60 will give us the number of minutes
		// in total, but we're interested in *minutes past the hour* and to get
		// this, we have to divide by 60 again and then use the remainder
		$minutes = intval( ($sec / 60) % 60 );

		// add minutes to $hms (with a leading 0 if needed)
		$hms .= str_pad( $minutes, 2, '0', STR_PAD_LEFT ) . ':';

		// seconds past the minute are found by dividing the total number of seconds
		// by 60 and using the remainder
		$seconds = intval( $sec % 60 );

		// add seconds to $hms (with a leading 0 if needed)
		$hms .= str_pad( $seconds, 2, '0', STR_PAD_LEFT );

		// done!
		return $hms;
	}

}
