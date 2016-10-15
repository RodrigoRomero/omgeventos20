<div class="row-fluid">
    <div class="span12 box">
        <div class="box-header">
    	   <h2><i class="icon-pencil"></i>Estadísticas Diarias</h2>
           <div class="box-icon">
            <a class="btn-setting tip-top" data-original-title='Actualizar Estadistica' href="javascript:void(0);" onclick="setChart()"><i class="icon-refresh"></i>Actualizar Estadísticas</a>
           </div>
        </div>
        <div class="box-content">
            <canvas id="chart_lines" height="350"></canvas>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="span3 box">
        <div class="box-header">
    	   <h2><i class="icon-pencil"></i>Acreditados Totales</h2>           
        </div>
        <div class="box-content text-center" style="background: #f6f6f6;">
            <div class="span6 offset3" style="border: 2px solid #fff; padding: 30px; display:inline-block; border-radius: 10px; background: #36A9E1;"> 
                <h1 style="color: #ffffff;">
                    <?php echo $total_acreditados->total; ?>
                </h1>
                <span class="icon-user" style="color: #ffffff; font-size: 25px"></span>
            </div>
        </div>
    </div>
    <div class="span3 box">
        <div class="box-header">
    	   <h2><i class="icon-pencil"></i>Tipos Acreditados</h2>           
        </div>
        <div class="box-content">
            <table class="table table-striped">
                <tr>
                    <td>Miembros IAE</td>
                    <td><?php echo $total_by_tipo['adherentes'] ?></td>
                </tr>
                <tr>
                    <td>Regulares</td>
                    <td><?php echo $total_by_tipo['no_adherentes'] ?></td>
                </tr>
                <tr>
                    <td>Total Global</td>
                    <td><?php echo $total_by_tipo['total'] ?></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="span3 box">
        <div class="box-header">
    	   <h2><i class="icon-pencil"></i>Miembros IAE</h2>           
        </div>
        <div class="box-content">
            <table class="table table-striped">
                <?php foreach($total_by_medio_pago_iae as $medios_pago){ ?>
                    <tr>
                        <td> 
                            <?php                            
                            switch(trim($medios_pago->medio_pago)){                                
                                case 'mercado_pago':
                                    echo 'Mercado Pago';
                                    break;
                                case 'pago_mis_cuentas':
                                    echo 'Pago Mis Cuentas';
                                    break;
                                case 'transferencia_bancaria':
                                    echo 'Transferencia Bancaria';
                                    break;
                                case 0:                                
                                    echo 'No define medio pago';
                                    break;
                            } ?>
                        </td>
                        <td><?php echo $medios_pago->total ?></td>
                    </tr>    
                <?php } ?>                
            </table>
        </div>
    </div>
    <div class="span3 box">
        <div class="box-header">
    	   <h2><i class="icon-pencil"></i>Medios Pago Totales</h2>           
        </div>
        <div class="box-content">
            <table class="table table-striped">
                <?php foreach($total_by_medio_pago as $medios_pago){ ?>
                    <tr>
                        <td> 
                            <?php                            
                            switch(trim($medios_pago->medio_pago)){                                
                                case 'mercado_pago':
                                    echo 'Mercado Pago';
                                    break;
                                case 'pago_mis_cuentas':
                                    echo 'Pago Mis Cuentas';
                                    break;
                                case 'transferencia_bancaria':
                                    echo 'Transferencia Bancaria';
                                    break;
                                case 0:                                
                                    echo 'No define medio pago';
                                    break;
                            } ?>
                        </td>
                        <td><?php echo $medios_pago->total ?></td>
                    </tr>    
                <?php } ?>                
            </table>
        </div>
    </div>
    
    
</div>
<div class="row-fluid">
	<?php //echo $smallStats ?>
    <div class="span3 box">
        <div class="box-header">
    	   <h2><i class="icon-pencil"></i>Facturación</h2>           
        </div>
        <div class="box-content">            
            <table class="table table-striped">
                <tr>
                    <td>Aprobada</td>
                    <td>$ <?php echo $total_facturacion['facturacion_aprobada'] ?></a></td>
                </tr>
                <tr>
                    <td>Pendiente</td>
                    <td>$ <?php echo $total_facturacion['facturacion_pendiente'] ?></td>
                </tr>
                <tr>
                    <td>Rechazada</td>
                    <td>$ <?php echo $total_facturacion['facturacion_rechazada'] ?></td>
                </tr>                 
                <tr>
                    <td>Total</td>
                    <td>$ <?php echo $total_facturacion['total'] ?></td>
                </tr>
                
                
                                                
            </table>
        </div>
    
    </div>
    
    
    <div class="span3 box">
        <div class="box-header">
    	   <h2><i class="icon-pencil"></i>Facuración Pendiente</h2>           
        </div>
        <div class="box-content">      
            <table class="table table-striped">
                <?php 
                $t = 0;
                foreach($total_facturacion_pendiente_medio as $medios_pago){
                    $t += $medios_pago->total;
                ?>
                    <tr>
                        <td> 
                            <?php                            
                            switch(trim($medios_pago->payment_type)){                                
                                case 'credit_card':
                                    echo 'Tarjeta Crédito';
                                    break;
                                case 'transferencia_bancaria':
                                    echo 'Transferencia Bancaria';
                                    break;
                                case 0:                                
                                    echo 'No Pagante';
                                    break;
                            } ?>
                        </td>
                        <td>$ <?php echo $medios_pago->total ?></td>
                    </tr>    
                <?php } ?>   
                <tr>
                    <td>TOTAL</td>
                    <td>$ <?php echo $t ?></td>
                </tr>             
            </table>
        </div>
    </div>
    <?php echo $ultimos_acreditados ?>
</div>
<!--
<div class="row-fluid">
<div class="span4 box">
        <div class="box-header">
    	   <h2><i class="icon-pencil"></i>Estadística Planes</h2>
           <div class="box-icon">
            <a class="btn-setting tip-top" data-original-title='Actualizar Estadistica' href="javascript:void(0);" onclick="setPiePlanes()"><i class="icon-refresh"></i></a>
           </div>
        </div>
        <div class="box-content">
            <canvas id="chart_pie_planes" height="205"></canvas>
        </div>
    </div>
    <div class="span4 box">
        <div class="box-header">
    	   <h2><i class="icon-pencil"></i>Estadística Pagantes vs No Pagantes</h2>
           <div class="box-icon">
            <a class="btn-setting tip-top" data-original-title='Actualizar Estadistica' href="javascript:void(0);" onclick="setPiePagos()"><i class="icon-refresh"></i></a>
           </div>
        </div>
        <div class="box-content">
            <canvas id="chart_pie_pagos" height="205"></canvas>
        </div>
    </div>
</div>
-->