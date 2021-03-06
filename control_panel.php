<?php
	session_start();
	
	$page_title = "Control Panel";
	
	require 'header.php';
	
	if (isset($_COOKIE['user'])){
		$_SESSION['loggedin'] = true;
		$_SESSION['userID'] = $_COOKIE['user'];
	}
	
	if (!empty($_SESSION['loggedin'])){
		if ($_SESSION['loggedin'] == true){
			$uid = "i7709331"; 
			$pwd = "phppass"; 
			$host = "127.0.0.1";
			$db = $uid;
			$conn = mysqli_connect($host, $uid, $pwd, $db);
			
			$users_email = $_SESSION['userID'];
			
			$qry_get_det= "SELECT * FROM user_details WHERE u_email LIKE '$users_email'";
			$result = mysqli_query($conn, $qry_get_det);
			
			$user_details = mysqli_fetch_row($result);
			
			$u_e = $user_details[0];
			$u_fn = $user_details[1];
			$u_sn = $user_details[2];
			$u_no = $user_details[3];
			$u_a1 = $user_details[4];
			$u_a2 = $user_details[5];
			$u_a3 = $user_details[6];
			$u_pc = $user_details[7];
			$u_co = $user_details[8];
			$u_sq = $user_details[9];
			$u_sa = $user_details[10];
?>
<div class="details-box">
	<h1> Welcome <?php echo $u_fn ?>! </h1>		
<?php	
			if ($_GET['alreadyLoggedIn']){
				echo "<p class='warning'>You are already logged in, please log out to reset password with security question.</p>";
			}
			
			if ($_GET['successfulChange']){
				echo "<p class='success'>Details successfully changed.</p>";
			}
			if ($_GET['successfulPassChange']){
				echo "<p class='success'>Password successfully changed.</p>";
			}
			if ($_GET['alreadyRegistered']){
				echo "<p class='warning'>You are already registered and logged in as $u_fn.</p>";
			}
	
?>
	
	<table id="user-details">
		<tr>
			<td>First Name: </td>
			<td><?php echo $u_fn; ?></td>
		</tr>
		<tr>
			<td>Surname: </td>
			<td><?php echo $u_sn; ?></td>
		</tr>
		<tr>
			<td>Email: </td>
			<td><?php echo $u_e; ?></td>
		</tr>
		<tr>
			<td>Phone Number: </td>
			<td><?php echo $u_no; ?></td>
		</tr>
		<tr>
			<td>Address 1: </td>
			<td><?php echo $u_a1; ?></td>
		</tr>
		<tr>
			<td>Address 2: </td>
			<td><?php echo $u_a2; ?></td>
		</tr>
		<tr>
			<td>Address 3: </td>
			<td><?php echo $u_a3; ?></td>
		</tr>
		<tr>
			<td>Post Code: </td>
			<td><?php echo $u_pc; ?></td>
		</tr>
		<tr>
			<td>Country: </td>
			<td><?php echo $u_co; ?></td>
		</tr>
		<tr>
			<td>Security question: </td>
			<td><?php echo $u_sq; ?></td>
		</tr>
	</table>
	
	<form action="change_details.php">
		<input type="submit" value="Anything wrong? Change Details" class="submit">
	</form>
	<form action="logout.php">
		<input type="submit" value="Not <?php echo $u_fn ?>? Logout" class="submit">
	</form>
</div>

<?php
		} else {
			echo "Error";
			session_destroy();
		}
		
	} else {
		header('Location: index.php?notLoggedIn=true');
	}


?>


</body>
</html>