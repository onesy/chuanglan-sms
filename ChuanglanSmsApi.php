<?php

/**
 * 该代码仅供学习和研究创蓝接口使用，只是提供一个参考。
 */
class ChuanglanSmsApi {
    
    private $chuanglan_config;
    
    public function init($chuanlan_config)
    {
        $this->chuanglan_config = $chuanlan_config;
    }

    /**
     * 发送短信。手机号码，密码，url不再是有效的，留在那里只是为了占位
     *
     * @param string $mobile 手机号码
     * @param string $msg 短信内容
     * @param string $needstatus 是否需要状态报告
     * @param string $product 产品id，可选
     * @param string $extno   扩展码，可选
     */
    public function sendSMS($account, $pswd, $url, $mobile, $msg, $needstatus = 'false', $product = '', $extno = '') {
//        global $chuanglan_config;
        //创蓝接口参数
        $postArr = array(
            'account' => $this->chuanglan_config['account'],
            'pswd' => $this->chuanglan_config['pwd'],
            'msg' => $msg,
            'mobile' => $mobile,
            'needstatus' => $needstatus,
            'product' => $product,
            'extno' => $extno
        );

        $result = $this->curlPost($this->chuanglan_config['url'], $postArr);
        return $result;
    }

    /**
     * 查询额度
     */
    public function queryBalance() {
//        global $chuanglan_config;
        //查询参数
        $postArr = array(
            'account' => $this->chuanglan_config['account'],
            'pswd' => $this->chuanglan_config['pwd'],
        );
        $result = $this->curlPost($this->chuanglan_config['api_balance_query_url'], $postArr);
        return $result;
    }

    /**
     * 处理返回值
     */
    public function execResult($result) {
        $result = preg_split("/[,\r\n]/", $result);
        return $result;
    }

    /**
     * 通过CURL发送HTTP请求
     * @param string $url  //请求URL
     * @param array $postFields //请求参数 
     * @return mixed
     */
    private function curlPost($url, $postFields) {
        $postFields = http_build_query($postFields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    //魔术获取
    public function __get($name) {
        return $this->$name;
    }

    //魔术设置
    public function __set($name, $value) {
        $this->$name = $value;
    }

}

?>