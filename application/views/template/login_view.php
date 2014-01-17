<div id='login_form'>
        <form action='<?php echo site_url('login/process'); ?>' method='post' name='process'>
            <h2>User Login</h2>
            <br /> 
						<?php if(! is_null($msg)) echo $msg;?>						
            <label for='username'>Username</label>
            <input type='text' name='username' id='username' size='25' /><br />
        
            <label for='password'>Password</label>
            <input type='password' name='password' id='password' size='25' /><br />                            
        
            <input type='Submit' value='Login' />            
        </form>
    </div>