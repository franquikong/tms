<!-- Page Header -->
<?php include 'inc/header.php';?>

<body id="page-top" class="text-gray-900">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar - Brand -->
         <?php include 'inc/sidebar.php';?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                 <?php include 'inc/topbar.php';?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    
                    <!-- Card -->
                    <div class="card shadow mb-2">
                        
                        <!-- Card Header -->
                        <div class="card-header">
                          <h1 class="h2 mb-1 ml-2">  Electricity Bills
                            <button class="btn btn-primary float-right" 
                              data-toggle="modal" 
                              data-target="#myModal" 
                              title="Change Electric Rate">
                              <i class="fa fa-rotate fa-fw"></i>
                              <b>  Rate  </b>
                            </button>
                          </h1>
                          
                          <!-- Change Rate Modal -->
                          <?php include 'elecrate_modal.php';?>
                        </div>
                    
                        <!-- Card Body -->
                         <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-hover text-gray-900" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                      <tr>
                                        <th>Stall</th>
                                        <th>Tenant</th>
                                        <th>Meter No</th>
                                        <th>Date</th>
                                        <th>Balance</th>
                                        <th>Electric Bill</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                        $sql = "SELECT *, a.tenant_id AS tenant_id FROM tenants a
                                        LEFT JOIN stalls ON stalls.stall_id = a.stall_id 
                                        LEFT JOIN (SELECT * FROM ebills WHERE ebill_id 
                                        IN (SELECT MAX(ebill_id) FROM ebills GROUP BY tenant_id)) e ON a.tenant_id=e.tenant_id
                                        LEFT JOIN rate ON rate.rate_id = a.rate_id 
                                        WHERE rate.rate_id = ? AND a.meter_number != ?";
                                        $query = $conn->prepare($sql);
                                        $query->execute(array(1,0));
                                        $fetch = $query->fetchAll();

                                      foreach ($fetch as $key => $value) { ?>
                                        <tr>                   
                                          <td><?php echo $value['stall_number'];?></td>  
                                          <td><?php echo $value['tenant_fname']." ".$value['tenant_lname'];?></td>
                                          <td><?php echo $value['meter_number'];?></td>
                                          <td><?php if ($value['ebill_date'] == ''){echo " ";} 
                                                  else { echo date('M d, Y',strtotime($value['ebill_date']));}?></td>
                                          <td style = "text-align:right"><?php echo "&#8369; ", number_format($value['ebill_newbal'], 2);?></td>
                                          <td class = "center" style = "text-align:center;">
                                            <button class="btn btn-sm btn-primary create_ebill" 
                                              data-id='<?php echo $value['tenant_id'];?>' 
                                              title="New Electric Reading">
                                              <i class="fa fa-edit"></i>  Reading </button>
                                            <button class="btn btn-sm btn-primary ebill_pay" 
                                              data-id='<?php echo $value['tenant_id'];?>' 
                                              title="Pay Electric Bill">
                                              <i class="fa fa-credit-card"></i>  Payment </button>
                                            <a href = "rpt_ind_elecbills.php?t_id=<?php echo $value['tenant_id'] ?>" 
                                              class="btn btn-primary btn-sm" 
                                              title="View Electric Bills">
                                              <i class="fa fa-search"></i>  View  </a>
                                            </td>                     
                                        </tr>
                                      <?php }?>                  
                                    </tbody>
                                </table>
                            </div> 
							              <!-- End of Table Responsive -->

                          </div> 
                          <!-- End of Body -->
						 
                    </div> 
                    <!-- End of Card -->

                </div>
                <!-- End of Page Content -->

            </div>
            <!-- End of Main Content -->
			 
            <!-- Footer-->
			      <?php include 'inc/footer.php';?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
     <?php include 'inc/logout_modal.php';?>

    <!-- Bootstrap core JavaScript-->
     <?php include 'inc/script.php';?>

    <!-- Page level plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>
    
</body>

