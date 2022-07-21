<?php
add_action( 'admin_menu', 'booking_summary', 10, 1 );
function booking_summary()
{
	add_menu_page( 'Booking Detail', 'Tableau des réservations', 0, "booking-detail", 'book_summary_page' );
}
function book_summary_page()
{
	?>
	<html lang="en">
	<head>
		<style>
			html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video {
				margin: 0;
				padding: 0;
				border: 0;
				font-size: 100%;
				font: inherit;
				vertical-align: baseline;
				outline: none;
				-webkit-font-smoothing: antialiased;
				-webkit-text-size-adjust: 100%;
				-ms-text-size-adjust: 100%;
				-webkit-box-sizing: border-box;
				-moz-box-sizing: border-box;
				box-sizing: border-box;
			}
			html { overflow-y: scroll; }
			body { 
				background: #eee url('https://i.imgur.com/eeQeRmk.png'); /* https://subtlepatterns.com/weave/ */
				font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
				font-size: 62.5%;
				line-height: 1;
				color: #585858;
				padding: 22px 0px;
				padding-bottom: 55px;
			}
			::selection { background: #5f74a0; color: #fff; }
			::-moz-selection { background: #5f74a0; color: #fff; }
			::-webkit-selection { background: #5f74a0; color: #fff; }
			br { display: block; line-height: 1.6em; } 
			article, aside, details, figcaption, figure, footer, header, hgroup, menu, nav, section { display: block; }
			ol, ul { list-style: none; }
			input, textarea { 
				-webkit-font-smoothing: antialiased;
				-webkit-text-size-adjust: 100%;
				-ms-text-size-adjust: 100%;
				-webkit-box-sizing: border-box;
				-moz-box-sizing: border-box;
				box-sizing: border-box;
				outline: none; 
			}
			blockquote, q { quotes: none; }
			blockquote:before, blockquote:after, q:before, q:after { content: ''; content: none; }
			strong, b { font-weight: bold; } 
			table { border-collapse: collapse; border-spacing: 0; }
			img { border: 0; max-width: 100%; }
			h1 { 
				font-family: 'Amarante', Tahoma, sans-serif;
				font-weight: bold;
				font-size: 3.6em;
				line-height: 1.7em;
				margin-bottom: 10px;
				text-align: center;
			}
			/** page structure **/
			#wrapper {
				display: block;
				width: 850px;
				background: #fff;
				margin: 0 auto;
				padding: 10px 17px;
				-webkit-box-shadow: 2px 2px 3px -1px rgba(0,0,0,0.35);
			}
			#keywords {
				font-size: 1.2em;
				margin-bottom: 15px;
				width: 100%;
			}
			#keywords thead {
				cursor: pointer;
				background: #c9dff0;
			}
			#keywords thead tr th { 
				font-weight: bold;
				padding: 12px 30px;
				font-size:14px;
			}
			#keywords thead tr th span { 
				padding-right: 20px;
				background-repeat: no-repeat;
				background-position: 100% 100%;
			}
			#keywords thead tr th.headerSortUp, #keywords thead tr th.headerSortDown {
				background: #acc8dd;
			}
			#keywords thead tr th.headerSortUp span {
				background-image: url('https://i.imgur.com/SP99ZPJ.png');
			}
			#keywords thead tr th.headerSortDown span {
				background-image: url('https://i.imgur.com/RkA9MBo.png');
			}
			#keywords tbody tr { 
				color: #555;
			}
			#keywords tbody tr td {
				text-align: center;
				padding: 6px 15px;
				border: 1px solid #eee;
				font-size: 12px;
				font-weight: 500;
			}
			#keywords tbody tr td.lalign {
				text-align: left;
			}
			
			#keywords tfoot tr { 
				color: #555;
			}
			#keywords tfoot{
			    background:#eeeeee;
			}
			
			#keywords tfoot tr td {
				text-align: center;
				padding: 6px 15px;
				border: 1px solid #eee;
				font-size: 17px;
				font-weight: 600;
			}
			
			#keywords tfoot tr td.lalign {
				text-align: left;
			}
			
			.detailtable{
				display: none;
			}
			
			#fetch-data{
				font-weight: 100;
			}
			
			.detail-msg{
				text-align: center;
                font-size: 20px;
                 margin: 30px auto;
			}
			.get-chil-entry{
				cursor: pointer;
			}
			.hide{
			    visibility: hidden;
			}
		</style>
		<script type="text/javascript">
 jQuery(document).ready(function($) {
     $('.hide').each(function () {
    $(this).prop('Counter',0).animate({
        Counter: $(this).text()
    }, {
        duration: 5000,
        easing: 'swing',
        step: function (now) {
            $('.Count').text(Math.ceil(now));
        }
    });
});
 	var leadidarr = [];
 	 // code to trigger on form or form page render
        	$('.get-chil-entry').click(function(e) {
				e.preventDefault();
				var leadidarr = $(this).data('leadid');
				//alert(leadidarr);
				jQuery.ajax({
					url: '<?php echo admin_url('admin-ajax.php'); ?>',
					type: 'POST',
					dataType: 'json',
					data: { action: 'summer_camp_entries_data', leadidarr:leadidarr},
					success: function(data) {
						console.log(data);
						$(".detailtable").fadeIn();
						$("#fetch-data").html("");
				$.each(data, function(index, val) {
			var detail_msg_detailtable = val["201"] + " / Liste des inscrits";
					var text = `<tr>
					     <td>${val["187"]}</td>
						 <td>${val["2"] + " " + val["4"]}</td>
						 <td>${val["111"]}</td>
						 <td><a target='_blank' href='/wp-admin/admin.php?page=gf_entries&view=entry&id=1&lid=${val.id}'>Voir</a></td>
										</tr>`
						$(".detail-msg").html(detail_msg_detailtable);
						$("#fetch-data").append(text);
						});

					}
				});
			});
 });
