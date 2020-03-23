<?php session_start(); ?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Dream Singles PHP Quiz</title>
    <style type="text/css">

    body {
      background: #053c96;
    }

    img {
      float: left;
    }

    input[type=text], input[type=password] {
      width: 100%;
      padding: 15px;
      margin: 5px 0 22px 0;
      display: inline-block;
      border: 1px solid black;
      background: #f1f1f1;
    }  

    input[type=text]:focus, input[type=password]:focus {
      background-color: #ddd;
      outline: none;
    }

    input[type=submit] {
      margin-top: 20px;
      padding:5px 15px; 
      background:#ccc; 
      border: 1px solid black;
      cursor:pointer;
      float: right;
    }

    .register {
      position: absolute;
      background: #fff;
      padding: 20px;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      border: 1px solid black;
    }

    select {
      width: 30%;
      padding:5px 15px;
      margin-top: 10px;
      background: #f1f1f1;
    }

    hr {
      border: 0;
      height: 1px;
      background: #333;
      background-image: linear-gradient(to right, #ccc, #333, #ccc);
    }

    .success {
        color: green;
    }

    .error {
        color: red;
    }
    </style>
  </head>
  <body>
    <img src="https://www.dream-singles.com/images/ds-logo-reward.png" />
    <div class="register">
    <form action="register.php" method="POST">
      <div class="title">
        <h2>Register</h2>
      </div>
      <div class="<?php echo $_SESSION["message"]["response"]; ?>">
        <?php echo $_SESSION["message"]["value"]; ?>
      </div>
      

      <hr />

      <div class="emailpswd">
        <label for="email">Email</label>
        <input type="text" name="email" id="email" placeholder="Enter Email" required />
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Enter Password" 
          pattern="(?=.*\d)(?=.*[a-z]).{8,}" 
          title="Must contain both numbers and characters, and at least 8 or more characters" required />
        <label for="password2">Reenter Password</label>
        <input type="password" name="password2" id="password2" placeholder="Reenter Password" required />
      </div>

      <label for="bday">Birthday</label>
      <div class="bday" id="bday" required>
        <select name="bdmonth">
          <option value="">Month</option>
          <option value="11">November</option>
        </select>
        <select name="bdday" required>
          <option value="">Day</option>
          <option value="3">03</option>
        </select>
        <select name="bdyear" required>
          <option value="">Year</option>
          <option value="1986">1986</option>
          <option value="2005">2005</option>
        </select>
      </div>
        
      <div class="submit">
        <input type="submit" value="Register">
      </div>
    </form>
    </div>
  </body>
</html>
<?php session_destroy(); ?>