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
                            <h1 class="h2 mb-1 ml-2">  Rentals</h1>
						</div>

						<!-- Card Body -->
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-sm table-bordered table-hover text-gray-900" id="dataTable" width="100%" cellspacing="0">
									<thead>
										<tr>
											<th> Stall </th>
											<th> Tenant </th>
											<th> Latest </th>
											<th> Date </th>
											<th> Balance </th>																						
											<th> Transact </th>
										</tr>
									</thead>
									<tbody>
										<?php
											$sql = "SELECT *, a.tenant_id AS the_tenant_id FROM tenants a  
												LEFT JOIN  stalls ON  stalls.stall_id = a.stall_id
												LEFT JOIN (SELECT *,rentals.pay_balance AS balance FROM rentals 
												WHERE pay_id IN (SELECT MAX(pay_id) FROM rentals GROUP BY tenant_id) ) b ON a.tenant_id=b.tenant_id
												WHERE  a.tenant_status = ?"; 										
											$query = $conn->prepare($sql);
											$query->execute(array(1));
											$fetch = $query->fetchAll();
											foreach ($fetch as $key => $value) { ?>
												<tr>
													<td><?php echo $value['stall_number'];?></td>
													<td><?php echo $value['tenant_fname']." ".$value['tenant_lname'];?></td>
													<td><?php echo $value['pay_part'];?></td>
													<td><?php if ($value['pay_date'] == ''){echo " ";} 
														else { echo date('M d, Y',strtotime($value['pay_date']));}?></td>
													<td style="text-align:right;"><?php if ($value['balance'] == ''){echo " ";} 
														else { echo "&#8369; ", number_format($value['balance'], 2);}?></td>
													<td style="text-align:center"> 
														<a href="#rental<?=$value['the_tenant_id'];?>" 
															data-toggle="modal" 
															class="btn btn-primary btn-sm"
															title="Rental Transaction">
															<i class="fa fa-edit"></i> Rental
														</a>
														<a href="#payment<?=$value['the_tenant_id'];?>" 
															data-toggle="modal" 
															class="btn btn-primary btn-sm"
															title="Payment Transaction">
															<i class="fa fa-money-bill-alt"></i> Payment
														</a>
														<a href="rpt_ind_rentals.php?t_id=<?=$value['the_tenant_id']?>" 
															class="btn btn-primary btn-pill btn-sm" 
															title="View Transactions">
															<i class="fa fa-search" ></i> View
														</a>
													</td>
													<?php include 'rentals_modal.php';?>
												</tr> 
										<?php }  ?>
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

	
<script>
        $(document).ready(function () {
            // Real-time computation
            $('#rent_prevbal, #rent').on('input', function () {
                let input1 = $('#rent_prevbal').val();
                let input2 = $('#rent').val();

                // Send data to PHP via AJAX
                $.ajax({
                    url: 'rentals_newbal.php', // PHP file for computation
                    method: 'POST',
                    data: { input1: input1, input2: input2 },
                    success: function (response) {
                        $('#rent_newbal').val(response); // Display result
                    }
                });
            });
        });
    </script>
	
</body>

</html>