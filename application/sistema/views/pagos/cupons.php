<div id="cupon">
<h2 class="sectionTitle">Tiene código promocional?</h2>
<div class="cuponContent">
    <div class="row">
        <div class="searchField col-xs-12 col-sm-12 col-md-4">
            <?php
            $data = array('name'=>'cupons','id'=>'cupons','placeholder'=>'Ingrese código promocional', 'class'=>'fullwidth jCupons', 'value'=>$cupon,  'tabindex'=>1);
            echo form_input($data);
            ?>
            <!-- cancelar
            <a href="#" class="cancelBtn" onClick="return false"> <i class="fa fa-times"></i> </a>
             -->
        </div>
        <div class="submitBtn col-xs-12 col-sm-12 col-md-offset-4 col-md-4">
         <!--   <input type="submit" value="APLICAR CODIGO" class="btnONE" /> -->
            <a href="javascript:void(0)" onclick="validateCupon()" class="btnONE">APLICAR CODIGO</a>
        </div>
    </div>
    
    
</div>
</div>
<div class="space"></div>