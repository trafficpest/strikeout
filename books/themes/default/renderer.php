<?php
/**********************************************************************
	Copyright (C) FrontAccounting Team.
	Released under the terms of the GNU General Public License, GPL, 
	as published by the Free Software Foundation, either version 3 
	of the License, or (at your option) any later version.
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
	See the License here <http://www.gnu.org/licenses/gpl-3.0.html>.
***********************************************************************/
// Author: Joe Hunt, 01/06/2019. Release 2.4.6.

	class renderer
	{
		function get_icon($category)
		{
			global	$path_to_root, $SysPrefs;

			if ($SysPrefs->show_menu_category_icons)
				$img = $category == '' ? 'right.gif' : $category.'.png';
			else	
				$img = 'right.gif';
			return "<img src='$path_to_root/themes/".user_theme()."/images/$img' style='vertical-align:middle;' border='0'>&nbsp;&nbsp;";
		}

		function wa_header()
		{
			page(_($help_context = "Main Menu"), false, true);
		}

		function wa_footer()
		{
			end_page(false, true);
		}
		function shortcut($url, $label) 
		{
			echo "<li>";
			echo menu_link($url, $label);
			echo "</li>";
		}
		function menu_header($title, $no_menu, $is_index)
		{
			global $path_to_root, $SysPrefs, $version, $db_connections, $installed_extensions;

			$sel_app = $_SESSION['sel_app'];
			echo "<div class='fa-main'>\n";
			if (!$no_menu)
			{
				echo "
<script type='text/javascript'>
var _toggle_ = false;
function openNav() {
	if (_toggle_) {
		document.getElementById('sidebar').style.width = '220px';
		document.getElementById('main').style.marginLeft = '220px';
	}
	else {
	document.getElementById('sidebar').style.width = '0';
	document.getElementById('main').style.marginLeft= '0';
	}
	_toggle_ = !_toggle_;
}
/*
window.onload = function(){
	if (document.readyState == 'complete')
	button_operator(\"m0\");
}
*/
function button_operator(id) {
	var max = document.getElementById(id).style.maxHeight;
	var dropdowns = document.getElementsByClassName('accordion');
	var i;
	var panel;
	for (i = 0; i < dropdowns.length; i++) {
		var openDropdown = dropdowns[i];
		var panel = openDropdown.nextElementSibling;
		panel.style.maxHeight = null;
	}
	if (!max)
		document.getElementById(id).style.maxHeight = document.getElementById(id).scrollHeight + 'px';
}
</script>";
				$applications = $_SESSION['App']->applications;

				echo "<div class='topnav'>";
				add_access_extensions();
				$i = 0;
				$cur_app = array();
				foreach($applications as $app)
				{
					if ($_SESSION["wa_current_user"]->check_application_access($app))
					{
						if ($sel_app == $app->id)
							$cur_app = $app;
						$acc = access_string($app->name);
						$i++;
						$link = "$path_to_root/index.php?application=$app->id '$acc[1]";
						echo "<a ".($sel_app == $app->id ? "class='active' " : " ") . "href='$link>" . $acc[0] . "</a>\n";
					}
				}
				$cpath = company_path();
				$logo = get_company_pref('coy_logo');
        $logo_img = "$cpath/images/$logo";
        if (!is_file($logo_img)){
          $logo_img = $path_to_root.'/themes/'.user_theme()
            .'/images/sq-logo.png';
        }
				echo "<a class='right' href='#'><img src='$path_to_root/themes/".user_theme()."/images/so-fa-logo.png' style='height:28px; border-radius: 5px;'></a>\n";
				echo "</div>\n"; // topnav
				$applications = $_SESSION['App']->applications;
				$local_path_to_root = $path_to_root;
				$pimg = "<img src='$local_path_to_root/themes/".user_theme()."/images/preferences.png' style='border:0;vertical-align:middle;padding-bottom:3px;' alt='"._('Preferences')."'>&nbsp;&nbsp;";
				$limg = "<img src='$local_path_to_root/themes/".user_theme()."/images/password.png' style='border:0;vertical-align:middle;padding-bottom:3px;' alt='"._('Change Password')."'>&nbsp;&nbsp;";
				$img = "<img src='$local_path_to_root/themes/".user_theme()."/images/logoff.png' style='border:0;vertical-align:middle;padding-bottom:3px;' alt='"._('Logout')."'>&nbsp;&nbsp;";
				$himg = "<img src='$local_path_to_root/themes/".user_theme()."/images/help.png' style='border:0;vertical-align:middle;padding-bottom:3px;' alt='"._('Help')."'>&nbsp;&nbsp;";
				echo "<div class='menu2'><div id='header'>\n";
				echo "<ul>\n";
				echo "	<li><a href='$local_path_to_root/admin/display_prefs.php?'>$pimg" . _("Preferences") . "</a></li>\n";
				echo "	<li><a href='$local_path_to_root/admin/change_current_user_password.php?selected_id=" . $_SESSION["wa_current_user"]->username . "'>$limg" . _("Change password") . "</a></li>\n";
				if ($SysPrefs->help_base_url != null)
					echo "	<li><a target = '_blank' onclick=" .'"'."javascript:openWindow(this.href,this.target); return false;".'" '. "href='". 
						help_url()."'>$himg" . _("Help") . "</a></li>";
				echo "	<li><a href='$path_to_root/access/logout.php?'>$img" . _("Logout") . "</a></li>";
				echo "</ul>\n";
		
				$indicator = "$path_to_root/themes/".user_theme(). "/images/ajax-loader.gif";
				$but = "<img src='$local_path_to_root/themes/".user_theme()."/images/menu.png' title='"._("Menu")."' style='width:20px;height:20px;border:0;vertical-align:middle;padding-bottom:3px;'>";
		
				echo "<h1><a class='but' href='#' onclick='openNav();'>$but</a>&nbsp;&nbsp;";
				echo "$SysPrefs->power_by $version<span style='padding-left:200px;'><img id='ajaxmark' src='$indicator' align='center' style='visibility:hidden;'></span></h1>\n";
		
				echo "</div></div>\n"; // header, menu2
				echo "<div id='sidebar'>\n";	
		
				echo "<div class='header'>\n";
				echo "<div class='user-pic'>\n";
				echo "<img src='$logo_img' style='border:1px solid #ccc;width:60px;height:60px;border-radius:6px;'>\n";
				echo "</div>\n";
				echo "<div class='user-info'>\n";
				echo "<span class='user-role'><strong>" . $db_connections[$_SESSION["wa_current_user"]->company]["name"] . "</strong></span>\n";
				echo "<span class='user-role'>" . $_SESSION["wa_current_user"]->name . "</span>\n";
				if ($SysPrefs->show_users_online)
					echo "<span class='user-role'>" . show_users_online() . "</span>\n";
				else
					echo "<span class='user-role'>"._('Date') . ": " . today() . "</span>\n";
				echo "</div></div>\n"; // user info
		
				$app = $cur_app;
				if ($app->id == "system")
					$imgs2 = array("menu_settings.png", "menu_system.png", "menu_maintenance.png", "menu_system.png", "menu_system.png");
				else	
					$imgs2 = array("menu_transaction.png", "menu_inquiry.png", "menu_maintenance.png", "menu_money.png", "menu_transaction.png");
				$j = -1;
				foreach ($app->modules as $module)
				{
					$j++;
					if (!$_SESSION["wa_current_user"]->check_module_access($module))
						continue;
					$apps = array();
					foreach ($module->lappfunctions as $appfunction)
						$apps[] = $appfunction;
					$k = count($apps);	
					foreach ($module->rappfunctions as $appfunction)
						$apps[] = $appfunction;
					$count = 0;	
					foreach ($apps as $value)
					{
						if (!empty($value->label))
							$count++;
					}
					$img_src = "<img style='vertical-align:middle;' src='$path_to_root/themes/".user_theme()."/images/".$imgs2[$j]."' width='14' height='14' border='0' />";
					echo "<div class='accordion m".$j."' onclick='button_operator(\"m".$j."\");'>$img_src&nbsp;&nbsp;$module->name <span class='circle'>$count</span></div>\n";						
					//echo "<button type='submit' class='accordion' onclick='button_operator(\"m".$j."\");'><i class='".$imgs2[$j]." fa-fw'></i>&nbsp;$module->name</button>\n";					
		
					$application = array();	
					echo "<ul id='m".$j."'>\n";
					$i = 0;
					foreach ($apps as $application)	
					{
						if ($i++ == $k)
							$line = "class='line'";
						else
							$line = "";
						$img = $this->get_icon($application->category);
						$lnk = access_string($application->label);
						if ($_SESSION["wa_current_user"]->can_access_page($application->access))
						{
							if ($application->label != "")
							{
								echo "<li $line><a href='$path_to_root/$application->link'>$img{$lnk[0]}</a></li>\n";
							}
						}
						elseif (!$_SESSION["wa_current_user"]->hide_inaccessible_menu_items())	
							echo "<li $line><a class='inactive'>$img{$lnk[0]}</a></li>\n";
					}
					echo "</ul>\n";
				}
				echo "</div>\n"; // sidebar
				echo "<div id='main'>\n";
			}
			echo "<div class='fa-body'>\n";
			echo "<div class='fa-content'>\n";
			if ($no_menu)
				echo "<br>";
			elseif ($title && !$no_menu && !$is_index)
			{
				echo "<center><table id='title'><tr><td width='100%' class='titletext'>$title</td>"
					."<td align=right>"
					.(user_hints() ? "<span id='hints'></span>" : '')
					."</td>"
					."</tr></table></center>";
			}
		}

		function menu_footer($no_menu, $is_index)
		{
			global $path_to_root, $SysPrefs, $version, $db_connections, $Ajax, $Pagehelp;
			include_once($path_to_root . "/includes/date_functions.inc");

			if (!$no_menu)
			{
				echo "<div class='fa-footer'>\n";
				if (isset($_SESSION['wa_current_user']))
				{
					$phelp = implode('; ', $Pagehelp);
					$Ajax->addUpdate(true, 'hotkeyshelp', $phelp);
					echo "<span id='hotkeyshelp' style='float:right;'>".$phelp."</span>";
					echo "<span class='power'><a target='_blank' href='$SysPrefs->power_url'>&nbsp;&nbsp;$SysPrefs->power_by $version</a></span>\n";
					echo "<span class='date'>".Today() . "&nbsp;" . Now()."</span>\n";
					echo "<span class='date'>" . $db_connections[$_SESSION["wa_current_user"]->company]["name"] . "</span>\n";
					echo "<span class='date'>" . $_SERVER['SERVER_NAME'] . "</span>\n";
					echo "<span class='date'>" . $_SESSION["wa_current_user"]->name . "</span>\n";
					echo "<span class='date'>" . _("Theme:") . " " . user_theme() . "</span>\n";
					echo "<span class='date'>".show_users_online()."</span>\n";
				}
				echo "</div>\n"; // footer
				echo "</div>\n"; // main
			}
			echo "</div>\n"; // fa-content
			echo "</div>\n"; // fa-body
			echo "</div>\n"; // fa-main
		}

		function display_applications(&$waapp)
		{
			global $path_to_root;

			$sel = $waapp->get_selected_application();
			meta_forward("$path_to_root/admin/dashboard.php", "sel_app=$sel->id");	
			end_page();
			exit;
		}
	}
