<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 18/11/2015
 * Time: 1:46
 */

namespace Aacp\OnlineConvertApiBundle\Routing;


use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class CallbackLoader extends Loader
{

    private $loaded = false;

    private $route;

        /**
     * Loads a resource.
     *
     * @param mixed $resource The resource
     * @param string|null $type The resource type or null if unknown
     *
     * @return RouteCollection
     * @throws \Exception If something went wrong
     */
    public function load($resource, $type = null)
    {
        if (!$resource || !$type) {
            return;
        }

        if (true === $this->loaded) {
            throw new \RuntimeException('Do not add the "extra" loader twice');
        }

        $routes = new RouteCollection();

        // prepare a new route
        $path = '/oc/callback/'.$resource.'_'.$type;
        $defaults = array(
            '_controller' => 'AacpOnlineConvertApiBundle:Callback:endPoint',
        );
        $route = new Route($path, $defaults);
        // add the new route to the route collection
        $routeName = 'online_convert_callback'.$resource.'_'.$type;
        $routes->add($routeName, $route);

        $this->loaded = true;
        $this->route = $route->getPath();

        return $routes;
    }

    /**
     * Returns whether this class supports the given resource.
     *
     * @param mixed $resource A resource
     * @param string|null $type The resource type or null if unknown
     *
     * @return bool True if this class supports the given resource, false otherwise
     */
    public function supports($resource, $type = null)
    {
        return 'online_convert' === $type;
    }

    /**
     * @return mixed
     */
    public function getRoute()
    {
        return $this->route;
    }

}