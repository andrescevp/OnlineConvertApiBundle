<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 05/11/2015
 * Time: 23:56
 */

namespace Aacp\OnlineConvertApiBundle\Decorator;


class Factory
{
    private $decoratorName;

    public function __construct($decoratorName)
    {
        $this->decoratorName = $decoratorName;
    }
    /**
     * Return a decorator
     *
     * @return Interfaced
     */
    public function getDecorator()
    {
        $namespace = __NAMESPACE__ . '\\' . ucfirst($this->decoratorName);

        $decorator = new $namespace();

        return $decorator;
    }
}