<?php

class m_pelanggan extends CI_Model{
	function get_pengguna(){
		$hsl=$this->db->query("SELECT * FROM tbl_pelanggan");
		return $hsl;
	}
	function tampil_pelanggan($role){
		$hsl=$this->db->query("SELECT * FROM tbl_pelanggan where role='". $role ."'");
		return $hsl;
	}

    function simpan_pelanggan($nama,$alamat,$no_telp,$role){
		$hsl=$this->db->query("INSERT INTO tbl_pelanggan(nama,alamat,no_telp,role) VALUES ('$nama','$alamat','$no_telp','$role')");
		return $hsl;
	}
	function update_pelanggan($id,$nama,$alamat,$no_telp,$role){
		$hsl=$this->db->query("UPDATE tbl_pelanggan SET nama='$nama',alamat='$alamat',no_telp='$no_telp',role='$role' WHERE id='$id'");
		return $hsl;
	}
	function hapus($kode){
		$hsl=$this->db->query("DELETE FROM tbl_pelanggan WHERE id='$kode'");
		return $hsl;
	}
}