<?php
// Preventing loading direct from browser
defined( 'ABSPATH' ) or die();

echo '<link rel="stylesheet" type="text/css" href="' . plugins_url( 'admin-header.css', __FILE__ ) . '">' . "\n";
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <?php switch($_GET['mas-action']) {
            case 'edit': include 'member-edit/admin-members-edit.html'; break;
            default: include 'member-table/admin-members-table.html'; break;
        } ?>
    </main><!-- .site-main -->
</div>
