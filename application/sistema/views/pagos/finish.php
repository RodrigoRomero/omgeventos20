        <?php     

        $status_pago = '';
        switch($order_details['order']->pago_status){
            case 1:
            case '1':
                $status_pago = 'Aprobado';
                break;
            case 2:
            case '-1':
                $status_pago = 'Pendiente';
                break;
            case 3:
                $status_pago = 'Rechazado';
                break;

            default:
                $status_pago = 'Sin Pago';
                break;
                
        } 


        ?>
        
        <section id="finish">
            <div class="container">
                
                <div>
                    <h2 class="sectionTitle">Gracias <?php echo $order_details['order']->nombre.' '.$order_details['order']->apellido ?>. Su orden ha sido recibida!</h2>
                    <div id="orderDetail">
                        <ul>
                            <li> <i class="fa fa-arrow-circle-o-right"></i> Numero de orden: <span><?php echo $order_details['order']->order_id ?></span></li>
                            <li> <i class="fa fa-arrow-circle-o-right"></i> Fecha: <span><?php echo SpanishDate($order_details['order']->fa) ?></span></li>
                            <li> <i class="fa fa-arrow-circle-o-right"></i> Total: <span>$ <?php echo $this->cart->total() ?></span></li>
                            <?php if($order_details->medio_pago) { ?>
                                <li> <i class="fa fa-arrow-circle-o-right"></i> Método de pago: <span></span><?php echo ucwords(str_replace('_',' ',$order_details->medio_pago)) ?></span></li>
                            <?php } else if($this->cart->total()>0) { ?>
                             <li> <i class="fa fa-arrow-circle-o-right"></i> Status de pago: <span></span><?php echo $status_pago ?></span></li>
                            <?php } ?>
                        </ul>
                    </div>

                </div> 

                <div class="space"></div>

                <div id="paso3">
                    
                    <!-- order resume -->
                    <div id="resumeOrder">
                        <h2 class="sectionTitle">Resúmen de Orden</h2>
                        
                        <ul class="table container">
                            <!--item-->
                            <?php echo $this->view('pagos/cart') ?>
                        </ul> <!-- #table -->

                    </div>

                </div>

            </div>

        </section>