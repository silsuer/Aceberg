<?php
/**
 * Created by PhpStorm.
 * User: silsuer
 * Date: 2018/4/26
 * Time: 16:58
 */

namespace App;


// 模版环境中加载的通用类
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use S\Template;

// 此处所有的方法都可以在页面中使用 {{ace.方法名}} 来调用
class GlobalObj
{

    public function handle($componentName, $req, $res, $arr = [])
    {
        if (array_key_exists($componentName, Template::$componentsTree) && array_key_exists('namespace', Template::$componentsTree[$componentName])) {
            $comp = new Template::$componentsTree[$componentName]['namespace']();
            $comp->handle($req, $res, $arr);
        }
    }

    public function makeCaptcha($req, $res, $length = 4, $weigh = 100, $height = 40)
    {
        // 生成验证码，第三个参数是验证码长度
        $phraseBuilder = new PhraseBuilder($length);
        $builder = new CaptchaBuilder(null, $phraseBuilder);
        $builder->build($width = 100, $height = 40);
        $phrase = $builder->getPhrase(); // 获取生成的字符串
        session($req, 'phrase', $phrase);  // 存入session
        return $builder->inline();  // 输出图片链接
    }

    // 根据传入的组件名，生成一个用于访问组件的url   /c.componentName.handle  组件名是类，handle是方法名
    public function makeUrl($componentName, $handle = 'handle',$arr = [])
    {
        if (array_key_exists($componentName, Template::$componentsTree) && array_key_exists('namespace', Template::$componentsTree[$componentName])) {
            // 存在这个组件
//            $comp = new Template::$componentsTree[$componentName]['namespace']();
            if(!empty($arr)){
                $params = [];
                foreach ($arr as $k => $v){
                    $params[] = $k.'='.$v;
                }
                // /c.name.handle?a=5&5=6
                return '/c.' . $componentName . '.' . $handle . '?' . join('&',$params);
            }else{
                return '/c.' . $componentName . '.' . $handle;
            }

        }
    }


    // 把字符串转为json对象
    public  function parseJson($string){
        return json_decode($string,true);
    }


    public function getContent($dir)
    {
        $path = root_path() . $dir;
        if (file_exists($path)) {
            return file_get_contents($path);
        }
        return "";
    }

    public function getArrayContent($dir)
    {
        $path = root_path() . $dir;
        if (file_exists($path)) {
            return json_decode(file_get_contents($path), true);
        }
        return "";
    }

    public function tag($tagName, $handle = 'view', $arr = null)
    {
        if (array_key_exists($tagName, Template::$tagsTree) && array_key_exists('namespace', Template::$tagsTree[$tagName])) {
            // 存在这个标签
            $tag = new Template::$tagsTree[$tagName]['namespace']();
            return $tag->$handle($arr);  // 执行标签的方法
        }
    }

    // 对数据explode的方法
    public function explode($delimiter, $string)
    {
        // twig模版默认会对传入的数据进行转码，此处要先进行解码
        $delimiter = html_entity_decode($delimiter);
        $string = html_entity_decode($string);
        return explode($delimiter, $string);
    }

    public function in_array($delimiter, $arr)
    {
        $delimiter = html_entity_decode($delimiter);
//        $string = html_entity_decode($string);
        return $this->in_array($delimiter, $arr);
    }
}