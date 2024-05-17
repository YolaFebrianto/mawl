<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');

	class M_pildun extends CI_Model{
	    public function event($event_id=''){
	        if(empty($event_id)){
	            $event_id=get_event_id();
	        }
	        $res = $this->db->query("SELECT * FROM event WHERE id='$event_id'");
			return $res;
	    }
	    public function grup_count($event_id=''){
	        if(empty($event_id)){
	            $event_id=get_event_id();
	        }
	        $res = $this->db->query("SELECT COUNT(DISTINCT p.grup) AS jumlah_grup FROM negara n 
			    INNER JOIN peserta p ON p.negara_id=n.id 
			    WHERE p.negara_id=n.id AND p.event_id='$event_id'
				ORDER BY n.negara ASC");
			return $res;
	    }
		public function all_nations_list($event_id=''){
	        if(empty($event_id)){
	            $event_id=get_event_id();
	        }
			$res = $this->db->query("SELECT n.id,n.kode,n.negara,n.konfederasi,p.event_id,p.grup FROM negara n 
			    INNER JOIN peserta p ON p.negara_id=n.id 
			    WHERE p.negara_id=n.id AND p.event_id='$event_id'
				ORDER BY n.negara ASC");
			return $res;
		}
		public function all_nations($event_id=''){
	        if(empty($event_id)){
	            $event_id=get_event_id();
	        }
			$res = $this->db->query("SELECT 
				    e.kode,e.negara,e.konfederasi,e.grup,e.babak,
					SUM(e.GM) AS GM, SUM(e.GK) AS GK,
					SUM(e.SELISIH) AS SELISIH, SUM(e.POIN) AS POIN, 
					SUM(e.M) AS M, SUM(e.S) AS S, SUM(e.K) AS K
				FROM (
				    SELECT a.kode,a.negara,a.konfederasi,p0.grup,b.babak,
				    b.skor1 AS GM,
				    b.skor2 AS GK,
				    b.skor1-b.skor2 AS SELISIH,
				    IF(b.skor1=b.skor2, 1, IF(b.skor1<b.skor2, 0, 3)) AS POIN, 
				    IF(b.skor1>b.skor2, 1, 0) AS M,
				    IF(b.skor1=b.skor2, 1, 0) AS S,
				    IF(b.skor1<b.skor2, 1, 0) AS K,b.tanggal
				    FROM negara a INNER JOIN pertandingan b ON a.kode=b.negara1
				    LEFT JOIN peserta p0 ON p0.negara_id=a.id AND p0.event_id='$event_id'
				    WHERE b.event_id='$event_id'
				    UNION
				    SELECT c.kode,c.negara,c.konfederasi,p1.grup,d.babak,
				    d.skor2 AS GM,
				    d.skor1 AS GK,
				    d.skor2-d.skor1 AS SELISIH,
				    IF(d.skor2=d.skor1, 1, IF(d.skor2<d.skor1, 0, 3)) AS POIN, 
				    IF(d.skor2>d.skor1, 1, 0) AS M,
				    IF(d.skor2=d.skor1, 1, 0) AS S,
				    IF(d.skor2<d.skor1, 1, 0) AS K,d.tanggal
				    FROM negara c INNER JOIN pertandingan d ON c.kode=d.negara2
				    LEFT JOIN peserta p1 ON p1.negara_id=c.id AND p1.event_id='$event_id'
				    WHERE d.event_id='$event_id'
				    GROUP BY kode,tanggal
				) AS e
				GROUP BY e.kode
				ORDER BY POIN DESC,SELISIH DESC,GM DESC");
			return $res;
		}
		public function grup($grup,$event_id=''){
	        if(empty($event_id)){
	            $event_id=get_event_id();
	        }
			$res = $this->db->query("SELECT
					e.kode,e.negara,e.konfederasi,e.grup,
					SUM(e.GM) AS GM, SUM(e.GK) AS GK,
					SUM(e.SELISIH) AS SELISIH, SUM(e.POIN) AS POIN, 
					SUM(e.M) AS M, SUM(e.S) AS S, SUM(e.K) AS K
				FROM (
				    SELECT a.kode,a.negara,a.konfederasi,p0.grup,
				    b.skor1 AS GM,
				    b.skor2 AS GK,
				    b.skor1-b.skor2 AS SELISIH,
				    IF(b.skor1=b.skor2, 1, IF(b.skor1<b.skor2, 0, 3)) AS POIN, 
				    IF(b.skor1>b.skor2, 1, 0) AS M,
				    IF(b.skor1=b.skor2, 1, 0) AS S,
				    IF(b.skor1<b.skor2, 1, 0) AS K,b.tanggal
				    FROM negara a INNER JOIN pertandingan b ON a.kode=b.negara1
				    LEFT JOIN peserta p0 ON p0.negara_id=a.id AND p0.event_id='$event_id'
				    WHERE p0.grup='$grup' AND b.babak LIKE '%grup%' AND b.event_id='$event_id'
				    UNION
				    SELECT c.kode,c.negara,c.konfederasi,p1.grup,
				    d.skor2 AS GM,
				    d.skor1 AS GK,
				    d.skor2-d.skor1 AS SELISIH,
				    IF(d.skor2=d.skor1, 1, IF(d.skor2<d.skor1, 0, 3)) AS POIN, 
				    IF(d.skor2>d.skor1, 1, 0) AS M,
				    IF(d.skor2=d.skor1, 1, 0) AS S,
				    IF(d.skor2<d.skor1, 1, 0) AS K,d.tanggal
				    FROM negara c INNER JOIN pertandingan d ON c.kode=d.negara2
				    LEFT JOIN peserta p1 ON p1.negara_id=c.id AND p1.event_id='$event_id'
				    WHERE p1.grup='$grup' AND d.babak LIKE '%grup%' AND d.event_id='$event_id'
				    GROUP BY kode,tanggal
				) AS e
				GROUP BY e.kode
				ORDER BY POIN DESC,SELISIH DESC,GM DESC");
			return $res;
		}
		public function konfederasi($konfederasi,$event_id=''){
	        if(empty($event_id)){
	            $event_id=get_event_id();
	        }
			$res = $this->db->query("SELECT n.id,n.kode,n.negara,n.konfederasi,p.event_id,p.grup FROM negara n 
			    INNER JOIN peserta p ON p.negara_id=n.id 
			    WHERE p.negara_id=n.id AND p.event_id='$event_id' AND n.konfederasi='$konfederasi'
				ORDER BY n.negara ASC");
			return $res;
		}
		public function all_match($event_id=''){
	        if(empty($event_id)){
	            $event_id=get_event_id();
	        }
			$res = $this->db->query("SELECT b.negara AS negara1,a.skor1,a.skor2,c.negara AS negara2,a.babak,a.tanggal,a.keterangan FROM pertandingan a LEFT JOIN negara b ON a.negara1=b.kode LEFT JOIN negara c ON a.negara2=c.kode WHERE a.event_id='$event_id'");
			return $res;
		}
		public function all_ost(){
			$res = $this->db->query("SELECT * FROM ost_list ORDER BY anime ASC, jenis DESC, urutan ASC, judul ASC, artis ASC");
			return $res;
		}
		public function get_last_round($kode,$event_id='')
		{
	        if(empty($event_id)){
	            $event_id=get_event_id();
	        }
			$res = $this->db->query("SELECT babak FROM pertandingan 
				WHERE (negara1='$kode' OR negara2='$kode') AND event_id='$event_id'
				ORDER BY tanggal DESC LIMIT 1");
			return $res;
		}
	}