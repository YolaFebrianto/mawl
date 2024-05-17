<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');

	class M_pildun extends CI_Model{
		public function all_nations_list(){
			$this->db->order_by('negara','ASC');
			$res = $this->db->get('negara');
			return $res;
		}
		public function all_nations(){
			$res = $this->db->query("SELECT 
				    e.kode,e.negara,e.konfederasi,e.grup,e.babak,
					SUM(e.GM) AS GM, SUM(e.GK) AS GK,
					SUM(e.SELISIH) AS SELISIH, SUM(e.POIN) AS POIN, 
					SUM(e.M) AS M, SUM(e.S) AS S, SUM(e.K) AS K
				FROM (
				    SELECT a.kode,a.negara,a.konfederasi,a.grup,b.babak,
				    b.skor1 AS GM,
				    b.skor2 AS GK,
				    b.skor1-b.skor2 AS SELISIH,
				    IF(b.skor1=b.skor2, 1, IF(b.skor1<b.skor2, 0, 3)) AS POIN, 
				    IF(b.skor1>b.skor2, 1, 0) AS M,
				    IF(b.skor1=b.skor2, 1, 0) AS S,
				    IF(b.skor1<b.skor2, 1, 0) AS K,b.tanggal
				    FROM negara a INNER JOIN pertandingan b ON a.kode=b.negara1
				    UNION
				    SELECT c.kode,c.negara,c.konfederasi,c.grup,d.babak,
				    d.skor2 AS GM,
				    d.skor1 AS GK,
				    d.skor2-d.skor1 AS SELISIH,
				    IF(d.skor2=d.skor1, 1, IF(d.skor2<d.skor1, 0, 3)) AS POIN, 
				    IF(d.skor2>d.skor1, 1, 0) AS M,
				    IF(d.skor2=d.skor1, 1, 0) AS S,
				    IF(d.skor2<d.skor1, 1, 0) AS K,d.tanggal
				    FROM negara c INNER JOIN pertandingan d ON c.kode=d.negara2
				    GROUP BY kode,tanggal
				) AS e
				GROUP BY e.kode
				ORDER BY POIN DESC,SELISIH DESC,GM DESC");
			return $res;
		}
		public function grup($grup){
			$res = $this->db->query("SELECT
					e.kode,e.negara,e.konfederasi,e.grup,
					SUM(e.GM) AS GM, SUM(e.GK) AS GK,
					SUM(e.SELISIH) AS SELISIH, SUM(e.POIN) AS POIN, 
					SUM(e.M) AS M, SUM(e.S) AS S, SUM(e.K) AS K
				FROM (
				    SELECT a.kode,a.negara,a.konfederasi,a.grup,
				    b.skor1 AS GM,
				    b.skor2 AS GK,
				    b.skor1-b.skor2 AS SELISIH,
				    IF(b.skor1=b.skor2, 1, IF(b.skor1<b.skor2, 0, 3)) AS POIN, 
				    IF(b.skor1>b.skor2, 1, 0) AS M,
				    IF(b.skor1=b.skor2, 1, 0) AS S,
				    IF(b.skor1<b.skor2, 1, 0) AS K,b.tanggal
				    FROM negara a INNER JOIN pertandingan b ON a.kode=b.negara1
				    WHERE a.grup='$grup' AND b.babak LIKE '%grup%'
				    UNION
				    SELECT c.kode,c.negara,c.konfederasi,c.grup,
				    d.skor2 AS GM,
				    d.skor1 AS GK,
				    d.skor2-d.skor1 AS SELISIH,
				    IF(d.skor2=d.skor1, 1, IF(d.skor2<d.skor1, 0, 3)) AS POIN, 
				    IF(d.skor2>d.skor1, 1, 0) AS M,
				    IF(d.skor2=d.skor1, 1, 0) AS S,
				    IF(d.skor2<d.skor1, 1, 0) AS K,d.tanggal
				    FROM negara c INNER JOIN pertandingan d ON c.kode=d.negara2
				    WHERE c.grup='$grup' AND d.babak LIKE '%grup%'
				    GROUP BY kode,tanggal
				) AS e
				GROUP BY e.kode
				ORDER BY POIN DESC,SELISIH DESC,GM DESC");
			return $res;
		}
		public function konfederasi($konfederasi){
			$res = $this->db->get_where('negara',['konfederasi'=>$konfederasi]);
			return $res;
		}
		public function all_match(){
			$res = $this->db->query('SELECT b.negara AS negara1,a.skor1,a.skor2,c.negara AS negara2,a.babak,a.tanggal,a.keterangan FROM pertandingan a LEFT JOIN negara b ON a.negara1=b.kode LEFT JOIN negara c ON a.negara2=c.kode');
			return $res;
		}
		public function get_last_round($kode)
		{
			$res = $this->db->query("SELECT babak FROM pertandingan 
				WHERE negara1='$kode' OR negara2='$kode' 
				ORDER BY tanggal DESC LIMIT 1");
			return $res;
		}
	}