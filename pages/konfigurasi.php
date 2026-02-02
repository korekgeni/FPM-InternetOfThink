<?php
if(isset($_SESSION['page'])){
  
}else{
  header("location: ../index.php?page=dashboard&error=true");
}
?>
<div class="content-header ml-3 mr-3">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">KONFIGURASI</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php?page=dashboard">Home</a></li>
              <li class="breadcrumb-item active">Konfigurasi</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
</div>

<section class="content ml-3 mr-3">
	<div class="content">
		<div class="container-fluid">
			
							<div class="table-responsive">
								<table class="table table-bordered table-hover">
									<thead class="bg-secondary">
                                        <tr>
											<th>No</th>
                                            <th>Variabel</th>
                                            <th>Parameter Konfigurasi</th>
                                            <th>Keterangan</th>
                                            <th></th>
                                        </tr>
                                    </thead>
									<?php 
										$sql = mysqli_query($dbconnect,"SELECT * FROM tb_settings");
										$no='1';									
										while($data = mysqli_fetch_array($sql)){
									?>
									
									<tbody>
                                    <tbody class="bg-white">
                                        <tr class="odd gradeX">
										<td><?php echo $no;?></td>
										<td>Mulai jam masuk</td>
										<td><?php echo $data['masuk_mulai']; ?></td>
										<td>Parameter jam akan dimulai presensi masuk</td>
										<td> <center><a href="./index.php?page=edit_konfigurasi&id=<?php echo $no;?>&param=<?php echo $data['masuk_mulai'];?>" class="btn btn-outline-primary btn-sm"><i class="fas fa-cog" data-toggle="tooltip" title="Edit"></i></a></center></td>
										<?php $no+='1'; ?>
                                        </tr>
										
										<tr class="odd gradeX">
										<td><?php echo $no; ?></td>
										<td>Akhir jam masuk</td>
										<td><?php echo $data['masuk_akhir']; ?></td>
										<td>Batas dari Parameter jam presensi masuk </td>
										<td><center><a href="./index.php?page=edit_konfigurasi&id=<?php echo $no;?>&param=<?php echo $data['masuk_akhir'];?>" class="btn btn-outline-primary btn-sm"><i class="fas fa-cog" data-toggle="tooltip" title="Edit"></i></a></center></td>
										<?php $no+='1'; ?>
										</tr>
										
                                        </tr><tr class="odd gradeX">
										<td><?php echo $no;?></td>
										<td>Mulai jam keluar</td>
										<td><?php echo $data['keluar_mulai']; ?></td>
										<td>Parameter jam akan dimulai presensi keluar / pulang</td>
										<td><center><a href="./index.php?page=edit_konfigurasi&id=<?php echo $no;?>&param=<?php echo $data['keluar_mulai'];?>" class="btn btn-outline-primary btn-sm"><i class="fas fa-cog" data-toggle="tooltip" title="Edit"></i></a></center></td>
										<?php $no+='1'; ?>
										</tr>
										
                                        </tr><tr class="odd gradeX">
										<td><?php echo $no;?></td>
										<td>Akhir jam keluar</td>
										<td><?php echo $data['keluar_akhir']; ?></td>
										<td>Batas dari parameter jam presensi keluar / pulang</td>
										<td><center><a href="./index.php?page=edit_konfigurasi&id=<?php echo $no;?>&param=<?php echo $data['keluar_akhir'];?>" class="btn btn-outline-primary btn-sm"><i class="fas fa-cog" data-toggle="tooltip" title="Edit"></i></a></center></td>
                                        <?php $no+='1'; ?>
										</tr>
										
										</tr><tr class="odd gradeX">
										<td><?php echo $no; ?></td>
										<td>Hari Libur 1</td>
										<td><?php echo $data['libur1'];?></td>
										<td>Jika parameter ini diset pada hari tersebut presensi tidak berjalan</td>
										<td><center><a href="./index.php?page=edit_konfigurasi&id=<?php echo $no;?>&param=<?php echo $data['libur1'];?>" class="btn btn-outline-primary btn-sm"><i class="fas fa-cog" data-toggle="tooltip" title="Edit"></i></a></center></td>
                                        <?php $no+='1'; ?>
										</tr>
										
										</tr>
										<tr class="odd gradeX">
										<td><?php echo $no;?></td>
										<td>Hari Libur 2</td>
										<td><?php echo $data['libur2'];?></td>
										<td>Jika parameter ini diset pada hari tersebut presensi tidak berjalan</td>
										<td><center><a href="./index.php?page=edit_konfigurasi&id=<?php echo $no;?>&param=<?php echo $data['libur2'];?>" class="btn btn-outline-primary btn-sm"><i class="fas fa-cog" data-toggle="tooltip" title="Edit"></i></a></center></td>
										<?php $no+='1'; ?>
										</tr>

										</tr>
										<tr class="odd gradeX">
										<td><?php echo $no;?></td>
										<td>Zona Waktu</td>
										<td><?php echo $data['timezone'];?></td>
										<td>Parameter zona waktu berdasarkan area</td>
										<td><center><a href="./index.php?page=edit_konfigurasi&id=<?php echo $no;?>&param=<?php echo $data['timezone'];?>" class="btn btn-outline-primary btn-sm"><i class="fas fa-cog" data-toggle="tooltip" title="Edit"></i></a></center></td>
										<?php $no+='1'; ?>
										</tr>
										
										<tr class="odd gradeX">
										<td><?php echo $no;?></td>
										<td>IP Address</td>
										<td><?php echo $data['ip'];?></td>
										<td>IP Address Kontroler</td>
										<td><center><a href="./index.php?page=edit_konfigurasi&id=<?php echo $no;?>&param=<?php echo $data['ip'];?>" class="btn btn-outline-primary btn-sm"><i class="fas fa-cog" data-toggle="tooltip" title="Edit"></i></a></center></td>
										</tr>
										
										<?php 
										}
										?>
                                    </tbody>
                        	</table>
            </div>
	</div>
</div>
</section>