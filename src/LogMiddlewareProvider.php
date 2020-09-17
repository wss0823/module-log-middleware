<?php
/**
 * Created by PhpStorm.
 * User: weng
 * Date: 2020-09-17
 * Time: 14:14
 */
namespace Uniondrug\Middleware;

use App\Middleware\LogMiddlewareService;
use Phalcon\Di\ServiceProviderInterface;

class LogMiddlewareProvider implements ServiceProviderInterface
{
    public function register(\Phalcon\DiInterface $di)
    {
        $di->set(
            'LogMiddlewareService',
            function () {
                return new LogMiddlewareService();
            }
        );
    }
}