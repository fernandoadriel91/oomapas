<?php

namespace App\Routing;

use Illuminate\Routing\ResourceRegistrar;

class ExtendedResourceRegistrar extends ResourceRegistrar
{
    protected static $verbs = [
        'create' => 'create',
        'edit' => 'edit',
        'destroy' => 'destroy',
        'datatable' => 'datatable'
    ];
    
    protected $resourceDefaults = ['index', 'datatable', 'create', 'store', 'show', 'edit', 'update', 'destroy'];

    /**
     * Add the show method for a resourceful route.
     *
     * @param  string  $name
     * @param  string  $base
     * @param  string  $controller
     * @return void
     */
    public function addResourceDatatable($name, $base, $controller, $options)
    {
        //echo $name;
        $uri = $this->getResourceUri($name).'/'.static::$verbs['datatable'];;

        $action = $this->getResourceAction($name, $controller, 'datatable', $options);
        return $this->router->get($uri, $action);
    }
    
}