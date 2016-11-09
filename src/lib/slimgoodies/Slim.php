<?php namespace SlimGoodies;

/**
 * Override Slim to add the ability to bind routes to controllers and actions.
 *
 * @package SlimGoodies
 */
class Slim extends \Slim\Slim {
    /**
     * Map route to a callable func. Now, the callable func can also  be a string incl the controller &
     * action (controller-name:actoin-name).
     *
     * @param $args
     */
    public function mapRoute($args) {
        $app = $this;
        
        $numArgs = count($args);
        
        // Let's see what we're dealing with : 
        switch ($numArgs) {
            // Route args incl route + callable func.
            case 2:
                $callable = array_pop($args);
                break;
            // Route args incl route + callable func + middlewares.
            case 3:
                $middlewares = array_pop($args);
                $callable    = array_pop($args);
                break;
            // Huh ? that's not right !
            default:
                // Let Slim deal with this...
                return parent::mapRoute($args);
        }
        
        // Were middlewares provided in the args ?
        if (isset($middlewares) && is_array($middlewares)) {
            // If so, create a callable func for each middleware.
            foreach ($middlewares as $middleware) {
                // Is the middleware a callable func ? 
                if (is_callable($middleware)) {
                    // If so, simply add it.
                    $args[] = $middleware;
                    continue;
                }

                // Otherwise, it's most likely a string representing the middleware name. 
                $args[] = function() use($app, $middleware) {
                    // Init the middleware and execute.
                    $m = new $middleware();
                    $m->setApplication($app);
                    $m->call();
                };
            }
        } 
        
        // Is the callable arg a string representing the controller & action ? 
        if (is_string($callable) && substr_count($callable, ':', 1) == 1) {
            // If so, create a callable func that will init the controller & execute the action.
            list($controllerName, $actionName) = explode(':', $callable);
            
            $callable = function () use ($app, $controllerName, $actionName) {
                // Try to fetch the controller instance from Slim's container.
                if ($app->container->has($controllerName)) {
                    $controller = $app->container->get($controllerName);
                } else {
                    // not in container, assume it can be directly instantiated
                    $controller = new $controllerName($app);
                }

                return call_user_func_array(array($controller, $actionName), func_get_args());
            };
        }

        $args[] = $callable;

        return parent::mapRoute($args);
    }
}
