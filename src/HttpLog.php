<?php
/**
 * Created by PhpStorm.
 * User: weng
 * Date: 2020-09-17
 * Time: 16:13
 */
namespace App\Middleware;

use Phalcon\Mvc\Model\Behavior\Timestampable;
use Uniondrug\Framework\Models\Model;

class HttpLog extends Model
{
    public function getSource()
    {
        return "http_log";
    }
    function initialize()
    {
        parent::initialize();
        $this->addBehavior(new Timestampable([
            'beforeCreate' => [
                'field' => [
                    'gmtCreated',
                    'gmtUpdated'
                ],
                'format' => 'Y-m-d H:i:s',
            ],
            'beforeUpdate' => [
                'field' => 'gmtUpdated',
                'format' => 'Y-m-d H:i:s',
            ],
        ]));
    }

    /**
     * 设置别名
     * @return array
     */
    public function columnMap()
    {
        return [
            'id' => 'id',
            'request_id' => 'requestId',
            'http_url' => 'httpUrl',
            'http_url_content' => 'httpUrlContent',
            'user_agent' => 'userAgent',
            'request_body' => 'requestBody',
            'gmt_created' => 'gmtCreated',
            'gmt_updated' => 'gmtUpdated',
        ];
    }
}