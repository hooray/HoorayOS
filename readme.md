# HoorayOS

## 作者寄语

这个框架是我在刚入程序员这行时，为了学习 jQuery 而写的一个练手项目，由于功能一步步扩充，也发现了一些商业价值。

做为一款曾经的付费框架，它给我带来过不错的收益，其中不乏有BAT之类的大厂也曾向我采购过此项目。但由于技术发展和业务迭代，这款框架也逐渐不被市场所需要。

昨天帮我续费域名的朋友和我说，http://hoorayos.com 这个域名快到期了，是否还要续费，思考过后决定不再续费了，同时也将源码完全开源。

对我个人来说，此仓库只是一段历史；但对你来说，如果你对该项目感兴趣，你完全可以用于商业或非商业的项目中，只是我不再提供技术支持了，仓库采用了 MIT 开源协议。

—— Hooray 写于 2021/1/30

## 使用说明

推荐使用 [WampServer](https://sourceforge.net/projects/wampserver/) 运行，需要安装 composer 并在项目内执行 `composer i` 安装依赖，然后将 `_sql/hoorayos.sql` 数据库文件导入到 mysql 中，最后在 `inc/config.php` 里修改数据库连接配置即可。

## 主要技术栈

php + mysql + jquery