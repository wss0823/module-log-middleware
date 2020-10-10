<?php
/**
 * Created by PhpStorm.
 * User: weng
 * Date: 2020-09-07
 * Time: 15:08
 */
namespace Uniondrug\ModuleLogMiddleware;

use Phalcon\Http\RequestInterface;
use Uniondrug\Middleware\DelegateInterface;
use Uniondrug\Middleware\Middleware;

/**
 * Class LogMiddleware
 * @package Uniondrug\Middleware
 * @property LogMiddlewareService $logMiddlewareService
 */
class LogMiddleware extends Middleware
{
    public $httpUrl = "";
    protected $whiteList = null;

    private function getHttpUrl()
    {
        return $this->request->getURI();
    }

    private function getRequestId()
    {
        return $this->logMiddlewareService->getSwoole()->getTrace()->getRequestId();
    }

    private function getRawBody()
    {
        return $this->request->getRawBody();
    }

    private function getUserAgent()
    {
        return $this->request->getUserAgent();
    }

    private function getClientAddress()
    {
        return $this->request->getClientAddress();
    }

    public function handle(RequestInterface $request, DelegateInterface $next)
    {
        $return = $next($request);
        //拉去需要获取的白名单地址
        $this->getWhiteList();
        if (count($this->whiteList) > 0) {
            $urlKeys = $this->analysisUrl();
            if ($urlKeys != false) {
                //处理日志服务
                $this->addLog($urlKeys);
            }
        }
        return $return;
    }

    public function addLog(string $urlKeys)
    {
        //请求链ID
        $requestId = $this->getRequestId();
        //请求地址
        $httpUrl = $this->getHttpUrl();
        //请求接口功能文本
        $httpUrlContent = $urlKeys;
        //请求入参
        $requestBody = $this->getRawBody();
        //请求来源
        $userAgent = $this->getUserAgent();
        //请求ip地址
        $ip = $this->getClientAddress();
        $arr['requestId'] = $requestId;
        $arr['httpUrl'] = $httpUrl;
        $arr['httpUrlContent'] = $httpUrlContent;
        $arr['requestBody'] = $requestBody;
        $arr['userAgent'] = $userAgent;
        $arr['ip'] = $ip;
        $this->logMiddlewareService->getSwoole()->runTask(AddLogTask::class, $arr);
    }

    private function analysisUrl()
    {
        $httpUrl = explode('/', $this->request->getURI());
        array_shift($httpUrl);
        $overKey = array_pop($httpUrl);
        $key = implode("/", $httpUrl);
        //var_dump($key,$overKey);
        if (key_exists($key, $this->whiteList)) {
            if (key_exists($overKey, $this->whiteList[$key])) {
                return $this->whiteList[$key][$overKey];
            }
        }
        return false;
    }

    private function getWhiteList()
    {
        if ($this->whiteList === null) {
            $whiteList = $this->config->path('middleware.addLog.whitelist')->toArray();
            if (count($whiteList) > 0) {
                $this->whiteList = $whiteList;
            } else {
                $this->whiteList = [];
            }
        }
        return $this->whiteList;
    }
}