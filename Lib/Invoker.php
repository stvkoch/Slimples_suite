<?php
/**
 * \Lib\Invoker('\App\Controller\Home::instance->method')
 *
 * why \Lib\Invoker? when Slim append your route,
 * he use is_callable to verify callback and that
 * include/open controller file on stack.
 *
 */
namespace Lib;
class Invoker {
    protected $klass = null;

    public function __construct($klass)
    {
        $this->klass = $klass;
    }

    //allow \namespace\klass::intance::method
    public function __invoke()
    {
        $meta = explode("->", $this->klass);
        if(strrpos($meta[0], '::'))
            $result = call_user_func_array($meta[0], func_get_args());
        else
            $result = new $meta[0];

        $c = count($meta);
        for ($i=1; $i < $c; $i++) {
            if(strrpos($meta[$i], '::'))
                $result = call_user_func_array($meta[$i], func_get_args());
            else
                $result = call_user_func_array(array($result, $meta[$i]), func_get_args());
        }
        return $result;
    }
}