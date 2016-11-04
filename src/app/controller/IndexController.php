<?php namespace App\Controller;

use SlimGoodies\Mvc\Controller;

class IndexController extends Controller {

    public function index() {
    
        $this->app()->render("index.html", array(
            'title'   => 'Home',
            'message' => 'Hello World.'
        ));

    }

}
