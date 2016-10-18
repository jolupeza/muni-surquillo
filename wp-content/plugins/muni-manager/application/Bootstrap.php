<?php

/**
 * Description of Bootstrap.
 *
 * @author jperez
 */
class Bootstrap
{
    public static function run(Request $request)
    {
        //        $controller = $request->getController();
        $controller = $request->getController().'Controller';

        $method = $request->getMethod();
        $args = $request->getArgs();

//        $pathController = ROOT . 'admin' . DS . $controller . '.php';
        $pathController = ROOT.'controllers'.DS.$controller.'.php';

        if (is_readable($pathController)) {
            require_once $pathController;
            $controller = new $controller();

            if (is_callable(array($controller, $method))) {
                $method = $request->getMethod();
            } else {
                $method = 'index';
            }

            if (isset($args)) {
                call_user_func_array(array($controller, $method), $args);
            } else {
                call_user_func(array($controller, $method));
            }
        } else {
            throw new Exception('no encontrado');
        }
    }
}
