<?php
$read_file_path = "tags.el";
$write_file_path = "write.org";
// 正则表达式的格式 ： "/表达式/修正符"
// 修正符 i 表示不区分大小写   "/[a-zA-Z]/" <==>"/[a-z]/i"
// 一个\要写成\\\\
// 为了匹配 ("\\CrossClanBattleGuild".
$pattern1 = "/\(\"\\\\\\\\[a-z]+\"\./i";
// 匹配单词
$pattern2 = "/[a-z]+/i";
// 查看是否存在要读取得文件
if(!file_exists($read_file_path))
{
    die("read file not exist");
}
// 删除写入文件
if(file_exists($write_file_path))
{
    unlink($write_file_path);
}
// fopen会创建文件
$write_file = fopen($write_file_path,"w");

// 逐行读取
$file_arr = file($read_file_path);
for($i = 0 ;$i<count($file_arr);$i++)
{
    // 输出类
    $str = preg_match($pattern1, $file_arr[$i], $matches11);
    if(!empty($matches11))
    {
        $str = preg_match($pattern2, $matches11[0], $matches12);
        // 四级标题
        fwrite($write_file, "**** " . $matches12[0]."\n");
        continue;
    }
    // 输出函数
    $str = preg_match_all($pattern2, $file_arr[$i], $matches21);
    if($matches21[0][0] == "m")
    {
        // 五级标题，增加TODO
        fwrite($write_file,"***** TODO " . $matches21[0][1] . "\n");
    }
}

fclose($write_file);
