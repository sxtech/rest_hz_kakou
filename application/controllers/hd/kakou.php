<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example
 *
 * This is vehicle info rest
 *
 * @package		CodeIgniter
 * @subpackage	Kakou Rest Server
 * @category	Controller
 * @author		Fire
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
//require APPPATH . '/libraries/REST_Controller.php';

class Kakou extends Parsing_Controller
{
	function __construct()
    {
        // Construct our parent class
        parent::__construct();
        
        $this->load->model('Mhd');

        // header('Cache-Control: public, max-age=60, s-maxage=60');
        header('Content-Type: application/json');
        header("HTTP/1.1 200 OK");

        $this->img_ip = array('HDWJ-KKDATA1' => '10.44.249.227:81', 'HDWJ-KKDATA2' => '10.44.249.227:82');
        $this->hpys_id = array('其他'=>1,'蓝牌'=>2, '黄牌'=>3, '白牌'=>4, '黑牌'=>5);
        $this->fxbh_id = array('其他'=>1, '进城'=>2, '出城'=>3, '由东往西'=>4, '由南往北'=>5, '由西往东'=>6, '由北往南'=>7);
    }


    /**
     * 根据id获取车辆信息
     * 
     * @return json
     */
    function cltxs_get()
    {
        $data['id'] = $this->uri->segment(4);
        $data['last_id'] = $this->uri->segment(5);

        $query = $this->Mhd->getCltx($data);
        $result = $query->result_array();

        $items = [];
        foreach($result as $id => $row) {
            $items[$id]['id']   = (int)$row['ID'];
            $items[$id]['hphm'] = $row['HPHM'];
            $items[$id]['jgsj'] = $row['PASSTIME'];
            $items[$id]['hpys'] = $row['HPYS'];
            $items[$id]['hpys_id'] = array_key_exists($row['HPYS'], $this->hpys_id) ? $this->hpys_id[$row['HPYS']] : 1;
            $items[$id]['kkdd'] = $row['WZDD'];
            $items[$id]['fxbh'] = $row['FXBH'];
            $items[$id]['fxbh_id'] = array_key_exists($row['FXBH'], $this->fxbh_id) ? $this->fxbh_id[$row['FXBH']] : 1;
            $items[$id]['cdbh'] = (int)$row['CDBH'];
            $items[$id]['kkbh'] = $row['KKBH'];
            $items[$id]['imgurl'] = "http://" . @$this->img_ip[$row['TPWZ']] . "/$row[QMTP]/" . str_replace('\\','/',$row['TJTP']);
        }
        $json = json_encode(array('total_count' => $query->num_rows(), 'items' => $items));

		echo str_replace("\/", "/", $json);
    }

    /**
     * 根据id获取车辆信息
     * 
     * @return json
     */
    function cltx_get()
    {
        $id = $this->uri->segment(4);
        
        $query = $this->Mhd->getCltxById($id);
        $row = $query->row_array();
        $item = array();
        $item['id']   = (int)$row['ID'];
        $item['hphm'] = $row['HPHM'];
        $item['jgsj'] = $row['PASSTIME'];
        $item['hpys'] = $row['HPYS'];
        $item['hpys_id'] = array_key_exists($row['HPYS'], $this->hpys_id) ? $this->hpys_id[$row['HPYS']] : 1;
        $item['kkdd'] = $row['WZDD'];
        $item['fxbh'] = $row['FXBH'];
        $item['fxbh_id'] = array_key_exists($row['FXBH'], $this->fxbh_id) ? $this->fxbh_id[$row['FXBH']] : 1;
        $item['cdbh'] = (int)$row['CDBH'];
        $item['kkbh'] = $row['KKBH'];
        #$img_ip = array('HDWJ-KKDATA1' => '192.168.1.1', 'HDWJ-KKDATA2' => '192.168.1.2');
        $item['imgurl'] = "http://" . @$this->img_ip[$row['TPWZ']] . "/$row[QMTP]/" . str_replace('\\','/',$row['TJTP']);

        $json = json_encode($item);
		echo str_replace("\/", "/", $json);
    }

    /**
     * 获取cltx表最大ID
     * 
     * @return json
     */
    function cltxmaxid_get()
    {
        $query = $this->Mhd->getCltxMaxId();
        $result = array('maxid' => (int)$query->row()->MAXID);

        echo json_encode($result);
    }

    /**
     * 获取cltx表最大ID
     * 
     * @return json
     */
    function test_get()
    {
        echo 'test';
    }

}