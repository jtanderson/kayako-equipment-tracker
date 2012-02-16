<?php
/**
 * File: Search.php
 * 
 * This is the view for the search page.  Any content change should happen via AJAX and jQuery
 * 
 * @author Joseph T. Anderson
 * @since 2012-02-01
 * @version 2012-02-01
 * 
 */
?>
<div class="main-panel">
    <div id="message_container">
        <div id="DEFAULT_warning" style="display:none;" class="message">
            <a href="#" onclick="MainObj.removeWarning(this);" class="remove_warning"><img style="height: 15px; width: 15px;" src="<?php echo base_url('/cdn/img/moblin-close.png'); ?>"/></a>
            <table>
                <tr>
                    <td><img src="<?php echo base_url('/cdn/img/Red_triangle_alert_icon.png'); ?>" class="error_img"/></td>
                    <td><span class="warning_text"></span></td>
                </tr>
            </table>
        </div>
        <?php foreach ( $Errors as $error ){ ?>
            <script type="text/javascript">MainObj.displayWarning("<?php echo mysql_escape_string($error); ?>");</script>
        <?php } ?>
    </div>
    <div id="container">
        <div>
            <h1>Search</h1>
            <h2>Enter the ticket information.</h2>
            <p>
                This will search all tickets submitted through the Equipment Tracking System. The information will be displayed below.
            </p>
        </div>
        <div class="clear"></div>
        <div class="search_container">
            <form action="javascript:SearchObj.submitSearch();">
                <input id="ticket_search" class="big-search default-search-text" type="text" value="Ticket ID"/>
                <input id="ticket_search_submit" type="submit" value="Go" onclick="SearchObj.submitSearch();"/>
                <script type="text/javascript">
                    $('#ticket_search_submit').button();
                </script>
            </form>
        </div>
    
        <?php if ( isset($TicketData) ) { ?>
            <div class="divide"></div>
            <?php if ( $TicketData == "[None]" ){ ?>
                <h2 class="center">No Results</h2>
            <?php } else { ?>
                <div class="ticket_data">
                    <div>
                        <span class="title"><?php echo $TicketData["Subject"]; ?></span>
                        <span style="float: right;"><?php echo date('l F j, Y', strtotime($TicketData["CreatedDT"])); ?></span>
                    </div>
                    <div class="display_id"><?php echo $TicketData["TicketDisplayID"]; ?></div><br/><br/>
                    <table>
                        <tr>
                            <td class="user_col">
                                <div><?php echo $TicketData["FirstName"] . " " . $TicketData["LastName"]; ?></div>
                                <div><?php echo $TicketData["Email"]; ?></div>
                                <div><?php echo $TicketData["Phone"]; ?></div>
                            </td>
                            <td>
                                <div><?php echo nl2br($TicketData["FullFusionText"]); ?></div>
                            </td>
                        </tr>
                    </table><br/>
                    <div style="text-align: right;"><span class="barcode"><img src="<?php echo base_url("/cdn/img/barcodes/" . $TicketData["TicketDisplayID"] . ".gif"); ?>"/></span></div style="text-align: center;">
                </div>
            <?php //print_r($TicketData);
            }
        } ?>
    </div>
    <script type="text/javascript">SearchObj.setSearchBarCSS();</script>
</div>
<script type="text/javascript">
    $(document).ready( function(){
        $('#ticket_search').focus();
    });
</script>
