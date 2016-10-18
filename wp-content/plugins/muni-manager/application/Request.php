<?php
/**
 * Description of Request.
 *
 * @author jperez
 */
class Request
{
    private $controller;
    private $method;
    private $args;

    public function __construct()
    {
        if (isset($_GET['url'])) {
            $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            $url = array_filter($url);

            $this->controller = strtolower(array_shift($url));
            $this->method = strtolower(array_shift($url));
            $this->args = $url;

            if (!$this->controller) {
                $this->controller = 'index';
            }
        }

        if (!$this->controller) {
            $this->controller = DEFAULT_CONTROLLER;
        }

        if (!$this->method) {
            $this->method = 'index';
        }

        if (!isset($this->args)) {
            $this->args = array();
        }
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getArgs()
    {
        return $this->args;
    }
}
