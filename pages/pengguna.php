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
            <h1 class="m-0 text-dark">DAFTAR PENGGUNA</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php?page=dashboard">Home</a></li>
              <li class="breadcrumb-item active">Daftar Pengguna</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
</div>
	
  <section class="content ml-3 mr-3">
    <div class="content">
      <div class="container-fluid">

      <div class="row">
          <div class="col-md-12 mb-3 mt-4">
            <a href="./index.php?page=tambah_pengguna"><button type="button" class="btn btn-secondary btn-sm float-right"><i class="fas fa-plus-square"></i> Pengguna</button></a>
          </div>
      </div>
      
			<div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="bg-secondary">
              <tr>
                <th>No</th>
                <th>Nama Pengguna</th>
                <th>Password</th>
                <th>Level</th>
                <th></th>
              </tr>
            </thead>

          <tbody>
          <tbody class="bg-white">
						<?php
							$sql = mysqli_query($dbconnect,"SELECT * FROM tb_pengguna");
								$no = '0';
								while($data = mysqli_fetch_array($sql)){
								if($data['level'] == '0'){
									$role = "Admin";
								}
								$no++;
						?>
              <tr class="odd gradeX">
                <td><?php echo $no; ?></td>
                <td><?php echo $data['username']; ?></td>
                <td><?php echo $data['password']; ?></td>
								<td><?php echo $role; ?></td>
								<td>
								<center>
									<a href="./konfig/delete_pengguna.php?no=<?php echo $data['no'];?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Ingin menghapus pengguna?')" data-toggle="tooltip" title="Hapus"><i class="fas fa-trash-alt"></i></a>
									<a href="./index.php?page=edit_pengguna&no=<?php echo $data['no'];?>&username=<?php echo $data['username']; ?>&password=<?php echo $data['password']; ?>&role=<?php echo $data['level']; ?>" class="btn btn-outline-primary btn-sm ml-3" data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>
								</center>
								</td>
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