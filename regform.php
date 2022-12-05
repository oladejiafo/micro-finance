<form>
<div align="center">
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#0099FF" width="800" height="35">
   <tr> <td colspan="1">
    <img border="0" src="images/p_top.jpg" width="99%" height="117"></td></tr>
</table>
<?php
require_once 'conn.php';
echo "<h2 align='center'>Registration Form</h2>";
?>
 <table border="0" width="700" cellspacing="1" id="table1">
  <tr align="center">
   <td>
<Fieldset>
<legend><b><i> Create Log-in Profile (Compusory)</i></b></legend><br>
<table align="center" width="700">
<tr>
 <td width="15%">
  User Name:(One word)
 </td>
 <td width="15%">
  <input type="text" size="30" name="name" maxlength="12" value="<?php echo @$row['username']; ?>">
 </td>
 <td width="15%">
  E-mail Address:
 </td>
 <td width="15%">
  <input type="text" class="txtinput" size="30" name="e-mail" maxlength="255" value="<?php echo htmlspecialchars(@$email); ?>">
 </td>
</tr>
<tr>
 <td width="15%">
  Password:
 </td>
 <td width="15%">
  <input type="password" id="passwd" size="30" name="passwd" maxlength="50" value="<?php echo @$row['password']; ?>">
 </td>
 <td width="15%">
 </td>
 <td width="15%">
 </td>
</tr>
</table>
</fieldset>
<br>
<Fieldset><legend><b><i>Create Other Details</i></b></legend>
<table align="left">
<tr>
 <td width="20%">
  Surname:
 </td>
 <td width="20%">
  <input type="text" name="sname" value="<?php echo @$row['Surname']; ?>" >
 </td>
 
 <td width="20%">
  First Name:
 </td>
 <td width="20%">
  <input type="text" name="fname" value="<?php echo @$row['Firstname']; ?>" >
 </td>
</tr>
<tr>
 <td width="20%">
  Sponsor ID#:
 </td>
 <td width="20%">
  <input type="text" name="sponsor" value="<?php echo @$row['Sponsor']; ?>" >
 </td>
 
 <td width="20%">
  Registration Number (If known): 
 </td>
 <td width="20%">
  <input type="text" name="regno" value="<?php echo @$row['Reg Number']; ?>" >
 </td>
</tr>
<tr>
 <td width="20%">
  Bank:
 </td>
 <td width="20%">
  <input type="text" name="bank" value="<?php echo @$row['Bank']; ?>">
 </td>
 <td width="20%">
  Account Number:
 </td>
 <td width="20%">
  <input type="text" name="account" value="<?php echo @$row['Account']; ?>" >
 </td>
</tr>
<tr>
 <td width="20%">
  Address: 
 </td>
 <td width="20%">
  <textarea name="address" rows="3" cols="20" ><?php echo @$row['Address']; ?></textarea>
 </td> 
 <td width="20%">
  City:
 </td>
 <td width="20%">
  <input type="text" name="city" value="<?php echo @$row['City']; ?>" >
 </td>
</tr>
<tr>
 <td width="20%">
  State (Nigeria Only): 
 </td>
 <td width="20%">
  <input type="text" name="state" value="<?php echo @$row['State']; ?>">
 </td>
 <td width="20%">
  Country:
 </td>
 <td width="20%">
  <input type="text" name="country" value="<?php echo @$row['Country']; ?>">
 </td>
</tr>
<tr>
 <td width="20%">
  Postal Code: 
 </td>
 <td width="20%">
  <input type="text" name="pcode" value="<?php echo @$row['Postal Code']; ?>" >
 </td>
 <td width="20%">
  Phone:
 </td>
 <td width="20%">
  <input type="text" name="phone" value="<?php echo @$row['Phone']; ?>" >
 </td>
</tr>
<tr>
 <td width="20%">
  Fax: 
 </td>
 <td width="20%">
  <input type="text" name="fax" value="<?php echo @$row['Fax']; ?>" >
 </td>
 <td width="20%">
  Date of Birth: 
 </td>
 <td width="20%">
  <select size="1" name="dob_day" value="<?php echo @$row['DoB_Day']; ?>">
   <?php  
     echo '<option selected></option>';
     for($day=1; $day<=31; $day++)
     {
     echo '<option>' . $day . '</option>';
     }
   ?> 
  </select>
  <select size="1" name="dob_month" value="<?php echo @$row['DoB_Month']; ?>">
   <?php  
     echo '<option selected></option>';
     #if $day=1 to 31
     echo '<option>Jan</option>';
     echo '<option>Feb</option>';
     echo '<option>Mar</option>';
     echo '<option>Apr</option>';
     echo '<option>May</option>';
     echo '<option>Jun</option>';
     echo '<option>Jul</option>';
     echo '<option>Aug</option>';
     echo '<option>Sep</option>';
     echo '<option>Oct</option>';
     echo '<option>Nov</option>';
     echo '<option>Dec</option>';
   ?> 
  </select>
  <select size="1" name="dob_year" value="<?php echo @$row['DoB_Year']; ?>">
   <?php  
     echo '<option selected></option>';
     for($year=2018; $year>=1901; $year--)
     {
     echo '<option>' . $year . '</option>';
     }
   ?> 
  </select>
 </td>
</tr>
</table>
</fieldset>
  </table>
  </div>
</form>
