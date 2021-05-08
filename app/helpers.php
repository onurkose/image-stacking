<?php

use Illuminate\Support\HtmlString;

if (!function_exists('vite_assets')) {
    function vite_assets(): HtmlString
    {
        if (app()->environment('local')) {
            return new HtmlString(<<<HTML
            <script type="module" src="http://localhost:3000/@vite/client"></script>
            <script type="module" src="http://localhost:3000/resources/js/app.js"></script>
        HTML
            );
        }

        $manifest = json_decode(file_get_contents(
            public_path('build/manifest.json')
        ), true);

        return new HtmlString(<<<HTML
        <script type="module" src="/build/{$manifest['resources/js/app.js']['file']}"></script>
        <link rel="stylesheet" href="/build/{$manifest['resources/js/app.js']['css'][0]}">
    HTML
        );
    }
}

if (!function_exists('combinations')) {
    function combinations($array, &$output, $index = 0, $p = [])
    {
        foreach ($array[$index] as $i => $name) {
            $copy = $p;
            $copy[] = $name;
            $subIndex = $index + 1;

            if (isset($array[$subIndex])) {
                combinations($array, $output, $subIndex, $copy);
            } else {
                foreach ($copy as $_index => $_name) {
                    if (!isset($output[$_index])) {
                        $output[$_index] = [];
                    }

                    $output[$_index][] = $_name;
                }
            }
        }
    }
}
