芝麻信用接入示例
1、参考链接：https://b.zmxy.com.cn/technology/openDoc.htm?relInfo=zhima.credit.score.get@1.0@1.5&relType=API_DOC&type=API_INFO_DOC&LEFT_MENU_MODEnull

2、生成芝麻信用公钥、私钥(ubuntu)
安装openssl：sudo apt-get install openssl
生成私钥：openssl genrsa -out rsa_private_key.pem 1024
生成公钥：openssl rsa -in rsa_private_key.pem -pubout -out rsa_public_key.pem
注：直接按照芝麻信用的genrsa -out rsa_private_key.pem 1024生成会报"bash: genrsa: command not found"错误，
要用"openssl genrsa -out rsa_private_key.pem 1024"才能正确生成，通过openssl库来解析
参考：http://blog.csdn.net/fym0121/article/details/7987512

3、坑
1)zmop/ZmopClient.php文件的106行
$logger = new LtLogger;这个类是不存在的，运行时会报错，是类找不到，注释掉再运行就ok了
2)官网的示例代码有问题：
这是官网的：
include('./ZmopClient.php');
class TestZhimaCreditScoreGet {
    //芝麻信用网关地址
    public $gatewayUrl = "https://zmopenapi.zmxy.com.cn/openapi.do";
    //商户私钥文件
    public $privateKeyFile = "d:\\keys\\private_key.pem";
    //芝麻公钥文件
    public $zmPublicKeyFile = "d:\\keys\\public_key.pem";
    //数据编码格式
    public $charset = "UTF-8";
    //芝麻分配给商户的 appId
    public $appId = "501";

    public function testZhimaCreditScoreGet(){
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

这是我修改过后的：
include('./ZmopClient.php');
include('./request/ZhimaCreditScoreGetRequest.php');//这行我加的，不加的话会报class ZhimaCreditScoreGetRequest not found
class TestZhimaCreditScoreGet {
    //芝麻信用网关地址
    public $gatewayUrl = "https://zmopenapi.zmxy.com.cn/openapi.do";
    //商户私钥文件
    public $privateKeyFile = "d:\\keys\\private_key.pem";
    //芝麻公钥文件
    public $zmPublicKeyFile = "d:\\keys\\public_key.pem";
    //数据编码格式
    public $charset = "UTF-8";
    //芝麻分配给商户的 appId
    public $appId = "501";

    public function __construct(){//这行我将方法名由TestZhimaCreditScoreGet改为了__construct，这和php的版本有关，在构造聚光灯自调用时
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
