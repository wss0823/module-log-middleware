<?php
/**
 * Created by PhpStorm.
 * User: weng
 * Date: 2020-09-17
 * Time: 14:19
 */
namespace App\Middleware;

use Uniondrug\Framework\Container;
use Uniondrug\Framework\Services\Service;
use Uniondrug\Phar\Server\Services\Http;

class LogMiddlewareService extends Service
{
    /**
     * @return mixed
     * @throws \Exception
     */
    public function getSwoole()
    {
        /**
         * @var Container $di
         */
        $di = $this->di;
        $swoole = $di->getShared('server');
        if ($swoole instanceof Http) {
            return $swoole;
        }
        throw new \Exception("only work with swoole mode");
    }

    public function addLog(array $data){
        $model = new HttpLog();
        if($model->create($data)){
            return $model;
        }
        $this->logger->info("异步写入{".$data['userAgent']."}动作{".$data['httpUrl']."}");
    }
}