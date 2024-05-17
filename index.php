<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>U-Vote Login</title>
  <link rel="icon" type="image/x-icon" href="U-Vote Logo.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
  <style>

    body {
        font-family: 'Inter', sans-serif;
        background-color: #ffffff;
        background-image: url('backgroundVoter.svg');
        background-size: 76.5vh;
        background-repeat: no-repeat;
        margin: 0;
        padding: 0;
    }

    img{
        -webkit-user-drag: none;
    }

    /* CSS animation for fading in */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    header {
        display: grid;
        grid-template-columns: 1fr 2fr;
        background-color: #2F80ED;
        background-image: url('backgroundVoter.svg');
        background-size: 76.5vh;
        background-repeat: no-repeat;
        height: auto;
        width: 100vw;
        text-align: center;
        padding: 0.8% 3%;
        position: fixed;
        box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);
        background-blend-mode: multiply;
        z-index: 10;
    }

    .logoName {
        display: flex;
        align-items: center;
        width: 45vw;
        gap: 10px;
    }

    .bodycontainer{
        display: flex;
        justify-content: center; /* Center horizontally */
        align-items: center;
        width: 100vw;
        background-color: transparent;
        overflow: hidden;
        position: fixed;
        z-index: 1;
        animation: fadeIn 0.3s forwards;
    }

    .imagecontainer {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 60%;
        height: 100%;
        position: relative;
        opacity: 1;
        transition: opacity 0.5s ease-in-out;
    }

    .imagecontainer.hidden {
        opacity: 0;
        transition: opacity 0.5s ease-in-out; /* Add transition property */
    }


    #imagebg {
        max-width: 90%;
        max-height: 90%;
        position: absolute; /* Position the image absolutely within the container */
        top: 50%; /* Move the image 50% from the top */
        left: 50%; /* Move the image 50% from the left */
        transform: translate(-50%, -50%); /* Center the image */
    }

    .logincontainer {
        display: flex;
        width: 40%;
        height: 100%;
        align-items: center;
        justify-content: center;
        transition: transform 0.5s ease-in-out; /* Add transition property */
        transform: translateX(0); /* Initial position */
    }

    .logincontainer.shifted {
        transform: translateX(calc(-50vw + 50%)); /* Shifted position */
    }


    .login{
        display: flex;
        justify-content: center; /* Center horizontally */
        align-items: center; /* Center vertically */
        flex-direction: column;
        width: 50%;
        min-width: 300px;
        max-width: 325px;
        height: auto;
        background-color: white;
        border-radius: 12px;
        box-shadow: 5px 8px 15px rgba(0, 0, 0, 0.25);
        padding: 40px;
    }

    @media (max-width: 500px) {
        .login{
            size-adjust: 0.8;
            scale: 0.8;
        }

    }

    h1{
        font-size: 50px;
        font-weight: 500;
        padding: 0;
        margin-top: 0;
    }

    form{
        width: 100%;
    }

    .forgap{
        width: 100%;
        margin-bottom: 33px;
    }

    #username, #password{
        height: 55px;
        width: 100%;
        font-size: 20px;
        background-color: #D9D9D9;
        color: black;
        font-weight: 100;
        border: none;
        border-radius: 12px;
        text-indent: 3%;
        padding: 0%;
    }

    input:focus{
        outline: none;
    }

    .showpasscon{
        display: flex;
        align-items: center;
    }

    .showpass{
        height: 18px;
        width: 18px;
        background-color: #D9D9D9;
        border: none;
        border-radius: 4px;
        text-indent: 3%;
    }

    #usertype {
      height: 55px;
      width: 100%;
      font-size: 20px;
      background-color: #D9D9D9;
      border-radius: 12px;
      color: gray;
      border: none;
      text-indent: 3%;
      cursor: pointer;
      background-image: url('arrow-down.png'); 
      background-repeat: no-repeat;
      background-position: right 10px center; /* Adjusted position of the dropdown symbol */
      /* Hide the default dropdown arrow */
      -webkit-appearance: none; /* Safari and Chrome */
      -moz-appearance: none; /* Firefox */
      appearance: none; /* All other browsers */
    }

    select:focus{
        outline: none;
    }

    .loginbutton {
        height: 52px;
        width: 100%;
        padding: 3%;
        font-size: larger;
        font-weight: lighter;
        background-color: #4361EE;
        color: #ffffff;
        border: none;
        border-radius: 16px;
        cursor: pointer;
        box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);
    }

    /*pop up*/
    .popup {
        color: white;
        display: none;
        flex-direction: column;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #222E50;
        box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);
        height: auto;
        width: 60vh;
        border-radius: 5px;
        z-index: 9999;
    }

    #logoutpop, #deletepop{
        height: auto;
    }



    .head {
        background: linear-gradient(to bottom, #28579E, #222E50);
        width: 100%;
        height: 6vh;
        border-radius: 5px 5px 0 0;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #fff;
        box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);
    }

    .popup-content {
        flex: 1;
        overflow: auto;
        padding: 5%;
        box-sizing: border-box;
    }

    #logoutpop .popup-content, #deletepop .popup-content{
        overflow: hidden;
    }

    .popup-content-inner {
        display: grid;
        height: auto;
        gap: 10px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 10px;
        height: auto;
    }

    .form-group label {
        text-align: left;
        width: 100%;
        margin-bottom: 10px;
        font-size: 15px;
    }

    .input-form{
        width: 100%;
        height: 40px;
        padding: 1% 1%;
        border: none;
        border-radius: 10px;
        font-size: 15px;
        color: white;
        background-color: rgba(150, 191, 245, 0.5); 
        outline: none;
        box-sizing: border-box; 
    }

    .input-form::placeholder {
        color: inherit; 
    }

    .popup-content .cancel-button, .popup-content .save-button {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 40PX;
        width: 100%;
        font-size: large;
        font-weight: lighter;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .popup-content .cancel-button {
        background-color: #ffffff;
        color: #090074;
    }

    .popup-content .save-button {
        background-color: #4361EE;
        color: white;
    }

    .cancel-button:hover {
        color: white;
        background-color: #F34235;
    }

    .save-button:hover {
        background-color: #7790ff;
    }

    @media (max-width: 1000px) {
      .popup{
          height: auto;
      }

    }

    @media (max-width: 500px) {
      .popup{
            width: 100vw;
        }

    }

    @media (max-width: 1000px) {

        .logoName, .logoName img{
            scale: 0.9;
        }

        header{
            padding-left: 3%;
        }

        .imagecontainer , .login{
            scale: 0.9;
        }

    }

    @media (max-height: 800px) {

        .logoName, .logoName img{
            scale: 0.9;
        }

        header{
            padding-left: 3%;
        }

        .imagecontainer ,.login{
            scale: 0.9;
        }

    }

    @media (max-width: 700px) {

        header{
            grid-template-columns: 1fr;
        }

        .logoName, .searchspace{
            width: 100%;
            padding: 1.5% 5%;
        }

        .login{
            scale: 0.8;
        }

    }

    @media (max-height: 500px) {

        .imagecontainer ,.login{
            scale: 0.8;
        }

    }

   </style>

</head>
<body>
    <header>
        <div class="logoName">
            <img id="Logo" src="U-Vote Logo.svg" alt="Logo">
            <img id="Name" src="U-Vote Name.svg" alt="Name">
        </div>
    </header>

    <div class="bodycontainer" >
        <div class="imagecontainer">
            <img id="imagebg" src="ImageBG.svg" alt="Logo">
        </div>
        <div class="logincontainer">
            <div class="login">
                <div class="forgap">
                        
                </div>
                <div>
                    <h1>Login</h1>
                </div>
                <form method = "get" action = "validateUser.php">
                    <div class="forgap">
                        <input type="email" id="username" name="username" placeholder="Username" required>
                    </div>
                    <div>
                        <input type="password" id="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="showpasscon">
                        <input class="showpass" type="checkbox" id="showPassword"> <p>Show Password</p> 
                    </div>
                    <div class="forgap">
                        
                    </div>
                    <button type="submit" onclick="switchHTML('Voting1.html')" class="loginbutton">Login</button>
                    <div class="forgap">
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="popup" id="passpop">
        <div class="head">
          <h3>ENTER ADMIN PASSKEY</h3>
        </div>
        <div class="popup-content">
            <div class="popup-content-inner">
                <form>
                <div class="form-group">
                    <label for="pName">Passkey:</label>
                    <input type="text" id="passkey" class="input-form">
                </div>
                </form>
                <br>
                <button class="cancel-button">Cancel</button>
                <button class="save-button">Login</button>
            </div>
        </div>    
    </div>
    <script>

    document.addEventListener('keydown', function(event) {
        // Check if Ctrl (or Cmd on Mac) and Y keys are pressed
        if ((event.ctrlKey || event.metaKey) && event.key === 'y') {
            // Prevent default browser behavior
            event.preventDefault();

            // Display the popup
            document.getElementById("passpop").style.display = "flex";
        }
    });

    // Hide the popup when the cancel button is clicked
    document.querySelector("#passpop .cancel-button").addEventListener("click", function() {
        document.getElementById("passpop").style.display = "none";
    });

    // Check the entered passkey and open the new page if correct
    document.querySelector("#passpop .save-button").addEventListener("click", function() {
        // Retrieve the entered passkey
        var passkey = document.getElementById("passkey").value;

        // Check if the passkey is correct (you need to replace 'YOUR_PASSKEY' with the actual passkey)
        if (passkey === 'adminni') {
            // Open the new page in the same window
            window.open('indexWatcher.php', '_self');
        } else {
            // Notify the user about incorrect passkey
            alert('Incorrect passkey. Please try again.');
        }

        // Hide the popup
        document.getElementById("passpop").style.display = "none";
    });


        var headerHeight;

        function setHeight() {
            var headerHeight = document.querySelector('header').offsetHeight;
            document.querySelector('.imagecontainer').style.height = `calc(100vh - ${headerHeight}px)`;
            document.querySelector('.logincontainer').style.height = `calc(100vh - ${headerHeight}px)`;
        }

        window.addEventListener('load', setHeight);
        window.addEventListener('resize', setHeight);

        function setPaddingTop() {
            headerHeight = document.querySelector('header').offsetHeight;
            document.querySelector('.bodycontainer').style.paddingTop = headerHeight + 'px';
        }

        window.addEventListener('load', setPaddingTop);
        window.addEventListener('resize', setPaddingTop);

        // JavaScript code to switch HTML files with animation
        function switchHTML(file) {
                // Add fade-out animation to the body
                document.body.classList.add('fade-out');
                
                // Wait for the animation to finish, then switch to the new HTML file
                setTimeout(function() {
                    window.location.href = file;
                }, 500); // Delay should match the animation duration
            }

            // Add a listener for animation end to remove the fade-out class and add the fade-in class
            document.body.addEventListener('animationend', function() {
                document.body.classList.remove('fade-out');
                document.body.classList.add('fade-in');
            });

        const passwordInput = document.getElementById('password');
        const showPasswordCheckbox = document.getElementById('showPassword');

        showPasswordCheckbox.addEventListener('change', function() {
            if (showPasswordCheckbox.checked) {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        });

        function setContainerVisibility() {
            const imageContainer = document.querySelector('.imagecontainer');
            const loginContainer = document.querySelector('.logincontainer');
            const viewportWidth = window.innerWidth;

            if (viewportWidth < 1100) {
                imageContainer.classList.add('hidden');
                loginContainer.classList.add('shifted'); // Shift login container to the left
            } else {
                imageContainer.style.display = 'flex'; // Show image container if viewport width is 1090px or more
                loginContainer.classList.remove('shifted'); // Reset login container position
                imageContainer.classList.remove('hidden');
            }
        }

        window.addEventListener('load', setContainerVisibility);
        window.addEventListener('resize', setContainerVisibility);

    </script>
      

</body>
</html>