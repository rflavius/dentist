<!-- BEGIN if_breadcrumb -->
<ol class="breadcrumb">
	<!-- BEGIN if_wide_breadcrumb -->
	<li>
		<div class="btn-group text-right">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
				Meniu&nbsp;<span class="glyphicon glyphicon-menu-hamburger"  aria-hidden="true"></span>
			</button>
			<ul class="dropdown-menu" role="menu">
				{DISPLAY_MENU_3}
			</ul>
		</div>
	</li>
	<!-- END if_wide_breadcrumb -->
	<li class='small'><a href='{SITE_BASE}' title='acasa'>Acasa</a></li>
	<!-- BEGIN list_breadcrumb -->
	<li class='small {BREADCRUMB_ACTIVE}'>{BREADCRUMB}</li>
	<!-- END list_breadcrumb -->
	{RSS_FILE}
</ol>
<!-- END if_breadcrumb -->
{EXPAND_TITLE_TAGS}