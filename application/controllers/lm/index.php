<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Index
 *
 * This is v1 index
 *
 * @package     CodeIgniter
 * @subpackage  Index Rest Server
 * @category    Controller
 * @author      Fire
*/


class Index extends CI_Controller
{
    function __construct()
    {
        // Construct our parent class
        parent::__construct();

        $this->load->helper('url');

        header('Cache-Control:public, max-age=60, s-maxage=60');
        header('Content-Type: application/json; charset=utf-8');
    }
    
    /**
     * vehicle get method
     * 
     * @return json
     */
    function index()
    {
        $url_array = [
            'cltxmaxid_url' => site_url('hd/kakou/cltxmaxid'),
            'cltx_url' => site_url('hd/kakou/cltx'),
			'cltxs_url' => site_url('hd/kakou/cltxs/:id/:last_id')
        ];

        $json = json_encode($url_array, true);
        echo str_replace("\/", "/", $json);
    }

}