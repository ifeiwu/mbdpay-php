<?php

namespace Pagepan;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;


class MbdPayClient
{
    
    public const BASE_URL = 'https://api.mianbaoduo.com';
    
    public const OPENID_URL = 'https://mbd.pub/openid';
    
    public const WX_JS_URL = self::BASE_URL . '/release/wx/prepay';
    
    public const WX_H5_URL = self::BASE_URL . '/release/wx/prepay';
    
    public const ALIPAY_URL = self::BASE_URL . '/release/alipay/pay';
    
    public const REFUND_URL = self::BASE_URL . '/release/main/refund';
    
    public const SEARCH_ORDER_URL= self::BASE_URL . '/release/main/search_order';
    
    public $httpClient;
    
    private $appId;
    
    private $appKey;
    
    
    public function __construct(string $appId, string $appKey)
    {
        $this->appId = $appId;
        
        $this->appKey = $appKey;
        
        $this->httpClient = new Client();
    }
    
    
    /**
     * 微信 JSAPI 支付
     * 
     * @link https://doc.mbd.pub/api/wei-xin-zhi-fu
     * @example example/wxjs.php
     *
     * @param string $openid 用户的 openid
     * @param string $amount_total 金额，单位为分
     * @param string $description 支付描述，一般为商品名称
     * @param string $callback_url 支付后跳转地址
     * @param string $out_trade_no 订单号，如不填，面包多将随机生成订单号
     * @param string $share_code 分账参数，需先开通分账权限
     *
     * @return array
     */
    public function wxjs(string $openid, int $amount_total, string $description, string $callback_url, string $out_trade_no = '', string $share_code = ''): array
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
            
            return $this->error($request->getUri() . ' ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase());
        }
        
        $content = json_decode($content, true);
        
        $error = json_last_error();
        
