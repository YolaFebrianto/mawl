<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pildun extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_pildun');
	}
	public function index()
	{
		$data['allm'] = $this->M_pildun->all_match()->result();
		$this->load->view('crud/pildun',$data);
	}
	public function grup()
	{
		$data['grupA'] = $this->M_pildun->grup('A')->result();
		$data['grupB'] = $this->M_pildun->grup('B')->result();
		$data['grupC'] = $this->M_pildun->grup('C')->result();
		$data['grupD'] = $this->M_pildun->grup('D')->result();
		$data['grupE'] = $this->M_pildun->grup('E')->result();
		$data['grupF'] = $this->M_pildun->grup('F')->result();
		$data['grupG'] = $this->M_pildun->grup('G')->result();
		$data['grupH'] = $this->M_pildun->grup('H')->result();
		$this->load->view('crud/pildun_grup',$data);
	}
	public function rekap()
	{
		$data['alls'] = $this->M_pildun->all_nations()->result();
		$this->load->view('crud/pildun_rekap',$data);
	}
	public function insert_form()
	{
		if ($this->session->userdata('username') != '') {
			$data['alln'] = $this->M_pildun->all_nations_list()->result();
			$this->load->view('crud/pildun_form',$data);
		} else {
			redirect();
		}
	}
	public function insert()
	{
		if ($this->session->userdata('username') != '') {
			$tgl = date('Y-m-d',strtotime($this->input->post('tanggal')));
			$data = [
				'negara1'	=> $this->input->post('negara1'),
				'skor1'		=> $this->input->post('skor1'),
				'skor2'		=> $this->input->post('skor2'),
				'negara2'	=> $this->input->post('negara2'),
				'babak'		=> $this->input->post('babak'),
				'tanggal'	=> $tgl,
				'keterangan'=> $this->input->post('keterangan'),
			];
			$cek = $this->db->insert('pertandingan',$data);
			if ($cek) {
				$this->session->set_flashdata('info','Data Berhasil Ditambahkan!');
			}
			unset($_POST);
			redirect('pildun/index');
		} else {
			redirect();
		}
	}
}