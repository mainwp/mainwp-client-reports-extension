<?php
include_once('bootstrap.php');

if ( class_exists('MainWP_CReport')) {
    MainWP_CReport::cron_continue_send_reports();
}