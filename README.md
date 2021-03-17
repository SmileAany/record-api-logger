#### Documentations
* 采用Job记录api接口请求期下，**query** 和 **response**
* 默认采用mongodb记录日志，可更换成mysql
* 本扩展满足psr2,psr4规范
* 由于扩展了mongodb 需要配置，[点击跳转](https://github.com/jenssegers/laravel-mongodb)
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
#### 使用说明
记录操作，采用队列的形式进行，故系统应该采用supervisor来守护队列
> php artisan queue:word redis --queue=record-api-logger

日志记录过程中，会导致数据量过大，影响系统性能。通过任务调度的方式，来删除历史数据
> php artisan clear:api-logger

#### 配置说明
|  字段名   | 说明  |
|  ----  | ----  |
| queue      | 队列名称，可以自定义 |
| default    | 存储类型，分为mongodb 和 mysql两种类型 |
| cache_time | 缓存时间 |
| days       | 数据存储的时间长/天数 |

