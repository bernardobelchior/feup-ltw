<form action="database/create_user.php" method="post">
    <input type="text" name="username" placeholder="Username"/>
    <input type="password" name="password" placeholder="Password"/>
    <input type="email" name="email" placeholder="Email"/>
    <input type="text" name="name" placeholder="Name"/>
    <input type="date" name="birthdate" placeholder="Date of Birth"/>

    <select name="gender">
        <option value="M">Male</option>
        <option value="F">Female</option>
    </select>

    <!-- Upload picture -->
    <button type="submit">Submit</button>
</form>