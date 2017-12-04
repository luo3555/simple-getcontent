<?php
require_once('vendor/autoload.php');

function makeHtml($html, $mod=false)
{
    $html = explode('</head>', $html);
    $html[0] =  $html[0] . '<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>';
    $html[0] = $html[0] . '<script src="/global.js"></script>';
    $html[0] = $html[0] . sprintf('<base href="%s"/>', $_POST['domain']);
    return implode('</head>', $html);
}

if (isset($_POST['url'])) {
    try {
        if (!file_exists('tmp')) {
            if (!is_dir('tmp')) {
                mkdir('tmp');
            }
        }

        // clean cache
        if (file_exists('tmp') && is_dir('tmp')) {
            $hd = opendir('tmp');
            while ($file = readdir($hd))
            {
                if ($file!='.'&&$file!='..') {
                    if (preg_match('/\.html$/', $file)) {
                        unlink(sprintf('tmp/%s', $file));
                    }
                }
            }
            closedir($hd);
        }

        $url = $_POST['url'];

        if (preg_match("/^\//", $url)) {
            $url = $_POST['domain'] . $url;
        }

        if (!preg_match('/^http(s)?:\/\//i', $url, $matches)) {
            $prefix = $_POST['prefix'] == 1 ? 'http://' : 'https://' ;
            $url = $prefix . $url;
        }

        $response = Requests::get($url);
        $html = $response->body;


        $fileName = sprintf('tmp/%d.html', time());
        $hd = fopen($fileName, 'w+');
        fwrite($hd, makeHtml($html));
        fclose($hd);
        echo $fileName;
    } catch (Esception $e) {
        echo $e->getMessage();
    }
}