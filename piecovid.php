<?php
include 'koneksi.inc.php';
$case =mysqli_query($conn, "SELECT *FROM covid");
while($row = mysqli_fetch_array($case)){
	$nama_kasus[]=$row['negara'];

	$query=mysqli_query($conn, "SELECT sum(tot_kasus) as tot_kasus from covid where id='".$row['id']."'");
	$row =$query->fetch_array();
	$tot_kasus[]=$row['tot_kasus'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>PIE CHART</title>
	<script type="text/javascript" src="Chart.js"></script>
</head>
<body>
	<div id="canvas-holder" style="width:50%">
		<canvas id="chart-area"></canvas>
	</div>
	<script type="">
		var config={
			type:'pie',
			data:{
				datasets:[{
					data:<?php echo json_encode($tot_kasus);?>,
					backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(255, 206, 86, 0.2)',
					'rgba(75, 192, 192, 0.2)'
					],
					borderColor:[
					'rgba(255, 99, 132, 0.2)',
					'rgba(255, 99, 132, 0.2)',
					'rgba(255, 99, 132, 0.2)',
					'rgba(255, 99, 132, 0.2)'
					],
					label:'Presentase Penjualan Barang'
				}],
				labels:<?php echo json_encode($nama_kasus);?>
			},
			options:{
				responsive:true
			}
		};

		window.onload=function(){
			var ctx=document.getElementById('chart-area').getContext('2d');
			window.myPie=new Chart(ctx, config);
		};

		document.getElementById('randomizeData').addEventListener('click', function(){
			config.data.datasets.forEach(function(dataset){
				dataset.data=dataset.data.map(function(){
					return randomScalingFactor();
				});
			});

			window.myPie.update();
		});

		var colorNames=Object.keys(window.chartColors);
		document.getElementById('addDataset').addEventListener('click', function(){
			var newDataset={
				backgroundColor:[],
				data:[],
				label:'New dataset'+
				config.data.datasets.length,
			};
			for(var index=0; index<config.data.labels.length;
				++index){
				newDataset.data.push(randomScalingFactor());
			var colorName = colorNames[index%colorNames.length];
			var newColor=window.chartColors[colorName];
			newDataset.backgroundColor.push(newColor);
			}
			config.data.datasets.push(newDataset);
			window.myPie.update();
		});

		document.getElementById('removeDataset').addEventListener('click',function(){
			config.data.datasets.splice(0,1);
			window.myPie.update();
		});

	</script>
</body>
</html>