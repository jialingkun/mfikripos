<?php

class pelanggan extends CI_Controller{
    function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('m_pelanggan');
	}

    function index(){
        if($this->session->userdata('akses')=='1' || $this->session->userdata('akses')=='2'){
            $data['data']=$this->m_pelanggan->get_pengguna();
            $this->load->view('admin/v_pelanggan',$data);
        }else{
            echo "Halaman tidak ditemukan";
        }
    }

    function tambah_pelanggan(){
        if($this->session->userdata('akses')=='1'){
            $nama=$this->input->post('nama');
            $alamat=$this->input->post('alamat');
            $no_telp=$this->input->post('no_telp');
            $role=$this->input->post('role');
            $this->m_pelanggan->simpan_pelanggan($nama,$alamat,$no_telp,$role);
            echo $this->session->set_flashdata('msg','<label class="label label-success">Pelanggan Berhasil ditambahkan</label>');
            redirect('admin/pelanggan');
            
        }else{
            echo "Halaman tidak ditemukan";
        }
        }

        function edit_pelanggan(){
            if($this->session->userdata('akses')=='1'){
                $id=$this->input->post('id');
                $nama=$this->input->post('nama');
                $alamat=$this->input->post('alamat');
                $no_telp=$this->input->post('no_telp');
                $role=$this->input->post('role');
                    $this->m_pelanggan->update_pelanggan($id,$nama,$alamat,$no_telp,$role);
                    echo $this->session->set_flashdata('msg','<label class="label label-success">Pengguna Berhasil diupdate</label>');
                    redirect('admin/pelanggan');

            }else{
                echo "Halaman tidak ditemukan";
            }
            }

        function hapus(){
            if($this->session->userdata('akses')=='1'){
                $kode=$this->input->post('kode');
                $this->m_pelanggan->hapus($kode);
                redirect('admin/pelanggan');
            }else{
                echo "Halaman tidak ditemukan";
            }
            }


}