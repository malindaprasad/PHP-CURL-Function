<?php
ini_set("log_errors", "1");
ini_set("error_log", "Errors.log.txt");
ini_set("display_errors", "1");

function getHTTP($url, $param, $method, $httpuserpw, $header, $agent, $followLocation)
{

    if ($agent == null)
        $agent = 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.146 Safari/537.36';
    //httpuserpw == 'admin:nexs1981050'
    //header aray = 'HeaderName: HeaderValue','HeaderName: HeaderValue'
    if ($method == 'GET' && $param != null) {
        $url = $url . $param;
    }

    $curl = curl_init($url . $param);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    if ($httpuserpw != null && $httpuserpw != '')
        curl_setopt($curl, CURLOPT_USERPWD, $httpuserpw);

    if (($method == 'POST' || $method == 'PUT') && $param != null) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
    }

    if ($header != null && count($header) > 0)
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    if ($followLocation)
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

    curl_setopt($curl, CURLOPT_USERAGENT, $agent);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($curl, CURLOPT_HEADER, 1);

    $response = curl_exec($curl);


    if (!curl_errno($curl)) {
        $resultStatus = curl_getinfo($curl);

        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        $header = str_replace("\r\n","\n",$header);
        $result['status'] = "OK";
        $result['statusCode'] = $resultStatus['http_code'];
        $result['time'] = $resultStatus['total_time'];
        $result['statusData'] = $result;
        $result['header'] = explode( '\n', $header);
        $result['body'] = $body;
    } else {
        $result['status'] = "ERROR";
        $result['msg'] = curl_error($curl);
    }
    return $result;


}

echo json_encode(getHTTP('http://localhosst/dd/', '', 'GET', null, null,null,false));

