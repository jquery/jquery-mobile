<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Filterable inside custom select - jQuery Mobile Demos</title>
	<link rel="shortcut icon" href="../favicon.ico">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
	<link rel="stylesheet" href="../../css/themes/default/jquery.mobile.css">
	<link rel="stylesheet" href="../_assets/css/jqm-demos.css">
	<script src="../../external/jquery/jquery.js"></script>
	<script src="../_assets/js/"></script>
	<script src="../../js/"></script>
	<script>
( function( $ ) {

function pageIsSelectmenuDialog( page ) {
	var isDialog = false,
		id = page && page.attr( "id" );

	$( ".filterable-select" ).each( function() {
		if ( $( this ).attr( "id" ) + "-dialog" === id ) {
			isDialog = true;
			return false;
		}
	});

	return isDialog;
}

$.mobile.document

	// Upon creation of the select menu, we want to make use of the fact that the ID of the
	// listview it generates starts with the ID of the select menu itself, plus the suffix "-menu".
	// We retrieve the listview and insert a search input before it.
	.on( "selectmenucreate", ".filterable-select", function( event ) {
		var input,
			selectmenu = $( event.target ),
			list = $( "#" + selectmenu.attr( "id" ) + "-menu" ),
			form = list.jqmData( "filter-form" );

		// We store the generated form in a variable attached to the popup so we avoid creating a
		// second form/input field when the listview is destroyed/rebuilt during a refresh.
		if ( !form ) {
			input = $( "<input data-type='search'></input>" );
			form = $( "<form></form>" ).append( input );

			input.textinput();

			list
				.before( form )
				.jqmData( "filter-form", form )	;
			form.jqmData( "listview", list );
		}

		// Instantiate a filterable widget on the newly created selectmenu widget and indicate that
		// the generated input form element is to be used for the filtering.
		selectmenu
			.filterable({
				input: input,
				children: "> option[value]"
			})

			// Rebuild the custom select menu's list items to reflect the results of the filtering
			// done on the select menu.
			.on( "filterablefilter", function() {
				selectmenu.selectmenu( "refresh" );
			});
	})

	// The custom select list may show up as either a popup or a dialog, depending on how much
	// vertical room there is on the screen. If it shows up as a dialog, then the form containing
	// the filter input field must be transferred to the dialog so that the user can continue to
	// use it for filtering list items.
	.on( "pagecontainerbeforeshow", function( event, data ) {
		var listview, form;

		// We only handle the appearance of a dialog generated by a filterable selectmenu
		if ( !pageIsSelectmenuDialog( data.toPage ) ) {
			return;
		}

		listview = data.toPage.find( "ul" );
		form = listview.jqmData( "filter-form" );

		// Attach a reference to the listview as a data item to the dialog, because during the
		// pagecontainerhide handler below the selectmenu widget will already have returned the
		// listview to the popup, so we won't be able to find it inside the dialog with a selector.
		data.toPage.jqmData( "listview", listview );

		// Place the form before the listview in the dialog.
		listview.before( form );
	})

	// After the dialog is closed, the form containing the filter input is returned to the popup.
	.on( "pagecontainerhide", function( event, data ) {
		var listview, form;

		// We only handle the disappearance of a dialog generated by a filterable selectmenu
		if ( !pageIsSelectmenuDialog( data.toPage ) ) {
			return;
		}

		listview = data.prevPage.jqmData( "listview" ),
		form = listview.jqmData( "filter-form" );

		// Put the form back in the popup. It goes ahead of the listview.
		listview.before( form );
	});

})( jQuery );
	</script>
	<style>
		.ui-selectmenu.ui-popup .ui-input-search {
			margin-left: .5em;
			margin-right: .5em;
		}
		.ui-selectmenu.ui-dialog .ui-content {
			padding-top: 0;
		}
		.ui-selectmenu.ui-dialog .ui-selectmenu-list {
			margin-top: 0;
		}
		.ui-selectmenu.ui-popup .ui-selectmenu-list li.ui-first-child .ui-btn {
			border-top-width: 1px;
			-webkit-border-radius: 0;
			border-radius: 0;
		}
		.ui-selectmenu.ui-dialog .ui-header {
			border-bottom-width: 1px;
		}
	</style>
