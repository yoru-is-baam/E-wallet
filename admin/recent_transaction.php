<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>Recent transaction</title>
	<link
		rel="stylesheet"
		href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
	/>
	<link
		rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
	/>
</head>
<body>
<div class="container-fluid mt-5">
	<div class="content">
		<!-- Transaction History -->
		<div class="content__recent--history text-center align-items-center">
			<h2 class="text-center">Your transaction history</h2>
			<table class="table text">
				<thead class="thead-dark">
				<tr>
					<th scope="col">#</th>
					<th scope="col">Transaction type</th>
					<th scope="col">Fee</th>
					<th scope="col">Execution time</th>
					<th scope="col">Status</th>
					<th scope="col">See detail</th>
				</tr>
				</thead>
				<tbody>
				<tr class="withdrawal">
					<th scope="row">1</th>
					<td>Withdraw</td>
					<td>0đ</td>
					<td>27/10/2022</td>
					<td>Approved</td>
					<td>
						<a href="../e_wallet-core/withdrawal_history_detail.php" class="btn">
							Detail infor
						</a>
					</td>
				</tr>
				<tr class="transfer">
					<th scope="row">1</th>
					<td>Transfer</td>
					<td>0đ</td>
					<td>27/10/2022</td>
					<td>Approved</td>
					<td>
						<a href="../e_wallet-core/transfer_history_detail.php" class="btn">
							Detail infor
						</a>
					</td>
				</tr>
				<tr class="buy-phone-card">
					<th scope="row">1</th>
					<td>Buy phone card</td>
					<td>0đ</td>
					<td>27/10/2022</td>
					<td>Approved</td>
					<td>
						<a href="../e_wallet-core/card_infor.php" class="btn">Detail infor</a>
					</td>
				</tr>
				<tr class="receive">
					<th scope="row">1</th>
					<td>Receive</td>
					<td>0đ</td>
					<td>27/10/2022</td>
					<td>Approved</td>
					<td>
						<a href="../e_wallet-core/receive.php" class="btn">Detail infor</a>
					</td>
				</tr>
				<tr class="deposit">
					<th scope="row">1</th>
					<td>Deposit</td>
					<td>0đ</td>
					<td>27/10/2022</td>
					<td>Approved</td>
					<td>
						<a href="../e_wallet-core/deposit_history.php" class="btn">Detail infor</a>
					</td>
				</tr>
				</tbody>
			</table>
			<a href="activated_display.php" class="btn btn-light"
			><i class="fa-solid fa-arrow-left"></i> Go back
			</a>
		</div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
