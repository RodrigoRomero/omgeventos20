<?php

$ticket_options = array();
$ticket_name_options = array();
$user_info_qty_ticket = 0;
$user_info_ticket_monto = 0;
$user_info_ticket_name = '';
$user_info_almuerzo = 0;
foreach($tickets as $tkt){
    $tiket_name_options[$tkt->nombre] = $tkt->nombre;
    $ticket_options[$tkt->precio_regular] = $tkt->precio_regular;
    $ticket_options[$tkt->precio_oferta] = $tkt->precio_oferta;    
}
ksort($ticket_options);

if($cart_info->full_cart){
$cart = json_decode($user_info->full_cart);
foreach($cart as $cart_items){
    if($cart_items->options->ticket_id == $user_info->id_ticket){        
        $user_info_ticket_name = $cart_items->name;
        $user_info_qty_ticket = $cart_items->qty;
        $user_info_ticket_monto = $cart_items->price;
    }
    
    if($cart_items->name == 'almuerzo'){
        $user_info_almuerzo = $cart_items->subtotal;
    }        
}
}

$data = array ('id'=>'eventosForm', 'class'=>'form');
echo form_open($action,$data);





?>
<div class="row-fluid">  
    <div class="box span12">
        <?php echo $this->view('layout/panels/box_header', array('title'=>'Acreditados', 'icon'=>'icon-pencil')) ?>
        <?php $this->view('alerts/error') ?>        
    </div>