</head>
<body>
<div data-role="page" class="jqm-demos">

	<div data-role="header" class="jqm-header">
		<h2><a href="../" title="jQuery Mobile Demos home"><img src="../_assets/img/jquery-logo.png" alt="jQuery Mobile"></a></h2>
		<p><span class="jqm-version"></span> Demos</p>
		<a href="#" class="jqm-navmenu-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-bars ui-nodisc-icon ui-alt-icon ui-btn-left">Menu</a>
		<a href="#" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-search ui-nodisc-icon ui-alt-icon ui-btn-right">Search</a>
	</div><!-- /header -->

	<div role="main" class="ui-content jqm-content">

    <h1>Filterable inside custom select</h1>

		<p>
		These examples show how you can filter the list inside a custom select menu.
		</p>

		<p>You can create an input field and prepend it to the popup and/or the dialog used by the custom select menu list and you can use it to filter items inside the list by instantiating a filterable widget on the select menu.</p>

		<h2>Examples</h2>

		<div data-demo-html="true" data-demo-js="true" data-demo-css="true">
			<form>
				<div class="ui-field-contain">
					<label for="filter-menu">Basic:</label>
					<select id="filter-menu" data-native-menu="false" class="filterable-select">
						<option value="SFO">San Francisco</option>
						<option value="LAX">Los Angeles</option>
						<option value="YVR">Vancouver</option>
						<option value="YYZ">Toronto</option>
					</select>
				</div>
			</form>
		</div>

		<div data-demo-html="true" data-demo-js="true" data-demo-css="true">
			<form>
				<div class="ui-field-contain">
					<label for="title-filter-menu">Placeholder:</label>
					<select id="title-filter-menu" data-native-menu="false" class="filterable-select">
						<option>Select fruit...</option>
						<option value="orange">Orange</option>
						<option value="apple">Apple</option>
						<option value="peach">Peach</option>
						<option value="lemon">Lemon</option>
					</select>
				</div>
			</form>
		</div>

		<div data-demo-html="true" data-demo-js="true" data-demo-css="true">
			<form>
				<div class="ui-field-contain">
					<label for="filtertext">Filter text:</label>
					<select id="filtertext" data-native-menu="false" class="filterable-select">
						<option>Select fruit...</option>
						<option value="orange" data-filtertext="Florida">Orange</option>
						<option value="apple">Apple</option>
						<option value="peach">Peach</option>
						<option value="lemon">Lemon</option>
					</select>
				</div>
			</form>
		</div>

		<div data-demo-html="true" data-demo-js="true" data-demo-css="true">
			<form>
				<div class="ui-field-contain">
					<label for="select-custom-20">Long list:</label>
					<select name="select-custom-20" id="select-custom-20" data-native-menu="false" class="filterable-select">
						<option value="AL">Alabama</option>
						<option value="AK">Alaska</option>
						<option value="AZ">Arizona</option>
						<option value="AR">Arkansas</option>
						<option value="CA">California</option>
						<option value="CO">Colorado</option>
						<option value="CT">Connecticut</option>
						<option value="DE">Delaware</option>
						<option value="FL">Florida</option>
						<option value="GA">Georgia</option>
						<option value="HI">Hawaii</option>
						<option value="ID">Idaho</option>
						<option value="IL">Illinois</option>
						<option value="IN">Indiana</option>
						<option value="IA">Iowa</option>
						<option value="KS">Kansas</option>
						<option value="KY">Kentucky</option>
						<option value="LA">Louisiana</option>
						<option value="ME">Maine</option>
						<option value="MD">Maryland</option>
						<option value="MA">Massachusetts</option>
						<option value="MI">Michigan</option>
						<option value="MN">Minnesota</option>
						<option value="MS">Mississippi</option>
						<option value="MO">Missouri</option>
						<option value="MT">Montana</option>
						<option value="NE">Nebraska</option>
						<option value="NV">Nevada</option>
						<option value="NH">New Hampshire</option>
						<option value="NJ">New Jersey</option>
						<option value="NM">New Mexico</option>
						<option value="NY">New York</option>
						<option value="NC">North Carolina</option>
						<option value="ND">North Dakota</option>
						<option value="OH">Ohio</option>
						<option value="OK">Oklahoma</option>
						<option value="OR">Oregon</option>
						<option value="PA">Pennsylvania</option>
						<option value="RI">Rhode Island</option>
						<option value="SC">South Carolina</option>
						<option value="SD">South Dakota</option>
						<option value="TN">Tennessee</option>
						<option value="TX">Texas</option>
						<option value="UT">Utah</option>
						<option value="VT">Vermont</option>
						<option value="VA">Virginia</option>
						<option value="WA">Washington</option>
						<option value="WV">West Virginia</option>
						<option value="WI">Wisconsin</option>
						<option value="WY">Wyoming</option>
					</select>
				</div>
			</form>
		</div><!--/demo-html -->

	</div><!-- /content -->

	<?php include( '../jqm-navmenu.php' ); ?>

	<div data-role="footer" data-position="fixed" data-tap-toggle="false" class="jqm-footer">
		<p>jQuery Mobile Demos version <span class="jqm-version"></span></p>
		<p>Copyright The jQuery Foundation</p>
	</div><!-- /footer -->

<?php include( '../jqm-search.php' ); ?>

</div><!-- /page -->

</body>
</html>
