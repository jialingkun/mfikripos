<?php
class m_penjualan extends CI_Model{

	function hapus_retur($kode){
		$hsl=$this->db->query("DELETE FROM tbl_retur WHERE retur_id='$kode'");
		return $hsl;
	}

	function tampil_retur(){
		$hsl=$this->db->query("SELECT retur_id,DATE_FORMAT(retur_tanggal,'%d/%m/%Y') AS retur_tanggal,retur_barang_id,retur_barang_nama,retur_barang_satuan,retur_harjul,retur_qty,(retur_harjul*retur_qty) AS retur_subtotal,retur_keterangan FROM tbl_retur ORDER BY retur_id DESC");
		return $hsl;
	}

	function simpan_retur($kobar,$nabar,$satuan,$harjul,$qty,$keterangan){
		$hsl=$this->db->query("INSERT INTO tbl_retur(retur_barang_id,retur_barang_nama,retur_barang_satuan,retur_harjul,retur_qty,retur_keterangan) VALUES ('$kobar','$nabar','$satuan','$harjul','$qty','$keterangan')");
		return $hsl;
	}

	function simpan_penjualan($nofak,$total,$jml_uang,$kembalian,$pelanggan,$id_pemb,$ket_pemb){
		$idadmin=$this->session->userdata('idadmin');
		$this->db->query("INSERT INTO tbl_jual (jual_nofak,jual_total,jual_jml_uang,jual_kembalian,jual_user_id,jual_keterangan,pelanggan,id_pembayaran,keterangan_pembayaran) VALUES ('$nofak','$total','$jml_uang','$kembalian','$idadmin','eceran','$pelanggan','$id_pemb','$ket_pemb')");
		foreach ($this->cart->contents() as $item) {
			$data=array(
				'd_jual_nofak' 			=>	$nofak,
				'd_jual_barang_id'		=>	$item['id'],
				'd_jual_barang_nama'	=>	$item['name'],
				'd_jual_barang_satuan'	=>	$item['satuan'],
				'd_jual_barang_harpok'	=>	$item['harpok'],
				'd_jual_barang_harjul'	=>	$item['amount'],
				'd_jual_qty'			=>	$item['qty'],
				'd_jual_diskon'			=>	$item['disc'],
				'd_jual_total'			=>	$item['subtotal']
			);
			$this->db->insert('tbl_detail_jual',$data);
			$this->db->query("update tbl_barang set barang_stok=barang_stok-'$item[qty]' where barang_id='$item[id]'");
		}
		return true;
	}
	function get_nofak(){
		$q = $this->db->query("SELECT MAX(RIGHT(jual_nofak,6)) AS kd_max FROM tbl_jual WHERE DATE(jual_tanggal)=CURDATE()");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%06s", $tmp);
            }
        }else{
            $kd = "000001";
        }
        return date('dmy').$kd;
	}

	//=====================Penjualan grosir================================
	function simpan_penjualan_grosir($nofak,$total,$jml_uang,$kembalian,$pelanggan,$id_pemb,$ket_pemb){
		$idadmin=$this->session->userdata('idadmin');
		$this->db->query("INSERT INTO tbl_jual (jual_nofak,jual_total,jual_jml_uang,jual_kembalian,jual_user_id,jual_keterangan,pelanggan,id_pembayaran,keterangan_pembayaran) VALUES ('$nofak','$total','$jml_uang','$kembalian','$idadmin','grosir','$pelanggan','$id_pemb','$ket_pemb')");
		foreach ($this->cart->contents() as $item) {
			$data=array(
				'd_jual_nofak' 			=>	$nofak,
				'd_jual_barang_id'		=>	$item['id'],
				'd_jual_barang_nama'	=>	$item['name'],
				'd_jual_barang_satuan'	=>	$item['satuan'],
				'd_jual_barang_harpok'	=>	$item['harpok'],
				'd_jual_barang_harjul'	=>	$item['amount'],
				'd_jual_qty'			=>	$item['qty'],
				'd_jual_diskon'			=>	$item['disc'],
				'd_jual_total'			=>	$item['subtotal']
			);
			$this->db->insert('tbl_detail_jual',$data);
			$this->db->query("update tbl_barang set barang_stok=barang_stok-'$item[qty]' where barang_id='$item[id]'");
		}
		return true;
	}

	function simpan_penjualan_member($nofak,$total,$jml_uang,$kembalian,$pelanggan,$id_pemb,$ket_pemb){
		$idadmin=$this->session->userdata('idadmin');
		$this->db->query("INSERT INTO tbl_jual (jual_nofak,jual_total,jual_jml_uang,jual_kembalian,jual_user_id,jual_keterangan,pelanggan,id_pembayaran,keterangan_pembayaran) VALUES ('$nofak','$total','$jml_uang','$kembalian','$idadmin','member','$pelanggan','$id_pemb','$ket_pemb')");
		foreach ($this->cart->contents() as $item) {
			$data=array(
				'd_jual_nofak' 			=>	$nofak,
				'd_jual_barang_id'		=>	$item['id'],
				'd_jual_barang_nama'	=>	$item['name'],
				'd_jual_barang_satuan'	=>	$item['satuan'],
				'd_jual_barang_harpok'	=>	$item['harpok'],
				'd_jual_barang_harjul'	=>	$item['amount'],
				'd_jual_qty'			=>	$item['qty'],
				'd_jual_diskon'			=>	$item['disc'],
				'd_jual_total'			=>	$item['subtotal']
			);
			$this->db->insert('tbl_detail_jual',$data);
			$this->db->query("update tbl_barang set barang_stok=barang_stok-'$item[qty]' where barang_id='$item[id]'");
		}
		return true;
	}

	function cetak_faktur(){
		$nofak=$this->session->userdata('nofak');
		$hsl=$this->db->query("SELECT jual_nofak,DATE_FORMAT(jual_tanggal,'%d/%m/%Y %H:%i:%s') AS jual_tanggal,jual_total,jual_jml_uang,jual_kembalian,jual_keterangan,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE jual_nofak='$nofak'");
		return $hsl;
	}

	public function datatable($postData){
		$response = array();
	
		// Membaca nilai
		$draw = $postData['draw'];
		$start = $postData['start'];
		$rowperpage = $postData['length']; // Baris yang ditampilkan per halaman
		if(isset($postData['order'])){
			$columnIndex = $postData['order'][0]['column'];
			$columnName = $postData['columns'][$columnIndex]['data']; // Nama Kolom
		$columnSortOrder = $postData['order'][0]['dir']; // asc or desc
		}
		 // Indeks Kolom
		
		$searchValue = $postData['search']['value']; // Nilai Pencarian
	
		// Pencarian
		$searchQuery = "";
		if ($searchValue != '') {
			$searchQuery = " (jual_nofak like '%" . $searchValue . "%' ) ";
		}
	
		// Jumlah total rekaman tanpa filtering
		$totalRecords = $this->db->count_all('tbl_jual'); // Ubah dengan nama tabel
	
		// Jumlah total rekaman dengan filtering
		$this->db->select('COUNT(*) as allcount');
		$this->db->from('tbl_jual'); // Ubah dengan nama tabel
		if ($searchQuery != '') {
			$this->db->where($searchQuery);
		}
		$records = $this->db->get()->result();
		$totalRecordwithFilter = $records[0]->allcount;
	
		// Mengambil rekaman
		$this->db->select('*,tbl_user.user_nama,tbl_jenis_pembayaran.jenis as jenis_pemb');
		$this->db->from('tbl_jual');
		$this->db->join('tbl_user', 'tbl_user.user_id = tbl_jual.jual_user_id');
		$this->db->join('tbl_jenis_pembayaran','tbl_jenis_pembayaran.id = tbl_jual.id_pembayaran','left');
		 // Ubah dengan nama tabel
		if ($searchQuery != '') {
			$this->db->where($searchQuery);
		}
		// if (isset($postData['status'])) {
		// 	$this->db->where('status', $postData['status']);
		// }
		if (isset($postData['where'])) {
			$this->db->where($postData['where']);
		}
		if (isset($postData['order'])) {
			if(!$columnName || !$columnSortOrder || !$columnIndex){
				$this->db->order_by('jual_tanggal', 'desc');
			} else {
				$this->db->order_by($columnName, $columnSortOrder);
			}
		}
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get()->result_array();
	
		$data = array();
		$dataTambahan = array();
		foreach ($records as $record) {
			$id = $record['jual_nofak'];
			$dataTambahan['item'] = $this->db->where('d_jual_nofak', $id)
                ->get('tbl_detail_jual')
                ->result_array();

			$confirm = "'Apa anda yakin menghapus data ini?'";
			$word = '
			';
	$record = array_merge($dataTambahan,$record);
			$data[] = array_merge($record, array('action' => $word));
		}
	
		// Respons
		$response = array(
			"draw" => intval($draw),
			"recordsTotal" => $totalRecords,
			"recordsFiltered" => $totalRecordwithFilter,
			"data" => $data,
		);
	
		return $response;
	}
	
	
}