<?php  session_start(); include 'sambungkan.php'; 
// error_reporting(0); 
// if (isset($_SESSION['username'])) {
//     header("Location: 200ceb26807d6bf99fd6f4f0d1ca54d4/index.php?page=dashboard");

// }
if (isset($_POST['submit'])) {
    $username = htmlspecialchars($_POST['username'], ENT_QUOTES);   
    $password = htmlspecialchars($_POST['password'], ENT_QUOTES); 
	$sqlAdministrator = "SELECT * FROM user WHERE username='$username' AND password ='$password'";   
	// echo $sqlAdministrator; exit;
		$result = mysqli_query($conn, $sqlAdministrator);
		if (mysqli_num_rows($result) > 0) { 
			$row = mysqli_fetch_assoc($result); 
			$_SESSION['isLogin'] = true;							$_SESSION['id'] = $row['id'];   							
			$_SESSION['nama_pengguna'] = $row['nama_pengguna'];		$_SESSION['username'] = $row['username'];
			$_SESSION['password'] = $row['password']; 				$_SESSION['nama_sekolah'] = $row['nama_sekolah'];
			$_SESSION['foto_sekolah'] = $row['foto_sekolah'];		 
 			$_SESSION['email_pengguna'] = $row['email_pengguna'];
			$_SESSION['peran'] = "administrator"; 
			$_SESSION['role'] = 0;			
			header("Location:index.php?page=dashboard");
		} else {
				$_SESSION['eror'] = "Username atau password anda salah. Silahkan coba lagi";
				header("Location:error.php");
				} 
	}else{
     header("Location:error.php"); 
	} 
?>