<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_pildun');
	}
	public function index()
	{
/*$this->session->set_userdata('username','yola');
$resultdata=$this->db->get('tblanime')->result();
echo var_dump($resultdata);*/
		if ($this->session->userdata('username') != '') {
			$where = [
				'username' => $this->session->userdata('username'),
				'status'   => 1
			];
			$data['user'] = $this->db->get_where('tbluser',$where)->row_array();
            $data['event_name'] = $this->M_pildun->event()->row_array();
			$user_id = @$data['user']['id'];
			$this->db->order_by('tahun','DESC');
			$this->db->order_by('season','ASC');
			$this->db->order_by('judul','ASC');
			$this->db->where('user_id',$user_id);
			$this->db->where('status != ',2);
			$data['isi'] = $this->db->get('tblanime')->result();
			$data['title'] = 'Semua Anime';
			$data['id_kategori'] = -1;
			$this->load->view('crud/index',$data);
		} else {
			$this->load->view('crud/login');
		}
		$namafile = "DataRecord.txt"; 
		$handle = fopen(dirname(__FILE__)."/../../".$namafile, "w");
		// if (!$handle) { 				
		// 	$server_output = "Filed Save"; 
		// } else { 				
		fwrite ($handle, $this->CreateUserJSON()); 					
			// $dirname = dirname($path)."/DataRecord.txt";
		// } 
		fclose($handle);
	}
	function CreateUserJSON(){
		$header = '{"Result":true,"Data":[';
		$footer = "]}";
		$content = "INSERT INTO tblanime(id,judul,season,tahun,status,foto,catatan,platform,last_view_eps,total_eps,user_id,created_at,updated_at) VALUES";
		//$sqlscan = "SELECT * FROM tblanime";
    	//$resultscan = Yii::app()->db->createCommand($sqlscan)->queryAll();
    	$resultscan = $this->db->get('tblanime')->result_array();
    	foreach ($resultscan as $k => $datascan) {
			if ($k!=0){
				$content = $content.',';
			}

			$i = $k+1;
			$content .= "('".$datascan['id']."','".$datascan['judul']."','".$datascan['season']."','".$datascan['tahun']."','".$datascan['status']."','".$datascan['foto']."','".$datascan['catatan']."','".$datascan['platform']."','".$datascan['last_view_eps']."','".$datascan['total_eps']."','".$datascan['user_id']."','".$datascan['created_at']."','".$datascan['updated_at']."')";
		}
		
		return $content;
	}
	public function login(){
		$username = $this->input->post('username');
		$password = md5($this->input->post('password'));
// 		$username='yola';
// 		$password=md5('12345');
		$where = [
			'username' => $username,
			'password' => $password,
			'status'   => 1
		];
		$cek = $this->db->get_where('tbluser',$where)->row_array();
		if ($cek != null) {
			$this->session->set_userdata('username',$username);
			redirect();
		} else {
			$this->session->set_flashdata('error','User ID atau Password Salah!');
			redirect();
		}	
	}
	public function jadwal()
	{
		if ($this->session->userdata('username') != '') {
			$where = [
				'username' => $this->session->userdata('username'),
				'status'   => 1
			];
            $data['event_name'] = $this->M_pildun->event()->row_array();
			$data['user'] = $this->db->get_where('tbluser',$where)->row_array();
			$user_id = @$data['user']['id'];
			$data['title'] = 'Jadwal dan Hari Rilis';
			$this->db->order_by('hari','ASC');
			$this->db->order_by('pukul','ASC');
			$data['jadwal'] = $this->db->get_where('tblanime',['user_id'=>$user_id,'status'=>1])->result();
			$this->load->view('crud/jadwal',$data);
		}
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect();
	}
	public function view(){
		$id = $this->input->post('id');
		$data['data'] = $this->db->get_where('tblanime',['id'=>$id])->row_array();
		$this->load->view('crud/view',$data);
	}
	public function kategori($idstatus=0)
	{
		$where = [
			'username' => $this->session->userdata('username'),
			'status'   => 1
		];
		$data['event_name'] = $this->M_pildun->event()->row_array();
		$data['user'] = $this->db->get_where('tbluser',$where)->row_array();
		$user_id = @$data['user']['id'];
		$this->db->order_by('tahun','DESC');
		$this->db->order_by('season','DESC');
		$this->db->order_by('judul','ASC');
		$data['isi'] = $this->db->get_where('tblanime',['user_id'=>$user_id,'status'=>$idstatus])->result();
		$ongoingSeason='';
		$month = date('m');
		if ($month>=1 && $month<=3) {
			$ongoingSeason .= "WINTER ";
		} else if ($month>=4 && $month<=6) {
			$ongoingSeason .= "SPRING ";
		} else if ($month>=7 && $month<=9) {
			$ongoingSeason .= "SUMMER ";
		} else if ($month>=10 && $month<=12) {
			$ongoingSeason .= "FALL ";
		}
		$ongoingSeason .= date('Y');
		if ($idstatus==0) {
			$status='SCHEDULE LIST';
		} else if ($idstatus==1) {
			$status='ONGOING LIST ('.$ongoingSeason.')';
		} else if ($idstatus==2) {
			$status='FINISHED LIST';
		} else {
			$status='KATEGORI: '.$idstatus;
		}
		$data['title'] = $status;
		$data['id_kategori'] = $idstatus;
		$this->load->view('crud/index',$data);	
	}
	public function form_add(){
		$data['id_kategori'] = $this->input->post('id_kategori');
		$this->load->view('crud/form-add',$data);	
	}
	public function form_edit(){
		$id = $this->input->post('id');
		$data['edit'] = $this->db->get_where('tblanime',['id'=>$id])->row_array();
		$this->load->view('crud/form-edit',$data);
	}
	public function delete($id){
		$cek = $this->db->delete('tblanime',['id'=>$id]);
		if ($cek) {
			$this->session->set_flashdata('info', 'Data Berhasil Dihapus!');
		}
		redirect();
	}
	public function add(){
		$where = [
			'username' => $this->session->userdata('username'),
			'status'   => 1
		];
		$data['user'] = $this->db->get_where('tbluser',$where)->row_array();
		$user_id = @$data['user']['id'];
		$data = [
			'judul'		=> $this->input->post('judul'),
			'season'	=> $this->input->post('season'),
			'tahun'		=> $this->input->post('tahun'),
			'last_view_eps'	=> $this->input->post('last_view_eps'),
			'total_eps'	=> $this->input->post('total_eps'),
			'status'	=> $this->input->post('status'),
			'foto' 		=> $this->input->post('foto'),
			'catatan' 	=> $this->input->post('catatan'),
			'platform' 	=> $this->input->post('platform'),
			'hari' 		=> $this->input->post('hari'),
			'pukul' 	=> $this->input->post('pukul'),
			'user_id' 	=> $user_id,
		];
		// $config['upload_path']          = './img';
		// $config['allowed_types']        = 'gif|jpg|png|bmp|jpeg';
		// $config['max_size']             = 1000;
		// $config['max_width']            = 1024;
		// $config['max_height']           = 768;
		// $this->load->library('upload', $config);

		// if (!$this->upload->do_upload('foto'))
		// {
		// 	$error = $this->upload->display_errors();
		// 	$this->session->set_flashdata('danger',$error);
		// }
		// else
		// {
		// 	$data['gambar'] = $this->upload->data('file_name');
		// }
		$cek = $this->db->insert('tblanime',$data);
		if ($cek) {
			$this->session->set_flashdata('info','Data Berhasil Ditambahkan!');
		}
		unset($_POST);
		redirect();
	}
	public function edit(){
		$where = [
			'username' => $this->session->userdata('username'),
			'status'   => 1
		];
		$data['user'] = $this->db->get_where('tbluser',$where)->row_array();
		$user_id = @$data['user']['id'];
		$data = [
			'judul'		=> $this->input->post('judul'),
			'season'	=> $this->input->post('season'),
			'tahun'		=> $this->input->post('tahun'),
			'last_view_eps'	=> $this->input->post('last_view_eps'),
			'total_eps'	=> $this->input->post('total_eps'),
			'status'	=> $this->input->post('status'),
			'foto' 		=> $this->input->post('foto'),
			'catatan' 	=> $this->input->post('catatan'),
			'platform' 	=> $this->input->post('platform'),
			'hari' 		=> $this->input->post('hari'),
			'pukul' 	=> $this->input->post('pukul'),
			'user_id' 	=> $user_id,
		];
		// $config['upload_path']          = './img';
		// $config['allowed_types']        = 'gif|jpg|png|bmp|jpeg';
		// $config['max_size']             = 1000;
		// $config['max_width']            = 1024;
		// $config['max_height']           = 768;
		// $this->load->library('upload', $config);

		// if (!$this->upload->do_upload('foto'))
		// {
		// 	if ($this->upload->data('file_name') != null) {
		// 		$error = $this->upload->display_errors();
		// 		$this->session->set_flashdata('danger',$error);
		// 		redirect();
		// 		die;
		// 	}
		// }
		// else
		// {
		// 	$data['gambar'] = $this->upload->data('file_name');
		// }
		$this->db->where('id',$this->input->post('id'));
		$cek = $this->db->update('tblanime',$data);
		if ($cek) {
			$this->session->set_flashdata('info','Data Berhasil Diubah!');
		}
		unset($_POST);
		redirect();
	}
	public function updateStatus(){
		$month = date('m');
	    $season=0;
		if ($month>=1 && $month<=3) {
			$season = 1;
		} else if ($month>=4 && $month<=6) {
			$season = 2;
		} else if ($month>=7 && $month<=9) {
			$season = 3;
		} else if ($month>=10 && $month<=12) {
			$season = 4;
		}
		$this->db->where('season',$season);
		$this->db->where('tahun',date('Y'));
		$this->db->where('status',0);
		$data = [
		    'status' => 1,
		];
		$cek = $this->db->update('tblanime',$data);
		if ($cek) {
			$this->session->set_flashdata('info','Status Berhasil Diubah!');
		}
		redirect('user/kategori/1');
	}
	public function nextEps(){
		$id = $_POST['id'];
		$dataLama = $this->db->get_where('tblanime',['id'=>$id])->row_array();
		$eps = @$dataLama['last_view_eps']+1;
		$data = [
		    'last_view_eps' => $eps
		];
		$this->db->where('id',$id);
		$cek = $this->db->update('tblanime',$data);
		// if ($cek) {
		// 	$this->session->set_flashdata('info','Data Berhasil Diubah!');
		// }
		// redirect('user/kategori/1');
		echo $eps;
	}
	public function printPDF(){
		$where = [
			'username' => $this->session->userdata('username'),
			'status'   => 1
		];
		$data['user'] = $this->db->get_where('tbluser',$where)->row_array();
		$user_id = @$data['user']['id'];
		$this->db->order_by('tahun','DESC');
		$this->db->order_by('season','ASC');
		$this->db->order_by('judul','ASC');
		$where2 = ['user_id'=>$user_id];
		$data['cetak'] = $this->db->get_where('tblanime',$where2)->result();
		// $data['cetak'] = $this->db->get('tblanime')->result();
		$this->load->view('crud/cetak-pdf',$data);
		$html = $this->output->get_output();
		//$this->load->library('Dompdf_gen');
		//$this->dompdf->load_html($html);
		//$this->dompdf->render();
		//$this->dompdf->stream("cetak.pdf",array('Attachment'=>0));
		
		require_once APPPATH.'third_party/dompdf/dompdf_config.inc.php';
        $dompdf = new DOMPDF();
        $filename = "MyAnimeWatchList - ".@$data['user']['username'].".pdf";
        $dompdf->load_html($html);
        $dompdf->set_paper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream($filename,array("Attachment"=>false));
	}
	public function printExcel(){
		$where = [
			'username' => $this->session->userdata('username'),
			'status'   => 1
		];
		$data['user'] = $this->db->get_where('tbluser',$where)->row_array();
		$user_id = @$data['user']['id'];
		$username= @$data['user']['username'];

        $objPHPExcel = new \PHPExcel();

        $title = "MyAnimeWatchList - ".$username;

        $objPHPExcel->getProperties()->setCreator($username)
                                     ->setLastModifiedBy($username)
                                     ->setTitle($title)
                                     ->setSubject("MyAnimeWatchList")
                                     ->setDescription("MyAnimeWatchList")
                                     ->setKeywords("MyAnimeWatchList")
                                     ->setCategory("MyAnimeWatchList");
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A3', 'No.')
            ->setCellValue('B3', 'Judul')
            ->setCellValue('C3', 'Season')
            ->setCellValue('D3', 'Tahun')
            ->setCellValue('E3', 'Status')
            ->setCellValue('F3', 'Catatan')
            ->setCellValue('G3', 'Platform');
        $no=1;
		$this->db->order_by('tahun','DESC');
		$this->db->order_by('season','ASC');
		$this->db->order_by('judul','ASC');
		$data['cetak'] = $this->db->get_where('tblanime',['user_id'=>$user_id])->result();
		// $data['cetak'] = $this->db->get('tblanime')->result();
        foreach ($data['cetak'] as $key => $value) {
			if ($value->season==1) {
				$season = "Winter";
			} else if ($value->season==2) {
				$season = "Spring";
			} else if ($value->season==3) {
				$season = "Summer";
			} else if ($value->season==4) {
				$season = "Fall";
			} else { $season = "-"; }
			if ($value->status==0) {
				$status = "SCHEDULE";
			} else if ($value->status==1) {
				$status = "ONGOING";
			} else if ($value->status==2) {
				$status = "FINISHED";
			} else { $status = "-"; }
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.($key + 4), $no++)
                    ->setCellValue('B'.($key + 4), $value->judul)
                    ->setCellValue('C'.($key + 4), $season)
                    ->setCellValue('D'.($key + 4), $value->tahun)
                    ->setCellValue('E'.($key + 4), $status)
                    ->setCellValue('F'.($key + 4), $value->catatan)
                    ->setCellValue('G'.($key + 4), $value->platform);
        }            

        $objPHPExcel->getActiveSheet()->setTitle($title);

        $objPHPExcel->setActiveSheetIndex(0); 

        $writer = new PHPExcel_Writer_Excel2007($objPHPExcel);
        
        $filepath = "MyAnimeWatchList (".$username.").xlsx";

        try {
            $writer->save($filepath);
            echo "<script>alert('Berhasil')</script>Berhasil";
			$this->session->set_flashdata('info','Berhasil!');
			redirect();
            
        } catch (Exception $e) {
            echo "<script>alert('Berhasil')</script>Gagal";
			$this->session->set_flashdata('danger','Gagal!');
			redirect();
        }
	}
	
	public function demoAccount()
	{
		$this->load->view('crud/demoAccount');
	}
}
