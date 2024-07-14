<?php include 'koneksi.php' ;
$sql='SELECT * FROM daftarkoleksi';
$result = mysqli_query($conn,$sql);
?>
<?php include 'views/blog/header.php'; ?>


<div class="about">
		<div class="container">
			<div class="text-center">
				<h2>Daftar Koleksi</h2>
				<div class="col-md-10 col-md-offset-1">
			<table border="1" align='center' class = "table table-striped"  >

				<tr>

					 <th>No</th>
					 <th>Kode Katalog</th>
					 <th>Judul Katalog</th>
					 <th>Jumlah</th>

					 </tr>


					 	<?php  while ($row = $result->fetch_assoc()) { ?>
					 <tr>
					 	<td><?=$row['id']?></td>
					 	<td><?=$row['kodekatalog']?></td>
					 	<td><?=$row['judulkatalog']?></td>
					 	<td><?=$row['jumlah']?></td>
					 </tr>
					 <?php } ?>
			</table>
				</div>
			</div>
		</div>
	</div>
<?php include 'views/blog/footer.php'; ?>
