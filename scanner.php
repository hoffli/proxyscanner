/**************************************************************************/
/* scanProxy function by Christian Haschek christian@haschek.at           */
/* @link https://blog.haschek.at/2015-analyzing-443-free-proxies          */
/*                                                                        */
/* Requests a specific file ($url) via a proxy ($proxy)                   */
/* if first parameter is set to false it will retrieve                    */
/* $url without a proxy. CURL extension for PHP is required.              */
/*                                                                        */
/* @param $proxy (string) is the proxy server used (eg 127.0.0.1:8123)    */
/* @param $url (string) is the URL of the requested file or site          */
/* @param $socks (bool) true: SOCKS proxy, false: HTTP proxy              */
/* @param $timeout (int) timeout for the request in seconds               */
/* @return (string) the content of requested url                          */
/**************************************************************************/
function scanProxy($proxy,$url,$socks=true,$timeout=10)
{
    $ch = curl_init($url); 
    $headers["User-Agent"] = "Proxyscanner/1.0";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_HEADER, 0); //we don't need headers in our output
    curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 0); 
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,$timeout); 
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //return output as string
    $proxytype = ($socks?CURLPROXY_SOCKS5:CURLPROXY_HTTP); //socks or http proxy?
    if($proxy)
    {
        curl_setopt($ch, CURLOPT_PROXY, $proxy); 
        curl_setopt($ch, CURLOPT_PROXYTYPE, $proxytype);
    }

    $out = curl_exec($ch); 
    curl_close($ch);

    return trim($out);
}
