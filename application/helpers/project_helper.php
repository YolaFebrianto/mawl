<?php
	function get_last_round($kode){
		$CI = get_instance();
		$CI->load->model('M_pildun');
		$data = $CI->M_pildun->get_last_round($kode)->row_array();
		return @$data['babak'];
	}