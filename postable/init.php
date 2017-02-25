<?php

// Preventing loading direct from browser
defined( 'ABSPATH' ) or die();

// Including postable actions
include_once plugin_dir_path( __FILE__ ) . 'integrations-manager.php';
include_once plugin_dir_path( __FILE__ ) . 'registration.php';
include_once plugin_dir_path( __FILE__ ) . 'update-card.php';