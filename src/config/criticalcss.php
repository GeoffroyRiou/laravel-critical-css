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
    'sitemap_path' => ''
];
