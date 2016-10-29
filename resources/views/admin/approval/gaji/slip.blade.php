<script type="text/javascript">
	window.print();
</script>
<!DOCTYPE html>
<html>
<head>
	<title>SLIP Gaji</title>
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div style="text-algin:center;margin-left:30%;">
					<h3>PT Web Architect Technology</h3>
				</div>
				<div style="margin-left:25%;font-size: 9px;">
					PT. WEB ARCHITECT TECHNOLOGY
					MENARA CITICON LT. 15 SUITE A-B
					JL. S. PARMAN KAV 72
					JAKARTA 11410
				</div>
				<div style="border-bottom:1px solid black;">
				&nbsp;
				</div>
			</div>
			<div class="col-md-6" style="margin-top:10px;">
				<table class="" width="80%" style="border:0px;">
					<tr>
						<td>Tanggal</td>
						<td>:</td>
						<td>{{ $model->created_at->format('d, F Y') }}</td>
					</tr>
					<tr>
						<td>Nama</td>
						<td>:</td>
						<td>{{ $model->employee->name }}</td>
					</tr>
					<tr>
						<td>Departemen</td>
						<td>:</td>
						<td>{{ $model->employee->position->department->department }}</td>
					</tr>
					<tr>
						<td>Jabatan</td>
						<td>:</td>
						<td>{{ $model->employee->position->position }}</td>
					</tr>
				</table>
			</div>
			<div class="col-md-6">
				&nbsp;
			</div>
			<div class="col-md-12" style="margin-top:20px;">
				<div class="row">
					<div class="col-md-6">
						<h4>PENGHASILAN</h4>
						<table class="table">
							<tr>
								<td>Gaji Pokok</td>
								<td>:</td>
								<td>{{ Admin::formatMoney($model->gaji_pokok) }}</td>
							</tr>
							<tr>
								<td>Total Transport</td>
								<td>:</td>
								<td>{{ Admin::formatMoney($model->total_transport) }}</td>
							</tr>
							<tr>
								<td>Total Uang Makan</td>
								<td>:</td>
								<td>{{ Admin::formatMoney($model->total_uang_makan) }}</td>
							</tr>
							<tr>
								<td>Total Lembur</td>
								<td>:</td>
								<td >{{ Admin::formatMoney($model->total_lembur) }}</td>
							</tr>
							<tr>
								<td style="border-bottom:1px solid black;">&nbsp;</td>
								<td style="border-bottom:1px solid black;"><b>Total (A)</b></td>
								<td style="border-bottom:1px solid black;">{{ Admin::formatMoney($model->total + $model->pph21) }}</td>
							</tr>
						</table>
					</div>
					<div class="col-md-6">
						<h4>Pengurangan</h4>
						<table class="table">
							<tr>
								<td>PPH 21</td>
								<td>:</td>
								<td>{{ Admin::formatMoney($model->pph21) }}</td>
							</tr>
							<tr>
								<td colspan="3">-</td>
							</tr>
							<tr>
								<td colspan="3">-</td>
							</tr>
							<tr>
								<td colspan="3">-</td>
							</tr>
							<tr>
								<td style="border-bottom:1px solid black;">&nbsp;</td>
								<td style="border-bottom:1px solid black;"><b>Total (B)</b></td>
								<td style="border-bottom:1px solid black;">{{ Admin::formatMoney($model->pph21) }}</td>
							</tr>

							
						</table>
					</div>
					<div class="col-md-12">
						<table class="table">
							<tr>
								<td style="background-color:#efefef;color:black" style="text-align: center;">
									PENERIMAAN BERSIH (A - B) = {{ Admin::formatMoney($model->total) }}
								</td>
							</tr>
							<tr>
								<td style="background-color:#efefef;color:black" style="text-align: center;">
									Terbilang : {{ terbilang($model->total,1) }}
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>