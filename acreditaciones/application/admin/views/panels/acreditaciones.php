<?php
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
                
                $checked = ($user_info->status==1) ? array('checked'=>true) : array();
                $data = array('name'=>'status','id'=>'status', 'class'=>'', 'disabled'=>'disabled', 'type'=>'checkbox');
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
        <div class="row-fluid">
            <div class=" span12">
                <?php echo $this->view('layout/panels/box_header', array('title'=>'Datos Pago', 'icon'=>'icon-money', 'subaction'=>false)) ?>
                <div class="box-content">                    
                    <div class="form_container">
                        <?php
                        $data = array('mercado_pago'            => 'Mercado Pago',
                                      'transferencia_bancaria'  => 'Transferencia Bancaria',
                                      'pago_mis_cuentas'        => 'Pago Mis Cuentas',
                                      '0'                       => 'No Disponible',
                                      );
                        echo control_group('Medio de Pago', form_dropdown('medio_pago',$data, $user_info->medio_pago),$attr = array());
                        
                        $data = array('100'  => '100',
                                      '250' => '250',
                                      '300'  => '300',
                                      '350'  => '350',
                                      '400'  => '400',
                                      '500' => '500',
                                      '700' => '700',
                                      '1800' => '1800',
                                      '0'    => '0'
                                      );
                        echo control_group('Monto', form_dropdown('monto',$data, $user_info->monto),$attr = array());
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
                        
                        $data = array('0'    => '0',
                                        '180'  => '180',
                                      
                                      );
                        echo control_group('Costo Almuerzo', form_dropdown('costo_almuerzo',$data, $lunch_info->transaction_amount),$attr = array());
                       
                        $data = array('sin_pago'        => 'Sin Pago',
                                      'approved'        => 'Aprobado',
                                      'pending'         => 'Pendiente',
                                      'in_process'      => 'En Proceso', 
                                      'rejected'        => 'Rechazado', 
                                      'refunded'        => 'Devuelto al usuario',
                                      'cancelled'       => 'Cancelado',
                                      'in_mediation'    => 'En Mediación',
                                      
                                      );
                        echo control_group('Pago Status', form_dropdown('almuerzo-payment_status',$data, $lunch_info->status),$attr = array());
                        
                        $checked = ($user_info->invitacion==2) ? array('checked'=>true) : array();
                        $data = array('name'=>'autorizar','id'=>'autorizar', 'class'=>'', 'type'=>'checkbox');
                        echo control_group('Autorizar', form_input($data+$checked),$attr = array('class'=>''));
                        ?>
                    </div>
                </div>
            </div>
        </div>
        
       
    </div>
</div>
<div class="row-fluid">
    <div class="box span12">
        <div class="box-content">
            <div class="form_container">
                <?php 
                $buttons = '';
                $buttons .= '<span class="pull-left">';
                $data = array('type'=>'submit', 'value'=>'Guardar', 'class'=>'btn btn-primary', 'onclick'=>"validateForm('eventosForm')", 'style' =>'margin-right: 10px');
                $buttons .= form_input($data);
                $buttons .= anchor($back,'Cancelar',array('class'=>'btn btn-inverse'));
                $buttons .= '</span>'; 
                echo form_action($buttons);
                echo form_close(); 
                ?>
            </div>
        </div>
    </div>
</div>


