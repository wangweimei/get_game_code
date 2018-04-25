# 这是什么？

这是一条关于高并发的PHP面试题解决思路。

前段时间我去了某知名游戏公司面试，遇到如下这条考题：

    现在要上线一个新游戏，需要放出100万个游戏注册码，目前已经有过亿玩家预约，问后端该如何应对这个活动。
    （要求：同一个注册码不能被重复抢到、不能让用户排队等待、只能使用MySQL作为数据库）



# 解决思路

如果允许使用redis，个人认为最好的方法，就是将注册码存到redis的集合里面，然后用spop取出给用户。

这样在高并发的情况下，既不会同一个注册码被重复抢到，也不需要用户排队等待。

但是，题目要求只能使用MySQL作为数据库，要想实现前面那两个条件，就需要用到悲观锁了。




# 一些延伸的想法

题目说有过亿玩家预约，那这个请求量估计没一亿都有九千万吧，而注册码就只有100万个，如果全部流量都由PHP承受，那就太浪费资源了。

所以这里应该再优化一下，假设一打开活动页面就可以获取一个注册码，那活动结束后应该返回一个纯静态页面。（真实场景肯定没那么简单，这里只是提供一个思路）

可以利用Nginx的URL重写实现：

```nginx
location / {
    if (!-e $request_filename) {
        rewrite  ^/index.html$  /index.php  last;
        break;
    }
}
```

另外，单机肯定承受不了如此高的流量，分布式之类更广泛的思路就不在这里展开赘述了。