<?php
include('./ZmopClient.php');
include('./request/ZhimaCreditScoreGetRequest.php');
class TestZhimaCreditScoreGet {
    //芝麻信用网关地址
    public $gatewayUrl = "https://zmopenapi.zmxy.com.cn/openapi.do";
    //商户私钥文件
    public $privateKeyFile = "./keys/private_key.pem";
    //芝麻公钥文件
    public $zmPublicKeyFile = "./keys/public_key.pem";
    //数据编码格式
    public $charset = "UTF-8";
    //芝麻分配给商户的 appId
    public $appId = "501";

    public function __construct(){
        $client = new ZmopClient($this->gatewayUrl,$this->appId,$this->charset,$this->privateKeyFile,$this->zmPublicKeyFile);
        $request = new ZhimaCreditScoreGetRequest();
        $request->setChannel("apppc");
        $request->setPlatform("zmop");
        $request->setTransactionId("201512100936588040000000465158");// 必要参数
        $request->setProductCode("w1010100100000000001");// 必要参数
        $request->setOpenId("268810000007909449496");// 必要参数
        $response = $client->execute($request);
        echo json_encode($response);
    }
}

$get_score = new TestZhimaCreditScoreGet();