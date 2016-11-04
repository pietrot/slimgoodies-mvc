<?php namespace SlimGoodies\Mvc;

/**
 * View
 *
 * Custom view class that renders templates using the Twig template language
 * (http://www.twig-project.org/).
 */
class View extends \Slim\View {

    public static $twigDir          = null;
    public static $twigTemplateDirs = array();
    public static $twigOptions      = array();
    public static $twigExts         = array();
    private $twigEnv                = null;

    /**
     * Get a list of template dirs.
     *
     * @return array
     */
    private function getTemplateDirs() {

        if (empty(self::$twigTemplateDirs)) {

            return array($this->getTemplatesDirectory());

        }

        return self::$twigTemplateDirs;

    }

    /**
     * Render template.
     *
     * @param  string $template Template path.
     * @return void
     */
    public function render($template) {

        $env      = $this->getEnvironment();
        $template = $env->loadTemplate($template);

        return $template->render($this->all());

    }

    /**
     * Get environment.
     *
     * @return Twig_Environment
     */
    public function getEnvironment() {

        if (!$this->twigEnv) {

            if (!class_exists('\Twig_Autoloader')) {
                
                require_once(self::$twigDir . '/Autoloader.php');
            
            }

            \Twig_Autoloader::register();

            $loader        = new \Twig_Loader_Filesystem($this->getTemplateDirs());
            $this->twigEnv = new \Twig_Environment($loader, self::$twigOptions);

            if (!class_exists('\Twig_Extensions_Autoloader')) {

                $extension_autoloader = dirname(__FILE__) . '/Extension/TwigAutoloader.php';
                
                if (file_exists($extension_autoloader)) {
                    
                    require_once($extension_autoloader);

                }

            }

            if (class_exists('\Twig_Extensions_Autoloader')) {

                \Twig_Extensions_Autoloader::register();

                foreach (self::$twigExts as $ext) {

                    $extension = is_object($ext) ? $ext : new $ext();
                    $this->twigEnv->addExtension($extension);

                }
            }
        }

        return $this->twigEnv;

    }

}
