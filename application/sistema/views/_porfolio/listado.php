<div class="container min-height">
			<div class="row-fluid">
				<div class="span12">
                    <?php echo $filter ?>
					<div class="sf-isotope">
                        <?php 
                            foreach($items as $k => $item){
                                $this->view('porfolio/item-filter',$item);    
                            } 
                        ?>
					</div>
				</div>
			</div>
		</div>