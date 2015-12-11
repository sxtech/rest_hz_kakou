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
	public function __construct()
    {
        // Construct our parent class
        parent::__construct();
        
        #$this->load->model('Mjjlm');

        // header('Cache-Control: public, max-age=60, s-maxage=60');
		header('Access-Control-Allow-Origin:*');
        header('Content-Type: application/json');
        header("HTTP/1.1 200 OK");

		$this->hpys_code = array(
			'1' => 'BU',
			'2' => 'YL',
			'3' => 'WT',
			'4' => 'BK',
			'99' => 'QT'
		);
		$this->hpys_name = array(
			'1' => '蓝牌',
			'2' => '黄牌',
			'3' => '白牌',
			'4' => '黑牌',
			'99' => '其他'
		);
		$this->kkdd_id = array(
			'1' => '441324401',
			'2' => '441324402',
			'3' => '441324403',
			'4' => '441324404',
			'5' => '441324405'
		);
		$this->kkdd_name = array(
			'1' => '永汉',
			'2' => '龙华',
			'3' => '平陵',
			'4' => '鸬鹚',
			'5' => '西埔'
		);
		$this->fxbh_code = array(
			'5' => array('2' => 'IN', '1' => 'OT'),
			'4' => array('1' => 'IN', '2' => 'OT'),
			'3' => array('1' => 'IN', '2' => 'OT'),
			'2' => array('1' => 'IN', '2' => 'OT'),
			'1' => array('1' => 'IN', '2' => 'OT'),
		);
    }


    /**
     * 根据id获取车辆信息
     * 
     * @return json
     */
    public function test_get()
    {
		$data['st'] = '2015-12-01 16:03:03';
		$data['et'] = '2015-12-01 16:05:03';
	        #$query = $this->Mjjlm->getJGCLByJGSJ($data);
		echo json_encode(array('1'=>'3'));
    }

    /**
     * 根据时间获取车辆信息
     * 
     * @return json
     */
    public function jgcl_get()
    {
        $data['st'] = $this->uri->segment(4);
		$data['et'] = $this->uri->segment(5);

        $query = $this->Mjjlm->getJGCLByJGSJ($data);
        $result = $query->result_array();
		$items = [];
        foreach ($result as $id => $row) {
			$items[$id]['id'] = $row['ID'];
			$items[$id]['hphm'] = $row['VehicleNo'];
			$items[$id]['jgsj'] = $row['IllTime'];
			$items[$id]['cdbh'] = $row['RoadWayNo'];
			$fxbh = @$this->fxbh_code[$row['CrossingNo']][$row['RoadWayNo']];
			$items[$id]['fxbh_code'] = $fxbh == Null ? 'IN' : $fxbh;
			$items[$id]['hpys_code'] = array_key_exists($row['VehicleColor'], $this->hpys_code) ? $this->hpys_code[$row['VehicleColor']] : 'QT';
			$items[$id]['kkdd_id'] = array_key_exists($row['CrossingNo'], $this->kkdd_id) ? $this->kkdd_id[$row['CrossingNo']] : null;
			$items[$id]['kkdd'] = array_key_exists($row['CrossingNo'], $this->kkdd_name) ? $this->kkdd_name[$row['CrossingNo']] : null;
			$items[$id]['imgurl'] = str_replace('\\', '/', $row['PicUrl'])
								  . $row['Pic1'];
		}

        $json = json_encode(array('total_count' => $query->num_rows(), 'items' => $items));
		echo str_replace("\/", "/", $json);
    }

}