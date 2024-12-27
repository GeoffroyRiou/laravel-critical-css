<?php

declare(strict_types=1);

return [


    /***********************************************************
     * 
     * Storage config
     * 
     * Where critical css files should be stored.
     * 
     ***********************************************************/
    'disk' => 'local',
    'folder' => 'criticalcss',

    /***********************************************************
     * 
     * Routes names to generate critical css from.
     * 
     * If your route as parameters you can add them as array value like you do in route generation :
     * 
     * 'route_names' => [
     *   'foo',
     *   'foo.bar' => ['user' => 1]
     * ],
     * 
     ***********************************************************/
    'route_names' => [],

    /***********************************************************
     * 
     * Sitemap file path.
     * 
     * If relative, it must be from laravel root folder
     * 
     * Ex: public/sitemap.xml
     * 
     ***********************************************************/
    'sitemap_path' => '',

    /***********************************************************
     * 
     * Css Selectors to include in critical css even if it is not shown in the viewport during the generation.
     * 
     * Selectors must be exactly the same as those used in the css
     * 
     * Ex: nav.main-menu will not work if the css declares .main-menu
     * 
     ***********************************************************/
    'force_include' => [],

    /***********************************************************
     * 
     * Use Vite overlay to defer css loading 
     * 
     * Automatically preload and defer non critical css.
     * 
     ***********************************************************/
    'useViteCssDefer' => true,
];
