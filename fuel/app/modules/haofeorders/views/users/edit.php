<form method="post">
    <div>
        <label>Username</label>
        <input type="text" name="username" readonly="readonly" value="<?php if(isset($username)) echo $username; ?>" required="required" />
    </div>
    <div>
        <label>Password</label>
        <input type="password" name="password" required="required" />
    </div>
    <div>
        <label>Email</label>
        <input type="email" name="email" readonly="readonly" value="<?php if(isset($email)) echo $email; ?>" required="required" />
    </div>
    <div> 
        <input type="submit" class="btn btn-primary" value="Submit"  />
    </div>
</form>