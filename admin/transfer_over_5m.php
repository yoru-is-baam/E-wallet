<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>My E-wallet</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
	<link rel="stylesheet" href="../assets/css/admin-responsive.css" />
</head>

<body>
	<div class="container-fluid">
		<div class="content">
			<!-- Transfer History -->
			<div class="content__transfer--history text-center">
				<h2 class="text-center mt-4">Transfer history over 5,000,00đ</h2>
				<table class="table">
					<thead class="thead-dark">
						<tr>
							<th scope="col">#</th>
							<th scope="col">Transfer code</th>
							<th scope="col">Transaction Fee</th>
							<th scope="col">Execution time</th>
							<th scope="col">Transfer amount</th>
							<th scope="col">Message</th>
							<th scope="col">Status</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th scope="row">1</th>
							<td>T001</td>
							<td>50.000 đ</td>
							<td>27/10/2022</td>
							<td>1.000.000 đ</td>
							<td>I love you</td>
							<td>
								<button data-toggle="modal" data-target="#transfer-agree" class="btn btn-success mt-2">
									Agree
								</button>
								<button data-toggle="modal" data-target="#transfer-disagree" class="btn btn-danger mt-2">
									Disagree
								</button>
							</td>
						</tr>
					</tbody>
				</table>
				<a href="admin_system.html" class="btn btn-light" type="submit"><i class="fa-solid fa-arrow-left"></i>
					Go back
				</a>
			</div>

			<!-- Modal agree -->
			<div class="modal fade" id="transfer-agree" tabindex="-1" role="dialog" aria-labelledby="transfer-agreeLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<h2>Do you want to approve this account?</h2>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-dismiss="modal">
								Disagree
							</button>
							<button type="button" class="btn btn-success">Agree</button>
						</div>
					</div>
				</div>
			</div>

			<!-- Modal disagree -->
			<div class="modal fade" id="transfer-disagree" tabindex="-1" role="dialog" aria-labelledby="transfer-disagreeLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<h2>Do you want to disapprove verification?</h2>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-dismiss="modal">
								Disagree
							</button>
							<button type="button" class="btn btn-success">Agree</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>