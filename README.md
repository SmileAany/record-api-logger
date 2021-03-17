### Laravel Api接口日志
#### Documentations
* 采用redis队列记录api接口请求
* 本扩展满足psr2,psr4规范
* 已通过单元测试
#### Requirements
* PHP ^7.4 | ^8.0
* Laravel 8.x
* jenssegers/mongodb ^3.8
#### 安装
> composer require smbear/record-api-logger
#### 发布配置
>php artisan vendor:publish --provider="Smbear\RecordApiLogger\AppServiceProvider"
#### 数据库迁移
>php artisan migrate --force
#### 分配中间件
> 'api' => [
    \Smbear\RecordApiLogger\Http\Middleware\RecordApi::class,
]

#### 配置门面
> 'aliases' => [
    'RecordApiLogger' => Smbear\RecordApiLogger\Facades\RecordApiLoggerFacades::class,
]
#### 配置说明
|  字段名   | 说明  |
|  ----  | ----  |
| queue      | 队列名称，可以自定义 |
| default    | 存储类型，分为mongodb 和 mysql两种类型 |
| cache_time | 缓存时间 |
| days       | 数据存储的时间长/天数 |
#### 使用说明
记录操作，采用队列的形式进行，故系统应该采用supervisor来守护队列
>   php artisan queue:word redis --queue=record-api-logger
