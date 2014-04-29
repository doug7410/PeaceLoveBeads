
<pre>
<? //print_r($user_array) ?>
</pre>
<form method="post" action="<? echo $_SERVER[PHP_SELF]; ?>">
<input type="hidden" name="url" value="<? echo $_SESSION['PHP_SELF'] . "?screen=checkout"; ?>" />

<table width="600" border="1">
  <tr>
    <td width="113">Name:</td>
    <td width="471"><input type="text" name="user_name" value="" /></td>
  </tr>
  <tr>
    <td>Email:</td>
    <td><input type="text" name="user_email" value="" /></td>
  </tr>
  <tr>
    <td>Address:</td>
    <td><input type="text" name="address" value="" /></td>
  </tr>
  <tr>
    <td>Phone:</td>
    <td><input type="text" name="phone" value="" /></td>
  </tr>
  <tr>
    <td>City:</td>
    <td><input type="text" name="city" value="" /></td>
  </tr>
  <tr>
    <td>State:</td>
    <td><input type="text" name="state" value="" /></td>
  </tr>
  <tr>
    <td>Zip:</td>
    <td><input type="text" name="zip" value="" /></td>
  </tr>
   <tr>
    <td>Password:</td>
    <td><input type="text" name="user_password" value="" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<input type="submit" value="submit" /> 
</form>