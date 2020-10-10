# 日志中间件

## 安装
```shell
composer require wss0823/module-log-middleware
```
> 中间件依赖 `uniondrug/middleware` 中间件基础组件。


修改 `app.php` 配置文件，加上Middleware服务，服务名称`LogMiddleware`

```php
return [
    'default' => [
        ......
        'providers'           => [
            ......
            \Uniondrug\TokenAuthMiddleware\LogMiddleware::class,
        ],
    ],
];
```
增加配置文件 `middleware.php`,加入如下配置
```php
return [
    'default' => [
        // 应用定义的中间件
        'middlewares' => [
            // 注册名为token的中间件
            'addLog' => \Uniondrug\ModuleLogMiddleware\LogMiddleware::class,
        ],
        // 将token中间件放在全局中间列表中
        'global' => [
            'addLog'
        ],
        'addLog' => [
            'whitelist' => [
                //请求controllers 路由名称
                'amap' => [
                    //请求function 路由名称 & 路由备注
                    'search' => '地图查询',
                ],
            ]
        ]
    ]
];
```
在db注册的数据库中增加如下表
```sql
CREATE TABLE `http_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `request_id` varchar(32) NOT NULL DEFAULT '' COMMENT '请求链id',
  `http_url` varchar(32) NOT NULL DEFAULT '' COMMENT '请求地址',
  `http_url_content` varchar(240) NOT NULL DEFAULT '' COMMENT '请求地址简介',
  `user_agent` varchar(240) NOT NULL DEFAULT '' COMMENT '请求来源',
  `ip` varchar(120) DEFAULT '' COMMENT 'IP地址',
  `request_body` text COMMENT '请求入参json',
  `gmt_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `gmt_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `idx_request_id` (`request_id`) USING HASH COMMENT '请求链',
  KEY `idx_http_url` (`http_url`) USING HASH COMMENT '请求地址',
  KEY `idx_user_agent` (`user_agent`) USING BTREE COMMENT '请求来源'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='请求日志表';
```