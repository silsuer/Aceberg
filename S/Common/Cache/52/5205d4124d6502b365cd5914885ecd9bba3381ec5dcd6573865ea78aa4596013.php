<?php

/* plugins/a/AdminManager/html/index.html */
class __TwigTemplate_a05ce1e4bf8b2cdc2f3377f52947ba7ba85d867c942a9419f847bb90e319fab9 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
<head>
    <meta charset=\"utf-8\">
    <title>layui后台管理模板 2.0</title>
    <meta name=\"renderer\" content=\"webkit\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge,chrome=1\">
    <meta http-equiv=\"Access-Control-Allow-Origin\" content=\"*\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1\">
    <meta name=\"apple-mobile-web-app-status-bar-style\" content=\"black\">
    <meta name=\"apple-mobile-web-app-capable\" content=\"yes\">
    <meta name=\"format-detection\" content=\"telephone=no\">
    <link rel=\"icon\" href=\"favicon.ico\">
    <link rel=\"stylesheet\" href=\"";
        // line 14
        echo ($context["data_path"] ?? null);
        echo "/layui/css/layui.css\" media=\"all\" />
    <link rel=\"stylesheet\" href=\"";
        // line 15
        echo ($context["data_path"] ?? null);
        echo "/css/index.css\" media=\"all\" />
</head>
<body class=\"main_body\">

";
        // line 20
        echo " ";
        echo twig_get_attribute($this->env, $this->source, ($context["ace"] ?? null), "handle", array(0 => "a_if_login", 1 => ($context["request"] ?? null), 2 => ($context["response"] ?? null)), "method");
        echo "
