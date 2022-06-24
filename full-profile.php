<?php
session_start();
//include("includes/config.php");
define('DB_SERVER', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'accommodation');
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>
<script language="javascript" type="text/javascript">
    function f2()
    {
        window.close();
    }
    function f3()
    {
        window.print();
    }
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Student  Information</title>
        <link href="style.css" rel="stylesheet" type="text/css" />
        <link href="hostel.css" rel="stylesheet" type="text/css">
    </head>

    <body>
        <table width="100%" border="0">

            <?php
            $id = $_GET['id'];
            $ret = "SELECT * FROM registration where student_id =?";
            $stmt = $con->prepare($ret);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $res = $stmt->get_result();
            while ($ros = $res->fetch_object()) {
                ?>
                <tr>
                    <td colspan="2" align="center" class="font1">&nbsp;</td>
                </tr>

                <tr>
                    <td colspan="2" align="center" class="font1">&nbsp;</td>
                </tr>

                <tr>
                    <td colspan="2"  class="font">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ucfirst($ros->firstname); ?> <?php echo ucfirst($ros->lastname); ?> <span class="font1"> information &raquo;</span> </td>
                </tr>

                <tr>
                    <td colspan="2"  class="font"> &nbsp;&nbsp;&nbsp;&nbsp;<img src="./user_images/<?php echo $ros->img; ?>" height="100" width="100">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <div align="right">Reg Date : <span class="comb-value"><?php echo $ros->reg_date; ?></span></div></td>
                </tr>


                <tr>
                    <td colspan="2"  class="heading" style="color: red;">Room Related Info &raquo; </td>
                </tr>
                <tr>
                    <td colspan="2"  class="font1"><table width="100%" border="0">
                            <tr>
                                <td width="32%" valign="top" class="heading">Villa name : </td>
                                <?php
                                $landl_id = $ros->villa_id;
                                $ret = "select h.villa_name,h.villa_address,h.image,a.username,a.contactNo from houses h "
                                        . "JOIN admin a ON a.id=h.aid where h.houseid=?";
                                $stmt = $con->prepare($ret);
                                $stmt->bind_param('i', $landl_id);
                                $stmt->execute();
                                $res = $stmt->get_result();
                                $row = $res->fetch_object();

                                $landl_name = $row->username;
                                $landl_no = $row->contactNo;
                                $villa_name = $row->villa_name;
                                $villa_address = $row->villa_address;
                                $villa_image = $row->image;
                                ?>
                                <td class="comb-value1"><span class="comb-value"><?php echo $villa_name; ?></span></td>
                            </tr>

                            <tr>
                                <td width="35%" valign="top" class="heading">Landlord name: </td>

                                <td class="comb-value1"><span class="comb-value"><?php echo $landl_name; ?></span></td>
                            </tr>

                            <tr>
                                <td width="32%" valign="top" class="heading">Landlord number: </td>

                                <td class="comb-value1"><span class="comb-value"><?php echo $landl_no; ?></span></td>
                            </tr>

                            <tr>
                                <td width="32%" valign="top" class="heading">Room no: </td>

                                <td class="comb-value1"><span class="comb-value"><?php echo $ros->roomno; ?></span></td>
                            </tr>

                            <tr>
                                <td width="32%" valign="top" class="heading">Room info: </td>

                                <td class="comb-value1"><span class="comb-value"><?php echo $ros->room_details; ?></span></td>
                            </tr>



                            <tr>
                                <td width="32%" valign="top" class="heading">Staying From: </td>
                                <td class="comb-value1"><?php echo $ros->stayfrom; ?></td>
                            </tr>
                            <tr>
                                <td width="32%" valign="top" class="heading">Duration: </td>
                                <td class="comb-value1">1 years</td>
                            </tr>
                            <tr>
                                <td width="32%" valign="top" class="heading">Total Fees: </td>
                                <td class="comb-value1">
                                    <?php echo $ros->amount; ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="left"  class="heading" style="color: red;">Personal Info &raquo; </td>
                            </tr>
                            <tr>
                                <td width="12%" valign="top" class="heading">Department: </td>
                                <td class="comb-value1"><?php echo $ros->department; ?></td>
                            </tr>

                            <tr>
                                <td width="12%" valign="top" class="heading">Admission No: </td>
                                <td class="comb-value1"><?php echo $ros->admission_no; ?></td>
                            </tr>

                            <tr>
                                <td width="12%" valign="top" class="heading">First Name: </td>
                                <td class="comb-value1"><?php echo $ros->firstname; ?></td>
                            </tr>

                            <tr>
                                <td width="12%" valign="top" class="heading">Middle name: </td>
                                <td class="comb-value1"><?php echo $ros->middlename; ?></td>
                            </tr>

                            <tr>
                                <td width="12%" valign="top" class="heading">Last name: </td>
                                <td class="comb-value1"><?php echo $ros->lastname; ?></td>
                            </tr>

                            <tr>
                                <td width="12%" valign="top" class="heading">Gender: </td>
                                <td class="comb-value1"><?php echo $ros->gender; ?></td>
                            </tr>

                            <tr>
                                <td width="12%" valign="top" class="heading">Contact No: </td>
                                <td class="comb-value1"><?php echo $ros->contactno; ?></td>
                            </tr>

                            <tr>
                                <td width="12%" valign="top" class="heading">Guardian Name: </td>
                                <td class="comb-value1"><?php echo $ros->gname; ?></td>
                            </tr>

                            <tr>
                                <td colspan="2"  class="heading" style="color: red;"><?php echo $villa_name; ?> Address  &raquo; </td>
                            </tr>
                            <tr>
                                <td width="12%" valign="top" class="heading">Address: </td>
                                <td class="comb-value1"><?php echo $villa_address; ?></td>
                            </tr>

                        <?php } ?>



                    </table></td>
            </tr>


        </table></td>
        </tr>
        </table></td>
        </tr>




        </table></td>
        </tr>


        <tr>
            <td colspan="2" align="right" ><form id="form1" name="form1" method="post" action="">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="14%">&nbsp;</td>
                            <td width="35%" class="comb-value"><label>
                                    <input name="Submit" type="submit" class="txtbox4" value="Prints this Document " onClick="return f3();" />
                                </label></td>
                            <td width="3%">&nbsp;</td>
                            <td width="26%"><label>
                                    <input name="Submit2" type="submit" class="txtbox4" value="Close this document " onClick="return f2();"  />
                                </label></td>
                            <td width="8%">&nbsp;</td>
                            <td width="14%">&nbsp;</td>
                        </tr>
                    </table>
                </form>    </td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        </table>
    </body>
</html>
