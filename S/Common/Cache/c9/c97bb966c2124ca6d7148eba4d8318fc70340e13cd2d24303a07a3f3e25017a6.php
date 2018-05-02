<?php

/* plugins/a/AdminManager/html/login.html */
class __TwigTemplate_09d78047a02bd99e358ac1bbd58d4f67e36ffdb30937996c9b687b7043269770 extends Twig_Template
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
<html class=\"loginHtml\">
<head>
    <meta charset=\"utf-8\">
    <title>登录</title>
    <meta name=\"renderer\" content=\"webkit\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge,chrome=1\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1\">
    <meta name=\"apple-mobile-web-app-status-bar-style\" content=\"black\">
    <meta name=\"apple-mobile-web-app-capable\" content=\"yes\">
    <meta name=\"format-detection\" content=\"telephone=no\">
    <link rel=\"icon\" href=\"";
        // line 12
        echo ($context["data_path"] ?? null);
        echo "/favicon.ico\">
    <link rel=\"stylesheet\" href=\"";
        // line 13
        echo ($context["data_path"] ?? null);
        echo "/layui/css/layui.css\" media=\"all\" />
    <link rel=\"stylesheet\" href=\"";
        // line 14
        echo ($context["data_path"] ?? null);
        echo "/css/public.css\" media=\"all\" />
</head>
<body class=\"loginBody\">
<form class=\"layui-form\">
    <div class=\"login_face\" ><img src=\"";
        // line 18
        echo ($context["data_path"] ?? null);
        echo "/images/face.jpg\" class=\"userAvatar\"></div>
    <div class=\"layui-form-item input-item\">
        <label for=\"userName\">用户名</label>
        <input type=\"text\" placeholder=\"请输入用户名\" autocomplete=\"off\" id=\"userName\" class=\"layui-input\" lay-verify=\"required\">
    </div>
    <div class=\"layui-form-item input-item\">
        <label for=\"password\">密码</label>
        <input type=\"password\" placeholder=\"请输入密码\" autocomplete=\"off\" id=\"password\" class=\"layui-input\" lay-verify=\"required\">
    </div>
    <div class=\"layui-form-item input-item\" id=\"imgCode\">
        <label for=\"code\">验证码</label>
        <input type=\"text\" placeholder=\"请输入验证码\" autocomplete=\"off\" id=\"code\" class=\"layui-input\">
        <img src=\"";
        // line 30
        echo twig_get_attribute($this->env, $this->source, ($context["ace"] ?? null), "makeCaptcha", array(0 => ($context["request"] ?? null), 1 => ($context["response"] ?? null), 2 => 5, 3 => 116, 4 => 36), "method");
        echo "\">
    </div>
    <div class=\"layui-form-item\">
        <button class=\"layui-btn layui-block\" lay-filter=\"login\" lay-submit>登录</button>
    </div>

</form>
<script type=\"text/javascript\" src=\"";
        // line 37
        echo ($context["data_path"] ?? null);
        echo "/layui/layui.js\"></script>
<!--<script type=\"text/javascript\" src=\"";
        // line 38
        echo ($context["data_path"] ?? null);
        echo "/js/login.js\"></script>-->
<script type=\"text/javascript\" src=\"";
        // line 39
        echo ($context["data_path"] ?? null);
        echo "/js/cache.js\"></script>
