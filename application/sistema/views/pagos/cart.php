<!--tableHeader-->
<li class="tableHead row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-xs-5 col-md-5 text-left"> <div class="hidden-md hidden-lg">Entrada</div> <div class="hidden-xs hidden-sm">Tipo de entrada</div> </div>
            <div class="col-xs-3 col-md-1"> <div class="hidden-md hidden-lg">$</div> <div class="hidden-xs hidden-sm">Precio</div> </div>
            <div class="col-xs-2 col-md-1"> <div class="hidden-md hidden-lg">Cant.</div> <div class="hidden-xs hidden-sm">Cantidad</div> </div>
            <div class="hidden-xs col-md-3"> <div class="hidden-md hidden-lg">Total</div> <div class="hidden-xs hidden-sm">SubTotal</div> </div>
        </div>
    </div>
</li> <!-- #tableHeader -->
<?php
foreach ($this->cart->contents() as $key => $row) {
$discount = ( preg_match('/^code/', $row['id'], $matches) === 1) ? 'discount' : '';
?>
 <li class="item <?php echo $discount ?> row">
    <div class="col-md-12">
        <div class="row">
            <div class="ticket col-xs-5 col-md-5 text-left"> <?php echo $row['name'] ?></div>
            <div class="precioUnidad col-xs-3 col-md-1"> <?php echo $row['price'] ?> </div>
            <div class="cant col-xs-2 col-md-1"> <?php echo $row['qty'] ?> </div>
            <div class="precioTotal hidden-xs hidden-sm col-md-3"> <?php echo $row['subtotal'] ?> </div>
            <?php if($this->params['cart']=='checkout' || $param=='checkout') { ?>
            <div class="col-md-1"><a href="<?php echo lang_url('cart/remove/'.$row['rowid'])?>" class="ax-modal">X</a></div>
            <?php } ?>
        </div>
    </div>
</li>
<?php } ?>
<li class="item total row">
    <div class="col-md-12">
        <div class="row">
            <div class="cant col-xs-6 col-md-offset-7 col-md-2">Total </div>
            <div class="precioTotal col-xs-6 col-md-3"> <?php echo $this->cart->total() ?> </div>
        </div>
    </div>
</li>