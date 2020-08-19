<div class="row">
     <div class="col-lg-12 nav">
         <div class="container">
             <div class="col-lg-12 nav-wrapper">
                <div class="col-lg-2 col-sm-12 logo">
                     <a href="#"><h1>AUROS</h1></a>
                </div>
                <div class="col-lg-6 col-sm-12 menu-items">
                     <ul id="mainMeni" class="col-sm-12">
                    
                     </ul>
                </div>
                
                <div class="col-lg-4" id="loginShopMeni">
                    <i class="fa fa-user-o" aria-hidden="true" id="btnModal"></i>
                    <!-- The Modal -->
                    <div id="myModalLogin" class="modal">

                    <!-- Modal content -->
                    
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        
                        <!-- <div class="col-lg-12" id="loginForm"> -->
                            <form action="index.php?page=login" id="loginForm" class="animated fadeIn" method="post" onsubmit="return checkLogin()">
                                <h2>Login </h2>
                                <input type="text" name="emailLogin" id="emailLogin" class="col-lg-12" placeholder="email">
                                <p id="error-emailLogin"></p>
                                <input type="password" name="passwordLogin" id="passwordLogin" class="col-lg-12" placeholder="password">
                                <p id="error-passwordLogin"></p>
                               <input type="submit" value="Login" class="btnLogin" name="btnLogin">
                               <p id="error-login1"></p>
                            <?php if(isset($_SESSION['greska'])): ?>
									<p id="error-login"> <?= $_SESSION["greska"] ?> </p>
									<?php unset($_SESSION["greska"]); ?>
								<?php endif; ?>
                               <p id="signup-link">Sign up?</p> 
                            </form>
                            <form  action="index.php?page=register" method="post" id="formReg" class="animated fadeIn" onsubmit="return checkRegister()">
                            <h2>Sign up</h2>
                            <input type="text" class="col-lg-12" name="fullName"id="fullName" placeholder="full name"/><br>
                            <p id="errorReg-name" class="err"></p>
                            <input type="text" class="col-lg-12" name="emailReg" id="emailReg" placeholder="example@example.com"/><br>
                            <p id="errorReg-mail" class="err"></p>
                            <input type="password" class="col-lg-12" name="passwordReg" id="passwordReg" placeholder="at leas 8 letters and 1 number"/><br>
                            <p id="errorReg-pass" class="err"></p>
                            <input type="submit" id="btnSignIn" value="Sign up" class="btnLogin" name="btnSignIn"/>
                            <p id="feedback"></p>

                            <p id="login-link">Login</p>
                        </form>
                            
                        <!-- </div> -->
                    </div>

                    </div>
                
                        
                         <?php if(isset($_SESSION['user'])): ?>
                            <a href="index.php?page=bag"><i class="fa fa-shopping-bag" aria-hidden="true"></i></a> 
									<span>Hi, <?php echo $_SESSION['user']->fullName?></span>
								<?php endif; ?>
                </div>
                
            </div>
        </div>
    </div>