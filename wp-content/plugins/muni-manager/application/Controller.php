<?php

/**
 * Description of Controller.
 *
 * @author jperez
 */
abstract class Controller
{
    private $registry;
//    protected $view;
//    protected $acl;
    protected $request;

    public function __construct()
    {
        $this->registry = Registry::getInstance();
        $this->request = $this->registry->request;
    }

    abstract public function index();
}
