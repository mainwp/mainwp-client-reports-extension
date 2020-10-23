<?php
/**
 * MainWP Client Reports Extension continue sending reports.
 *
 * @uses MainWP_CReport::cron_continue_send_reports()
 * @uses MainWP_CReport()
 */

include_once('bootstrap.php');

if ( class_exists('MainWP_CReport')) {
    MainWP_CReport::cron_continue_send_reports();
}