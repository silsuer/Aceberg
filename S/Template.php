<?php
/**
 * Created by PhpStorm.
 * User: silsuer
 * Date: 2018/4/23
 * Time: 17:47
 */

namespace S;

// 用来扩展twig的模版，当加载的时候，自动扫描全局，添加扫描到的所有扩展
use Ace\tags\a\getInfo\getDoc;
use App\GlobalObj;

class Template
{
    // 所有环境中都将加载所有扫描到的扩展
    public $themeEnv;  // 主题环境
    public $pluginEnv;  // 插件环境
    public $modelEnv;   // 模型环境
    public $commonEnv; // 通用环境

    // 树上挂着的是一个数组 包括路径和命名控件

    public static $componentsTree = [];  // 组件树
    public static $tagsTree = []; // 标签树 数组
    public static $macroTree = []; // 宏树  数组
    public static $pluginsTree = []; // 插件树 数组
    public static $modelsTree = []; // 模型树  数组
    public static $themesTree = []; // 主题树  数组

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
            'debug' => C('TWIG_DEBUG'),
            'charset' => C('TWIG_CHARSET'),
//            'cache' => root_path() . C('TWIG_CACHE'),
            'auto_reload' => C('TWIG_AUTO_RELOAD'),
            'strict_variables' => C('TWIG_STRICT_VARIABLES'),
            'autoescape' => C('TWIG_AUTOESCAPE'),
            'optimizations' => C('TWIG_OPTIMIZATIONS')
        ];

        // 建立模版环境
        $commonLoader = new \Twig_Loader_Filesystem(root_path() . '/ace');
        $this->commonEnv = new \Twig_Environment($commonLoader, $config);
        $this->commonEnv->addGlobal('ace', new GlobalObj());

        // 向环境中添加扩展

        // 调试模式，添加调试扩展
        if(C('TWIG_DEBUG')){
          $this->commonEnv->addExtension(new \Twig_Extension_Debug());
        }

    }

    public static function parseUrl(\swoole_http_request $request,\swoole_http_response $response)
    {
        // 解析uri看看是否符合 p/m.name.temp 规则，符合按照规则解析，否则去主题中寻找，如果主题中找不到，返回主题404页面
        $arr = explode('.', trim($request->server['request_uri'], '/'));
        if (count($arr) == 3 && ($arr[0] == 'm' || $arr[0] == 'p' || $arr[0] == 't' || $arr[0] == 'c')) {  // 有效访问路径
            switch ($arr[0]) {
                case 'm':
                    self::modelLoad($arr[1], $arr[2], $request, $response);
                    break;
                case 'p':
                    self::pluginLoad($arr[1], $arr[2], $request, $response);
                    break;
                case 't':
                    self::themeLoad($arr[1], $arr[2], $request, $response);
                    break;
                case 'c':
                    self::handleComponent($arr[1], $arr[2], $request, $response);
                    break;
                default:
                    break;
            }
        } else {
            // 去主题文件夹中寻找
            // TODO 判断主题文件夹下是否有这个文件，如果有，加载，否则，判断是否有静态文件
            if (false) {
                $url = trim($request->server['request_uri'], '/');
                self::themeLoad("default", $url, $request, $response);
            } else {
                // css js images 资源文件，根据不同类型，设置响应头
//                echo r . $request->server['request_uri'] . "\n";
                $contentType = '';
                $arr = explode('.', $request->server['request_uri']);
                $ext = $arr[count($arr) - 1];
                $response->header('Content-Type',self::getContentType($ext));
                if (file_exists(ace_path() . $request->server['request_uri'])) {
                    $response->end(file_get_contents(ace_path() . $request->server['request_uri']));
                } else if (file_exists(root_path() . '/data' . $request->server['request_uri'])) {
                    $response->end(file_get_contents(root_path() . '/data' . $request->server['request_uri']));
                }
            }
        }
    }

    private static function getContentType($ext)
    {
        $type = '';
        switch ($ext) {
            case 'css':
                $type = 'text/css';
                break;
            case 'js':
                $type = 'text/javascript';
                break;
            case 'jpg':
                $type = 'image/jpeg';
                break;
            case 'png':
                $type = 'image/png';
                break;
            default:
                break;
        }
        return $type;
    }

    // 主题加载器
    public static function themeLoad($themeName, $page, $req, $res)
    {
        if (!array_key_exists($themeName, self::$themesTree)) {  // 如果不存在模版
            $res->end("not found $themeName theme");
            return;
        }
        // 初始化需要的数据，然后渲染模版
        $twig = temp()->commonEnv;
        $data = [
            'request' => $req,
            'response' => $res,
            'data_path' => '/data',
            'current_path' => '/' . self::$themesTree[$themeName]['path'] . '/html'
        ];

        $res->end($twig->loadTemplate(self::$themesTree[$themeName]['path'] . '/html/' . $page . '.html')->render($data));
    }

    // 插件加载器
    public
    static function pluginLoad($pluginName, $page, $req, $res)
    {
        if (!array_key_exists($pluginName, self::$pluginsTree)) {  // 如果不存在模版
            $res->end("not found $pluginName plugins");
            return;
        }
        // 初始化需要的数据，然后渲染模版
        $twig = temp()->commonEnv;
        $data = [
            'request' => $req,  // 请求
            'response' => $res,  // 响应
            'data_path' => '/data',   // data路径
            'current_path' => '/' . self::$pluginsTree[$pluginName]['path'] . '/html'  // 当前路径
        ];

        $res->end($twig->loadTemplate(self::$pluginsTree[$pluginName]['path'] . '/html/' . $page . '.html')->render($data));
    }

    // 模型加载器
    public static function modelLoad($modelName, $page, $req, $res)
    {
        if (!array_key_exists($modelName, self::$modelsTree)) {  // 如果不存在模版
            $res->end("not found $modelName plugins");
            return;
        }
        // 初始化需要的数据，然后渲染模版
        $twig = temp()->commonEnv;
        $data = [
            'request' => $req,  // 请求
            'response' => $res,  // 响应
            'data_path' => '/data',   // data路径
            'current_path' =>  '/' . self::$modelsTree[$modelName]['path'] . '/html'  // 当前路径
        ];

        $res->end($twig->loadTemplate(self::$modelsTree[$modelName]['path'] . '/html/' . $page . '.html')->render($data));

    }

