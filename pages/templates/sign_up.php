<?php
include_once('utils/utils.php');

$_SESSION['token'] = generate_random_token();
?>

<script src="/js/sign_up.js"></script>
<link rel="stylesheet" href="../css/sign_up.min.css">

<form id="form" method="post" action="actions/sign_up.php" onsubmit="return validateForm();">
    <input id="username" type="text" name="username" placeholder="Username" required/>
    <input id="password" type="password" name="password" placeholder="Password" required/>
    <input id="password-repeat" type="password" name="password-repeat" placeholder="Repeat your Password" required/>
    <input id="email" type="email" name="email" placeholder="Email" required/>
    <input id="name" type="text" name="name" placeholder="Name" required/>

    <!-- Upload picture -->
    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
    <button type="submit">Submit</button>
    <span id="output"></span>
</form>
