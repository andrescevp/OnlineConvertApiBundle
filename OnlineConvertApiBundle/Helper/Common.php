<?php

namespace Aacp\OnlineConvertApiBundle\Helper;


class Common
{
    public static function httpsToHttpVice($url, $https = false)
    {
        if ($https) {
            return preg_replace("/^http:/i", "https:", $url);
        }

        return preg_replace("/^https:/i", "http:", $url);
    }
}