// 应用启动时执行，构建整个组件树、标签数组、宏数组、插件数组、模型数组、主题数组
    public static function organizeTree()
    {
        // 扫描ace下的几个文件夹，根据文件夹路径生成数组
//        $tree['a_AdminManager'] = 'plugins/a/AdminManager/html/'. 'index.html';  生成一个这样的数组
        $temp = temp()->getInstance();
        $path = root_path() . '/ace/';
        $compoentsPath = $path . 'components';
        $macroPath = $path . 'macro';
        $modelsPath = $path . 'models';
        $pluginsPath = $path . 'plugins';
        $tagsPath = $path . 'tags';
        $themesPath = $path . 'themes';
        self::setTree($pluginsPath, 'pluginsTree', 'plugins'); // 第三个参数是ace目录下一级目录
        self::setTree($compoentsPath, 'componentsTree', 'components');
        self::setTree($macroPath, 'macroTree', 'macro');
        self::setTree($modelsPath, 'modelsTree', 'models');
        self::setTree($tagsPath, 'tagsTree', 'tags');
        self::setTree($themesPath, 'themesTree', 'themes');
        // TODO 检测依赖是否都存在
    }

    private
    static function setTree($path, $variable, $dir)
    {
        $dirs = scandir($path);
        foreach ($dirs as $username) {  // 第二层是用户名，下面是用户定义的项目名
            if ($username == '.' || $username == '..') continue;
            $projectDirs = scandir($path . '/' . $username);
            foreach ($projectDirs as $pdir) {
                if ($pdir == '.' || $pdir == '..') continue;
                self::$$variable[$username . '_' . $pdir]['path'] = $dir . '/' . $username . '/' . $pdir;
                $desPath = $path . '/' . $username . '/' . $pdir . '/description.json';
//                echo $desPath;
                if (file_exists($desPath)) {
                    $des = json_decode(file_get_contents($desPath), true);
                    if (!is_null($des) && array_key_exists('namespace', $des)) {
                        self::$$variable[$username . '_' . $pdir]['namespace'] = $des['namespace'];
                    }

                    // 判断是否写了文档,如果没写的话，停止运行，组件和标记必须写文档，宏，模型模块无所谓
                    if ($dir == 'components' || $dir == 'tags') {
                        if (C('DOC_STRICT') == 1) {
                            $phpPath = $path . '/' . $username . '/' . $pdir . '/' . $pdir . '.php';
                            $content = file_get_contents($phpPath);
                            $role = "/(\/\*)\s+(@doc)((.*\n)*?.*?)?(\*\/)/s";
                            preg_match_all($role, $content, $mattches);
                            if (empty($mattches[0])) {
                                echo "\n" . $username . '/' . $pdir . '的文档不完整，请补充文档后再次运行，或者将 .env文件的 DOC_STRICT 项设置为0' . "\n";
                                die();
                            }

                        }
                    }


                } else {
                    echo "\n" . self::$$variable[$username . '_' . $pdir]['path'] . '的描述文件不存在！';
                }
            }
        }
    }

    public
    static function handleComponent($componentName, $handle = 'handle', $request, $response)
    {
        // 执行组件代码
        if (array_key_exists($componentName, self::$componentsTree) && array_key_exists('namespace', self::$componentsTree[$componentName])) {
            $comp = new self::$componentsTree[$componentName]['namespace']();
//            print_r(self::$componentsTree);
            $comp->{$handle}($request, $response);
        }
    }

}