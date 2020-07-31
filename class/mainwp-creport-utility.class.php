<?php
/** MainWP Client Reports Utility. */

/**
 * Class MainWP_CReport_Utility
 */
class MainWP_CReport_Utility {

    /**
     * Get timestamp.
     *
     * @param sting $timestamp Holds Timestamp.
     * @return float|int Return GMT offset.
     */
    public static function get_timestamp($timestamp ) {
			$gmtOffset = get_option( 'gmt_offset' );

			return ($gmtOffset ? ($gmtOffset * HOUR_IN_SECONDS) + $timestamp : $timestamp);
	}

    /**
     * Format timestamp.
     *
     * @param sting $timestamp Holds Timestamp.
     * @param bool $gmt Whether to set as General mountain time. Default: FALSE.
     * @return string Return Timestamp.
     */
    public static function format_timestamp($timestamp, $gmt = false ) {
		return date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), $timestamp, $gmt );
	}

    /**
     * Format datestamp.
     *
     * @param sting $timestamp Holds Timestamp.
     * @param bool $gmt Whether to set as General mountain time. Default: FALSE.
     * @return string Return Timestamp.
     */
    public static function format_datestamp($timestamp, $gmt = false ) {
		return date_i18n( get_option( 'date_format' ), $timestamp, $gmt );
	}

    /**
     * Format date.
     *
     * @param sting $timestamp Holds Timestamp.
     * @param bool $gmt Whether to set as General mountain time. Default: FALSE.
     * @return string Return Timestamp.
     */
    public static function format_date($timestamp, $gmt = false  ) {
		return date_i18n( get_option( 'date_format' ), $timestamp, $gmt );
	}

    /**
     * Check digit type.
     *
     * @param $str String to check.
     * @return bool TRUE|FALSE.
     */
    static function ctype_digit($str ) {
		return (is_string( $str ) || is_int( $str ) || is_float( $str )) && preg_match( '/^\d+\z/', $str );
	}

    /**
     * Map website.
     *
     * @param array $website Website array.
     * @param array $keys Website array keys.
     * @return array Output site array.
     */
    public static function map_site(&$website, $keys ) {
		$outputSite = array();
		foreach ( $keys as $key ) {
			$outputSite[ $key ] = $website->$key;
		}
		return $outputSite;
	}

    /**
     * Convert seconds to hours & minutes.
     *
     * @param string $sec Seconds.
     * @param bool $padHours Hours to pad.
     * @return string Hours Minuets & Seconds.
     */
    static function sec2hms($sec, $padHours = false ) {

        /** Start with a blank string. */
		$hms = '';

        /**
         * Do the hours first: there are 3600 seconds in an hour, so if we divide
         * the total number of seconds by 3600 and throw away the remainder, we're
         * left with the number of hours in those seconds.
         */
		$hours = intval( intval( $sec ) / 3600 );

		/** Add hours to $hms (with a leading 0 if asked for). */
		$hms .= ($padHours) ? str_pad( $hours, 2, '0', STR_PAD_LEFT ) . ':' : $hours . ':';

        /**
         * Dividing the total seconds by 60 will give us the number of minutes
         * in total, but we're interested in *minutes past the hour* and to get
         * this, we have to divide by 60 again and then use the remainder.
         */
		$minutes = intval( ($sec / 60) % 60 );

		/** add minutes to $hms (with a leading 0 if needed). */
		$hms .= str_pad( $minutes, 2, '0', STR_PAD_LEFT ) . ':';

        /**
         * Seconds past the minute are found by dividing the total number of seconds
         * by 60 and using the remainder.
         */
		$seconds = intval( $sec % 60 );

		/** Add seconds to $hms (with a leading 0 if needed). */
		$hms .= str_pad( $seconds, 2, '0', STR_PAD_LEFT );

		/** Done! Return Hours Minues & Seconds. */
		return $hms;
	}

}
