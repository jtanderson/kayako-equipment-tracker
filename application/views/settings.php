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
            <legend><span id="legend_user" class="legend current">My Details</span><span id="legend_system" class="legend">System</span><span id="legend_security" class="legend">Security</span></legend>
            <table id="prefs_user" class="pref_table">
                <tr>
                    <td class="pref_title"><span>First Name</span></td>
                    <td class="pref_value hybrid"><span id="First"><?php echo $UserData['First'];?></span></td>
                    <td class="pref_title"><span>Last Name</span></td>
                    <td class="pref_value hybrid"><span id="Last"><?php echo $UserData['Last'];?></span></td>
                </tr>
                <tr>
                    <td class="pref_title"><span>Username</span></td>
                    <td class="pref_value hybrid"><span id="U_Username"><?php echo $UserData['U_Username'];?></span></td>
                    <td class="pref_title"><span>Email</span></td>
                    <td class="pref_value hybrid"><span id="Email"><?php echo $UserData['Email'];?></span></td>
                </tr>
            </table>
            <table id="prefs_system" class="pref_table" style="display: none;">
                <tr>
                    <td class="pref_title"><span>Default Ticket Priority</span></td>
                    <td class="pref_value hybrid"><span id="DefaultTicketPriority"><?php echo $Settings['DefaultTicketPriority'];?></span></td>
                    <td class="pref_title"><span>Default Ticket Department</span></td>
                    <td class="pref_value hybrid"><span id="DefaultTicketDepartment"><?php echo $Settings['DefaultTicketDepartment'];?></span></td>
                </tr>
                <tr>
                    <td class="pref_title"><span>Color Theme</span></td>
                    <td class="pref_value hybrid"><span id="Theme"><?php echo '';?></span></td>
                    <td class="pref_title"><span>Some Other Option</span></td>
                    <td class="pref_value hybrid"><span id="Other"><?php echo '';?></span></td>
                </tr>
            </table>
            <table id="prefs_security" class="pref_table" style="display: none;">
                <tr>
                    <td class="pref_title"><span>Permissions?</span></td>
                    <td class="pref_value hybrid"><span id="Permission"><?php echo '';?></span></td>
                    <td class="pref_title"><span>Password</span></td>
                    <td class="pref_value hybrid"><span id="Password"><?php echo '';?></span></td>
                </tr>
                <tr>
                    <td class="pref_title"><span>API Key</span></td>
                    <td class="pref_value hybrid"><span id="APIKey"><?php echo '';?></span></td>
                    <td class="pref_title"><span>API Secret Key</span></td>
                    <td class="pref_value hybrid"><span id="APISecretKey"><?php echo '';?></span></td>
                </tr>
            </table>
        </fieldset>
        <div style="text-align: right;"><input type="button" id="settings_submit" value="Submit" onclick="SettingsObj.saveSettings();"/></div>
    </div>
    <script type="text/javascript">
        $('#settings_submit').button();
        SettingsObj.setPrefTableInputs();
        SettingsObj.setTabEvents();
    </script>
  </div>