        if ( $error == JSON_ERROR_NONE )
        {
            if ( isset($content['error']) )
            {
                return $this->error($content['error']);
            }
            
            return $this->success('', $content);
        }
        else
        {
            return $this->error($content);
        }
    }
    
    
    /**
     * 微信 H5 支付
     * 
     * @link https://doc.mbd.pub/api/wei-xin-h5-zhi-fu
     * @example example/wxh5.php
     *
     * @param string $amount_total 金额，单位为分
     * @param string $description 支付描述，一般为商品名称
     * @param string $out_trade_no 订单号，如不填，面包多将随机生成订单号
     * @param string $share_code 分账参数，需先开通分账权限
     *
     * @return array
     */
    public function wxh5(int $amount_total, string $description, string $out_trade_no = '', string $share_code = ''): array
    {
        $json_data = [
            'channel' => 'h5',
            'app_id' => $this->appId,
            'description' => $description,
            'amount_total' => $amount_total,
            'out_trade_no' => $out_trade_no,
            'share_code' => $share_code
        ];
        
        $json_data['sign'] = $this->sign($json_data);

        try {
            
            $response = $this->httpClient->request('POST', self::WX_H5_URL, ['json' => $json_data]);
            
            $content = $response->getBody()->getContents();
            
        } catch (ClientException $e) {
            
            $request = $e->getRequest();
            $response = $e->getResponse();
            
            return $this->error($request->getUri() . ' ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase());
        }
        
        $content = json_decode($content, true);
        
        $error = json_last_error();
        
        if ( $error == JSON_ERROR_NONE )
        {
            if ( isset($content['error']) )
            {
                return $this->error($content['error']);
            }
        
            return $this->success('h5_url', $content['h5_url']);
        }
        else
        {
            return $this->error($content);
        }
    }
    
    
    /**
     * 支付宝支付
     * 
     * @link https://doc.mbd.pub/api/zhi-fu-bao-zhi-fu
     * @example example/alipay.php
     *
     * @param string $amount_total 金额，单位为分
     * @param string $description 支付描述，一般为商品名称
     * @param string $out_trade_no 订单号，如不填，面包多将随机生成订单号
     * @param string $callback_url 支付后跳转地址，如不填会只显示「支付成功」
     * @param string $share_code 分账参数，需先开通分账权限
     *
     * @return array
     */
    public function alipay(int $amount_total, string $description, string $callback_url = '', string $out_trade_no = '', string $share_code = ''): array
    {
        $json_data = [
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
            
            return $this->error($request->getUri() . ' ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase());
        }

        $content = json_decode($content, true);
        
        $error = json_last_error();

        if ( $error == JSON_ERROR_NONE )
        {
            if ( isset($content['error']) )
            {
                return $this->error($content['error']);
            }
        
            return $this->success('', $content['body']);
        }
        else
        {
            return $this->error($content);
        }
    }
    
    
    /**
     * 退款
     * 
     * @link https://doc.mbd.pub/api/tui-kuan
     * @example example/refund.php
     *
     * @param string $out_trade_no 订单号
     *
     * @return array
     */
    public function refund(string $out_trade_no): array
    {
        $json_data = [
            'order_id' => $out_trade_no,
            'app_id' => $this->appId
        ];
        
        $json_data['sign'] = $this->sign($json_data);
        
        try {
            
            $response = $this->httpClient->request('POST', self::REFUND_URL, ['json' => $json_data]);
            
            $content = $response->getBody()->getContents();
            
        } catch (ClientException $e) {
            
            $request = $e->getRequest();
            $response = $e->getResponse();
            
            return $this->error($request->getUri() . ' ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase());
        }

        $content = json_decode($content, true);
        
        $error = json_last_error();
    
        if ( $error == JSON_ERROR_NONE )
        {
            if ( isset($content['error']) )
            {
                return $this->error($content['error']);
            }
            
            if ( $content['code'] === 200 )
            {
                return $this->success($content['message']);
            }
            else
            {
                return $this->error($content['message']);
            }
        }
        else
        {
            return $this->error($content);
        }
    }
    
    
    /**
     * 订单查询
     * 
     * @link https://doc.mbd.pub/api/ding-dan-cha-xun
     * @example example/order.php
     *
     * @param string $out_trade_no 订单号
     *
     * @return array
     */
    public function order(string $out_trade_no): array
    {
        $json_data = [
            'out_trade_no' => $out_trade_no,
            'app_id' => $this->appId
        ];
        
        $json_data['sign'] = $this->sign($json_data);
        
        try {
            
            $response = $this->httpClient->request('POST', self::SEARCH_ORDER_URL, ['json' => $json_data]);
            
            $content = $response->getBody()->getContents();
            
        } catch (ClientException $e) {
            
            $request = $e->getRequest();
            $response = $e->getResponse();
            
            return $this->error($request->getUri() . ' ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase());
        }
    
        $content = json_decode($content, true);
        
        $error = json_last_error();
    
        if ( $error == JSON_ERROR_NONE )
        {
            if ( isset($content['error']) )
            {
                return $this->error($content['error']);
            }
            
            return $this->success('', $content);
        }
        else
        {
            return $this->error($content);
        }
    }
    
    
    /**
     * 签名算法
     *
     * @link https://doc.mbd.pub/api/qian-ming-suan-fa
     *
     * @param array $data
     *
     * @return string
     */
    public function sign(array $data): string
    {
        ksort($data);

        $sign = md5(urldecode(http_build_query($data)) . '&key=' . $this->appKey);
        
        return $sign;
    }
    
    
    /**
     * 获取用户 openid
     *
     * @link https://doc.mbd.pub/api/huo-qu-yong-hu-openid
     * @example example/wxjs.php
     *
     * @param string $target_url 自动跳转地址
     *
     * @return string
     */
    public function openid(string $target_url): string
    {
        $params = ['app_id' => $this->appId, 'target_url' => $target_url];
        
        $query = urldecode(http_build_query($params));
        
        return self::OPENID_URL . '?' . $query;
    }
    
    
    /**
     * 统一返回结果
     *
     * @param int $code
     * @param string $message
     * @param mixed $data
     *
     * @return array
     */
    public function result($code, $message = '', $data = null): array
    {
        return ['code' => $code, 'message' => $message, 'data' => $data];
    }


    /**
     * 返回错误结果
     *
     * @param string $message
     * @param mixed $data
     *
     * @return array
     */
    public function error($message = '', $data = null): array
    {
        return $this->result(1, $message, $data);
    }
    
    
    /**
     * 返回成功结果
     *
     * @param string $message
     * @param mixed $data
     *
     * @return array
     */
    public function success($message = '', $data = null): array
    {
        return $this->result(0, $message, $data);
    }
}