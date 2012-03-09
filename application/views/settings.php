<?php
/**
 * File: User.php
 * 
 * The view that will be used to display user properties and
 * submit modifications.
 * 
 * @author Joseph T. Anderson
 * @since 2011-12-23
 * @version 2011-12-23
 */

?>
 <div class="main-panel">
    <input type="hidden" id="PK_UserNum" value="<?php echo $this->session->userdata('LocalID');?>"/>
    <div id="message_container">
        <div id="DEFAULT_warning" style="display:none;" class="message">
            <a href="#" onclick="removeWarning(this);" class="remove_warning"><img style="height: 15px; width: 15px;" src="/cdn/img/moblin-close.png"/></a>
            <table>
                <tr>
                    <td><img src="/cdn/img/Red_triangle_alert_icon.png" class="error_img"/></td>
                    <td><span class="warning_text"></span></td>
                </tr>
            </table>
        </div>
        <?php foreach ( $Errors as $error ){ ?>
            <script type="text/javascript">displayWarning("<?php echo $error; ?>");</script>
         <?php } ?>
    </div>
    <div id="container">
        <h2>System Settings</h2>
        <fieldset>  
            <legend><span id="legend_user" class="legend current">My Details</span><span id="legend_system" class="legend">System</span><!-- <span id="legend_security" class="legend">Security</span> --></legend>
            <table id="prefs_user" class="pref_table">
                <tr>
                    <td class="pref_title"><span>First Name</span></td>
                    <td class="pref_value hybrid"><span id="User-First"><?php echo isset($UserData['First']) ? $UserData['First'] : "";?></span></td>
                    <td class="pref_title"><span>Last Name</span></td>
                    <td class="pref_value hybrid"><span id="User-Last"><?php echo isset($UserData['Last']) ? $UserData['Last'] : ""; ?></span></td>
                </tr>
                <tr>
                    <td class="pref_title"><span>Username</span></td>
                    <td class="pref_value"><span id="User-U_Username"><?php echo isset($UserData['U_Username']) ? $UserData['U_Username'] : "";?></span></td>
                    <td class="pref_title"><span>Email</span></td>
                    <td class="pref_value hybrid"><span id="User-Email"><?php echo isset($UserData['Email']) ? $UserData['Email'] : "";?></span></td>
                </tr>
            </table>
            <table id="prefs_system" class="pref_table" style="display: none;">
                <tr>
                    <td class="pref_title"><span>Default Ticket Priority</span></td>
                    <td class="pref_value hybrid"><span id="System-DefaultTicketPriority"><?php echo isset($Settings['DefaultTicketPriority']) ? $Settings['DefaultTicketPriority'] : "";?></span></td>
                    <td class="pref_title"><span>Default Ticket Department</span></td>
                    <td class="pref_value hybrid"><span id="System-DefaultTicketDepartment"><?php echo isset($Settings['DefaultTicketDepartment']) ? $Settings['DefaultTicketDepartment'] : "";?></span></td>
                </tr>
				<tr>
					<td colspan="4" style="padding-top: 20px; padding-bottom: 10px;"></td>
				</tr>
                <tr>
                    <td class="pref_title"><span>API Key</span></td>
                    <td class="pref_value hybrid"><span id="API-APIKey"><?php echo $KayakoAPIKey['Value'];?></span></td>
                    <td class="pref_title"><span>Kayako Fusion URL</span></td>
                    <td class="pref_value hybrid"><span id="API-SwiftURL"><?php echo $SwiftURL['Value']; ?></span></td>
                </tr>
                <tr>
                    <td class="pref_title"><span>API Secret Key</span></td>
                    <td class="pref_value hybrid"><span id="API-APISecretKey" class="wrap"><?php echo $KayakoSecretKey['Value']; ?></span></td>
                </tr>
            </table>
        </fieldset>
    </div>
    <script type="text/javascript">
        $('#settings_submit').button();
        SettingsObj.setPrefTableInputs();
        SettingsObj.setTabEvents();
    </script>
  </div>
