<script src="/js/sign_up.js"></script>

<form id="#form" method="post" action="/database/create_user.php" onsubmit="return validateForm();">
    <input id="username" type="text" name="username" placeholder="Username" required/>
    <input id="password" type="password" name="password" placeholder="Password" required/>
    <input id="password-repeat" type="password" name="password-repeat" placeholder="Repeat your Password" required/>
    <input id="email" type="email" name="email" placeholder="Email" required/>
    <input id="name" type="text" name="name" placeholder="Name" required/>
    <input id="date" type="date" name="birthdate" placeholder="Date of Birth"/>

    <select id="gender" name="gender">
        <option value="M">Male</option>
        <option value="F">Female</option>
    </select>

    <!-- Upload picture -->
    <button type="submit">Submit</button>
    <span id="output"></span>
</form>
