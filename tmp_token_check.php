<?php
$s = file_get_contents(__DIR__ . '/../../ddsbe/app/Http/Middleware/AuthenticateAccess.php');
$tokens = token_get_all($s);
foreach ($tokens as $tok) {
    if (is_array($tok) && $tok[0] === T_CLASS) {
        echo "FOUND CLASS\n";
    }
}
