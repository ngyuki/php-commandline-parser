<?php
namespace ngyuki\CommandLineParser;

class CommandLineParser
{
    public function parse($cmdline)
    {
        $patterns = array();

        // ダブルクオート
        $patterns[] = '(?:("(?:\\\\"|[^"])*)"?)';

        // シングルクオート
        $patterns[] = "(?:('[^']*)'?)";

        // スペース または 終端
        $patterns[] = '(\s+|\\\\$|$)';

        // その他の文字 または バックスラッシュ＋文字
        $patterns[] = '((?:\\\\.|[^\s\'"])+)';

        $patterns = implode('|', $patterns);

        $arg = null;
        $args = array();

        $cmdline = trim($cmdline);

        $cmdline = preg_replace_callback("/(?:$patterns)/", function ($m) use (&$args, &$arg){

            list (, $dq, $sq, , $ch) = $m + array_fill(0, 5, null);

            if (strlen($ch))
            {
                // その他の文字 または バックスラッシュ＋文字
                $arg .= preg_replace('/\\\\(.|$)/', '\1', $ch);
            }
            else if (strlen($sq))
            {
                // シングルクオート
                $arg .= substr($sq, 1);
            }
            else if (strlen($dq))
            {
                // ダブルクオート
                $arg .= preg_replace('/\\\\([\\\\"])|(.)/', '\1\2', substr($dq, 1));
            }
            else
            {
                // スペース または 終端
                if ($arg !== null)
                {
                    $args[] = $arg;
                }
                $arg = null;
            }

        }, $cmdline);

        if (strlen($cmdline))
        {
            throw new \RuntimeException("unable parse cmdline \"$cmdline\".");
        }

        return $args;
    }
}
