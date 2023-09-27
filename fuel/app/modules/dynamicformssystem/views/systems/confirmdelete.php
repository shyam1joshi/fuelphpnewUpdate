
<h3>Delete Confirmation</h3>
<form>

    <div>
        <label>Please Enter Username</label>
        <input type="text" name="username" class="form-control" />
    </div> 
    <div>
        <label>Please Enter Password</label>
        <input type="password" name="password" class="form-control" />
    </div> 
    <div>
        <label>Confirm</label>
        <input type="checkbox" name="confirm"   value="1" />
    </div> 

    <div> 
        <input type="submit" name="submit" id="confirmDataSubmit" class="btn btn-danger" value="Confirm" />
    </div>

</form>

<input type="hidden" value="/<?php  echo $modulename ?>/<?php  echo \Inflector::pluralize($modulename); ?>" id="urlpath" />