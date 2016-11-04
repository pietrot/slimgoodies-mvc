<?php namespace SlimGoodies\Mvc;

/**
 * Controller
 *
 * @package SlimGoodies\Mvc
 */
abstract class Controller {
     
    protected $_app;
    
    /**
     * Default constructor.
     *
     * @param  mixed $app
     * @return void
     */
    public function __construct(&$app) {

        $this->_app = $app;

    }

    /**
     * Get app instance.
     *
     * @return mixed
     */
    protected function app() {

        return $this->_app;

    }

    /**
     * Render view.
     *
     * @param  string  $templatePath
     * @param  array   $data
     * @param  integer $httpCode
     * @return void
     */
    protected function renderView($templatePath, array $data = array(), $httpCode = null) {
        
        $this->app()->render($templatePath, $data, $httpCode);

    }

}
