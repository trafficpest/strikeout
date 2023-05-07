<?php 
foreach(glob($path_to_root.'/methods/*', GLOB_ONLYDIR) as $dir) {
include $dir.'/inc/ui/nav-menu.php';
}

?>