<script>
    layui.use(['form','layer','jquery'],function(){
        var form = layui.form,
            layer = parent.layer === undefined ? layui.layer : top.layer
        \$ = layui.jquery;

        //登录按钮
        form.on(\"submit(login)\",function(data){
            // \$(this).text(\"登录中...\").attr(\"disabled\",\"disabled\").addClass(\"layui-disabled\");

            // 与后端交互
            var d = {};
            d.name = \$('#userName').val();
            d.password = \$('#password').val();
            d.phrase = \$(\"#code\").val();
            \$.post('";
        // line 55
        echo twig_get_attribute($this->env, $this->source, ($context["ace"] ?? null), "makeUrl", array(0 => "a_admin_login"), "method");
        echo "',d,function (d) {
                d = JSON.parse(d);
               // 向后端传送
               if(d.info!=\"success\"){
                   layer.msg(d.info);
                   \$(this).removeAttribute(\"disabled\").removeClass(\"layui-disabled\")
               }else{
                   setTimeout(function(){
                       layer.msg(\"登录成功！\",{icon:6});
                       window.location.href = \"/p.a_AdminManager.index\";
                   },1000);
               }
            })

            // setTimeout(function(){
            //     window.location.href = \"/layuicms2.0\";
            // },1000);
            return false;
        })

        //表单输入效果
        \$(\".loginBody .input-item\").click(function(e){
            e.stopPropagation();
            \$(this).addClass(\"layui-input-focus\").find(\".layui-input\").focus();
        })
        \$(\".loginBody .layui-form-item .layui-input\").focus(function(){
            \$(this).parent().addClass(\"layui-input-focus\");
        })
        \$(\".loginBody .layui-form-item .layui-input\").blur(function(){
            \$(this).parent().removeClass(\"layui-input-focus\");
            if(\$(this).val() != ''){
                \$(this).parent().addClass(\"layui-input-active\");
            }else{
                \$(this).parent().removeClass(\"layui-input-active\");
            }
        })
    })

</script>
</body>
</html>";
    }

    public function getTemplateName()
    {
        return "plugins/a/AdminManager/html/login.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  103 => 55,  84 => 39,  80 => 38,  76 => 37,  66 => 30,  51 => 18,  44 => 14,  40 => 13,  36 => 12,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!DOCTYPE html>
<html class=\"loginHtml\">
<head>
    <meta charset=\"utf-8\">
    <title>登录</title>
    <meta name=\"renderer\" content=\"webkit\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge,chrome=1\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1\">
    <meta name=\"apple-mobile-web-app-status-bar-style\" content=\"black\">
    <meta name=\"apple-mobile-web-app-capable\" content=\"yes\">
    <meta name=\"format-detection\" content=\"telephone=no\">
    <link rel=\"icon\" href=\"{{data_path}}/favicon.ico\">
    <link rel=\"stylesheet\" href=\"{{data_path}}/layui/css/layui.css\" media=\"all\" />
    <link rel=\"stylesheet\" href=\"{{data_path}}/css/public.css\" media=\"all\" />
</head>
<body class=\"loginBody\">
<form class=\"layui-form\">
    <div class=\"login_face\" ><img src=\"{{data_path}}/images/face.jpg\" class=\"userAvatar\"></div>
    <div class=\"layui-form-item input-item\">
        <label for=\"userName\">用户名</label>
        <input type=\"text\" placeholder=\"请输入用户名\" autocomplete=\"off\" id=\"userName\" class=\"layui-input\" lay-verify=\"required\">
    </div>
    <div class=\"layui-form-item input-item\">
        <label for=\"password\">密码</label>
        <input type=\"password\" placeholder=\"请输入密码\" autocomplete=\"off\" id=\"password\" class=\"layui-input\" lay-verify=\"required\">
    </div>
    <div class=\"layui-form-item input-item\" id=\"imgCode\">
        <label for=\"code\">验证码</label>
        <input type=\"text\" placeholder=\"请输入验证码\" autocomplete=\"off\" id=\"code\" class=\"layui-input\">
        <img src=\"{{ ace.makeCaptcha(request,response,5,116,36)}}\">
    </div>
    <div class=\"layui-form-item\">
        <button class=\"layui-btn layui-block\" lay-filter=\"login\" lay-submit>登录</button>
    </div>

</form>
<script type=\"text/javascript\" src=\"{{data_path}}/layui/layui.js\"></script>
<!--<script type=\"text/javascript\" src=\"{{data_path}}/js/login.js\"></script>-->
<script type=\"text/javascript\" src=\"{{data_path}}/js/cache.js\"></script>
<script>
    layui.use(['form','layer','jquery'],function(){
        var form = layui.form,
            layer = parent.layer === undefined ? layui.layer : top.layer
        \$ = layui.jquery;

        //登录按钮
        form.on(\"submit(login)\",function(data){
            // \$(this).text(\"登录中...\").attr(\"disabled\",\"disabled\").addClass(\"layui-disabled\");

            // 与后端交互
            var d = {};
            d.name = \$('#userName').val();
            d.password = \$('#password').val();
            d.phrase = \$(\"#code\").val();
            \$.post('{{ace.makeUrl('a_admin_login')}}',d,function (d) {
                d = JSON.parse(d);
               // 向后端传送
               if(d.info!=\"success\"){
                   layer.msg(d.info);
                   \$(this).removeAttribute(\"disabled\").removeClass(\"layui-disabled\")
               }else{
                   setTimeout(function(){
                       layer.msg(\"登录成功！\",{icon:6});
                       window.location.href = \"/p.a_AdminManager.index\";
                   },1000);
               }
            })

            // setTimeout(function(){
            //     window.location.href = \"/layuicms2.0\";
            // },1000);
            return false;
        })

        //表单输入效果
        \$(\".loginBody .input-item\").click(function(e){
            e.stopPropagation();
            \$(this).addClass(\"layui-input-focus\").find(\".layui-input\").focus();
        })
        \$(\".loginBody .layui-form-item .layui-input\").focus(function(){
            \$(this).parent().addClass(\"layui-input-focus\");
        })
        \$(\".loginBody .layui-form-item .layui-input\").blur(function(){
            \$(this).parent().removeClass(\"layui-input-focus\");
            if(\$(this).val() != ''){
                \$(this).parent().addClass(\"layui-input-active\");
            }else{
                \$(this).parent().removeClass(\"layui-input-active\");
            }
        })
    })

</script>
</body>
</html>", "plugins/a/AdminManager/html/login.html", "/var/www/Aceberg/ace/plugins/a/AdminManager/html/login.html");
    }
}
