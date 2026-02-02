<?php
if(isset($_SESSION['page'])) {
	if(isset($_GET['no']) && isset($_GET['username']) && isset($_GET['password']) && isset($_GET['role'])){
		//lajut
	}else{
		echo '<h3><center> Permintaan ditolak :( </center></h3>';
		exit;
	}
}else{
  header("location: ../index.php?page=dashboard&error=true");
}
	$no = $_GET['no'];
	$username = $_GET['username'];
	$password = $_GET['password'];
	$role = $_GET['role'];
	
	if($role == '0'){
		$role = "Admin";
	}
	
?>

<div class="content-header ml-3 mr-3">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">EDIT PENGGUNA</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php?page=pengguna">Daftar Pengguna</a></li>
              <li class="breadcrumb-item active">Edit</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
</div>

<section class="content ml-3 mr-3">
	<div class="content">
		<div class="container-fluid">
	
		<form action="./konfig/update_pengguna.php" method="POST">
		  <div class="form-group">
			<label for="exampleInputEmail1">Username</label>
			 <input type="hidden" name="no" value="<?php echo $no; ?>">
			
			<input required class="form-control" type="text" name="username" placeholder="Masukan Username" value="<?php echo $username ?>">
	
		  </div>
		  
		  <div class="form-group">
			<label for="exampleInputEmail1">Password</label>
				<input required class="form-control" type="text" name="password" placeholder="Masukan Password" value="<?php echo $password ?>">
		  </div>
		  
		  <div class="form-group pt-2">
			<label for="exampleFormControlSelect1">Level</label>
			<select class="form-control" name="role">
				<option value="" selected disabled><?php echo $role;?></option>
				<option>Admin</option>
			</select>
			
		 </div>
		  
			<button type="submit" class="btn btn-outline-primary mt-3 float-right" value="simpan">Simpan</button>
		</form>

	</div>
</div>
</section>