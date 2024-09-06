<?php
class m_jenis_pemb extends CI_Model{

	function hapus_kategori($kode){
		$hsl=$this->db->query("DELETE FROM tbl_jenis_pembayaran where id='$kode'");
		return $hsl;
	}

	function update_kategori($kode,$kat){
		$hsl=$this->db->query("UPDATE tbl_jenis_pembayaran set jenis='$kat' where id='$kode'");
		return $hsl;
	}

	function tampil_kategori(){
		$hsl=$this->db->query("select * from tbl_jenis_pembayaran order by id desc");
		return $hsl;
	}

	function simpan_kategori($kat){
		$hsl=$this->db->query("INSERT INTO tbl_jenis_pembayaran(jenis) VALUES ('$kat')");
		return $hsl;
	}

}