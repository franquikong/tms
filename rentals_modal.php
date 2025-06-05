<!-- RENTAL MODAL -->
<div class="modal fade" id="rental<?php echo $value['the_tenant_id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title text-center" id="myModalLabel">Rental Transaction</h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body pt-2">            
            <form action="rentals_save.php" method="POST">
                <div class="row">
                    <label class="col-sm-6 control-label mt-0">Name: 
                        <?php echo $value['tenant_fname']." ".$value['tenant_lname'];?></label>
                    <label class="col-sm-6 control-label mt-0">Stall: 
                        <?php echo $value['stall_number'];?></label>
                </div> 
                <div class="row">
                    <div class="col-sm-4">
                        <label>Date</label> 
                        <input class="form-control" type="date" id="date" name="pay_date" required>
                        <input type="hidden" class="form-control" name="tenant_id" value="<?php echo $value['the_tenant_id'];?>">
                    </div>
                    <div class="col-sm-8">
                        <label>Particulars</label>  
                        <select class="form-control" name="pay_part" value="Rental" required>
							<option value = "Rental" readonly>Rental</option>
							<option value = "Rental Adjustment">Rental Adjustment</option>
						</select>        
                    </div>
                </div> 

                <input type="hidden" class="form-control" name="pay_orno" value="0">
                <input type="hidden" class="form-control" name="payment" value="0">

                <div class="row"> 
                    <div class="col-sm-4">
                        <label>Previous Balance</label>
                        <input class="form-control" name="pay_prevbal" id="pay_prevbal" 
                        value="<?php echo number_format($value['pay_balance'], 2);?>" required>
                    </div>
                    <div class="col-sm-4">
                        <label>Amount</label>  
                        <input class="form-control" name="pay_amount" id="pay_amount" required>
                    </div>
                    <div class="col-sm-4">
                        <label>New Balance</label> 
                         <input class="form-control" name="pay_balance" id="pay_balance" required>
                    </div>
                </div> 
                
                <div class="row">
                    <div class="col-sm-11">
                        <label>Remarks</label> 
                        <input type="text" class="form-control" name="remarks"> 
                    </div>
                </div> 

            </div> 
            <div class="modal-footer">
                <button type="submit" name="add" class="btn btn-primary btn-md"><i class="fa fa-save"></i>  Save  </button>
            </div>
            </form>  
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<!-- RENTAL PAYMENT MODAL -->
<div class="modal fade" id="payment<?php echo $value['the_tenant_id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title text-center" id="myModalLabel">Rental Payment</h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body pt-2">            
                <form action="rentals_save.php" method="POST">
                <div class="row"> 
                    <label class="col-sm-6 control-label mt-0">Name: 
                        <?php echo $value['tenant_fname']." ".$value['tenant_lname'];?></label>
                    <label class="col-sm-6 control-label mt-0">Stall: 
                        <?php echo $value['stall_number'];?></label>
                </div>   
                <div class="row"> 
                    <div class="col-sm-4">
                        <label>Date</label> 
                        <input class="form-control" type="date" id="date" name="pay_date" required>
                        <input type="hidden" class="form-control" name="tenant_id" value="<?php echo $value['the_tenant_id'];?>">
                    </div>
                    <div class="col-sm-4">
                        <label>OR Number</label> 
                        <input class="form-control" name="pay_orno" required>
                    </div>
                </div>

                <div class="row"> 
                    <div class="col-sm-7">
                        <label>Particulars</label> 
                        <input type="text" class="form-control" name="pay_part" value="Rental Payment" readonly> 
                    </div>
                </div> 

                <input type="hidden" class="form-control" name="pay_amount" value="0"> 

                <div class="row"> 
                    <div class="col-sm-4">
                        <label>Previous Balance</label>
                        <input class="form-control" name="pay_prevbal" id="pay_prevbal" value="<?php echo number_format($value['pay_balance'], 2);?>" required>
                    </div>
                    <div class="col-sm-4">
                        <label>Payment</label> 
                         <input class="form-control" name="payment" id="payment" required>
                         </div> 
                    <div class="col-sm-4">
                        <label>New Balance</label> 
                         <input class="form-control" name="pay_balance" id="pay_newbal" required>
                    </div>
                </div> 
                
                <div class="row"> 
                    <div class="col-sm-11">
                        <label>Remarks</label> 
                        <input type="text" class="form-control" name="remarks"> 
                    </div>
                </div>  
                
            </div> 
            <div class="modal-footer">
                <button type="submit" name="add" class="btn btn-primary btn-md"><i class="fa fa-save" aria-hidden="true"></i>  Save  </button>
            </div>
            </form>  
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


