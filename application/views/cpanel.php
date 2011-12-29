<?php
/**
 * This is the view that will load the top control panel for authenticated users.
 * 
 * @author Joseph T. Anderson <jtanderson@ratiocaeli.com>
 * @since 2011-11-14
 * @version 2011-11-14
 * 
 */
?>
<div id="cpanel">
	<ul class="cpanel_menu">
		<li>
			<!-- <a href="">
				<span class="cpspan bordered">+Joe</span>
			</a> -->
		</li>
		<li>
			<a href="/">
				<span class="cpspan bordered">Home</span>
			</a>
		</li>
		<li>
            <a href="/Home/Search">
                <span class="cpspan bordered">Search</span>
            </a>
        </li>
        <li>
            <a href="/Home/Settings/<?php echo $this->session->userdata('LocalID'); ?>">
                <span class="cpspan">Settings</span>
            </a>
        </li>
	</ul>
	<ul class="cpanel_menu" style="float: right; padding-right: 25px;">
		<li>
			<a href="javascript:MainObj.logOut();">
				<span class="cpspan">Log Out</span>
			</a>
		</li>
	</ul>
</div>
