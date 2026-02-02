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
            <h1 class="m-0 text-dark">TAMBAH PENGGUNA</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php?page=pengguna">Daftar Pengguna</a></li>
              <li class="breadcrumb-item active">Tambah Pengguna</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
	</div>

<section class="content ml-3 mr-3">
	<div class="content">
		<div class="container-fluid">
	
		<form action="./konfig/add_pengguna.php" method="POST">
		  <div class="form-group">
			<label for="exampleInputEmail1">Username</label>
			<input required class="form-control" type="text" name="username" placeholder="Masukan Username">
	
		  </div>
		  
		 <div class="form-group">
			<label for="exampleInputEmail1">Password</label>
				<input required class="form-control" type="text" name="password" placeholder="Masukan Password">
		  </div>
		  
		  <div class="form-group pt-2">
			<label for="exampleFormControlSelect1">Level</label>
			<select class="form-control" name="role">
				<option>Admin</option>
			</select>
			
		 </div>
		  
			<button type="submit" class="btn btn-outline-primary mt-3 float-right" value="simpan">Tambahkan</button>
		</form>

	</div>
</div>
</section>