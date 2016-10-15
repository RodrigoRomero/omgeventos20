<!-- FOUR COLUMNS -->
<div class="row planes jPlanes ">
    <div class="jPlanesCupons">
    <?php
        foreach($planes as $plan){
            echo $this->view('forms/plan', $plan);
        }
    ?>
    </div>
<?php echo form_hidden('plan',0) ?>
</div>
<!-- PRICE TABLE -->
