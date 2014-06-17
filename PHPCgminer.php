<?php

header("Content-type: text/html; charset=utf-8");
class PHPCgminer {

	//shell文件所在目录
	private $shell_dir = './cgminer/shell/';
    //cgminer的配置文件所在目录
    private $cgminer_conf_dir = 'cgminer/conf/';
    //cgminer api 起始端口
    //private $cgminer_api_base_port = 18100;

	/**
	 * 写入配置文件
	 * $port : 设备端口
	 * $params : 配置参数数组
	 */
	public function write_config($port, $config_string){
        /*$pool = array();
        $pool['url']    = $params['pool'];
        $pool['user']   = $params['worker'];
        $pool['pass']   = $params['pwd'];
        
        $config = array();
        $config['pools'] = array($pool);
        $config['scan-serial']      = '/dev/'.$port;
        $config['chips-count']      = $params['chips'];
        $config['ltc-clk']          = $params['clock'];
        $config['ltc-debug']        = $params['ltc_debug'];
        $config['nocheck-golden']   = $params['nocheck_golden'];

        $config['api-listen']       = true;
        $config['api-network']      = true;
        $config['api-port']         = strval($this->cgminer_api_base_port + intval(substr($port, 6)));*/

        //$config_string = json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        //$config_string = json_encode($config_json , JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        //格式化
        $config_string_pretty = json_encode(json_decode($config_string),JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
		//写入文件
        $config_path = $this->cgminer_conf_dir.'cgminer_'.$port.'.conf';
		$f = fopen($config_path,'w');
		$f_result = fwrite($f, $config_string_pretty);
		fclose($f);

		return $f_result;
	}

    /**
     * 读取配置文件，作为表单的默认数据
     * $port : 设备端口
     */
    public function read_config($port){
        //读取文件
        $config_path = $this->cgminer_conf_dir.'cgminer_'.$port.'.conf';
        $f=fopen($config_path,'r');
        $f_content = fread($f, filesize($config_path));
        fclose($f);

        return $f_content;
    }

	/**
	 * 启动挖矿
	 * $port : 设备端口
	 */
	public function start($port){
		exec($this->shell_dir.'cgminer_init.sh '.$port.' restart',$output,$return_val);
		return $return_val;
	}

	/**
	 * 停止挖矿
	 * $port : 设备端口
	 */
	public function stop($port){
		exec($this->shell_dir.'cgminer_init.sh '.$port.' stop',$output,$return_val);
		return $return_val;
	}

	/**
	 * 检查挖矿状态
	 * $port : 设备端口
	 * $return_val : 0为running，1为not running
	 */
	public function check($port){
		exec($this->shell_dir.'cgminer_check.sh '.$port,$output,$return_val);
		return $return_val;
	}

	/**
	 * 输出log信息
	 * $port : 设备端口
	 * $last_line : 上一次读到得行号
	 * return $output : 输出的信息，类型是数组
	 */
	public function log($port, $last_line){
		exec($this->shell_dir.'cgminer_log.sh '.$port.' '.$last_line,$output,$return_val);
		return $output;
	}

	/**
	 * 获取矿机的设备端口
	 */
	public function get_miner_port(){
		return exec($this->shell_dir.'get_miner_port.sh',$output,$return_val);
	}
}

$cgminer = new PHPCgminer();

//操作类型
$action = $_GET['action'];
//矿机端口
$port = array_key_exists('port',$_POST)?$_POST['port']:'';

//保存并重启
if($action == 'start'){
	
	//挖矿参数
/*	$params = array();

	$params['pool'] = $_POST['pool'];
	$params['worker'] = $_POST['worker'];
	$params['pwd'] = $_POST['pwd'];

	$params['chips'] = $_POST['chips'];
	$params['clock'] = $_POST['clock'];

    if ($_POST['nocheck_golden'] == 'true')
        $params['nocheck_golden'] = true;
    if ($_POST['ltc_debug'])
        $params['ltc_debug'] = true;*/

	//保存配置
	if($cgminer -> write_config($port,$_POST['config_string'])){
		//开始挖矿
		echo $cgminer -> start($port);
	}
	else{
		echo '写入配置失败';      //写入配置失败
	}
}

//读取配置
else if($action == 'read'){
    echo $cgminer -> read_config($port);
}

//停止挖矿
else if($action == 'stop'){
	echo $cgminer -> stop($port);
}

//检查当前矿机状态
else if($action == 'check'){
	echo $cgminer -> check($port);
}

//输出log信息
else if($action == 'log'){
	$output_arr = array_filter($cgminer -> log($port, $_POST['last_line']));
    //数组的第一个值是输出的行数，后面的是输出的内容
    $output_json = array();
    $output_json['output_line'] = $output_arr[0];
    $output_json['output_content'] = array_splice($output_arr,1);

    echo json_encode($output_json);
//	if(count($output_arr) > 0) echo '<br/>'.implode('<br/>',$output_arr);
}

//获取矿机的设备端口
else if($action == 'port'){
	echo $cgminer -> get_miner_port();
}

?>
