<?php

use Illuminate\Support\Facades\Request;

if (!function_exists('activeMenu')) {
    function activeMenu($uri = '')
    {
        // Ambil segment pertama dari URL
        $segment = Request::segment(1);

        // Cek apakah URI cocok dengan berbagai kemungkinan skenario
        if (
            Request::is($segment . '/' . $uri . '/*') ||
            Request::is($segment . '/' . $uri) ||
            Request::is($uri)
        ) {
            return 'active';
        }

        return '';
    }
}
