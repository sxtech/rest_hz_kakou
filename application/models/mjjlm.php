<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mjjlm extends CI_Model
{
	private $jj_lm_db;
    /**
     * Construct a mhd instance
     *
     */
	public function __construct()
	{
		parent::__construct();

		$this->jj_lm_db = $this->load->database('jj_lm_db', TRUE);
	}
	

	//根据条件获取车辆信息
	public function getJGCLByJGSJ($data)
	{
		return $this->jj_lm_db->query("SELECT * FROM Illegal WHERE Illtime > '$data[st]' AND Illtime <= '$data[et]'" );
	}


}
?>

