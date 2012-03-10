<?php 
/**
 * This is the main page for the Kayako Extension Application
 * 
 * @author Joseph T. Anderson
 * @since 2011-09-29
 * @version 2011-09-29
 * 
 */
 ?>
 <div class="main-panel">
	<div id="message_container">
		<div id="DEFAULT_warning" style="display:none;" class="message">
			<a href="#" onclick="MainObj.removeWarning(this);" class="remove_warning"><img style="height: 15px; width: 15px;" src="<?php echo base_url("/cdn/img/moblin-close.png"); ?>"/></a>
	 		<table>
	 			<tr>
	 				<td><img src="<?php echo base_url("/cdn/img/Red_triangle_alert_icon.png"); ?>" class="error_img"/></td>
	 				<td><span class="warning_text"></span></td>
	 			</tr>
	 		</table>
	 	</div>
	 	<?php foreach ( $Errors as $error ){ ?>
	 		<script type="text/javascript">MainObj.displayWarning("<?php echo mysql_escape_string($error); ?>");</script>
	 	 <?php } ?>
	</div>
	<div id="container">
		<div id="top">
			<h1>Welcome</h1>
			<h2>Enter the ticket information.</h2>
		</div>
        <fieldset>
            <legend><span id="legend_client" class="legend current">Client Details</span><span id="legend_equipment" class="legend">Equipment Details</span>
            </legend>
            <form>
    			<div id="client_data">
    				<table class="client_data_table">
    					<tr>
    						<td colspan="2">
    							<span class="label">Subject<span class="required">*</span></span>
    						</td>
    					</tr>
    					<tr class="pad_row">
    						<td colspan="2">
    							<span class="div_texbox">
    								<input name="Subject" value="<?php //echo set_value('Subject', ''); ?>" type="text" class="textbox" id="Subject" size="93"/>
    							</span>
    						</td>
    					</tr>
    					<tr>
    						<td>
    							<span class="label">First Name<span class="required">*</span></span>
    						</td>
    						<td class="client_right">
    							<span class="label">Last Name<span class="required">*</span></span>
    						</td>
    					</tr>
    					<tr class="pad_row">
    						<td>
    							<span class="div_texbox">
    								<input name="FirstName" value="<?php //echo set_value('FirstName', ''); ?>" type="text" class="textbox" id="FirstName" size="39"/>
    							</span>
    						</td>
    						<td class="client_right">
    							<span class="div_texbox">
    	    						<input name="LastName" value="<?php //echo set_value('LastName', ''); ?>" type="text" class="textbox" id="LastName" size="39"/>
    							</span>
    						</td>
    					</tr>
    					<tr>
    						<td>
    							<span class="label">Email<span class="required">*</span></span>
    						</td>
    						<td class="client_right">
    							<span class="label">Phone<span class="required">*</span></span>
    						</td>
    					</tr>
    					<tr class="pad_row">
    						<td>
    							<span>
    						    	<input name="Email" value="<?php //echo set_value('Email', ''); ?>" type="text" class="textbox" id="Email" size="39"/>
    							</span>
    						</td>
    						<td class="client_right">
    							<span>
    						    	<input name="Phone" type="text" class="textbox" id="Phone" size="39"/>
    							</span>
    						</td>
    					</tr>
    					<tr>
    						<td>
    							<span class="label">Deadline<!-- <span class="required">*</span> --></span>
    						</td>
    						<td class="client_right">
    						</td>
    					</tr>
    					<tr class="pad_row">
    						<td>
    							<span>
    						    	<input name="display_deadline" type="text" class="textbox" id="display_deadline" size="39"/>
    						    	<input type="hidden" id="Deadline" name="Deadline" />
    							</span>
    							<script type="text/javascript">
    								$('#display_deadline').datepicker({
    									dateFormat: 'DD MM d, yy',
    									altField: '#Deadline',
    									altFormat: 'yy-mm-dd'
    								});
    							</script>
    						</td>
    						<td class="client_right">
    						</td>
    					</tr>
    					<tr>
    						<td>
    							<span class="label">Priority<span class="required">*</span></span>
    						</td>
    						<td class="client_right">
    							<span class="label">Department<span class="required">*</span></span>
    						</td>
    					</tr>
    					<tr>
    						<td>
    							<select name="Priority"	id="Priority">
    								<?php foreach ( $Priorities as $priority ){ ?>
    								<option value="<?php echo $priority['PriorityFusionID'];?>"><?php echo $priority['U_PriorityTitle']; ?></option>									
    								<?php } ?>
    							</select>
    							<script type="text/javascript">
    								$("#Priority").MyDropdown();
    							</script>
    						</td>
    						<td style="padding-left: 110px;">
    							<select name="Department" id="Department">
    								<?php foreach ( $Departments as $department ){ ?>
    								<option value="<?php echo $department['DepartmentFusionID'];?>"><?php echo $department['U_DepartmentTitle']; ?></option>									
    								<?php } ?>
    							</select>
    							<script type="text/javascript">
    								$("#Department").MyDropdown();
    							</script>
    						</td>
    					</tr>
    					<tr>
    						<td colspan="2" style="padding-top: 30px;">
    							<span class="label">Issue<span class="required">*</span></span>
    						</td>
    					</tr>
    					<tr>
    						<td colspan="2">
    							<span>
    						    	<textarea name="Issue" class="textbox" id="Issue"></textarea>
    							</span>
    						</td>
    					</tr>
    				</table>
    				<div class="clear"></div>
    				<div style="text-align: center;">
    					<span class="required">*</span>=&nbsp;required&nbsp;field.
    				</div>
    		</div>
    		<div id="equipment_data">
        		<table id="equipment_table">
        			<tr id="Equipment_DEFAULT" class="equipment_row">
        				<td>
        					<div class="equipment_banner">
        						<span class="label expansion expanded unchanged" onclick="HomeObj.toggleEquipmentCollapse(this);">[Equipment Template]</span>
        					</div>
        					<table class='equipment'>
        						<tr>
        							<td class="label">
        								Make<span class="required">*</span>
        							</td>
        							<td class="label">
        								Model<span class="required">*</span>
        							</td>
        						</tr>
        						<tr>
        							<td>
        								<input type="text" id="Make" size="35" onkeyup="HomeObj.setEquipmentTitle(this);"/>
        							</td>
        							<td>
        								<input type="text" id="Model" size="35" onkeyup="HomeObj.setEquipmentTitle(this);"/>
        							</td>
        						</tr>
        						<tr>
        							<td class="label">
        								Type
        							</td>
        							<td class="label">
        							</td>
        						</tr>
        						<tr>
        							<td>
        								<input type="text" id="Type" size="35"/>
        							</td>
        							<td>
        							</td>
        						</tr>
        						<tr>
        							<td class="label">
        								Notes
        							</td>
        							<td></td>
        						</tr>
        						<tr>
        							<td colspan="2">
        								<textarea id="Notes"></textarea>
        							</td>
        						</tr>
        						<tr>
        							<td colspan="2">
        								<table class="remove_equipment" onclick="HomeObj.removeEquipment(this);">
        									<tr>
        										<td>
        											<img src="<?php echo base_url("/cdn/img/TrashIcon.png"); ?>"/>
        										</td>
        										<td>
        											<span>Remove Item</span>
        										</td>
        									</tr>
        								</table>
        							</td>
        						</tr>
        					</table>
        				</td>
        			</tr>
        		</table>
				<div id="add_equipment_container">
					<a href="javascript:HomeObj.addEquipment();">
	        		<table id="add_equipment_table">
	        			<tr class="add_equipment">
	        				<td>
	        					<img src="<?php echo base_url("/cdn/img/green_plus.png"); ?>" class="plus_icon" />
	        				</td>
	        				<td>
	        					<span class="add_item">Add Item</span>
	        				</td>
	        			</tr>
	        		</table>
					<a>
				<div>
        	    <div class="clear"></div>
    	    </div>
	    </form>
        </fieldset>
		<div class="clear"></div>
		<div align="center">
			<input type="button" id="main_submit" value="Submit" onclick="HomeObj.submitTicketData();"/>
		</div>
		<script type="text/javascript">
			$('#main_submit').button();
		</script>
 	</div>
 	<!-- <style>
		.ui-progressbar-value { background: url(/cdn/img/scs_progress_bar.gif) 0px no-repeat; }
	</style> -->
 	<div id="submit_dialog" style="display: none;">
 		<div class="waiting">
	 		<div id="waiting_message" class="waiting_message">Please Wait. Processing Request...</div><br/>
	 		<div style="text-align: center;"><img src="<?php echo base_url("/cdn/img/load.gif"); ?>" alt="Waiting" title="Waiting"></div>
 		</div>
 		<div class="finished">
 			
 		</div>
 	</div>
	 <script type="text/javascript">
	    HomeObj.setTabEvents();
	    HomeObj.setSubmitDialog();
	 	HomeObj.setDocumentDropdownBlur();
	 </script>