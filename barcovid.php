<?php
	include ('koneksi.inc.php');
	$case = mysqli_query($conn, "SELECT * FROM covid");
	while($row = mysqli_fetch_array($case)){
		$nama_kasus[] = $row['negara'];

		$query = mysqli_query($conn, "SELECT sum(tot_kasus) as tot_kasus from covid WHERE id = '".$row['id']."'");
			$row = $query->fetch_array();
			$tot_kasus[] = $row['tot_kasus'];
	}

?>

<DOCTYPE HTML>
<html>
<head>
	<title> Membuat Grafik Menggunakan Chart JS</title>
	<script type="text/javascript" src="Chart.js"></script>
</head>

<body>
	<div style ="width : 800px; height:800px">
		<canvas id="myChart"></canvas>
	</div>

	<script>
		var ctx = document.getElementById("myChart").getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: <?php echo json_encode($nama_kasus); ?>,
				datasets: [{
					label: 'Grafik Penjualan',
					data: <?php echo json_encode($tot_kasus); ?>,
					backgroundColor: 'rgba(255, 99, 132, 0.2)',
					borderColor: 'rgba(255, 99, 132, 1)',
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});
	</script>
</body>
</html>