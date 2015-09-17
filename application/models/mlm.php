<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mlm extends CI_Model
{
	private $lm_db;
    /**
     * Construct a mhd instance
     *
     */
	public function __construct()
	{
		parent::__construct();

		$this->lm_db = $this->load->database('lm_db', TRUE);
	}
	

	//根据条件获取车辆信息
	public function getCltx($data)
	{
		return $this->lm_db->query("SELECT t.*, to_char(jgsj, 'yyyy-mm-dd hh24:mi:ss')AS passtime FROM cltx t WHERE id>$data[id] AND id<=$data[last_id] ORDER BY id" );
	}

	//根据条件获取车辆信息
	public function getLastCltx($limit = 20)
	{
		return $this->lm_db->query("SELECT t.*, to_char(jgsj, 'yyyy-mm-dd hh24:mi:ss')AS passtime FROM cltx t WHERE ROWNUM <=$limit ORDER BY id DESC" );
	}

    /**
     * 根据id获取车辆信息
     * 
     * @param int $id cltx表ID
     * @return object
     */
	public function getCltxById($id)
	{
		return $this->lm_db->query("SELECT t.*, to_char(jgsj, 'yyyy-mm-dd hh24:mi:ss')AS passtime FROM cltx t WHERE id = $id");
	}

    /**
     * 获取cltx表最大ID
     * 
     * @return object
     */
	public function getCltxMaxId()
	{
		return $this->lm_db->query("SELECT max(id) as maxid FROM cltx");
	}

}
?>

