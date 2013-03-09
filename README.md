##Server Web-admin Control Panel
###Description
Powered by [Yii Framework](http://www.yiiframework.com/ "Yii Framework") 1.1.12, involved modular architecture.

Implemented few modules, include module for monitoring UTM5 Billing users, vpn server monitoring module and Direct Connect hub monitoring module.

Interface based on Yii-bootstrap extension.

##Modules

###Billing
Work with Netup [UTM5](http://www.netup.ru/UTM5/ "UTM5") billing.

Displays page user list, detailed information, reports.

###VPN
Work with [accel-ppp](http://sourceforge.net/projects/accel-ppp/ "accel-ppp") vpn server.

Display user sessions, server statistics, latest errors from RADIUS log (UTM5 Radius log).

Can kill user vpn session.

###Hub
Display main chat history

Require verlihub chatlog script [verlihub-chatlog](https://github.com/nezhelskoy/verlihub-chatlog "verlihub-chatlog")


##Not implemented...
- interaction between modules (for example, generate links in RADUIS error log to users billing account info);
- adding more tables from UTM5 database for billing module models;
- adding various user reports for billing module;
- DHCP module (showing dhcp leases, user subnets, etc.) for ISC DHCP Server;
- and many more...
