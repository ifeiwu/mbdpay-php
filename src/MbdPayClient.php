<?php

namespace Pagepan;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;


class MbdPayClient
{
    private const BASE_URL = 'https://api.mianbaoduo.com';
    
    private const OPENID_URL = 'https://mbd.pub/openid';
    
    private const WX_JS_URL = self::BASE_URL . '/release/wx/prepay';
    
    private const WX_H5_URL = self::BASE_URL . '/release/wx/prepay';
    
    private const ALIPAY_URL = self::BASE_URL . '/release/alipay/pay';
    
    private const REFUND_URL = self::BASE_URL . '/release/main/refund';
    
    private const SEARCH_ORDER_URL= self::BASE_URL . '/release/main/search_order';
    
    private $appId;
    
    private $appKey;
    
    private $httpClient;
    
    
    public function __construct(string $appId, string $appKey)
    {
        $this->appId = $appId;
        
        $this->appKey = $appKey;
        
        $this->httpClient = new Client();
    }
    
    
    public function wxjs(string $openid, int $amount_total, string $description, string $callback_url, string $out_trade_no = '', string $share_code = '')
    {
        $json_data = [
            'openid' => $openid,
            'app_id' => $this->appId,
            'description' => $description,
            'amount_total' => $amount_total,
            'out_trade_no' => $out_trade_no,
            'callback_url' => $callback_url,
            'share_code' => $share_code
        ];
        
        $json_data['sign'] = $this->sign($json_data);
        
        try {
            
            $response = $this->httpClient->request('POST', self::WX_JS_URL, ['json' => $json_data]);
            
            $content = $response->getBody()->getContents();
            
        } catch (ClientException $e) {
            
            $request = $e->getRequest();
            $response = $e->getResponse();
            
            return $request->getUri() . ' ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase();
        }
        
        $content = json_decode($content, true);
        
        $error = json_last_error();
        
        if ( $error == JSON_ERROR_NONE )
        {
            if ( isset($content['error']) )
            {
                return $content['error'];
            }
        
            return $content;
        }
        else
        {
            return $content;
        }
    }
    
    
    public function alipay(string $url, int $amount_total, string $description, string $out_trade_no = '', string $callback_url = '', string $share_code = '')
    {
        $json_data = [
            'url' => $url,
            'app_id' => $this->appId,
            'description' => $description,
            'amount_total' => $amount_total,
            'out_trade_no' => $out_trade_no,
            'callback_url' => $callback_url,
            'share_code' => $share_code
        ];
        
        $json_data['sign'] = $this->sign($json_data);
        
        try {
            
            $response = $this->httpClient->request('POST', self::ALIPAY_URL, ['json' => $json_data]);
            
            $content = $response->getBody()->getContents();
            
        } catch (ClientException $e) {
            
            $request = $e->getRequest();
            $response = $e->getResponse();
            
            return $request->getUri() . ' ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase();
        }

        $content = json_decode($content, true);
        
        $error = json_last_error();

        if ( $error == JSON_ERROR_NONE )
        {
            if ( isset($content['error']) )
            {
                return $content['error'];
            }
        
            return $content['body'];
        }
        else
        {
            return $content;
        }
    }
    
    
    private function sign($data)
    {
        ksort($data);

        $sign = md5(urldecode(http_build_query($data)) . '&key=' . $this->appKey);
        
        return $sign;
    }
    
    
    public function openid($target_url)
    {
        $params = ['app_id' => $this->appId, 'target_url' => $target_url];
        
        $query = urldecode(http_build_query($params));
        
        return self::OPENID_URL . '?' . $query;
    }
}