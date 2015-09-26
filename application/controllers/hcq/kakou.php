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
        
        $this->load->model('Mhcq');

        // header('Cache-Control: public, max-age=60, s-maxage=60');
        header('Content-Type: application/json');
        header("HTTP/1.1 200 OK");

        $this->img_ip = array(
            'HDWJ-KKDATA1' => '10.44.249.227:81',
            'HDWJ-KKDATA2' => '10.44.249.227:82'
        );
        $this->hpys_id = array(
            '其他' => 1,
            '蓝牌' => 2,
            '黄牌' => 3,
            '白牌' => 4,
            '黑牌' => 5
        );
        $this->hpys_code = array(
            '其他' => 'QT',
            '蓝牌' => 'BU',
            '黄牌' => 'YL',
            '白牌' => 'WT',
            '黑牌' => 'BK'
        );
        $this->fxbh_id = array(
            '其他' => 1,
            '进城' => 2,
            '出城' => 3,
            '由东往西' => 4,
            '由南往北' => 5,
            '由西往东' => 6,
            '由北往南' => 7
        );
        $this->fxbh_code = array(
            '其他' => 'QT',
            '进城' => 'IN',
            '出城' => 'OT',
            '由东往西' => 'EW',
            '由南往北' => 'SN',
            '由西往东' => 'WE',
            '由北往南' => 'NS'
        );
        $this->kkdd_id = array(
            '东湖路卡口' => '441302001',
            '交警支队卡口' => '441302002',
            '东江大桥卡口' => '441302003',
            '惠博路与三环路放口处卡口' => '441302004',
            '惠沙堤二路卡口' => '441302005',
            '陈江与镇隆交界处卡口' => '441302006',
            '小金口卡口' => '441302007',
            '仲恺卡口' => '441302008',
            '水口卡口' => '441302009',
            '马安卡口' => '441302010',
            '陈江梧村卡口' => '441302011',
            '惠澳大道卡口' => '441302012',
            '惠淡路卡口' => '441302013',
            '潼桥卡口' => '441302014',
            '汝湖卡口' => '441302015',
            '鳄湖路卡口' => '441302016',
            '梅湖卡口' => '441302017',
            '四角楼卡口' => '441302018',
            '火车西站卡口' => '441302019',
            '观岚大桥芦岚卡口' => '441302020',
            '芦村卡口' => '441302021',
            '仍图卡口' => '441302022',
            '大岚老收费站前卡口' => '441302023',
            '横沥卡口' => '441302024',
            '马安龙塘桥卡口' => '441302025',
            '马安柏田桥卡口' => '441302026',
            '三环西路丰山卡口' => '441302027'
        );
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
        
        $query = $this->Mhcq->getCltx($data);
        $result = $query->result_array();
        $items = [];
        foreach($result as $id => $row) {
            $items[$id]['id']   = (int)$row['ID'];
            $items[$id]['hphm'] = $row['HPHM'];
            $items[$id]['jgsj'] = $row['PASSTIME'];
            $items[$id]['hpys'] = $row['HPYS'];
            $items[$id]['hpys_id'] = array_key_exists($row['HPYS'], $this->hpys_id) ? $this->hpys_id[$row['HPYS']] : 1;
            $items[$id]['hpys_code'] = array_key_exists($row['HPYS'], $this->hpys_code) ? $this->hpys_code[$row['HPYS']] : 'QT';
            $items[$id]['kkdd'] = $row['WZDD'];
            $items[$id]['kkdd_id'] = array_key_exists($row['WZDD'], $this->kkdd_id) ? $this->kkdd_id[$row['WZDD']] : null;
            $items[$id]['fxbh'] = $row['FXBH'];
            $items[$id]['fxbh_id'] = array_key_exists($row['FXBH'], $this->fxbh_id) ? $this->fxbh_id[$row['FXBH']] : 1;
            $items[$id]['fxbh_code'] = array_key_exists($row['FXBH'], $this->fxbh_code) ? $this->fxbh_code[$row['FXBH']] : 'QT';
            $items[$id]['cdbh'] = (int)$row['CDBH'];
            $items[$id]['kkbh'] = $row['KKBH'];
            $items[$id]['imgurl'] = "http://10.47.187.166/$row[QMTP]/"
                                  . str_replace('\\', '/', $row['TJTP']);
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
        
        $query = $this->Mhcq->getCltxById($id);
        $row = $query->row_array();
        $item = array();
        $item['id']   = (int)$row['ID'];
        $item['hphm'] = $row['HPHM'];
        $item['jgsj'] = $row['PASSTIME'];
        $item['hpys'] = $row['HPYS'];
        $item['hpys_id'] = array_key_exists($row['HPYS'], $this->hpys_id) ? $this->hpys_id[$row['HPYS']] : 1;
        $item['hpys_code'] = array_key_exists($row['HPYS'], $this->hpys_code) ? $this->hpys_code[$row['HPYS']] : 'QT';
        $item['kkdd'] = $row['WZDD'];
        $item['kkdd_id'] = array_key_exists($row['WZDD'], $this->kkdd_id) ? $this->kkdd_id[$row['WZDD']] : null;
        $item['fxbh'] = $row['FXBH'];
        $item['fxbh_id'] = array_key_exists($row['FXBH'], $this->fxbh_id) ? $this->fxbh_id[$row['FXBH']] : 1;
        $item['fxbh_code'] = array_key_exists($row['FXBH'], $this->fxbh_code) ? $this->fxbh_code[$row['FXBH']] : 'QT';
        $item['cdbh'] = (int)$row['CDBH'];
        $item['kkbh'] = $row['KKBH'];
        #$img_ip = array('HDWJ-KKDATA1' => '192.168.1.1', 'HDWJ-KKDATA2' => '192.168.1.2');
        $item['imgurl'] = "http://10.47.187.166/$row[QMTP]/"
                        . str_replace('\\', '/', $row['TJTP']);

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
        $query = $this->Mhcq->getCltxMaxId();
        $result = array('maxid' => (int)$query->row()->MAXID);

        echo json_encode($result);
    }

}