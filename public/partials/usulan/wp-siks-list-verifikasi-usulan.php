<?php 
$jenis_data = $_GET['jenis'];
?>
<div class="container-md">
	<div class="cetak">
		<div style="padding: 10px;margin:0 0 3rem 0;">
			<h1 class="text-center">Daftar Data Usulan Per Desa <?php echo $jenis_data; ?></h1>
			<div class="wrap-table">
				<table id="listDesaTable" cellpadding="2" cellspacing="0" style="font-family:\'Open Sans\',-apple-system,BlinkMacSystemFont,\'Segoe UI\',sans-serif; border-collapse: collapse; width:100%; overflow-wrap: break-word;" class="table table-bordered">
					<thead>
						<tr>
							<th class="text-center">No</th>
							<th class="text-center">Kecamatan</th>
							<th class="text-center">Desa / Kelurahan</th>
							<th class="text-center">Jumlah Usulan</th>
							<th class="text-center">Jumlah Penetapan</th>
							<th class="text-center">Aksi</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>