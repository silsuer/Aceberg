<?php
/**
 * Created by PhpStorm.
 * User: liuho
 * Date: 2018/4/23
 * Time: 17:47
 */

namespace S;

// 用来扩展twig的模版，当加载的时候，自动扫描全局，添加扫描到的所有扩展
class Template
{
    // 所有环境中都将加载所有扫描到的扩展
    public  $themeEnv;  // 主题环境
    public  $pluginEnv;  // 插件环境
    public  $modelEnv;   // 模型环境

    public static $componentsTree;  // 组件树
    public static $tagsTree; // 标签树 数组
    public static $macroTree; // 宏树  数组
    public static $pluginsTree; // 插件树 数组
    public static $modelsTree; // 模型树  数组
    public static $themesTree; // 主题树  数组

    private static $instance;


    public static function getInstance()
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    // 初始化环境
     public function __construct()
     {
         $config = [
             'debug'=>C('TWIG_DEBUG'),
             'charset'=>C('TWIG_CHARSET'),
             'cache'=> root_path() .C('TWIG_CACHE').'/themeCache',
             'auto_reload'=>C('TWIG_AUTO_RELOAD'),
             'strict_variables'=>C('TWIG_STRICT_VARIABLES'),
             'autoescape'=>C('TWIG_AUTOESCAPE'),
             'optimizations'=>C('TWIG_OPTIMIZATIONS')
         ];


         $themeLoader = new \Twig_Loader_Filesystem(root_path().'/ace/themes');
         $this->themeEnv = new \Twig_Environment($themeLoader,$config);

         $config['cache'] = root_path() .C('TWIG_CACHE').'/pluginCache';
         $pluginLoader = new \Twig_Loader_Filesystem(root_path().'/ace/plugins');
         $this->pluginEnv = new \Twig_Environment($pluginLoader,$config);

         $config['cache'] = root_path() .C('TWIG_CACHE').'/modelCache';
         $modelLoader = new \Twig_Loader_Filesystem(root_path().'/ace/models');
         $this->modelEnv = new \Twig_Environment($modelLoader,$config);
     }

    public static function parseUrl($request,$response){
      // 解析uri看看是否符合 p/m.name.temp 规则，符合按照规则解析，否则去主题中寻找，如果主题中找不到，返回主题404页面
        $arr = explode('.',trim($request->server['request_uri'],'/'));
        if(count($arr)==3&&($arr[0]=='m'||$arr[0]=='p'||$arr[0]=='t')){  // 有效访问路径
            switch ($arr[0]){
                case 'm':
                    self::modelLoad($arr[1],$arr[2],$request,$response);
                    break;
                case 'p':
                    self::pluginLoad($arr[1],$arr[2],$request,$response);
                    break;
                case 't':
                    self::themeLoad($arr[1],$arr[2],$request,$response);
                    break;
                default:
                    break;
            }
        }else{
            // 去主题文件夹中寻找
            $url = trim($request->server['request_uri'],'/');
            self::themeLoad("default",$url,$request,$response);
        }
    }

    public static function themeLoad($themeName,$page,$req,$res){

    }

    public static function pluginLoad($pluginName,$page,$req,$res){
        $twig = temp()->pluginEnv;
        // 初始化需要的数据，然后渲染模版
        $res->end($twig->loadTemplate($pluginName.'/html/'.$page.'.html')->render([]));
    }

    public static function modelLoad($modelName,$page,$req,$res){

    }

    // 应用启动时执行，构建整个组件树、标签数组、宏数组、插件数组、模型数组、主题数组
    public static function organizeTree(){

    }
}