<div class=\"layui-layout layui-layout-admin\">
    <!-- 顶部 -->
    <div class=\"layui-header header\">
        <div class=\"layui-main mag0\">
            <a href=\"#\" class=\"logo\">Aceberg</a>
            <!-- 显示/隐藏菜单 -->
            <a href=\"javascript:;\" class=\"seraph hideMenu icon-caidan\"></a>
            <!-- 顶级菜单 -->
            <ul class=\"layui-nav mobileTopLevelMenus\" mobile>
                <li class=\"layui-nav-item\" data-menu=\"contentManagement\">
                    <a href=\"javascript:;\"><i class=\"seraph icon-caidan\"></i><cite>layuiCMS</cite></a>
                    <dl class=\"layui-nav-child\">
                        <dd class=\"layui-this\" data-menu=\"contentManagement\"><a href=\"javascript:;\"><i class=\"layui-icon\" data-icon=\"&#xe63c;\">&#xe63c;</i><cite>内容管理</cite></a></dd>
                        <dd data-menu=\"memberCenter\"><a href=\"javascript:;\"><i class=\"seraph icon-icon10\" data-icon=\"icon-icon10\"></i><cite>用户中心</cite></a></dd>
                        <dd data-menu=\"systemeSttings\"><a href=\"javascript:;\"><i class=\"layui-icon\" data-icon=\"&#xe620;\">&#xe620;</i><cite>系统设置</cite></a></dd>
                        <dd data-menu=\"seraphApi\"><a href=\"javascript:;\"><i class=\"layui-icon\" data-icon=\"&#xe705;\">&#xe705;</i><cite>使用文档</cite></a></dd>
                    </dl>
                </li>
            </ul>
            <ul class=\"layui-nav topLevelMenus\" pc>
                <li class=\"layui-nav-item layui-this\" data-menu=\"contentManagement\">
                    <a href=\"javascript:;\"><i class=\"layui-icon\" data-icon=\"&#xe63c;\">&#xe63c;</i><cite>内容管理</cite></a>
                </li>
                <li class=\"layui-nav-item\" data-menu=\"memberCenter\" pc>
                    <a href=\"javascript:;\"><i class=\"seraph icon-icon10\" data-icon=\"icon-icon10\"></i><cite>用户中心</cite></a>
                </li>
                <li class=\"layui-nav-item\" data-menu=\"systemeSttings\" pc>
                    <a href=\"javascript:;\"><i class=\"layui-icon\" data-icon=\"&#xe620;\">&#xe620;</i><cite>系统设置</cite></a>
                </li>

                <li class=\"layui-nav-item\" data-menu=\"seraphApi\" pc>
                    <a href=\"javascript:;\"><i class=\"layui-icon\" data-icon=\"&#xe705;\">&#xe705;</i><cite> 使用文档</cite></a>
                </li>

            </ul>
            <!-- 顶部右侧菜单 -->
            <ul class=\"layui-nav top_menu\">
                <li class=\"layui-nav-item\" pc>
                    <a href=\"javascript:;\" class=\"clearCache\"><i class=\"layui-icon\" data-icon=\"&#xe640;\">&#xe640;</i><cite>清除缓存</cite><span class=\"layui-badge-dot\"></span></a>
                </li>
                <li class=\"layui-nav-item lockcms\" pc>
                    <a href=\"javascript:;\"><i class=\"seraph icon-lock\"></i><cite>锁屏</cite></a>
                </li>
                <li class=\"layui-nav-item\" id=\"userInfo\">
                    <a href=\"javascript:;\"><img src=\"";
        // line 65
        echo ($context["data_path"] ?? null);
        echo "/images/face.jpg\" class=\"layui-nav-img userAvatar\" width=\"35\" height=\"35\"><cite class=\"adminName\">驊驊龔頾</cite></a>
                    <dl class=\"layui-nav-child\">
                        <dd><a href=\"javascript:;\" data-url=\"page/user/userInfo.html\"><i class=\"seraph icon-ziliao\" data-icon=\"icon-ziliao\"></i><cite>个人资料</cite></a></dd>
                        <dd><a href=\"javascript:;\" data-url=\"page/user/changePwd.html\"><i class=\"seraph icon-xiugai\" data-icon=\"icon-xiugai\"></i><cite>修改密码</cite></a></dd>
                        <dd><a href=\"javascript:;\" class=\"showNotice\"><i class=\"layui-icon\">&#xe645;</i><cite>系统公告</cite><span class=\"layui-badge-dot\"></span></a></dd>
                        <dd pc><a href=\"javascript:;\" class=\"functionSetting\"><i class=\"layui-icon\">&#xe620;</i><cite>功能设定</cite><span class=\"layui-badge-dot\"></span></a></dd>
                        <dd pc><a href=\"javascript:;\" class=\"changeSkin\"><i class=\"layui-icon\">&#xe61b;</i><cite>更换皮肤</cite></a></dd>
                        <dd><a href=\"page/login/login.html\" class=\"signOut\"><i class=\"seraph icon-tuichu\"></i><cite>退出</cite></a></dd>
                    </dl>
                </li>
            </ul>
        </div>
    </div>
    <!-- 左侧导航 -->
    <div class=\"layui-side layui-bg-black\">
        <div class=\"user-photo\">
            <a class=\"img\" title=\"我的头像\" ><img src=\"";
        // line 81
        echo ($context["data_path"] ?? null);
        echo "/images/face.jpg\" class=\"userAvatar\"></a>
            <p>你好！<span class=\"userName\">驊驊龔頾</span>, 欢迎登录</p>
        </div>
        <!-- 搜索 -->
        <div class=\"layui-form component\">
            <select name=\"search\" id=\"search\" lay-search lay-filter=\"searchPage\">
                <option value=\"\">搜索页面或功能</option>
                <option value=\"1\">layer</option>
                <option value=\"2\">form</option>
            </select>
            <i class=\"layui-icon\">&#xe615;</i>
        </div>
        <div class=\"navBar layui-side-scroll\" id=\"navBar\">
            <ul class=\"layui-nav layui-nav-tree\">
                <li class=\"layui-nav-item layui-this\">
                    <a href=\"javascript:;\" data-url=\"/p.a_AdminManager.main\"><i class=\"layui-icon\" data-icon=\"\"></i><cite>后台首页</cite></a>
                </li>
            </ul>
        </div>
    </div>
    <!-- 右侧内容 -->
    <div class=\"layui-body layui-form\">
        <div class=\"layui-tab mag0\" lay-filter=\"bodyTab\" id=\"top_tabs_box\">
            <ul class=\"layui-tab-title top_tab\" id=\"top_tabs\">
                <li class=\"layui-this\" lay-id=\"\"><i class=\"layui-icon\">&#xe68e;</i> <cite>后台首页</cite></li>
            </ul>
            <ul class=\"layui-nav closeBox\">
                <li class=\"layui-nav-item\">
                    <a href=\"javascript:;\"><i class=\"layui-icon caozuo\">&#xe643;</i> 页面操作</a>
                    <dl class=\"layui-nav-child\">
                        <dd><a href=\"javascript:;\" class=\"refresh refreshThis\"><i class=\"layui-icon\">&#x1002;</i> 刷新当前</a></dd>
                        <dd><a href=\"javascript:;\" class=\"closePageOther\"><i class=\"seraph icon-prohibit\"></i> 关闭其他</a></dd>
                        <dd><a href=\"javascript:;\" class=\"closePageAll\"><i class=\"seraph icon-guanbi\"></i> 关闭全部</a></dd>
                    </dl>
                </li>
            </ul>
            <div class=\"layui-tab-content clildFrame\">
                <div class=\"layui-tab-item layui-show\">
                    <iframe src=\"/p.a_AdminManager.main\"></iframe>
                </div>
            </div>
        </div>
    </div>
    <!-- 底部 -->
    <div class=\"layui-footer footer\">
        <p><span>copyright @2018 驊驊龔頾</span>　　<a onclick=\"donation()\" class=\"layui-btn layui-btn-danger layui-btn-sm\">捐赠作者</a></p>
    </div>
