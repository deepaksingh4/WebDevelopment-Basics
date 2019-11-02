<?php
// Include config file
//require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database//style="display: none;"
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="main.css">
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="  crossorigin="anonymous"></script>
	</head>
	
	<body onload="myFunction()">

    <div id="loading"></div>
	<div id="popupmain" style="display:none;">
		<div id="wrapper">
			<div class="close">+</div>
			<h2 id="heading1">Sign Up</h2>
			<p id="pop_p1">Please fill this form to create an account.</p>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label for="l1">Username</label><br>
                <input id="l1" type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label for="l2">Password</label><br>
                <input id="l2" type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label for="l3">Confirm Password</label><br>
                <input id="l3" type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group1">
                <input type="submit" class="btn_btn-primary" value="Submit">
                <input type="reset" class="btn_btn-1" value="Reset">
            </div>
            <p id="pop_p2">Already have an account? <a href="login.php" style="color:blue;">Login here</a></p>
            </form>
        </div>      
    </div>
      
    <div class="nav">
        <a href="#home">Home</a>
		<div class="dropdown">
			<button class="dropbtn">Books</button>
			<div class="dropdown-content">
				<a href="#">First Year</a>
				<a href="#">Second Year</a>
				<a href="#">Third Year</a>
				<a href="#">Fourth Year</a>
			</div>
        </div>
        <div class="dropdown">
			<button class="dropbtn">Sell</button>
			<div class="dropdown-content">
				<a href="#">1</a>
				<a href="#">2</a>
				<a href="#">3</a>
				<a href="#">4</a>
			</div>
        </div>
		<div>
			<div class="login">
				<a href="#login">Login</a>
			</div>
            <div class="searc-container">
                <form>
                    <input type="text" placeholder="Search..">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
			</div>
		</div>
	</div>
	
    <div class="slideshow-container">
		<div class="mySlides fade">
			<img  src='https://www.pixelstalk.net/wp-content/uploads/2016/04/Alphabet-inc-google-holding-company-wallpapers-HD.jpg' style='width: 100%; height: 100%;' alt="google wallpaper 1"/>
		</div>
		<div class="mySlides fade">
			<img  src='https://www.pixelstalk.net/wp-content/uploads/2016/04/Google-Wallpaper-HD-Images-Desktop.jpg' style='width: 100%; height:98%;' alt="google wallpaper2"/>
		</div>
		<div class="mySlides fade">
			<img  src='https://www.pixelstalk.net/wp-content/uploads/2016/04/Awesome-Google-Logo-Wallpaper-Computer.jpg' style='width: 100%; height:100%;' alt="google wallpaper3"/>
		</div>
		<div class="mySlides fade">
			<img  src='https://www.pixelstalk.net/wp-content/uploads/2016/04/Pictures-google-wallpapers-download.jpg' style='width: 100%; height:100%;' alt="google wallpaper4"/>
		</div>
		<a class="prev" onclick='plusSlides(-1)'>&#10094;</a>
		<a class="next" onclick='plusSlides(1)'>&#10095;</a>
    </div>
    <br>

    <div style='text-align: center;'>
      <span class="dot" onclick='currentSlide(1)'></span>
      <span class="dot" onclick='currentSlide(2)'></span>
      <span class="dot" onclick='currentSlide(3)'></span>
      <span class="dot" onclick='currentSlide(4)'></span>
    </div>
  
	<br><br>
	
	<div class="cat">Category</div><hr>
	
	<div>
		<div class="responsive">
			<div class="gallery">
				<a target="_blank" href="#">
				<img src="book.jpg" alt="First year books" >
				</a>
				<div class="desc">First Year</div>
			</div>
		</div>
		<div class="responsive">
			<div class="gallery">
				<a target="_blank" href="#">
				<img src="book.jpg" alt="Second year books" >
				</a>
				<div class="desc">Second Year</div>
			</div>
		</div>
		<div class="responsive">
			<div class="gallery">
				<a target="_blank" href="#">
				<img src="book.jpg" alt="Third year books" >
				</a>
				<div class="desc">Third Year</div>
			</div>
		</div>
		<div class="responsive">
			<div class="gallery">
				<a target="_blank" href="#">
				<img src="book.jpg" alt="Forth year books" >
				</a>
			<div class="desc">Forth Year</div>
			</div>
		</div>
	</div>

<script>
var preloader = document.getElementById('loading');

function myFunction(){
preloader.style.display = 'none';
}




      $(document).ready(function(){
    setTimeout(function(){
    $('#popupmain').css('display','block');},20000);
    });
    $('.close').click(function(){
    $('#popupmain').css('display','none');
    });

     // document.ready('load',function(){
       //     setTimeout()=>{
       //         function(){
        //          document.querySelector('#wrapper').style.display='block';
      //          }
    //        },5000
  //    });

    //  document.querySelector('.close').addEventListener('click',function(){
      //    document.querySelector('#wrapper').style.display='none';
          //document.querySelector('#popupmain').style.display='none';
     // });

        var slideIndex = 1;

        var myTimer;

        window.addEventListener("load",function() {
            showSlides(slideIndex);
            myTimer = setInterval(function(){plusSlides(1)}, 4000);
        })



        // NEXT AND PREVIOUS CONTROL
        function plusSlides(n){
        clearInterval(myTimer);
        if (n < 0){
            showSlides(slideIndex -= 1);
        } else {
        showSlides(slideIndex += 1); 
        }
        if (n === -1){
            myTimer = setInterval(function(){plusSlides(n + 2)}, 4000);
        } else {
            myTimer = setInterval(function(){plusSlides(n + 1)}, 4000);
        }
        }

        //Controls the current slide and resets interval if needed
        function currentSlide(n){
        clearInterval(myTimer);
        myTimer = setInterval(function(){plusSlides(n + 1)}, 4000);
        showSlides(slideIndex = n);
        }

        function showSlides(n){
        var i;
        var slides = document.getElementsByClassName("mySlides");
        var dots = document.getElementsByClassName("dot");
        if (n > slides.length) {slideIndex = 1}
        if (n < 1) {slideIndex = slides.length}
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex-1].style.display = "block";
        dots[slideIndex-1].className += " active";
        }
</script>

<br><br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br><br>

<footer>
	<div class="parent">
		<div class="child">
			<div class="space" ><a href="#">About Hotstar</a>  <a href="#">Terms Of Use</a>  <a href="#">Privacy Policy(New)</a>  <a href="#">FAQ</a>  <a href="#">Feedback</a>  <a href="#">Careers</a></div>
				<p align="justify" class="child1">&copy; 2019 STAR All Rights Reserved. HBO, Home Box Office and all related channel and programming logos are
				service marks of, and all related programming visuals and elements are the property of, Home Box Office, Inc.
				All rights reserved.</p>
		</div>
		<div class="child" >
		<center>
			<p class="space">Connect with us</p>
			<div class="size">
				<a href="#" class="b"><i class="fa fa-facebook" title="Facebook"></i></a>&nbsp;&nbsp;<a href="#" class="b"><i class="fa fa-instagram" title="Instagram"></i></a>&nbsp;&nbsp;<a href="#" class="b"><i class="fa fa-twitter" title="Twitter"></i></a>
			</div>
		</center>
		</div>
	</div>
</footer>

</body>
</html>
