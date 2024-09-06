 <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo base_url().'welcome'?>">Point of Sale</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                   <?php $h=$this->session->userdata('akses'); ?>
                    <?php $u=$this->session->userdata('user'); ?>
                    <?php if($h=='1'){ ?> 
                     <!--dropdown-->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" title="Transaksi"><span class="fa fa-shopping-cart" aria-hidden="true"></span> Transaksi</a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url().'admin/penjualan'?>"><span class="fa fa-shopping-bag" aria-hidden="true"></span> Penjualan (Eceran)</a></li> 
                            <li><a href="<?php echo base_url().'admin/penjualan_grosir'?>"><span class="fa fa-cubes" aria-hidden="true"></span> Penjualan (Grosir)</a></li> 
                            <li><a href="<?php echo base_url().'admin/penjualan_member'?>"><span class="fa fa-cubes" aria-hidden="true"></span> Penjualan (Member)</a></li>
                        </ul>
                    </li>
                    <!--ending dropdown-->
                    <li>
                        <a href="<?php echo base_url().'admin/retur'?>"><span class="fa fa-refresh"></span> Retur</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url().'admin/grafik'?>"><span class="fa fa-line-chart"></span> Grafik</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url().'admin/laporan'?>"><span class="fa fa-file"></span> Laporan</a>
                    </li>
                    <?php }?>
                    <?php if($h=='2'){ ?> 
                      <!--dropdown-->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" title="Transaksi"><span class="fa fa-shopping-cart" aria-hidden="true"></span> Transaksi</a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url().'admin/penjualan'?>"><span class="fa fa-shopping-bag" aria-hidden="true"></span> Penjualan (Eceran)</a></li> 
                            <li><a href="<?php echo base_url().'admin/penjualan_grosir'?>"><span class="fa fa-cubes" aria-hidden="true"></span> Penjualan (Grosir)</a></li> 
                            <li><a href="<?php echo base_url().'admin/penjualan_member'?>"><span class="fa fa-cubes" aria-hidden="true"></span> Penjualan (Member)</a></li>
                        </ul>
                    </li>
                    <!--ending dropdown-->
                    <li>
                        <a href="<?php echo base_url().'admin/retur'?>"><span class="fa fa-refresh"></span> Retur</a>
                    </li>
                    <?php }?>
                     <li>
                        <a href="<?php echo base_url().'administrator/logout'?>"><span class="fa fa-sign-out"></span> Logout</a>
                    </li>
                </ul>


            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    <script>
        function formatRp(angka, prefix){
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
    split   		= number_string.split(','),
    sisa     		= split[0].length % 3,
    rupiah     		= split[0].substr(0, sisa),
    ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if(ribuan){
        let separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
}
    </script>