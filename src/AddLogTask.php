<?php
/**
 * Created by PhpStorm.
 * User: weng
 * Date: 2020-09-17
 * Time: 14:01
 */
namespace App\Middleware;

use Uniondrug\Phar\Server\Tasks\XTask;

/**
 * Class AddLogTask
 * @package App\Middleware
 * @property LogMiddlewareService $logMiddlewareService
 */
class AddLogTask extends XTask
{
    public function run()
    {
        $data = $this->data;
        //异步写入数据
        $this->logMiddlewareService->addLog($data);

    }
}