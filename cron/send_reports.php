<?php
/**
 * MainWP Client Reports cron send reports.
 *
 * @uses MainWP_CReport::cron_send_reports()
 */

include_once( 'bootstrap.php' );

if ( class_exists('MainWP_CReport')) {
    MainWP_CReport::cron_send_reports();
}
