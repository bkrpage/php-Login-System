<?php 
	session_start();
	
	$page_title = "Home ";
	
	require 'header.php';
	
	if (isset($_COOKIE['user'])){
		$_SESSION['loggedin'] = true;
		$_SESSION['userID'] = $_COOKIE['user'];
	}
	
	if (isset($_SESSION['loggedin'])){
		if ($_SESSION['loggedin'] == true){
			header('Location: control_panel.php');
		} else {
			echo "Error";
			unset($_SESSION['loggedin']);
		}
	} else {
?>	
	<div class="form-box index">
	
		<h1> Login </h1>

		<p class="notification"> Currently, due to my hostings Database restrictions, the website is not functioning on bkrpage.co.uk right now. However, 
				there is a working version at <a href="http://student20352.201415.uk">my University sub-domain</a>.</p>
<?php
		if ($_GET['successfulReset']){
			
			unset($_SESSION['user_resetting_pass']);
			echo "<p class='success'>Password successfully reset, now you can login below</p>";
		}
	
		if ($_GET['registered']){
			echo "<p class='success'>Successfully registered. Please login below</p>";
		}
		
		if ($_GET['loggedout']){
			echo "<p class='success'>You have logged out. Goodbye!</p>";
		}
		
		if ($_GET['alreadyloggedout']){
			echo "<p class='warning'>You are already logged out</p>";
		}
		
		if ($_GET['notLoggedIn']){
			echo "<p class='warning'>You are not logged in</p>";
		}
		
		
			
		if (!empty($_POST)){
				
			$email = $_POST['email'];
			$password = $_POST['password'];
			$hashed_pw = SHA1("$password");
			
			$remember_me = $_POST['remember'];
		
			$entry_errors = array();
			
			if (empty($email)){
				$entry_errors[] = "<p class='error'>Please enter your Email</p><style>.e{border: 1px solid #CC0000;}</style>";
			} else {
				$uid = "i7709331"; 
				$pwd = "phppass"; 
				$host = "127.0.0.1";
				$db = $uid;
				$conn = mysqli_connect($host, $uid, $pwd, $db);
				 
				$q_email_check = "SELECT u_email FROM users WHERE u_email LIKE '$email'"; //Query to find duplicate emails
				$result_email = mysqli_query($conn, $q_email_check);
				$num_rows = mysqli_fetch_array($result_email);
			
				if (empty($num_rows)){
					$entry_errors[] = "<p class='error'>User does not exist</p><style>.e{border: 1px solid #CC0000;}</style>";
				}
			}
			
			if (empty($password) && empty($entry_errors)){
				$entry_errors[] = "<p class='error'>Please enter a Password</p><style>.pw{border: 1px solid #CC0000;}</style>";
			} else if (empty($entry_errors)){
				$uid = "i7709331"; 
				$pwd = "phppass"; 
				$host = "127.0.0.1";
				$db = $uid;
				$conn = mysqli_connect($host, $uid, $pwd, $db);
				 
				$q_password_check = "SELECT u_password FROM users WHERE u_email LIKE '$email' AND u_password LIKE '$hashed_pw'"; //Query to find duplicate emails
				$result_password = mysqli_query($conn, $q_password_check);
				$num_rows = mysqli_fetch_array($result_password);
			
				if (empty($num_rows)){
					$entry_errors[] = "<p class='error'>Password is incorrect</p><style>.pw{border: 1px solid #CC0000;}</style>";
				}
			}
		
			if(empty($entry_errors)){
				$uid = "i7709331"; 
				$pwd = "phppass"; 
				$host = "127.0.0.1";
				$db = $uid;
				$conn = mysqli_connect($host, $uid, $pwd, $db);
				
				//escapes any mysqli commands
				$email = mysqli_real_escape_string($conn, $email);
				
				$qry = "SELECT * FROM users WHERE u_email LIKE '$email' AND u_password LIKE '$hashed_pw'";
				$result = mysqli_query($conn,$qry);

				$rows = mysqli_num_rows($result);
				if ($rows == 1){
					
					$_SESSION['loggedin'] = true;
					$_SESSION['userID'] = $email;
					
					//set cookie to stay logged in if wanted
					
					if ($remember_me == "true"){
						$cookie_name = "user";
						$cookie_value = $email;
						$cookie_time = time() + 3600 * 24 * 7; //setting cookie expiry time for a week
						setcookie($cookie_name, $cookie_value, $cookie_time);
					}
					
					header('Location: control_panel.php');
				} 
				
				mysqli_close($conn);
			} else {
				foreach($entry_errors as $e){
					echo "$e";
				}
			}
		}
?>
		<form action="index.php" method="POST">
			<label for="email">Email</label>
			<input type="email" name="email" value="<?php if(!empty($email)) echo "$email" ; ?>" class="e">
			
			<label for="password">Password</label>
			<input type="password" name="password" class="pw">
			
			<label id="rememberme"><input type="checkbox" name="remember" value="true">Remember me</label>
			
			<input type="submit" value="Login" class="submit login">
		</form>
		
		<form action="register.php">
			<input type="submit" value="No account? Register!" class="submit register">
		</form>
		
		<form action="forgot_password.php">
			<input type="submit" value="Forgot Password?" class="submit forgot">
		</form>
	</div>

<?php
	}
?>
	<footer>
		<div id="github"> This site was made by Bradley Page using PHP and MySQLi. To see the working innards as well as my other projects, check out my <a href="https://github.com/bkrpage/php-Login-System">Github Repo</a>! </div>
	</footer>

</body>
</html>