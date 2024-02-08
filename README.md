# imi - PHP Coroutine Development Framework based on Swoole

<p align="center">
    <a href="https://www.imiphp.com" target="_blank">
        <img src="https://raw.githubusercontent.com/imiphp/imi/dev/res/logo.png" alt="imi" />
    </a>
</p>

[![Latest Version](https://img.shields.io/packagist/v/imiphp/imi.svg)](https://packagist.org/packages/imiphp/imi)
![GitHub Workflow Status (branch)](https://img.shields.io/github/workflow/status/imiphp/imi/ci/dev)
[![Php Version](https://img.shields.io/badge/php-%3E=7.1-brightgreen.svg)](https://secure.php.net/)
[![Swoole Version](https://img.shields.io/badge/swoole-%3E=4.4.0-brightgreen.svg)](https://github.com/swoole/swoole-src)
[![imi Doc](https://img.shields.io/badge/docs-passing-green.svg)](https://doc.imiphp.com)
[![imi License](https://img.shields.io/badge/license-MulanPSL%201.0-brightgreen.svg)](https://github.com/imiphp/imi/blob/master/LICENSE)
[![star](https://gitee.com/yurunsoft/IMI/badge/star.svg?theme=gvp)](https://gitee.com/yurunsoft/IMI/stargazers)

## Introduction

imi is a high-performance coroutine application development framework based on PHP Swoole, which supports the development of HttpApi, WebSocket, TCP, UDP, and MQTT services.

With the support of Swoole, compared to PHP-FPM, imi significantly improves the ability to handle I/O-intensive scenarios.

imi framework has rich functional components, which can be widely used in the Internet, mobile communications, enterprise software, cloud computing, online games, Internet of Things (IoT), car networking, smart home, and other fields. It can greatly improve the efficiency of enterprise IT R&D teams and focus more on developing innovative products.

> The development of imi v2 version has begun (as of 2020-09). If you have any questions or suggestions, please feel free to contact us!

## Official Video Tutorials (Completely Free)

imi framework introductory tutorial (free 11 episodes full) <https://www.bilibili.com/video/av78158909>

imi framework advanced tutorial - Gobang game development (free 7 episodes full) <https://space.bilibili.com/768718/channel/detail?cid=136926>

### Core Components

* HttpApi, WebSocket, TCP, UDP, MQTT servers
* MySQL connection pool (master-slave + load balancing)
* Redis connection pool (master-slave + load balancing)
* Extremely easy-to-use ORM (Db, Redis, Tree)
* Millisecond-level hot reload
* AOP
* Bean container
* Cache
* Configuration reading and writing (Config)
* Enum
* Event
* Facade
* Validator
* Lock
* Log
* Asynchronous tasks (Task)

### Extended Components

* [MQTT](src/Components/mqtt)
* [RPC](src/Components/rpc)
* [gRPC](src/Components/grpc)
* [Hprose](src/Components/hprose)
* [Message Queue](src/Components/queue)
* [AMQP](src/Components/amqp) (Supports message queues using the AMQP protocol, such as RabbitMQ)
* [Kafka](src/Components/kafka)
* [JWT](src/Components/jwt) (Conveniently integrates JWT into the imi framework)
* [Access Control](src/Components/access-control)
* [Smarty Template Engine](src/Components/smarty)
* [Rate Limiting](src/Components/rate-limit)
* [Cross-Process Variable Sharing](src/Components/shared-memory)
* [Snowflake Algorithm ID Generator](src/Components/snowflake)
* [Swagger API Documentation Generation](src/Components/apidoc)
* [Swoole Tracker](src/Components/swoole-tracker)

> These components are all maintained in the main repository of imi.

## Getting Started

Create Http Server project: `composer create-project imiphp/project-http:~1.0`

Create WebSocket Server project: `composer create-project imiphp/project-websocket:~1.0`

Create TCP Server project: `composer create-project imiphp/project-tcp:~1.0`

Create UDP Server project: `composer create-project imiphp/project-udp:~1.0`

Create MQTT Server project: `composer create-project imiphp/project-mqtt:~1.0`

[Complete Development Manual](https://doc.imiphp.com)

## Runtime Environment

* Linux system (Swoole does not support running on Windows)
* [PHP](https://php.net/) >= 7.1
* [Composer](https://getcomposer.org/)
* [Swoole](

https://www.swoole.com/) >= 4.4.0
* Redis, PDO extensions

## Docker

It is recommended to use the official Swoole Docker: <https://github.com/swoole/docker-swoole>

## Success Stories

Whether you are developing personal projects or company projects using imi, whether open source or commercial, you can submit cases to us.

Cases may be adopted and displayed on the imi official website, Swoole official website, etc., which promotes the promotion and development of projects.

**Submission Format:**

* Project Name
* Project Introduction
* Project URL (official website/download URL/Github, etc., at least one)
* Contact Information (phone/email/QQ/WeChat, etc., at least one)
* Project Screenshots (optional)
* Testimonials

### Case Display

* [Kangedan Movie and TV Search - Full Network Movie and TV Resource Search Platform](http://www.kangedan.com/)

![Kangedan Movie and TV Search](https://www.imiphp.com/images/anli/kangedan.jpg "Kangedan Movie and TV Search")

**Project Introduction:** The earliest purpose of building a website was for my own convenience! After it was put on the Internet, as the traffic became larger and larger, it was necessary to consider upgrading the configuration or refactoring the project. A few days ago, I saw imiphp on GitHub, so I decided to try it out. I simply refactored all the pages with imiphp, and introduced the think-template of TP as the template engine. The entire refactoring took less than a day, so imiphp is indeed very easy to use! Keep it up!

---

* [Hupu - Hundreds of millions of data migration services]

![Hupu](https://www.imiphp.com/images/anli/hupu.jpg "Hupu")

**Project Introduction:** With the increasing data scale, MySQL is no longer suitable for multi-dimensional queries of big data, and ES and other search engines are needed for multi-dimensional word segmentation queries. At present, MYSQL uses partitioned storage by day, which cannot meet long-term queries across days.

How to complete the data migration at the fastest speed, and migrate the data in the database to ES, is an important technical point that needs to be evaluated.

In high IO-intensive scenarios, a single request takes 80 milliseconds, and imi uses Swoole coroutines to switch between user space and kernel space, fully utilizing the CPU of the computer, so that it can quickly complete the massive data migration.

According to the monitoring statistics of Prometheus, on two 2C 4G machines, imi has a synchronization speed of 1000~1500 records per second, and has completed the data migration of hundreds of millions.

Blog address: <https://blog.csdn.net/qq_32783703/article/details/113576741>

---

* [Teacher's API - Free API Call Platform](https://api.oioweb.cn/)

![Teacher's API](https://www.imiphp.com/images/anli/jsxsapi.png "Teacher's API")

**Project Introduction:** Teacher's API is a free API data interface call service platform - we are committed to providing users with stable and fast free API data interface services.

**Testimonials:**

Previously, the server configuration was 8H8G 30M and other configurations, with a daily traffic of over 3 million requests. Once, a certain interface would cause the server to crash due to an occasional error. I found the imiphp project by chance on GitHub, so I stayed up late to replace the core code of the program's internal request with imi. Fortunately, I had a 1H2G 5M server on hand for testing, coupled with Redis, and there were no problems with 2-3 million+ requests. Finally, I would like to thank the open source project of Mr. Yurun.

---

## Copyright Information

imi is released under the Mulan Permissive Software License (Mulan PSL v2) open source license and is free to use.

## Acknowledgments

Thanks to the following open source projects (in alphabetical order) for their strong support for imi!

* [doctrine/annotations](https://github.com/doctrine/annotations) (PHP annotation processing library)
* [PHP](https://php.net/) (No PHP, no imi)
* [Swoole](https://www.swoole.com/) (No Swoole, no imi)

## Contributors

[![Contributors](https://opencollective.com/IMI/contributors.svg?width=890&button=false)](https://github.com/imiphp/imi/graphs/contributors)

Do you want to appear on the contributors list?

Things you can do (including but not limited to the following):

* Correct spelling and typos
* Improve comments
* Bug fixes
* Feature development
* Document writing
* Tutorial, blog sharing

> The latest code is based on the `dev` branch, and please merge your `PR` to the `dev` branch!

Submit a `Pull Request` to this repository, and you have the opportunity to become one of the authors of imi!

See the development tutorial for framework participation: <doc/adv/devp.md>

## Donation

![Donation](https://cdn.jsdelivr.net/gh/imiphp/imi@dev/res/pay.png)

Open source does not seek profit. It's all about goodwill. Life is not easy. Just go with the flow...