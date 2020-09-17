# 日志中间件

## 安装
```shell
composer require wss0823/module-log-middleware
```
> 中间件依赖 `uniondrug/middleware` 中间件基础组件。


修改 `app.php` 配置文件，加上Cache服务，服务名称`LogMiddleware`

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