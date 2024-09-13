<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
    <title>Faktur Penjualan Barang</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/laporan.css')?>"/>
</head>
<body onload="window.print()">
<div id="laporan">
<table align="center" style="width:180px; border-bottom:3px double;border-top:none;border-right:none;border-left:none;margin-top:5px;margin-bottom:20px; text-align:center;font-size: 12px;">
<tr>
    <!-- <td><img src="<?php// echo base_url().'assets/img/kop_surat.png'?>"/></td> -->
</tr>
<!--<tr>
    <td style="font-size: 13px;"><b>Toko Aman Jaya</b></td>
</tr>
<tr>
    <td>Raya Rungkut Tengah 47</td>
</tr>
<tr>
    <td>085 93 666 6388</td>
</tr>-->
</table>

<table border="0" align="center" style="width:180px; border:none;margin-top:5px;margin-bottom:0px;">
<tr>
    
</tr>
                       
</table>
<?php 
    $b=$data->row_array();
?>
<table border="0" align="center" style="width:180px;margin-bottom:20px;border:none;font-size: 12px">
        <tr>
            <th style="text-align:left; width: 35%">No Nota</th>
            <th style="text-align:left;">: <?php echo $b['jual_nofak'];?></th>
        </tr>
        <?php 
        list($date, $time)=explode(' ', $b['jual_tanggal']);
         ?>
        <tr>
            <th style="text-align:left;">Tanggal</th>
            <th style="text-align:left;">: <?php echo $date;?></th>
        </tr>
        <tr>
            <th style="text-align:left;">Waktu</th>
            <th style="text-align:left;">: <?php echo $time;?></th>
        </tr>
        <tr>
            <th style="text-align:left;">Keterangan</th>
            <th style="text-align:left;">: <?php echo $b['jual_keterangan'];?></th>
        </tr>
</table>

<table border="0" align="center" style="width:180px;margin-bottom:20px;border:none;font-size: 11px">
<thead>
</thead>
<tbody>
<?php 
$no=0;
    foreach ($data->result_array() as $i) {
        $no++;
        
        $nabar=$i['d_jual_barang_nama'];
        $satuan=$i['d_jual_barang_satuan'];
        
        $harjul=$i['d_jual_barang_harjul'];
        $qty=$i['d_jual_qty'];
        $diskon=$i['d_jual_diskon'];
        $total=$i['d_jual_total'];
?>
    <tr>
        <td style="text-align:left;"><div style="margin-bottom: 5px;margin-top: 5px"><?php echo $nabar;?></div><div style="margin-left: 10px"><?php echo $qty;?> <?php echo $satuan;?> X <?php echo number_format($harjul);?></div><div style="margin-bottom: 5px;margin-top: 5px">Diskon (<?php echo number_format($diskon);?>)</div></td>
        <td style="text-align:right;"><?php echo number_format($total);?></td>
    </tr>
<?php }?>
</tbody>
<tfoot>

    <tr>
        <td style="text-align:left;"><b>Total</b></td>
        <td style="text-align:right;"><b><?php echo number_format($b['jual_total']);?></b></td>
    </tr>
</tfoot>
</table>

<table border="0" align="center" style="width:180px;border:none;font-size: 12px">
        <tr>
            <th style="text-align:left; width: 35%">Total</th>
            <th style="text-align:left;">: <?php echo 'Rp '.number_format($b['jual_total']).',-';?></th>
        </tr>
        
        <tr>
            <th style="text-align:left;">Tunai</th>
            <th style="text-align:left;">: <?php echo 'Rp '.number_format($b['jual_jml_uang']).',-';?></th>
        </tr>
        
        <tr>
            <th style="text-align:left;">Kembalian</th>
            <th style="text-align:left;">: <?php echo 'Rp '.number_format($b['jual_kembalian']).',-';?></th>
        </tr>
</table>

<table align="center" style="width:180px; border:none;margin-top:5px;margin-bottom:20px;">
    <tr>
        <td></td>
</table>
<table align="center" style="width:180px; border:none;margin-top:5px;margin-bottom:20px;font-size: 12px">
    <tr>
        <td align="right"><?php echo date('d-M-Y')?></td>
    </tr>
    <tr>
        <td align="left"></td>
    </tr>
   
    <tr>
    <td><br/><br/><br/><br/></td>
    </tr>    
    <tr>
        <td align="right">( <?php echo $this->session->userdata('nama');?> )</td>
    </tr>
    <tr>
        <td align="center"></td>
    </tr>
</table>
<table align="center" style="width:180px; border:none;margin-top:5px;margin-bottom:20px;">
    <tr>
        <th><br/><br/></th>
    </tr>
    <tr>
        <th align="left"></th>
    </tr>
</table>
</div>
</body>
</html>