<!--Helps in creating navigation bar(collapsing) in the webpage where it is included-->
<nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="index.php" class="navbar-brand">Ct&#8377;l Budget</a>
                </div>
                <div>
                    <div class="collapse navbar-collapse" id="myNavbar">
                        <ul class="nav navbar-nav navbar-right">
                            <?php
                            //If the current user is a logged-in user.
                             if (isset($_SESSION['email'])){?>
                               <li><a href = "about_us.php"><span class = "glyphicon glyphicon-info-sign"></span>About us</a></li>
                               <li><a href = "change_password.php"><span class = "glyphicon glyphicon-cog"></span>Change Password</a></li>
                               <li><a href = "logout.php"><span class = "glyphicon glyphicon-log-out"></span> Logout</a></li> 
                            <?php }
                            else{//If the current user is a new user/logged-out user.?>
                               <li><a href="about_us.php"><span class="glyphicon glyphicon-info-sign"></span>About Us</a></li>
                               <li><a href="signup.php"><span class="glyphicon glyphicon-user"></span>Sign Up</a></li>
                               <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                            <?php }?>
                        </ul>
                    </div>
                </div>
            </div>
</nav>

