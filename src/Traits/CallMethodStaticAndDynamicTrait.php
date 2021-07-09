<?php

namespace App\Traits;

/**
 * Trait CallMethodStaticAndDynamicTrait.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 *
 * use this trait and add below to  class annotation to share with other developer to know that witch static methods are
 * exist.
 * below annotate means that MyMethod($arg) exist and you call it static by new name MyMethodStatic
 *              `method static $this methodStaic($arguemnt = 'default')`
 */
trait CallMethodStaticAndDynamicTrait
{
    public static function __callStatic($name, $arguments)
    {
        if (false != strpos($name, 'Static')) {
            $name = str_replace('Static', '', $name);

            return call_user_func_array([new static(), $name], $arguments);
        }
    }

    public function __call($method, $arguments)
    {
        // TODO: Implement __call() method.
    }
}
