<?php
/**
 * Created by PhpStorm.
 * User: weng
 * Date: 2020-09-17
 * Time: 14:14
 */
namespace Uniondrug\ModuleLogMiddleware;

use Phalcon\Di\ServiceProviderInterface;

class LogMiddlewareProvider implements ServiceProviderInterface
{
    public function register(\Phalcon\DiInterface $di)
    {
        $di->set(
            'logMiddlewareService',
            function () {
                return new LogMiddlewareService();
            }
        );
    }
}