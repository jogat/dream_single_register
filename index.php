<?php 
include ('class/Register.php');

$calendar = Register::calendar();
$genders = Register::gender();

$response = [];

if (!empty($_POST)) {
    $register = new Register();
    $response = $register->add($_POST);
}
 //echo "<pre>" . var_export($_POST, true) . "</pre>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Single-Dream</title>

    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/grid_system.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="header">
        <div class="row">
            <div class="col-12">
                <img src="https://www.dream-singles.com/images/ds-logo-reward.png" />
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12 ">
            <div class="register">
                <?php if(!empty($response) && isset($response['success']) && $response['success']):?>
                    <div class="col-12 success">
                        <p><?= $response['data'];?></p>                        
                    </div>
                <?php else:?>
                    <form method="POST" autocomplete="off">
                    <div class="title">
                        <h2>Create a free profile</h2>
                    </div>                    

                    <hr />

                    <div class="row">
                        <div class="col-12 py-0">
                            <label for="gender">I'm a</label>
                            
                            <select name="gender">
                                <?php foreach($genders as $gender=> $label):?>
                                    
                                    <?php $selected = $_POST['gender'] === $gender ? 'selected' : ''; ?>
                                    <option value="<?= $gender;?>" <?= $selected; ?>><?= $label;?></option>        
                                <?php endforeach;?>
                            </select>
                        </div>

                        <div class="col-12 py-0">
                            <label for="email">Email</label>
                            <input type="text" name="email" placeholder="Enter Email" required value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>" />
                        </div>

                        <div class="col-12 py-0">
                            <label for="password">Password</label>
                            <input type="password" name="password" placeholder="Enter Password" 
                            pattern="(?=.*\d)(?=.*[a-z]).{8,}" 
                            title="Must contain both numbers and characters, and at least 8 or more characters" required />

                            <input type="password" name="password_confirmation" placeholder="Reenter Password" required />
                        </div>

                        <div class="col-12 py-0">
                            <label for="bday">Birthday</label>
                            <div id="bday">
                                <select name="bd[month]" class="calendar">
                                    <?php foreach($calendar['months'] as $number=> $month):?>
                                        <?php $selected = $_POST['bd']['month'] === (string)$number ? 'selected' : ''; ?>
                                        <option value="<?= $number;?>"  <?= $selected;?>><?= $month ;?></option>        
                                    <?php endforeach;?>
                                </select>

                                <select name="bd[day]" class="calendar">
                                    <?php foreach($calendar['days'] as $day):?>
                                        <?php $selected = $_POST['bd']['day'] === (string)$day ? 'selected' : ''; ?>
                                        <option  value="<?= $day;?>" <?= $selected;?>><?= $day;?></option>        
                                    <?php endforeach;?>
                                </select>

                                <select name="bd[year]" class="calendar">
                                    <?php foreach($calendar['years'] as $year):?>
                                        <?php $selected = $_POST['bd']['year'] === (string)$year ? 'selected' : ''; ?>
                                        <option value="<?= $year;?>"  <?= $selected;?>><?= $year;?></option>        
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                                                
                        <div class="col-12">
                            <input type="submit" value="Register">
                        </div>

                        <?php if (!empty($response) && !$response['success']): ?>
                            <div class="col-12 errors">
                                <p>Found rrors:</p>
                                <ul>
                                <?php foreach($response['data'] as $error):?>
                                    <li>- <?= $error;?></li>
                                <?php endforeach;?>
                                </ul>
                            </div>
                        <?php endif;?>

                    </div>                    

                </form>
                <?php endif;?>
            </div>
        </div>
    </div>
</body>
</html>