<?php
/**
 * Created by PhpStorm.
 * User: silsuer
 * Date: 2018/4/27
 * Time: 3:50
 */

namespace Ace\tags\a\getDoc;


use S\Template;

class getDoc
{

    /* @doc
     * @name: view
     * @require: 空
     * @response: 返回全部模型、主题、插件、组件、标记、宏列表
     * @description: 用于/doc.html获取项目文档时，生成所有文档信息，并返回
     * @demo: {% set info = ace.tag('a_getDoc') %}
     * @return;
     * @more: http://doc.aceberg.org
     */
    public function view($arr = null)
    {
        $data = [];
        $data['models'] = [];
        // 模型
        foreach (Template::$modelsTree as $k => $v) {
            // 名称 路径 命名空间 描述 依赖插件（插件描述） 依赖组件（组件描述） 依赖标记（标记描述） 依赖宏（宏描述）
            $data['models'][$k] = $this->getInfo($k, 'modelsTree');
        }
        // 主题
        foreach (Template::$themesTree as $k => $v) {
            // 名称 路径 命名空间 描述 依赖模型(模型描述) 依赖插件（插件描述） 依赖组件（组件描述） 依赖标记（标记描述） 依赖宏（宏描述）
            $data['themes'][$k] = $this->getInfo($k, 'themesTree');
        }
        // 插件
        foreach (Template::$pluginsTree as $k => $v) {
            // 名称 路径 命名空间 描述 依赖插件（插件描述） 依赖组件（组件描述） 依赖标记（标记描述） 依赖宏（宏描述）
            $data['plugins'][$k] = $this->getInfo($k, 'pluginsTree');
        }
        // 组件
        foreach (Template::$componentsTree as $k => $v) {
            // 名称 路径 命名空间 描述 依赖组件（组件描述） 依赖标记（标记描述） 依赖宏（宏描述）
            $data['components'][$k] = $this->getInfo($k, 'componentsTree');
        }

        // 标记
        foreach (Template::$tagsTree as $k => $v) {
            // 名称 路径 命名空间 描述 依赖组件（组件描述） 依赖标记（标记描述） 依赖宏（宏描述）
            $data['tags'][$k] = $this->getInfo($k, 'tagsTree');
        }
        // 宏
        foreach (Template::$macroTree as $k => $v) {
            // 名称 路径 命名空间 描述 依赖宏（宏描述）
            $data['macro'][$k] = $this->getInfo($k, 'macroTree');
        }
        return $data;
    }

    private function getInfo($nName, $tree)
    {  // a_ArticleContent
        // 名称 路径 版本 命名空间 描述 依赖插件（插件描述） 依赖组件（组件描述） 依赖标记（标记描述） 依赖宏（宏描述）
        $name = '';
        // 初始化数据
        $path = '';
        $namespace = '';
        $description = '';
        $version = '';
        $dep_models = [];
        $dep_plugins = [];
        $dep_components = [];
        $dep_tags = [];
        $dep_macro = [];
        $code = [];  // 如果是标记和组件，还要扫描数据
        $data = [];
        $path = Template::$$tree[$nName]['path'];
        $nameArr = explode('/', $path);
        unset($nameArr[0]);
        $name = join('/', $nameArr);  // a/ArticleContent
        if($tree=='tagsTree'||$tree=='componentsTree'){
            $phpPath = ace_path() . '/' . $path . '/' . $nameArr[count($nameArr)] . '.php';
            if(file_exists($phpPath)){
                $c = file_get_contents($phpPath);
                $role = "/(\/\*)\s+(@doc)((.*\n)*?.*?)?(\*\/)/s";
                preg_match_all($role,$c,$mattches);
                $code = $mattches[0];
            }
        }
        $desPath = ace_path() . '/' . $path . '/description.json';
        $des = json_decode(file_get_contents($desPath), true);
        if (array_key_exists('namespace', $des)) $namespace = $des['namespace'];
        if (array_key_exists('description', $des)) $description = $des['description'];
        if (array_key_exists('version', $des)) $version = $des['version'];
        if (array_key_exists('depends', $des)) {
            // 判断有没有依赖 模型，插件，组件，标记，宏
            if (array_key_exists('models', $des['depends'])) {
                // 获取模型基础信息 ，模型名和模型描述
                foreach ($des['depends']['models'] as $k => $v) {
                    $dep_models[] = $this->getSimpleInfo($k, 'models');
                }

            }
            if (array_key_exists('plugins', $des['depends'])) {
                foreach ($des['depends']['plugins'] as $k => $v) {
                    $dep_plugins[] = $this->getSimpleInfo($k, 'plugins');
                }
            }
            if (array_key_exists('components', $des['depends'])) {
                foreach ($des['depends']['components'] as $k => $v) {
                    $dep_components[] = $this->getSimpleInfo($k, 'components');
                }
            }
            if (array_key_exists('tags', $des['depends'])) {
                foreach ($des['depends']['tags'] as $k => $v) {
                    $dep_tags[] = $this->getSimpleInfo($k, 'tags');
                }
            }
            if (array_key_exists('macro', $des['depends'])) {
                foreach ($des['depends']['macro'] as $k => $v) {
                    $dep_macro[] = $this->getSimpleInfo($k, 'macro');
                }
            }
        }

        $data = [
            'real_name' => $nName,
            'name' => $name,
            'path' => $path,
            'version' => $version,
            'namespace' => $namespace,
            'description' => $description,
            'dep_models' => $dep_models,
            'dep_plugins' => $dep_plugins,
            'dep_components' => $dep_components,
            'dep_tags' => $dep_tags,
            'dep_macro' => $dep_macro,
            'code'=>$code
        ];
        return $data;
    }


    // 传入模型名，返回模型名和模型描述
    private function getSimpleInfo($name, $type)  // type是models plugins等
    { // a/Article
        $description = '';
        $version = '';
        $real_name = join('_',explode('/',$name));
        $des = json_decode(file_get_contents(ace_path() . '/' . $type . '/' . $name . '/description.json'), true);
        if (array_key_exists('description', $des)) $description = $des['description'];
        if (array_key_exists('version', $des)) $version = $des['version'];
        return ['name' => $name, 'description' => $description,'real_name'=>$real_name, 'version' => $version];

    }
}