<'style type="text/css">
	.page-break {
            page-break-after: always;
        }
</style>
<?php foreach( $kartu as $k => $v){ ?>
<table cellspacing="0" cellpadding="0" border="1" width="100%">
    <tr>
        <?php $a = 0; ?>
    <?php foreach($v as $vl => $vb){ ?>
        
        <td style="width:100%; height: 180px; padding-left: 10px; padding-right: 10px;" align="right">
            <?php if(!empty($vb)){ ?>
            <?php echo '<img src="data:image/png;base64,' . DNS2D::getBarcodePNG($vb, "QRCODE") . '" alt="barcode"   />'; ?>
            <br/><br/>
            {{$vb}}
            <br/>
            <?php echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($vb, "C39+") . '" width="220px" alt="barcode"   />'; ?>
            <?php }else{ ?>
            
            <?php } ?>
        </td>
        
        
        <?php 
            $a++
         ?> 
        <?php if($a == 2){ ?>
            </tr><tr>
            <?php $a = 0; ?>
        <?php } ?>
    <?php } ?>
    </tr>
</table>
<div class="page-break"></div>
<?php } ?>



