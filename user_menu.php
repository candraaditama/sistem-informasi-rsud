<?php  
	session_start();
	if(!isset($_SESSION['id']))
	header('Location: login.php'); 
	include 'dbconfig.php';
?>

<?php 
	//$conn = new mysqli("localhost", "root" , "", "has");
	
	$u_id=$_SESSION['id'];
	$sql = " SELECT * from registered WHERE user_id = '$u_id' ";
	$result = $conn->query($sql);
	$row=mysqli_fetch_array($result);
	
	$sql_app="SELECT * from appointments WHERE user_id = '$u_id' ORDER BY date ";
	$result_app = $conn->query($sql_app);
	$count = mysqli_num_rows($result_app);
	
?>

<html>
	
	<head>
		<title>Halaman Penguna</title>
		<link rel="stylesheet" href="bootstrap/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="bootstrap/common.css" >
		<script src="bootstrap/jquery-1.11.3.min.js"></script>
		<script src="bootstrap/bootstrap.min.js"></script>
	</head>
	
<script>
	$(document).ready(function() {
		
		$(".cancel_app").click(function(event){
			var appid = $(this).val();
			 var passedData = 'appid=' + appid;
			
			 $.ajax( {
			 type: "POST",
			 url:'cancel_app.php',
			 data:passedData,
			 cache: false,
			 success:function(data) {
				 var x=1;
				if(data == x)
				{
				alert("Pendaftaran berhasil dibatalkan");
			 	location.reload();
				}
			}
			});
	});
 });
</script>

<body>
	<?php require("nav_bar_uc.php"); ?>

	<div class="form">
		<Center><div class="register">Selamat Datang</div></center>
		
		<table style="width:100%;">
			<tr>
				
				<td><a href="edit_profile.php" style="text-decoration:none; color:black;">
					<div id="div_img"  style="width:160 ; padding:8px; margin-left:10; margin-right:10; ">
						<?php if($row['image']==""){?>
						<img alt="user-image" src="image/user_img/default_profile_pic_user_<?php if($row['gender']!='-Select-')echo $row['gender']; else echo"male"; ?>.png" style="height:130px; width:130px; ">
						<?php }else{?>
						<img alt="user-image" src="image/user_img/<?php echo $row['image'];?>" style="height:130px; width:130px; ">							
						<?php }?>
					</div>
				</a></td>
									
				<td><a href="edit_profile.php" style="text-decoration:none; color:black;">
					<div class="user-information"  style="width:250; text-decoration:none;">
						<h4>
							<div><?php echo $row['name']; ?></div>
						</h4>
						<span style="font-size:15;"> <?php echo $row['email']; ?> </span>
						<br>
						<span style="font-size:15;"> <?php echo $row['mobile']; ?> </span>
						<br>
						<span style="font-size:15;"> <?php echo $row['dob']; ?> </span>
						<br>
						<span style="font-size:15;"> <?php echo $row['city']; ?> </span>
						<br>
					</div>
				</a></td>
				
				<td>
					<div class="appointment-block"  style="width:300; padding:5px; ">
						<div>
							<img src="image/time.png" style="height:32px; width:32px; margin-bottom:4px;">
							<span style="font-size:14;"><em>Jadwal Pemeriksaan:  <em><?php echo $count; ?></span>
						</div>
						<div>
							<!--<img src="image/cal_icon.jpg" style="height:16px; width:16px; margin-bottom:4px;">-->
						</div>
					</div>
				</td>
			</tr>
		</table>
	
	</div>
	
	<div class="form">
	
	<?php if($count > 0) {?>
		<Center><div class="register">Jadwal Pemeriksaan</div></center>
	<?php } ?>
	
	<?php while($row_app=mysqli_fetch_array($result_app))
	{ 
		$h_id=$row_app['hos_id'];
		$d_id=$row_app['doc_id'];
		
		$sql_hos=" SELECT * from hospital WHERE hos_id = '$h_id' ";
		$result_hos = $conn->query($sql_hos);
		$row_hos=mysqli_fetch_array($result_hos);
		
		$sql_doc=" SELECT * from doctor WHERE doc_id = '$d_id' ";
		$result_doc = $conn->query($sql_doc);
		$row_doc=mysqli_fetch_array($result_doc);
		?>

		
		<table>
			<tr>
				<td>
					<div id="div_img"  style="width:140 ; padding:8px; ">
						<img alt="doctor-image" src="image/default_profile_pic_<?php echo $row_doc['gender']; ?>.png" style="height:120px; width:120px; ">
					</div>
				</td>
				
				<td>
					<div class="doctor-information"  style="width:230; ">
						<h4>
							<div>Dr. <?php echo $row_doc['name']; ?> </div>
						</h4>
						<span> <?php echo $row_doc['qualification']; ?> </span>
						<br>
						<span style="font-size:14;"><?php echo $row_hos['hos_name'].' , '.$row_hos['hos_city']; ?></span>
						<br>
						<span style="font-weight:600"> <?php echo $row_doc['specialization']; ?> </span>
						<br>
						<span style="font-size:13;"> <?php echo $row_doc['experience'].' tahun pengalaman'; ?> </span>
						<br>
						<span style="font-size:12;"> <?php echo $row_doc['languages']; ?> </span>
					</div>
				</td>
				
				<td>
					<div class="appointment-block"  style="width:220; padding:5px; ">
						<div>
							<img src="image/cek.png" style="height:21px; width:21px; margin-bottom:4px;">
							<span style="font-size:14;"><em>Nama Pasien:  </em><?php echo $row_app['patient_name'];?></span>
							<br>
							<img src="image/cek.png" style="height:21px; width:21px; margin-bottom:4px;">
							<span style="font-size:14;"><em>Umur:  <em><?php echo $row_app['patient_age'];?></span>
						</div>
						<div>
							<img src="image/cek.png" style="height:21px; width:21px; margin-bottom:4px;">
							<span style="font-size:14;"><em>Tanggal:  <em><?php echo $row_app['date']; ?> </span>
							<br>
							<img src="image/cek.png" style="height:21px; width:21px;">
							<span style="font-size:14;"><em>Jam:  <em><?php echo $row_app['time_slot']; ?> </span>
						</div>
					</div>
				</td>
				
			</tr>
		</table>
		
		<table>
			<tr>
				<td>
					<div style="padding:5px">
						<a href="modify_appointment.php?a_id=<?php echo $row_app['app_id'];?> && d_id=<?php echo $row_app['doc_id'];?> && h_id=<?php echo $row_app['hos_id'];?>"<button class="btn btn-primary modify_app" value="<?php echo $row_app['app_id']; ?>" >Ubah Jadwal</button></a>
					</div>
				</td>
				
				<td>				
					<div style="padding:5px;">
						<button class="btn btn-primary cancel_app" value="<?php echo $row_app['app_id']; ?>" >Batalkan Jadwal</button>
					</div>
				</td>
				
				<td>
					<div style="padding:5px">
						<form action="appointment_pdf.php" method = "post">
							<button class="btn btn-primary app_pdf" style="margin-top:15;" name="appid" value="<?php echo $row_app['app_id']; ?>" >Unduh Slip Jadwal</button>
						</form>
					</div>
				</td>	
				
			</tr>
		</table><?php	
	}
?>	

	<a href="appointment_search.php" >
		<center><button class="btn btn-primary">Tambahkan Jadwal baru</button>
	</a>

	</div>
	
	
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" ></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" ></script>
	
	
</body>
</html>