</div>
<div class="row-fluid">
    <div class="box span7">
        <?php echo $this->view('layout/panels/box_header', array('title'=>'Datos Generales', 'icon'=>'icon-pencil')) ?>
        <div class="box-content">
            <div class="form_container">
                <?php 
                 echo '<div class="row-fluid">';  
                $data = array('name'=>'nombre','id'=>'nombre','placeholder'=>'Nombre', 'disabled'=>'disabled', 'class'=>'required input-xlarge', 'value'=>$user_info->nombre);
                echo control_group('Nombre', form_input($data),$attr = array('class'=>'span6'));
                $data = array('name'=>'apellido','id'=>'apellido','placeholder'=>'Apellido', 'disabled'=>'disabled', 'class'=>'required input-xlarge', 'value'=>$user_info->apellido);
                echo control_group('Apellido', form_input($data),$attr = array('class'=>'span6'));
                echo '</div>';
                echo '<div class="row-fluid">';
                $data = array('name'=>'email','id'=>'email','placeholder'=>'Email', 'disabled'=>'disabled', 'class'=>'required input-xlarge', 'value'=>$user_info->email);
                echo control_group('Email', form_input($data),$attr = array('class'=>'span6'));
                echo '</div>';
                echo '<div class="row-fluid">';
                $data = array('name'=>'empresa','id'=>'empresa','placeholder'=>'Empresa', 'disabled'=>'disabled', 'class'=>'required input-xlarge', 'value'=>$user_info->empresa);
                echo control_group('Empresa', form_input($data),$attr = array('class'=>'span6'));
                $data = array('name'=>'cargo','id'=>'cargo','placeholder'=>'Cargo', 'disabled'=>'disabled', 'class'=>'required input-xlarge', 'value'=>$user_info->cargo);
                echo control_group('Cargo', form_input($data),$attr = array('class'=>'span6'));
                echo '</div>';
                echo '<div class="row-fluid">';
                $data = array('name'=>'edad','id'=>'edad','placeholder'=>'Edad', 'disabled'=>'disabled', 'class'=>'required input-xlarge', 'value'=>$user_info->edad);
                echo control_group('Edad', form_input($data),$attr = array('class'=>'span6'));
                $data = array('name'=>'dni','id'=>'dni','placeholder'=>'DNI', 'disabled'=>'disabled', 'class'=>'required input-xlarge', 'value'=>$user_info->dni);
                echo control_group('DNI', form_input($data),$attr = array('class'=>'span6'));
                echo '</div>';
                echo '<div class="row-fluid">';
                if($user_info->tipo_usuario == 1){
                    $data = array('name'=>'','id'=>'','placeholder'=>'Tipo de usuario', 'disabled'=>'disabled', 'class'=>'required input-xlarge', 'value'=>'Adherente IAE');
                    echo control_group('Tipo de Usuario', form_input($data),$attr = array('class'=>'span6'));
                }
                $data = array('name'=>'conocio','id'=>'conocio','placeholder'=>'Como nos conocio', 'disabled'=>'disabled', 'class'=>'required input-xlarge', 'value'=>$user_info->conocio);
                echo control_group('Como nos conocio', form_input($data),$attr = array('class'=>'span6'));
                echo '</div>';
                
                echo '<div class="row-fluid">';
                $checked = ($user_info->donante_mensual==1) ? array('checked'=>true) : array();
                $data = array('name'=>'donante_mensual','id'=>'donante_mensual', 'disabled'=>'disabled', 'class'=>'', 'type'=>'checkbox');
                echo control_group('Donante Mensual', form_input($data+$checked),$attr = array('class'=>'span4'));
                
                $checked = ($user_info->newsletter==1) ? array('checked'=>true) : array();
                $data = array('name'=>'newsletter','id'=>'newsletter', 'disabled'=>'disabled', 'class'=>'', 'type'=>'checkbox');
                echo control_group('Suscribe Newsletter', form_input($data+$checked),$attr = array('class'=>'span4'));
                
                
                echo '</div>';
                
                echo '<div class="row-fluid">';
                $checked = ($user_info->status==1) ? array('checked'=>true) : array();
                $data = array('name'=>'status','id'=>'status', 'class'=>'', 'type'=>'checkbox');
                echo control_group('Activo', form_input($data+$checked),$attr = array('class'=>'span4'));
                
                
                
                echo '</div>';
                ?> 
            </div>
        </div>
    </div>
    <div class="box span5">
        <div class="row-fluid">
            <div class=" span12">
                <?php echo $this->view('layout/panels/box_header', array('title'=>'Datos Ingreso', 'icon'=>'icon-map-marker', 'subaction'=>false)) ?>
                <div class="box-content">
                    <div class="form_container">
                    <?php
                    $data = array('name'=>'barcode','id'=>'barcode','placeholder'=>'Código de Barras', 'disabled'=>'disabled', 'class'=>'required input-xlarge', 'value'=>$user_info->barcode);
                    echo control_group('Código de Barras', form_input($data),$attr = array());
                    ?>
                    </div>
                </div>
            </div>
        </div>
        <?php if($cart_info->full_cart) { ?> 
        <div class="row-fluid">
            <div class=" span12">
                <?php echo $this->view('layout/panels/box_header', array('title'=>'Datos Pago', 'icon'=>'icon-money', 'subaction'=>false)) ?>
                <div class="box-content">                    
                    <div class="form_container">
                        <?php
                        $data = array('name'=>'ticket_name','id'=>'ticket_name','placeholder'=>'Tickets', 'disabled'=>'disabled', 'class'=>'required input-xlarge', 'value'=>$user_info_ticket_name);
                        echo control_group('Tickets', form_input($data),$attr = array());
                        
                        $data = array('name'=>'qty','id'=>'qty','placeholder'=>'Cantidad Tickets', 'disabled'=>'disabled', 'class'=>'required input-xlarge', 'value'=>$user_info_qty_ticket);
                        echo control_group('Cantidad Tickets', form_input($data),$attr = array());
                        
                        $data = array('name'=>'monto','id'=>'monto','placeholder'=>'Monto', 'disabled'=>'disabled', 'class'=>'required input-xlarge', 'value'=>$user_info_ticket_monto);
                        echo control_group('Monto', form_input($data),$attr = array());
                        
                        $data = array('name'=>'medio_pago','id'=>'medio_pago','placeholder'=>'Medio de Pago', 'disabled'=>'disabled', 'class'=>'required input-xlarge', 'value'=>$user_info->medio_pago);
                        echo control_group('Medio de Pago', form_input($data),$attr = array());
                        
                        /*
                        $data = array('mercado_pago'            => 'Mercado Pago',
                                      'transferencia_bancaria'  => 'Transferencia Bancaria',
                                      'pago_mis_cuentas'        => 'Pago Mis Cuentas',
                                      '0'                       => 'No Disponible',
                                      );
                        echo control_group('Medio de Pago', form_dropdown('medio_pago',$data, $user_info->medio_pago),$attr = array());
                        */
                       # $data = $ticket_options;
                       # echo control_group('Monto', form_dropdown('monto',$data, $user_info_ticket_monto),$attr = array());
                        /*
                        $data = array('name'=>'monto','id'=>'monto','placeholder'=>'Monto', 'disabled'=>'disabled', 'class'=>'required input-xlarge', 'value'=>$user_info->monto);
                        echo control_group('Monto', form_input($data),$attr = array());
                        */
                        $data = array('sin_pago'        => 'Sin Pago',
                                      'approved'        => 'Aprobado',
                                      'pending'         => 'Pendiente',
                                      'in_process'      => 'En Proceso', 
                                      'rejected'        => 'Rechazado', 
                                      'refunded'        => 'Devuelto al usuario',
                                      'cancelled'       => 'Cancelado',
                                      'in_mediation'    => 'En Mediación',
                                      );
                        echo control_group('Pago Status', form_dropdown('payment_status',$data, $pago_info->status),$attr = array());
                        ?>
                    </div>
                </div>
            </div>
        </div>
         
        <div class="row-fluid">
            <div class=" span12">
                <?php echo $this->view('layout/panels/box_header', array('title'=>'Datos Almuerzo', 'icon'=>'icon-money', 'subaction'=>false)) ?>
                <div class="box-content">                    
                    <div class="form_container">
                        <?php
                        $checked = ($user_info->lunch==1) ? array('checked'=>true) : array();
                        $data = array('name'=>'lunch','id'=>'lunch', 'disabled'=>'disabled', 'class'=>'', 'type'=>'checkbox');
                        echo control_group('Asiste Almuerzo', form_input($data+$checked),$attr = array('class'=>'span4'));
                        
                        $data = array('name'=>'lunch','id'=>'lunch','placeholder'=>'Almuerzo', 'disabled'=>'disabled', 'class'=>'required input-xlarge', 'value'=>$user_info_almuerzo);
                        echo control_group('Almuerzo', form_input($data),$attr = array());
                        
                        
                        ?>
                    </div>
                </div>
            </div>
        </div>
       <?php } ?>
    </div>
</div>
<?php if($cart_info->full_cart) { ?> 
<div class="row-fluid">  
    <div class="box span12">
        <?php echo $this->view('layout/panels/box_header', array('title'=>'Detalle Compra', 'icon'=>'icon-pencil')) ?>
        <div class="box-content">
            <div class="form_container">
                <table class="table table-condensed">
                    <?php echo $this->view('panels/cart/cart', array('full_cart'=>$cart, 'total'=>$user_info->monto)) ?>
                </table>                
            </div>
        </div>       
    </div>
</div>
<?php } ?>
<div class="row-fluid">
    <div class="box span12">
        <div class="box-content">
            <div class="form_container">
                <?php 
                $buttons = '';
                $buttons .= '<span class="pull-left">';
               # $data = array('type'=>'submit', 'value'=>'Guardar', 'class'=>'btn btn-primary', 'onclick'=>"validateForm('eventosForm')", 'style' =>'margin-right: 10px');
               # $buttons .= form_input($data);
                $buttons .= anchor($back,'Cancelar',array('class'=>'btn btn-inverse'));
                $buttons .= '</span>'; 
                echo form_action($buttons);
                echo form_close(); 
                ?>
            </div>
        </div>
    </div>
</div>