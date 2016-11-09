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
     * Render a template.
     *
     * @param  string  $templatePath
     * @param  array   $data
     * @param  integer $httpCode
     * @return void
     */
    protected function render($templatePath, array $data = array(), $httpCode = null) {
        $this->app()->render($templatePath, $data, $httpCode);
    }
    
    /**
     * Output success response
     *
     * @param  string  $msg  - (Optional) The message 
     * @param  array   $data - (Optional) The data
     * @param  string  $next - (Optional) Some URI
     * @return void
     */
    protected function successResponse($msg = '', $data = array(), $next = null) {
        echo json_encode(array(
            'success' => true,
            'msg'     => $msg,
            'data'    => $data,
            'next'    => $next
        ));
    }
    
    /**
     * Output failure response
     *
     * @param  string  $msg  - (Optional) The message 
     * @param  array   $data - (Optional) The data
     * @param  string  $next - (Optional) Some URI
     * @return void
     */
    protected function failureResponse($msg = '', $data = array(), $next = null) {
        echo json_encode(array(
            'success' => false,
            'msg'     => $msg,
            'data'    => $data,
            'next'    => $next
        ));
    }
}
