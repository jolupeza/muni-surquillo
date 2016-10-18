<?php

/**
 * Description of Registry.
 *
 * @author jperez
 */
class Registry
{
    private static $instance;
    private $data;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        }

        return false;
    }
}