</script>
	</head>
	<body>
		<div id="wrapper">
			<?php
			global $wpdb;
			$results = $wpdb->get_results(
				'SELECT * FROM `wp_summer_camp` GROUP by class ORDER BY `id` ASC'
			);
	
			$form_id = 2;
			$search_criteria = array(
				'status'        => 'active',
			);
			$sorting = array();
			$paging  = array( 'offset' => 0, 'page_size' => 100 );
			/*=====================
			 Get all perant entries get
			 ======================*/
			$entries = GFAPI::get_entries( $form_id, $search_criteria,$sorting,$paging); 
			/*echo "<pre>";
			print_r($entries);
			echo "</pre>";*/
			$parintid = array();
			$lids = array();
			$class = array();
			$week1 = array();
			$week2 = array();
			$week3 = array();
			$totalweek = array();
			$grandweeks = array();
			
			foreach ($entries as $key => $valueparintloop) {
				$parintid[] = $valueparintloop["id"];
				$form_id = 1;
				$search_criteria = array(
					'status'        => 'active',
					'field_filters' => array(
						array(
							'key'   => 'gpnf_entry_parent',
							'value' => $valueparintloop["id"],
						),
					)
				);
				$sorting         = array();
			    $paging          = array( 'offset' => 0, 'page_size' => 100 );
				$entriesdata = GFAPI::get_entries( $form_id, $search_criteria, $sorting, $paging);
		    	/*echo "<pre>";
				print_r($entriesdata);
				echo "</pre>";*/
				foreach ($entriesdata as $keyid => $finaldata) {
					$grandweeks[] = array(
						"lid"  => $finaldata['id'],
						"class"  => $finaldata['201'],
						'week1'  => $finaldata['182.1'],
						'week2'  =>  $finaldata['182.2'],
						'week3'  =>  $finaldata['182.3'],
						'totalweek'  =>  $finaldata['194']
					);
				}
			}

			foreach ($grandweeks as $weekkey => $weekdatawithclass) {
				$lids[] = $weekdatawithclass["lid"];
				$class[] = $weekdatawithclass["class"];
				$week1[] = $weekdatawithclass["week1"];
				$week2[] = $weekdatawithclass["week2"];
				$week3[] = $weekdatawithclass["week2"];
				$totalweek[] = $weekdatawithclass["totalweek"];
			}		
			?>
			<?php
			/*echo "<pre>";
			print_r($grandweeks);
			echo "</pre>";*/
			?>
			<table id="keywords" cellspacing="0" cellpadding="0" class="table table-bordered">
				<thead>
					<tr>
						<th><span>CLASSE ACTUELLE</span></th>
						<th><span>SEMAINE 1</span></th>
						<th><span>SEMAINE 2</span></th>
						<th><span>SEMAINE 3</span></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($results as $key => $customdata): ?>
						<tr>
							<td class="lalign"><?php echo $customdata->class; ?></td>
							<td>
								<?php
								$tableentryids1 = array();
								$tableentryids2 = array();
								$tableentryids3 = array();
								$week1_i = 0;
								foreach ($grandweeks as $day1) {
									if ($day1["class"] ===  $customdata->class) {
										if (!empty($day1["week1"])) {
											//$week1_i = 	(int)$day1["week1"] += (int)$week1_i;
											$week1_i = 	$week1_i += 1;
											$tableentryids1[] =  $day1["lid"];
										}
									}
								}
								if ($week1_i != 0) {
									//print_r($tableentryids1);
									$leadidget =  implode(', ', $tableentryids1);
									echo "<button type='submit' class='get-chil-entry' data-leadid='{$leadidget}'><span style=''>".$week1_i."</span></button>";
								}else{
									echo "<span style='color:#dbdbdb;'>0</span>";
								}
								?>
							</td>
							<td>
								<?php
								$week2_i = 0;
								foreach ($grandweeks as $day2) {
									if ($day2["class"] ===  $customdata->class ) {
										if (!empty($day2["week2"])) {
											//$week2_i = 	(int)$day2["week2"] += (int)$week2_i;
											$week2_i = 	$week2_i += 1;
											$tableentryids2[] =  $day2["lid"];
										}
										
									}
								}
								if ($week2_i != 0) {
									$leadidget2 =  implode(', ', $tableentryids2);
									echo "<button type='submit' class='get-chil-entry' data-leadid='{$leadidget2}'><span style=''>".$week2_i."</span></button>";
								}else{
									echo "<span style='color:#dbdbdb;'>0</span>";
								}
								?>
							</td>
							<td>
								<?php
								$week3_i = 0;
								foreach ($grandweeks as $day3) {
									if ($day3["class"] ===  $customdata->class ) {
										if (!empty($day3["week3"])) {
											//$week3_i = 	(int)$day3["week3"] += (int)$week3_i;
											$week3_i = 	$week3_i += 1;
											$tableentryids3[] =  $day3["lid"];
										}
									}
								}
								if ($week3_i != 0) {
									$leadidget3 =  implode(', ', $tableentryids3);
									echo "<button type='submit' class='get-chil-entry' data-leadid='{$leadidget3}'><span style=''>".$week3_i."</span></button>";
								}else{
									echo "<span style='color:#dbdbdb;'>0</span>";
								}
								?>
						</td>
						</tr>
					<?php endforeach; ?>
					<tfoot>
					    <tr>
					        <td>Nombre total d'enfants</td>
					        <span class="hide" colspan="3"><?php echo count($grandweeks); ?></span>
					        <td class="Count" colspan="3">0</td>
					    </tr>
					</tfoot>
				</tbody>
			</table>
			<table  id="keywords" cellspacing="0" cellpadding="0" class="detailtable">
				<thead>
				<h3 class="detail-msg detailtable">Class Summary</h3>
					<th>Section</th>
					<th>Nom Prénom</th>
					<th>M/F</th>
					<th>...</th>
				</thead>
				<tbody id="fetch-data">	</tbody>
			</table>
		</div> 
	</body>

	</html>
	<?php
}
add_action('wp_ajax_summer_camp_entries_data' , 'summer_camp_entries_data');
add_action('wp_ajax_nopriv_summer_camp_entries_data','summer_camp_entries_data');
function summer_camp_entries_data() 
{
	 $parintid = $_REQUEST['leadidarr'];
	 $data = explode(",",$parintid);

				$form_id = 1;
				$search_criteria = array(
					'status'        => 'active',
					'field_filters' => array(
						array(
							'key'   => 'id',
							'operator' => 'in',
							'value' => $data
						),
					)
				);
  $sorting = array();
  $paging  = array( 'offset' => 0, 'page_size' => 100 );
  $entriesdata = GFAPI::get_entries( $form_id, $search_criteria, $sorting, $paging);
  wp_send_json($entriesdata);
}