<?php

// Remove annoying index.php in permalinks settings with Nginx.
add_filter( 'got_rewrite', '__return_true', 999 );