</div>

<!-- 移动导航 -->
<div class=\"site-tree-mobile\"><i class=\"layui-icon\">&#xe602;</i></div>
<div class=\"site-mobile-shade\"></div>

<script type=\"text/javascript\" src=\"";
        // line 134
        echo ($context["data_path"] ?? null);
        echo "/layui/layui.js\"></script>
<script type=\"text/javascript\" src=\"";
        // line 135
        echo ($context["data_path"] ?? null);
        echo "/js/index.js\"></script>
<script type=\"text/javascript\" src=\"";
        // line 136
        echo ($context["data_path"] ?? null);
        echo "/js/cache.js\"></script>

<script>
    var a = '";
        // line 139
        echo ($context["tags"] ?? null);
        echo "'
</script>

</body>
</html>";
    }

    public function getTemplateName()
    {
        return "plugins/a/AdminManager/html/index.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  187 => 139,  181 => 136,  177 => 135,  173 => 134,  117 => 81,  98 => 65,  49 => 20,  42 => 15,  38 => 14,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!DOCTYPE html>
<html>
<head>
    <meta charset=\"utf-8\">
    <title>layui后台管理模板 2.0</title>
    <meta name=\"renderer\" content=\"webkit\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge,chrome=1\">
    <meta http-equiv=\"Access-Control-Allow-Origin\" content=\"*\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1\">
    <meta name=\"apple-mobile-web-app-status-bar-style\" content=\"black\">
    <meta name=\"apple-mobile-web-app-capable\" content=\"yes\">
    <meta name=\"format-detection\" content=\"telephone=no\">
    <link rel=\"icon\" href=\"favicon.ico\">
    <link rel=\"stylesheet\" href=\"{{data_path}}/layui/css/layui.css\" media=\"all\" />
    <link rel=\"stylesheet\" href=\"{{data_path}}/css/index.css\" media=\"all\" />
</head>
<body class=\"main_body\">

{#判断是否登录，未登录，跳转到登录页 #}
 {{ ace.handle('a_if_login',request,response) }}
<div class=\"layui-layout layui-layout-admin\">
    <!-- 顶部 -->
    <div class=\"layui-header header\">
        <div class=\"layui-main mag0\">
            <a href=\"#\" class=\"logo\">Aceberg</a>
            <!-- 显示/隐藏菜单 -->
            <a href=\"javascript:;\" class=\"seraph hideMenu icon-caidan\"></a>
            <!-- 顶级菜单 -->
            <ul class=\"layui-nav mobileTopLevelMenus\" mobile>
                <li class=\"layui-nav-item\" data-menu=\"contentManagement\">
                    <a href=\"javascript:;\"><i class=\"seraph icon-caidan\"></i><cite>layuiCMS</cite></a>
                    <dl class=\"layui-nav-child\">
                        <dd class=\"layui-this\" data-menu=\"contentManagement\"><a href=\"javascript:;\"><i class=\"layui-icon\" data-icon=\"&#xe63c;\">&#xe63c;</i><cite>内容管理</cite></a></dd>
                        <dd data-menu=\"memberCenter\"><a href=\"javascript:;\"><i class=\"seraph icon-icon10\" data-icon=\"icon-icon10\"></i><cite>用户中心</cite></a></dd>
                        <dd data-menu=\"systemeSttings\"><a href=\"javascript:;\"><i class=\"layui-icon\" data-icon=\"&#xe620;\">&#xe620;</i><cite>系统设置</cite></a></dd>
                        <dd data-menu=\"seraphApi\"><a href=\"javascript:;\"><i class=\"layui-icon\" data-icon=\"&#xe705;\">&#xe705;</i><cite>使用文档</cite></a></dd>
                    </dl>
                </li>
            </ul>
            <ul class=\"layui-nav topLevelMenus\" pc>
                <li class=\"layui-nav-item layui-this\" data-menu=\"contentManagement\">
                    <a href=\"javascript:;\"><i class=\"layui-icon\" data-icon=\"&#xe63c;\">&#xe63c;</i><cite>内容管理</cite></a>
                </li>
                <li class=\"layui-nav-item\" data-menu=\"memberCenter\" pc>
                    <a href=\"javascript:;\"><i class=\"seraph icon-icon10\" data-icon=\"icon-icon10\"></i><cite>用户中心</cite></a>
                </li>
                <li class=\"layui-nav-item\" data-menu=\"systemeSttings\" pc>
                    <a href=\"javascript:;\"><i class=\"layui-icon\" data-icon=\"&#xe620;\">&#xe620;</i><cite>系统设置</cite></a>
                </li>

                <li class=\"layui-nav-item\" data-menu=\"seraphApi\" pc>
                    <a href=\"javascript:;\"><i class=\"layui-icon\" data-icon=\"&#xe705;\">&#xe705;</i><cite> 使用文档</cite></a>
                </li>

            </ul>
            <!-- 顶部右侧菜单 -->
            <ul class=\"layui-nav top_menu\">
                <li class=\"layui-nav-item\" pc>
                    <a href=\"javascript:;\" class=\"clearCache\"><i class=\"layui-icon\" data-icon=\"&#xe640;\">&#xe640;</i><cite>清除缓存</cite><span class=\"layui-badge-dot\"></span></a>
                </li>
                <li class=\"layui-nav-item lockcms\" pc>
                    <a href=\"javascript:;\"><i class=\"seraph icon-lock\"></i><cite>锁屏</cite></a>
                </li>
                <li class=\"layui-nav-item\" id=\"userInfo\">
                    <a href=\"javascript:;\"><img src=\"{{data_path}}/images/face.jpg\" class=\"layui-nav-img userAvatar\" width=\"35\" height=\"35\"><cite class=\"adminName\">驊驊龔頾</cite></a>
                    <dl class=\"layui-nav-child\">
                        <dd><a href=\"javascript:;\" data-url=\"page/user/userInfo.html\"><i class=\"seraph icon-ziliao\" data-icon=\"icon-ziliao\"></i><cite>个人资料</cite></a></dd>
                        <dd><a href=\"javascript:;\" data-url=\"page/user/changePwd.html\"><i class=\"seraph icon-xiugai\" data-icon=\"icon-xiugai\"></i><cite>修改密码</cite></a></dd>
                        <dd><a href=\"javascript:;\" class=\"showNotice\"><i class=\"layui-icon\">&#xe645;</i><cite>系统公告</cite><span class=\"layui-badge-dot\"></span></a></dd>
                        <dd pc><a href=\"javascript:;\" class=\"functionSetting\"><i class=\"layui-icon\">&#xe620;</i><cite>功能设定</cite><span class=\"layui-badge-dot\"></span></a></dd>
                        <dd pc><a href=\"javascript:;\" class=\"changeSkin\"><i class=\"layui-icon\">&#xe61b;</i><cite>更换皮肤</cite></a></dd>
                        <dd><a href=\"page/login/login.html\" class=\"signOut\"><i class=\"seraph icon-tuichu\"></i><cite>退出</cite></a></dd>
                    </dl>
                </li>
            </ul>
        </div>
    </div>
    <!-- 左侧导航 -->
    <div class=\"layui-side layui-bg-black\">
        <div class=\"user-photo\">
            <a class=\"img\" title=\"我的头像\" ><img src=\"{{data_path}}/images/face.jpg\" class=\"userAvatar\"></a>
            <p>你好！<span class=\"userName\">驊驊龔頾</span>, 欢迎登录</p>
        </div>
        <!-- 搜索 -->
        <div class=\"layui-form component\">
            <select name=\"search\" id=\"search\" lay-search lay-filter=\"searchPage\">
                <option value=\"\">搜索页面或功能</option>
                <option value=\"1\">layer</option>
                <option value=\"2\">form</option>
            </select>
            <i class=\"layui-icon\">&#xe615;</i>
        </div>
        <div class=\"navBar layui-side-scroll\" id=\"navBar\">
            <ul class=\"layui-nav layui-nav-tree\">
                <li class=\"layui-nav-item layui-this\">
                    <a href=\"javascript:;\" data-url=\"/p.a_AdminManager.main\"><i class=\"layui-icon\" data-icon=\"\"></i><cite>后台首页</cite></a>
                </li>
            </ul>
        </div>
    </div>
    <!-- 右侧内容 -->
    <div class=\"layui-body layui-form\">
        <div class=\"layui-tab mag0\" lay-filter=\"bodyTab\" id=\"top_tabs_box\">
            <ul class=\"layui-tab-title top_tab\" id=\"top_tabs\">
                <li class=\"layui-this\" lay-id=\"\"><i class=\"layui-icon\">&#xe68e;</i> <cite>后台首页</cite></li>
            </ul>
            <ul class=\"layui-nav closeBox\">
                <li class=\"layui-nav-item\">
                    <a href=\"javascript:;\"><i class=\"layui-icon caozuo\">&#xe643;</i> 页面操作</a>
                    <dl class=\"layui-nav-child\">
                        <dd><a href=\"javascript:;\" class=\"refresh refreshThis\"><i class=\"layui-icon\">&#x1002;</i> 刷新当前</a></dd>
                        <dd><a href=\"javascript:;\" class=\"closePageOther\"><i class=\"seraph icon-prohibit\"></i> 关闭其他</a></dd>
                        <dd><a href=\"javascript:;\" class=\"closePageAll\"><i class=\"seraph icon-guanbi\"></i> 关闭全部</a></dd>
                    </dl>
                </li>
            </ul>
            <div class=\"layui-tab-content clildFrame\">
                <div class=\"layui-tab-item layui-show\">
                    <iframe src=\"/p.a_AdminManager.main\"></iframe>
                </div>
            </div>
        </div>
    </div>
    <!-- 底部 -->
    <div class=\"layui-footer footer\">
        <p><span>copyright @2018 驊驊龔頾</span>　　<a onclick=\"donation()\" class=\"layui-btn layui-btn-danger layui-btn-sm\">捐赠作者</a></p>
    </div>
</div>

<!-- 移动导航 -->
<div class=\"site-tree-mobile\"><i class=\"layui-icon\">&#xe602;</i></div>
<div class=\"site-mobile-shade\"></div>

<script type=\"text/javascript\" src=\"{{data_path}}/layui/layui.js\"></script>
<script type=\"text/javascript\" src=\"{{data_path}}/js/index.js\"></script>
<script type=\"text/javascript\" src=\"{{data_path}}/js/cache.js\"></script>

<script>
    var a = '{{tags}}'
</script>

</body>
</html>", "plugins/a/AdminManager/html/index.html", "/var/www/Aceberg/ace/plugins/a/AdminManager/html/index.html");
    }
}
