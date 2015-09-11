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
        
        $img_ip = array('HDWJ-KKDATA1' => '192.168.1.1', 'HDWJ-KKDATA2' => '192.168.1.2');
        $query = $this->Mhd->getCltx($data);
        $result = $query->result_array();
        $items = [];
        foreach($result as $id => $row) {
            $items[$id]['id']   = (int)$row['ID'];
            $items[$id]['hphm'] = $row['HPHM'];
            $items[$id]['jgsj'] = $row['PASSTIME'];
            $items[$id]['hpys'] = $row['HPYS'];
            $items[$id]['kkdd'] = $row['WZDD'];
            $items[$id]['fxbh'] = $row['FXBH'];
            $items[$id]['cdbh'] = (int)$row['CDBH'];
            $items[$id]['kkbh'] = $row['KKBH'];
            $items[$id]['imgurl'] = "http://" . @$img_ip[$row['TPWZ']] . "/$row[QMTP]/" . str_replace('\\','/',$row['TJTP']);
        }
        echo json_encode(array('total_count' => $query->num_rows(), 'items' => $items));
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
        $item['kkdd'] = $row['WZDD'];
        $item['fxbh'] = $row['FXBH'];
        $item['cdbh'] = (int)$row['CDBH'];
        $item['kkbh'] = $row['KKBH'];
        $img_ip = array('HDWJ-KKDATA1' => '192.168.1.1', 'HDWJ-KKDATA2' => '192.168.1.2');
        $item['imgurl'] = "http://" . @$img_ip[$row['TPWZ']] . "/$row[QMTP]/" . str_replace('\\','/',$row['TJTP']);

        echo json_encode($item);
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