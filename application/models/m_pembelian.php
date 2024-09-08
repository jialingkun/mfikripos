<?php
class m_pembelian extends CI_Model{

	function simpan_pembelian($nofak,$tglfak,$suplier,$beli_kode,$id_pembelian,$ket){
		$idadmin=$this->session->userdata('idadmin');
		$this->db->query("INSERT INTO tbl_beli (beli_nofak,beli_tanggal,beli_suplier_id,beli_user_id,beli_kode,id_pembayaran,keterangan_pembayaran) VALUES ('$nofak','$tglfak','$suplier','$idadmin','$beli_kode','$id_pembelian','$ket')");
		foreach ($this->cart->contents() as $item) {
			$data=array(
				'd_beli_nofak' 		=>	$nofak,
				'd_beli_barang_id'	=>	$item['id'],
				'd_beli_harga'		=>	$item['price'],
				'd_beli_jumlah'		=>	$item['qty'],
				'd_beli_total'		=>	$item['subtotal'],
				'd_beli_kode'		=>	$beli_kode
			);
			$this->db->insert('tbl_detail_beli',$data);
			$this->db->query("update tbl_barang set barang_stok=barang_stok+'$item[qty]',barang_harpok='$item[price]',barang_harjul='$item[harga]' where barang_id='$item[id]'");
		}
		return true;
	}
	function get_kobel(){
		$q = $this->db->query("SELECT MAX(RIGHT(beli_kode,6)) AS kd_max FROM tbl_beli WHERE DATE(beli_tanggal)=CURDATE()");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%06s", $tmp);
            }
        }else{
            $kd = "000001";
        }
        return "BL".date('dmy').$kd;
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
			$searchQuery = "(beli_nofak like '%" . $searchValue . "%' OR beli_kode like '%" . $searchValue . "%')";
		}
	
		// Jumlah total rekaman tanpa filtering
		$totalRecords = $this->db->count_all('tbl_beli'); // Ubah dengan nama tabel
	
		// Jumlah total rekaman dengan filtering
		$this->db->select('COUNT(*) as allcount');
		$this->db->from('tbl_beli'); // Ubah dengan nama tabel
		if ($searchQuery != '') {
			$this->db->where($searchQuery);
		}
		$records = $this->db->get()->result();
		$totalRecordwithFilter = $records[0]->allcount;
	
		// Mengambil rekaman
		$this->db->select('*,tbl_user.user_nama,tbl_jenis_pembayaran.jenis as jenis_pemb');
		$this->db->from('tbl_beli');
		$this->db->join('tbl_user', 'tbl_user.user_id = tbl_beli.beli_user_id');
		$this->db->join('tbl_jenis_pembayaran','tbl_jenis_pembayaran.id = tbl_beli.id_pembayaran','left');
		$this->db->join('tbl_suplier','tbl_suplier.suplier_id = tbl_beli.beli_suplier_id','left');
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
				$this->db->order_by('beli_tanggal', 'desc');
			} else {
				$this->db->order_by($columnName, $columnSortOrder);
			}
		}
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get()->result_array();
	
		$data = array();
		$dataTambahan = array();
		foreach ($records as $record) {
			$id = $record['beli_nofak'];
			$dataTambahan['item'] = $this->db->select('*')->where('d_beli_nofak', $id)
			->from('tbl_detail_beli')
			->join('tbl_barang','tbl_barang.barang_id = tbl_detail_beli.d_beli_barang_id')
            ->get()
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