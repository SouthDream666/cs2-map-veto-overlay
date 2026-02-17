# 欢迎使用CS2-MAP-VETO-OVERLAY
一个用于管理和显示两队之间CS2赛事地图BP(Ban&Pick)的网页应用。该项目使用 PHP 和 JavaScript 构建，使用MYSQL和本地json文件储存数据。

ENGLISH:
## 特色
### 多赛制支持
- BO1（支持Major和IEM两种模式）
- BO3（标准赛制）
- BO5（标准赛制）
- 每种赛制都有对应的BP流程和次数计算

### 完整的BP流程管理
- 实时显示BP流程状态和剩余次数
- 自动切换BP阶段（Ban阶段 → Pick阶段 → BP完成）
- 支持拼刀选边（KNIFE）选项

### 地图管理
- 10张CS地图（Ancient,Anubis,Cache,Dust2,Inferno,Mirage,Nuke,Overpass,Train,Vertigo)
- 地图禁用功能，防止重复选择
- 地图选择的视觉反馈和动画效果

### 阵营选择
- 支持T、CT、KNIFE（拼刀）三种阵营选择
- 阵营选择的视觉区分（不同颜色显示）

## 用途
可用于赛事中导播放映BP结果。

## 如何安装
#### 前提条件
1. 已安装PHP的Web服务器或虚拟主机（例如Apache或Nginx）。
2. PHP 7.0或更高。
3. MYSQL5.6及以上。

------------

1. 下载本源码并解压到web服务器的网站目录中。
2. 打开config.php并配置以下内容：
```php
function dbConfig(): array
{
    return [
        'host' => '127.0.0.1', //一般不用动
        'port' => '3306',//端口
        'name' => 'cs_map_veto',//数据库名称
        'user' => 'cs_map_veto',//用户
        'pass' => 'DbA*****keF',//密码
        'charset' => 'utf8mb4',//一般不用动
    ];
}
```
3. 打开数据库导入文件夹中的cs_map_veto.sql文件

恭喜你！得到了一个可以投入使用的BP界面。
## 如何使用
打开OBS，添加浏览器，地址输入：https://yourdomain.com/display.php
## 如何联系我
如果无法正常使用可以在[Discord](https://discord.com/users/1061250571723620392 "Discord")私信我，国内用户可在[B站](https://space.bilibili.com/327205741 "B站")私信我。
## 许可
本项目采用MIT许可证授权 —— 详情请参见[LICENSE](https://github.com/SouthDream666/cs2-map-veto-overlay/blob/main/LICENSE "LICENSE"
)文件。
## 鸣谢
感谢 TechSanjal 的 [valorant-map-veto-overlay](https://github.com/TechSanjal/valorant-map-veto-overlay "valorant-map-veto-overlay")

------------

感谢您使用CS2地图BP系统！祝比赛顺利！