</html>

  <!-- ELECTRICITY BILL READING MODAL -->

  <div class="modal fade createebill" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title text-center" id="myModalLabel">Electric Bill Reading</h3>
          <button type="button" 
            class="close" 
            data-dismiss="modal">
            <span>&times;</span></button>
        </div>
        <div class="modal-body pt-2">          
          <form  action="elecbill_save.php" method="POST">
            <input type="hidden" class="form-control" name="id" value="<?php echo $value['tenant_id'];?>">
            <input type="hidden" class="form-control" id="elec_rate" value="<?php echo $value['elec_rate'];?>">
            <div class="row"> 
              <label class="col-sm-6 tenant_name control-label mt-0"></label>
              <label class="col-sm-6 stall_number control-label mt-0"></label>
              <label class="col-sm-6 meter_number control-label mt-0"></label>
              <label class="col-sm-6 control-label mt-0">Rate: &#8369; <?php echo $value['elec_rate']." / kWh";?></label>
            </div>
            <div class="row"> 
                <div class="col-sm-4">
                    <label>Date</label> 
                    <input class="form-control" type="date" name="ebill_date" required>
                </div>
                <div class="col-sm-4">
                    <label>Coverage</label>
                    <input class="form-control" type="date" name="ebill_period" required>
                </div>                
            </div>
            <div class="row"> 
                <div class="col-sm-4">
                    <label>Previous</label>
                    <input class="form-control" name="ebill_prevread" id="ebill_prevread" required>
                </div>
                <div class="col-sm-4">
                    <label>Current</label> 
                    <input class="form-control" name="ebill_newread" id="ebill_newread" required>                    
                </div>
                <div class="col-sm-4">
                    <label>kWh Consumed</label>
                    <input class="form-control" name="ebill_cons" id="ebill_cons" required>
                </div>
            </div>
            <div class="row"> 
                <div class="col-sm-4">
                    <label>Previous Balance </label>
                    <input class="form-control" name="ebill_prevbal" id="ebill_prevbal" required>
                </div>
                <div class="col-sm-4">
                    <label>Electric Bill</label>
                    <input class="form-control" name="ebill_amount" id="ebill_amount" required>
                </div>
                <div class="col-sm-4">
                    <label>New Balance </label>
                    <input class="form-control" name="ebill_newbal" id="ebill_newbal" required>
                </div>
                    <input type="hidden" class="form-control" name="ebill_orno" value="0">
                    <input type="hidden" class="form-control" name="ebill_payment" value="0">                    
                    <input type="hidden" class="form-control" name="ebill_part" value="Electricity Bill">
              </div>
            </div>
          <div class="modal-footer">
            <button class="btn btn-primary" type="submit"><i class="fa fa-save fa-fw"></i>  Save  </button>
          </div>
        </form>
      </div>
    </div>
  </div>


  <!-- ELECTRICITY BILL PAYMENT MODAL -->

  <div class="modal fade ebillpay" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title text-center" id="myModalLabel">Electric Bill Payment</h3>
          <button type="button" 
            class="close" 
            data-dismiss="modal">
            <span>&times;</span></button>
        </div>
        <div class="modal-body pt-2">          
          <form  action="elecbill_save.php" method="POST">
            <input type="hidden" class="form-control" name="id" value="<?php echo $value['tenant_id'];?>">
            <input type="hidden" class="form-control" id="elec_rate" value="<?php echo $value['elec_rate'];?>">
            <div class="row"> 
              <label class="col-sm-6 tenant_name control-label mt-0"></label>
              <label class="col-sm-6 stall_number control-label mt-0"></label>
              <label class="col-sm-6 meter_number control-label mt-0"></label>
              <label class="col-sm-6 control-label mt-0">Rate: &#8369; <?php echo $value['elec_rate']." / kWh";?></label>
            </div>
            <div class="row"> 
                <div class="col-sm-4">
                    <label>Date</label> 
                    <input class="form-control" type="date" name="ebill_date" required>
                </div>
                <div class="col-sm-4">
                    <label>OR No.</label>
                    <input class="form-control" name="ebill_orno" required>
                </div>                
            </div>

            <input type="hidden" class="form-control" name="ebill_period" id="ebill_period" value="0">
            <input type="hidden" class="form-control" name="ebill_prevread" id="ebill_prevread">
            <input type="hidden" class="form-control" name="ebill_newread" id="ebill_newread">                    
            <input type="hidden" class="form-control" name="ebill_cons" id="ebill_cons" value="0">
            <input type="hidden" class="form-control" name="ebill_amount" id="ebill_amount" value="0">
            <input type="hidden" class="form-control" name="ebill_part" value="Electricity Bill Payment">
             
			      <div class="row"> 
                <div class="col-sm-4">
                    <label>Payable Amount </label>
                    <input type="number" class="form-control" name="ebill_prevbal" id="ebill_prevbal" required>
                </div>
                <div class="col-sm-4">
                    <label>Payment </label>
                    <input type="number" class="form-control" name="ebill_payment" id="ebill_payment" required>
                </div>
                <div class="col-sm-4">
                    <label>New Balance </label>
                    <input type="number" class="form-control" name="ebill_newbal" id="ebill_newbal" required>
                </div>
						  </div>

            </div>
          <div class="modal-footer">
            <button class="btn btn-primary" type="submit"><i class="fa fa-save fa-fw"></i>  Save  </button>
          </div>
        </form>
      </div>
    </div>
  </div>                  


  <!-- Page-Level Demo Scripts - Tables - Use for reference -->
  <script type="text/javascript">
    $('.create_ebill').click(function(e){
      e.preventDefault();
      var id = $(this).attr('data-id');
      $('.createebill').modal('show');
      $('input[name="id"]').val(id);
      
      $.ajax({
        type: "POST",
        url: "class.php",
        data: {
          key: 'add_ebills',
          id: id
        }
      })
      
      .done(function(data){
          if (!data.includes('/')) {
              console.error("Invalid response format");
              return;
          }
          var newdata = data.split('/');
          if (newdata.length < 6) {
              console.error("Missing data values");
              return;
          }

          $('.tenant_name').text(newdata[0]);
          $('.stall_number').text(newdata[1]);
          $('.meter_number').text(newdata[2]);
          $('input[name="elec_rate"]').val(newdata[3]);
          $('input[name="ebill_prevread"]').val(newdata[4]);
          $('input[name="ebill_prevbal"]').val(newdata[5]);
      });

      $('input#ebill_newread').on('change paste keyup', function(){
          var nread = parseFloat($(this).val()) || 0;
          var pread = parseFloat($('input#ebill_prevread').val()) || 0;
          var erate = parseFloat($('input#elec_rate').val()) || 0;
          var pbal = parseFloat($('input#ebill_prevbal').val()) || 0;

          var cons = Math.max(nread - pread, 10);
          var amt = cons * erate;
          var nbal = amt + pbal;

          $('input#ebill_cons').val(cons);
          $('input#ebill_amount').val(amt);
          $('input#ebill_newbal').val(nbal);
      });
      
      $('.close-modal, .close, .modal-fade').click(function(){
        $('input#ebill_newread').val('');
        $('input#ebill_cons').val('');
        $('input#ebill_amount').val('');          
        $('input#ebill_newbal').val(''); 
      }); 

    });

    $('.ebill_pay').click(function(e){
      e.preventDefault();
      var id = $(this).attr('data-id');
      $('.ebillpay').modal('show');
      $('input[name="id"]').val(id);
      
      $.ajax({
        type: "POST",
        url: "class.php",
        data: {
          key: 'add_ebills',
          id: id
        }
      })
      
      .done(function(data){
        var newdata = data.split('/');        
        $('.tenant_name').text(newdata[0]);      
        $('.stall_number').text(newdata[1]);
        $('.meter_number').text(newdata[2]);
        $('input[name="elec_rate"]').val(newdata[3]);
        $('input[name="ebill_prevread"]').val(newdata[4]);
        $('input[name="ebill_prevbal"]').val(newdata[5]);
      }); 

      $('input#ebill_payment').on('change paste keyup', function(){
        var pay = $(this).val();
        console.log(pay);        
        var pbal = $('input#ebill_prevbal').val();
        var nread = $('input#ebill_prevread').val();
        var nbal = pbal - pay;
        $('input#ebill_newread').val(nread);        
        $('input#ebill_newbal').val(nbal);
      });

      $('.close-modal, .close, .modal-fade').click(function(){
        $('input#ebill_payment').val('');       
        $('input#ebill_newread').val('');       
        $('input#ebill_newbal').val('');
      }); 

    });
  </script>

  

</body>

</html>