<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->model('M_pildun');
		//$this->load->view('welcome_message');
		$data['allm'] = $this->M_pildun->all_ost()->result();
		$this->load->view('crud/all_ost',$data);
	}

	public function tokenisasi()
	{
		$teks = $this->input->post('teks');
		$lowercase = strtolower($teks);
		$onlyAllowedString = preg_replace("/[^a-z A-Z]/", "", $lowercase);
		$explode = explode(" ",$onlyAllowedString);
		// print_r($explode);
		$this->load->view('welcome_message',['hasil_token'=>$explode]);
	}

	public function filtering()
	{
		$hasil_token = $this->input->post('hasil_token');
		$hasil_token2 = explode(', ', $hasil_token);
		$data_stoplist = $this->db->get('stoplist')->result();
		$array_stoplist = [];
		$hasil_filtering=[];
		foreach ($data_stoplist as $key => $value) {
			$array_stoplist[$key] = $value->kata;
		}
		foreach ($hasil_token2 as $key => $value) {
			if (!in_array($value, $array_stoplist)) {
				$hasil_filtering[] = $value;
			}
		}
		$this->load->view('welcome_message',['hasil_token'=>$hasil_token2,'hasil_filtering'=>$hasil_filtering]);
	}
}
