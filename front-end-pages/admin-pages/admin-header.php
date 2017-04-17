<?php 

// Preventing loading direct from browser
defined( 'ABSPATH' ) or die();

include 'admin-header.html';

?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<?php

		// changes the html in the div based on button click
		switch($_GET['content']) {
			case 1: include 'members-tab/member-table/admin-members-table.html'; break;
			case 2: include 'classes-tab/admin-classes.html'; break;
            case 3: include 'access-tab/admin-access.html'; break;
			case 4: include 'integrations-tab/admin-integrations.html'; break;
			case 5: include 'members-tab/member-edit/admin-members-edit.html'; break;
            case 7: include 'classes-tab/admin-create-class.html'; break;
            default: include 'members-tab/member-table/admin-members-table.html'; break;
		}
		
		?>

	</main><!-- .site-main -->

</div>
