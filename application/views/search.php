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
            <a href="#" onclick="MainObj.removeWarning(this);" class="remove_warning"><img style="height: 15px; width: 15px;" src="/cdn/img/moblin-close.png"/></a>
            <table>
                <tr>
                    <td><img src="/cdn/img/Red_triangle_alert_icon.png" class="error_img"/></td>
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
        </div>
        <div class="clear"></div>
        <div class="search_container">
            <input id="ticket_search" class="big-search default-search-text" type="text" value="Ticket ID"/>
            <input id="ticket_search_submit" type="button" value="Go"/>
        </div>
    </div>
    <script type="text/javascript">SearchObj.setSearchBarCSS();</script>
</div>
<script type="text/javascript">
    $(document).ready( function(){
        $('#ticket_search').focus();
    });
</script>
