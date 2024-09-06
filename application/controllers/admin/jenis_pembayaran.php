<?php
class jenis_pembayaran extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('m_jenis_pemb');
	}
	function index(){
	if($this->session->userdata('akses')=='1'){
		$data['data']=$this->m_jenis_pemb->tampil_kategori();
		$this->load->view('admin/v_jenis_pemb',$data);
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function tambah_kategori(){
	if($this->session->userdata('akses')=='1'){
		$kat=$this->input->post('jenis');
		$this->m_jenis_pemb->simpan_kategori($kat);
		redirect('admin/jenis_pembayaran');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function edit_kategori(){
	if($this->session->userdata('akses')=='1'){
		$kode=$this->input->post('id');
		$kat=$this->input->post('jenis');
		$this->m_jenis_pemb->update_kategori($kode,$kat);
		redirect('admin/jenis_pembayaran');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function hapus_kategori(){
	if($this->session->userdata('akses')=='1'){
		$kode=$this->input->post('id');
		$this->m_jenis_pemb->hapus_kategori($kode);
		redirect('admin/jenis_pembayaran');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
}