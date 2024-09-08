<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Produk By Mfikri.com">
    <meta name="author" content="M Fikri Setiadi">

    <title>Welcome To Point of Sale Apps</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url().'assets/css/bootstrap.min.css'?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/css/style.css'?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/css/font-awesome.css'?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url().'assets/css/4-col-portfolio.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/css/dataTables.bootstrap.min.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/css/jquery.dataTables.min.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/dist/css/bootstrap-select.css'?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/bootstrap-datetimepicker.min.css'?>">
    <link href="https://cdn.datatables.net/2.0.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
	<link href="https://cdn.datatables.net/responsive/3.0.0/css/responsive.bootstrap5.min.css"/>
</head>

<body>

    <!-- Navigation -->
   <?php 
        $this->load->view('admin/menu');
   ?>

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
            <center><?php echo $this->session->flashdata('msg');?></center>
                <h1 class="page-header">Transaksi
                    <small>Penjualan (Grosir)</small>
                </h1>
            </div>
        </div>
        <!-- /.row -->
        <!-- Projects Row -->
        <div class="row">
            <div class="col-lg-12">
            <form action="<?php echo base_url().'admin/penjualan_grosir/add_to_cart'?>" method="post">
                    <div><a href="#" class="btn btn-success" data-toggle="modal" data-target="#largeModal"><span class="fa fa-search"></span> Cari Produk</a></div><br>
            <table>
                <tr>
                    <th>Kode Barang</th>
                </tr>
                <tr>
                    <th><input type="text" name="kode_brg" id="kode_brg" class="form-control input-sm"></th>                     
                </tr>
                    <div id="detail_barang" style="position:absolute;">
                    </div>
            </table>
             </form>
            <table class="table table-bordered table-condensed" style="font-size:11px;margin-top:10px;">
                <thead>
                    <tr>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th style="text-align:center;">Satuan</th>
                        <th style="text-align:center;">Harga(Rp)</th>
                        <th style="text-align:center;">Diskon(Rp)</th>
                        <th style="text-align:center;">Qty</th>
                        <th style="text-align:center;">Sub Total</th>
                        <th style="width:100px;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($this->cart->contents() as $items): ?>
                    <?php echo form_hidden($i.'[rowid]', $items['rowid']); ?>
                    <tr>
                         <td><?=$items['id'];?></td>
                         <td><?=$items['name'];?></td>
                         <td style="text-align:center;"><?=$items['satuan'];?></td>
                         <td style="text-align:right;"><?php echo number_format($items['amount']);?></td>
                         <td style="text-align:right;"><?php echo number_format($items['disc']);?></td>
                         <td style="text-align:center;"><?php echo number_format($items['qty']);?></td>
                         <td style="text-align:right;"><?php echo number_format($items['subtotal']);?></td>
                        
                         <td style="text-align:center;"><a href="<?php echo base_url().'admin/penjualan_grosir/remove/'.$items['rowid'];?>" class="btn btn-warning btn-xs"><span class="fa fa-close"></span> Batal</a></td>
                    </tr>
                    
                    <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <form action="<?php echo base_url().'admin/penjualan_grosir/simpan_penjualan_grosir'?>" method="post">
            <table>
                <tr>
                    <td style="width:760px;" rowspan="2">
                    <select name="pelanggan" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih Pelanggan Grosir" data-width="260px" required>
                        <?php foreach ($sup->result_array() as $i) {
                            $id_sup=$i['id'];
                            $nm_sup=$i['nama'];
                            $al_sup=$i['alamat'];
                            $notelp_sup=$i['no_telp'];

                           echo "<option value='$nm_sup'>$nm_sup - $al_sup - $notelp_sup</option>";
                        }?>
                    </select> <br> <br>
                    
                        <button type="submit" class="btn btn-info btn-lg"> Simpan</button></td>
                    <th style="width:140px;">Total Belanja(Rp)</th>
                    <th style="text-align:right;width:140px;"><input type="text" name="total2" value="<?php echo number_format($this->cart->total());?>" class="form-control input-sm" style="text-align:right;margin-bottom:5px;" readonly></th>
                    <input type="hidden" id="total" name="total" value="<?php echo $this->cart->total();?>" class="form-control input-sm" style="text-align:right;margin-bottom:5px;" readonly>
                </tr>
                <tr>
                    <th>Tunai(Rp)</th>
                    <th style="text-align:right;"><input type="text" id="jml_uang" name="jml_uang" class="jml_uang form-control input-sm" style="text-align:right;margin-bottom:5px;" required></th>
                    <input type="hidden" id="jml_uang2" name="jml_uang2" class="form-control input-sm" style="text-align:right;margin-bottom:5px;" required>
                </tr>
                <tr>
                    <td></td>
                    <th>Kembalian(Rp)</th>
                    <th style="text-align:right;"><input type="text" id="kembalian" name="kembalian" class="form-control input-sm" style="text-align:right;margin-bottom:5px;" required></th>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td><select name="id_pembayaran" class="selectpicker show-tick form-control" data-live-search="true" title="Jenis Pembayaran" data-width="260px" required>
                        <?php foreach ($jenis_pemb->result_array() as $i) {
                            $id_sup=$i['id'];
                            $nm_sup=$i['jenis'];

                           echo "<option value='$id_sup'>$nm_sup</option>";
                        }?>
                    </select>
                    <input type="text" style="width: 260px; margin-top: 10px;" placeholder="Keterangan pembayaran" class="form-control" name="keterangan_pembayaran"><br></td>
                </tr>


            </table>
            </form>
            <hr/>
        </div>
        <button class="btn btn-primary d-none" id="buka-histori" onclick="bukaHistori()" style="margin-bottom: 20px; margin-left: -15px; width: 100%; background-color: gray; border-color: gray;">Buka histori penjualan</button>
        <button class="btn btn-primary" id="tutup-histori" onclick="tutupHistori()" style="width: 100%; margin-bottom: 20px; margin-left: -15px; display: none;">Tutup histori penjualan</button>
        <div style="display: none;" id="datatable-wrapper">
        <table class="table" id="datatable"></table>
        </div>
        <!-- /.row -->
         <!-- ============ MODAL ADD =============== -->
        <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Data Barang</h3>
            </div>
                <div class="modal-body" style="overflow:scroll;height:500px;">

                  <table class="table table-bordered table-condensed" style="font-size:11px;" id="mydata">
                    <thead>
                        <tr>
                            <th style="text-align:center;width:40px;">No</th>
                            <th style="width:120px;">Kode Barang</th>
                            <th style="width:240px;">Nama Barang</th>
                            <th>Satuan</th>
                            <th style="width:100px;">Harga (Grosir)</th>
                            <th>Stok</th>
                            <th style="width:100px;text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $no=0;
                        foreach ($data->result_array() as $a):
                            $no++;
                            $id=$a['barang_id'];
                            $nm=$a['barang_nama'];
                            $satuan=$a['barang_satuan'];
                            $harpok=$a['barang_harpok'];
                            $harjul=$a['barang_harjul'];
                            $harjul_grosir=$a['barang_harjul_grosir'];
                            $stok=$a['barang_stok'];
                            $min_stok=$a['barang_min_stok'];
                            $kat_id=$a['barang_kategori_id'];
                            $kat_nama=$a['kategori_nama'];
                    ?>
                        <tr>
                            <td style="text-align:center;"><?php echo $no;?></td>
                            <td><?php echo $id;?></td>
                            <td><?php echo $nm;?></td>
                            <td style="text-align:center;"><?php echo $satuan;?></td>
                            <td style="text-align:right;"><?php echo 'Rp '.number_format($harjul_grosir);?></td>
                            <td style="text-align:center;"><?php echo $stok;?></td>
                            <td style="text-align:center;">
                            <!-- <form action="<?php echo base_url().'admin/penjualan_grosir/add_to_cart'?>" method="post"> -->
                            <input type="hidden" name="kode_brg" value="<?php echo $id?>">
                            <input type="hidden" name="nabar" value="<?php echo $nm;?>">
                            <input type="hidden" name="satuan" value="<?php echo $satuan;?>">
                            <input type="hidden" name="stok" value="<?php echo $stok;?>">
                            <input type="hidden" name="harjul" value="<?php echo number_format($harjul_grosir);?>">
                            <input type="hidden" name="diskon" value="0">
                            <input type="hidden" name="qty" value="1" required>
                                <button type="button" class="btn btn-xs btn-info" title="Pilih" onclick="copykode('<?php echo $id?>')"><span class="fa fa-edit"></span> Pilih</button>
                            <!-- </form> -->
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>          

                </div>

                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    
                </div>
            </div>
            </div>
        </div>

        <!--END MODAL-->

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p style="text-align:center;">Copyright &copy; <?php echo '2017';?> by Bekko Studio</p>
                </div>
            </div>
            <!-- /.row -->
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="<?php echo base_url().'assets/js/jquery.js'?>"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url().'assets/dist/js/bootstrap-select.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/bootstrap.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/jquery.dataTables.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/dataTables.bootstrap.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/jquery.price_format.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/moment.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/bootstrap-datetimepicker.min.js'?>"></script>

    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/2.0.3/js/dataTables.bootstrap5.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/3.0.0/js/dataTables.responsive.js"></script>
	<script src="https://cdn.datatables.net/responsive/3.0.0/js/responsive.bootstrap5.min.js"></script>
    <script type="text/javascript">
        $(function(){
            $('#jml_uang').on("input",function(){
                var total=$('#total').val();
                var jumuang=$('#jml_uang').val();
                var hsl=jumuang.replace(/[^\d]/g,"");
                $('#jml_uang2').val(hsl);
                $('#kembalian').val(hsl-total);
            })
            
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#mydata').DataTable();
        } );
    </script>
    <script type="text/javascript">
        $(function(){
            $('.jml_uang').priceFormat({
                    prefix: '',
                    //centsSeparator: '',
                    centsLimit: 0,
                    thousandsSeparator: ','
            });
            $('#jml_uang2').priceFormat({
                    prefix: '',
                    //centsSeparator: '',
                    centsLimit: 0,
                    thousandsSeparator: ''
            });
            $('#kembalian').priceFormat({
                    prefix: '',
                    //centsSeparator: '',
                    centsLimit: 0,
                    thousandsSeparator: ','
            });
            $('.harjul').priceFormat({
                    prefix: '',
                    //centsSeparator: '',
                    centsLimit: 0,
                    thousandsSeparator: ','
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            //Ajax kabupaten/kota insert
            $("#kode_brg").focus();
            $("#kode_brg").on("input",function(){
                var kobar = {kode_brg:$(this).val()};
                   $.ajax({
               type: "POST",
               url : "<?php echo base_url().'admin/penjualan_grosir/get_barang';?>",
               data: kobar,
               success: function(msg){
               $('#detail_barang').html(msg);
               }
            });
            }); 

            $("#kode_brg").keypress(function(e){
                if(e.which==13){
                    $("#jumlah").focus();
                }
            });
        });
    </script>


    <script>
        function copykode(kode){
            $("#kode_brg").val(kode).trigger("input");
            $('#largeModal').modal('hide');
        }
    </script>

<script>
     $(document).ready(function() {
        function format(d) {
    // `d` is the original data object for the row
    return (
        `
        <div style="display: flex; justify-content: center;">
        <table>
        <tr style="background-color: lightgray;">
        <td>ID Barang</td>
        <td>Nama Barang</td>
        <td>Satuan</td>
        <td>Harga jual</td>
        <td>Qty</td>
        <td>Diskon</td>
        <td>Total</td>
        </tr>
            ${d.item.map(e=>{
                return `
                <tr>
                <td>${e.d_jual_barang_id}</td>
                <td>${e.d_jual_barang_nama}</td>
                <td>${e.d_jual_barang_satuan}</td>
                <td>${formatRp(e.d_jual_barang_harjul,'Rp')}</td>
                <td>${e.d_jual_qty}</td>
                <td>${formatRp(e.d_jual_diskon,'Rp')}</td>
                <td>${formatRp(e.d_jual_total,'Rp')}</td>
                </tr>
                `
            })}
        </table>
        </div>
        `
    );
}
            table = $('#datatable').DataTable({  
                "autoWidth": false,
                "responsive": false,
                'processing': true,
                'serverSide': true,
'ordering': true,
'scrollX': true,
                'serverMethod': 'post',
                'ajax': {
                    'url': '<?= base_url() ?>admin/penjualan/datatable',
                    "data": function(d) {
                        d.where = "jual_keterangan = 'grosir'"
                        // d.filter_barang = $('#filter_barang').val();
                        // tambahkan parameter lain jika diperlukan
                    }
                },
                'columns': [
                    // {
                    //     data: 'datetime',
                    //     title: 'Tanggal',
                    //     render: (data,type,row) =>{
                    //         return row.datetime
                    //     }
                    // },
                    {
            class: 'dt-control',
            orderable: false,
            data: null,
            defaultContent: ''
        },
        {
                        data: 'jual_tanggal',
                        title: 'Tanggal'
                    },
                    {
                        data: 'pelanggan',
                        title: 'Pelanggan'
                    },
                    {
                        data: 'jual_nofak',
                        title: 'No Faktur'
                    },
                    {
                        data: 'jual_total',
                        title: 'Total penjualan',
                        render: function(e){
                            return formatRp(e,'Rp')
                        }
                    },
                    {
                        data: 'jual_jml_uang',
                        title: 'Jumlah uang',
                        render: function(e){
                            return formatRp(e,'Rp')
                        }
                    },
                    {
                        data: 'jual_kembalian',
                        title: 'Kembalian',
                        render: function(e){
                            return formatRp(e,'Rp')
                        }
                    },
                    {
                        data: 'jual_keterangan',
                        title: 'Keterangan'
                    },
                    {
                        data: 'jenis_pemb',
                        title: 'Pembayaran',
                        render: function(e,i,a){
                            if(a.jenis_pemb){
return `${a.jenis_pemb} <br/> <small>${a.keterangan_pembayaran}</small>`
                            }
                            return ''
                            
                        }
                    },
                    {
                        data: 'user_nama',
                        title: 'User ID'
                    },
                    
                    // {
                    //     data: 'no_telp',
                    //     title: 'No Telepon'
                    // },
                    // {
                    //     data: 'total',
                    //     title: 'Total Pembelian',
                    //     render: (data,type,row) => {
                    //         return formatRp(row.total,'Rp')
                    //     }
                    // },
                    // {
                    //     data: 'hpp',
                    //     title: 'HPP',
                    //     render:(data,type,row) => {
                    //         return formatRp(row.hpp,'Rp.')
                    //     }
                    // },


                ],
       
            });

            table.on('click', 'td.dt-control', function (e) {
    let tr = e.target.closest('tr');
    let row = table.row(tr);
 
    if (row.child.isShown()) {
        // This row is already open - close it
        row.child.hide();
    }
    else {
        // Open this row
        row.child(format(row.data())).show();
    }
});

            $(".dataTables_empty").text("Tidak Ada Data Export");
            // spinHandle = loadingOverlay().activate();



        });
</script>
<script>
    function bukaHistori(){
        document.querySelector('#datatable-wrapper').style.display = 'block'
        document.querySelector('#tutup-histori').style.display = 'block'
        document.querySelector('#buka-histori').style.display = 'none'
    }
    function tutupHistori(){
        document.querySelector('#datatable-wrapper').style.display = 'none'
        document.querySelector('#tutup-histori').style.display = 'none'
        document.querySelector('#buka-histori').style.display = 'block'
    }
</script>
    
</body>

</html>
