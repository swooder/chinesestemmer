<?php

namespace Woodfish\Stemmer\Split;

use Woodfish\Stemmer\Analysis\ChineseAnalysis;

/**
 * php Split 主要接口提供
 *
 * @package phpSplit\Split
 */
class Split implements SplitInterface
{

    public $pa;

    public function __construct()
    {
        // $this->loadConfig();

        ChineseAnalysis::$loadInit = false;

        $this->pa = new ChineseAnalysis('utf-8', 'utf-8', false);
    }


    /**
     * 添加附加词
     *
     * @param array $words
     * @return void
     */
    public function attach(array $words = [])
    {
        $this->pa->setAttach($words);
    }

    /**
     * 开始分词
     *
     * @param string $word
     * @return array
     */
    public function start($word = '')
    {
        $this->pa->setSource($word);
        $this->pa->startAnalysis(true);

        $getInfo = true;
        $sign    = '-';
        $result  = $this->pa->getFinallyResult($sign, $getInfo);
        $result  = explode($sign, $result);
        $result  = array_filter($result, function ($var) {
            return !empty($var);
        });

        return $result;
    }

    /**
     * 简单分词方法
     *
     * @param string $string
     * @return array
     */
    public function simple($string = '')
    {
        $this->pa->setSource($string);
        $this->pa->startAnalysis(true);

        $getInfo = true;
        $sign    = '-';
        $result  = $this->pa->getFinallyResult($sign, $getInfo);
        $result  = explode($sign, $result);
        $result  = array_filter($result, function ($var) {
            return !empty($var);
        });

        return array_map(function ($word) {
            $word = explode('/', $word);

            return $word[0];
        }, $result);
    }

    /**
     * load config
     *
     * @return bool
     */
    public static function loadConfig()
    {
        $files = [__DIR__ . '/Config.php',];

        foreach ($files as $file) {
            if (is_file($file)) {
                require_once($file);

                return true;
            }
        }

        return false;
    }
}

?>
