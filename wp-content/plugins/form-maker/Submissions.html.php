<?php
	if(!current_user_can('manage_options')) {
	die('Access Denied');
}
function html_show_submits($rows, $forms, $lists, $pageNav, $labels, $label_titles, $rows_ord, $filter_order_Dir,$form_id, $labels_id, $sorted_labels_type, $total_entries, $total_views, $where,$where_choices,$sort)
{	
	$label_titles_copy=$label_titles;
	global $wpdb;

	$n=count($rows);
	$m=count($labels);
	$group_id_s= array();
	
	$rows_ord_none=array();
	
	if(count($rows_ord)>0 and $m)
	for($i=0; $i <count($rows_ord) ; $i++)
	{
	
		$row = $rows_ord[$i];
	
		if(!in_array($row->group_id, $group_id_s))
		{
		
			array_push($group_id_s, $row->group_id);
			
		}
	}

	?>
<style>
.calendar .button
{
display:table-cell !important;
}
</style>
<script type="text/javascript">
function tableOrdering( order, dir, task ) 
{
    var form = document.admin_form;
    form.filter_order2.value     = order;
    form.filter_order_Dir2.value = dir;
    submitform( task );
}
function ordering(name,as_or_desc)
	{
		document.getElementById('asc_or_desc').value=as_or_desc;		
		document.getElementById('order_by').value=name;
		document.getElementById('admin_form').submit();
	}
function renderColumns()
{
	allTags=document.getElementsByTagName('*');
	
	for(curTag in allTags)
	{
		if(typeof(allTags[curTag].className)!="undefined")
		if(allTags[curTag].className.indexOf('_fc')>0)
		{
			curLabel=allTags[curTag].className.replace('_fc','');
			if(document.forms.admin_form.hide_label_list.value.indexOf('@'+curLabel+'@')>=0)
				allTags[curTag].style.display = 'none';
			else
				allTags[curTag].style.display = '';
		}
		if(typeof(allTags[curTag].id)!="undefined")
		if(allTags[curTag].id.indexOf('_fc')>0)
		{
			curLabel=allTags[curTag].id.replace('_fc','');
			if(document.forms.admin_form.hide_label_list.value.indexOf('@'+curLabel+'@')>=0)
				allTags[curTag].style.display = 'none';
			else
				allTags[curTag].style.display = '';
		}
	}
}

function clickLabChB(label, ChB)
{
	document.forms.admin_form.hide_label_list.value=document.forms.admin_form.hide_label_list.value.replace('@'+label+'@','');
	if(document.forms.admin_form.hide_label_list.value=='') document.getElementById('ChBAll').checked=true;
	
	if(!(ChB.checked)) 
	{
		document.forms.admin_form.hide_label_list.value+='@'+label+'@';
		document.getElementById('ChBAll').checked=false;
	}
	renderColumns();
}

function toggleChBDiv(b)
{
	if(b)
	{
		sizes=window.getSize().size;
		document.getElementById("sbox-overlay").style.width=sizes.x+"px";
		document.getElementById("sbox-overlay").style.height=sizes.y+"px";
		document.getElementById("ChBDiv").style.left=Math.floor((sizes.x-350)/2)+"px";
		
		document.getElementById("ChBDiv").style.display="block";
		document.getElementById("sbox-overlay").style.display="block";
	}
	else
	{
		document.getElementById("ChBDiv").style.display="none";
		document.getElementById("sbox-overlay").style.display="none";
	}
}

function clickLabChBAll(ChBAll)
{
	<?php
	if(isset($labels))
	{
		$templabels=array_merge(array('submitid','submitdate','submitterip'),$labels_id);
		$label_titles=array_merge(array('ID','Submit date', "Submitter's IP Address"),$label_titles);
	}
	?>

	if(ChBAll.checked)
	{ 
		document.forms.admin_form.hide_label_list.value='';

		for(i=0; i<=ChBAll.form.length; i++)
			if(typeof(ChBAll.form[i])!="undefined")
				if(ChBAll.form[i].type=="checkbox")
					ChBAll.form[i].checked=true;
	}
	else
	{
		document.forms.admin_form.hide_label_list.value='@<?php echo implode($templabels,'@@') ?>@';

		for(i=0; i<=ChBAll.form.length; i++)
			if(typeof(ChBAll.form[i])!="undefined")
				if(ChBAll.form[i].type=="checkbox")
					ChBAll.form[i].checked=false;
	}

	renderColumns();
}

function remove_all()
{
	document.getElementById('startdate').value='';
	document.getElementById('enddate').value='';
	document.getElementById('ip_search').value='';
	<?php
		$n=count($rows);
	
	for($i=0; $i < count($labels) ; $i++)
	{
	echo "document.getElementById('".$form_id.'_'.$labels_id[$i]."_search').value='';
	";
	}
	?>
}

function show_hide_filter()
{	
	if(document.getElementById('fields_filter').style.display=="none")
	{
		document.getElementById('fields_filter').style.display='';
		document.getElementById('filter_img').src='<?php echo plugins_url('images/filter_hide.png',__FILE__) ?>';
	}
	else{
		document.getElementById('fields_filter').style.display="none";
		document.getElementById('filter_img').src='<?php echo plugins_url('images/filter_show.png',__FILE__) ?>';
	}
}
function submit_del(href_in)
{
	document.getElementById('admin_form').action=href_in;
	document.getElementById('admin_form').submit();
}
		<!--
		function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel_theme') {
		submitform( pressbutton );
		return;
		}
		
		if(document.getElementById('title').value==''){
		alert('The theme must have a title')
		return;			
		}
		submitform( pressbutton );
		}
		
		
		
		
		function submitform( pressbutton ){
			document.getElementById('adminForm').action=document.getElementById('adminForm').action+"&task="+pressbutton;
			document.getElementById('adminForm').submit();
		}
		//-->
	
		function change_width(){
		width=parseInt(document.getElementById('width').value)+45+parseInt(document.getElementById('border_width').value);		
		height=550;
	
		document.getElementById('spider_calendar_preview').href="http://localhost/wordpress/wp-content/plugins/spider-calendar/preview.php?TB_iframe=1&tbWidth="+width+"&tbHeight="+height;
		}
		
		
var thickDims, tbWidth, tbHeight;
jQuery(document).ready(function($) {

        thickDims = function() {
                var tbWindow = $('#TB_window'), H = $(window).height(), W = $(window).width(), w, h;

                w = (tbWidth && tbWidth < W - 90) ? tbWidth : W - 200;
                h = (tbHeight && tbHeight < H - 60) ? tbHeight : H - 200;

                if ( tbWindow.size() ) {
                        tbWindow.width(w).height(h);
                        $('#TB_iframeContent').width(w).height(h - 27);
                        tbWindow.css({'margin-left': '-' + parseInt((w / 2),10) + 'px'});
                        if ( typeof document.body.style.maxWidth != 'undefined' )
                                tbWindow.css({'top':(H-h)/2,'margin-top':'0'});
                }
        };

        thickDims();
        $(window).resize( function() { thickDims() } );

        $('a.thickbox-preview').click( function() {
                tb_click.call(this);

                var alink = $(this).parents('.available-theme').find('.activatelink'), link = '', href = $(this).attr('href'), url, text;

                if ( tbWidth = href.match(/&tbWidth=[0-9]+/) )
                        tbWidth = parseInt(tbWidth[0].replace(/[^0-9]+/g, ''), 10);
                else
                        tbWidth = $(window).width() - 90;

                if ( tbHeight = href.match(/&tbHeight=[0-9]+/) )
                        tbHeight = parseInt(tbHeight[0].replace(/[^0-9]+/g, ''), 10);
                else
                        tbHeight = $(window).height() - 60;

                if ( alink.length ) {
                        url = alink.attr('href') || '';
                        text = alink.attr('title') || '';
                        link = '&nbsp; <a href="' + url + '" target="_top" class="tb-theme-preview-link">' + text + '</a>';
                } else {
                        text = $(this).attr('title') || '';
                        link = '&nbsp; <span class="tb-theme-preview-link">' + text + '</span>';
                }

                $('#TB_title').css({'background-color':'#222','color':'#dfdfdf'});
                $('#TB_closeAjaxWindow').css({'float':'left'});
                $('#TB_ajaxWindowTitle').css({'float':'right'}).html(link);

                $('#TB_iframeContent').width('100%');
                thickDims();

                return false;
        } );

        // Theme details
        $('.theme-detail').click(function () {
                $(this).siblings('.themedetaildiv').toggle();
                return false;
        });

});

        
</script>

<style>

.reports
{
	border:1px solid #DEDEDE;
	border-radius:11px;
	background-color:#F0F0F0;
	text-align:center;
	width:100px;
}

.bordered
{
	border-radius:8px
}

.simple_table
{
	background-color:transparent; !important
}
</style>
<?php 
if(isset($labels))
{
?>
<div id="sbox-overlay" style="z-index: 65555; position: fixed; top: 0px; left: 0px; visibility: visible; zoom: 1; background-color:#000000; opacity: 0.7; filter: alpha(opacity=70); display:none;" onclick="toggleChBDiv(false)"></div>
<div style="background-color:#FFFFFF; width: 350px; height: 350px; overflow-y: scroll; padding: 20px; position: fixed; top: 100px;display:none; border:2px solid #AAAAAA;  z-index:65556" id="ChBDiv">

<form action="#">
    <p style="font-weight:bold; font-size:18px;margin-top: 0px;">
    Select Columns
    </p>

    <input type="checkbox" <?php if($lists['hide_label_list']==='') echo 'checked="checked"' ?> onclick="clickLabChBAll(this)" id="ChBAll" />All</br>

	<?php 
    
        foreach($templabels as $key => $curlabel)
        {
            if(strpos($lists['hide_label_list'],'@'.$curlabel.'@')===false)
            echo '<input type="checkbox" checked="checked" onclick="clickLabChB(\''.$curlabel.'\', this)" />'.$label_titles[$key].'<br />';
            else
            echo '<input type="checkbox" onclick="clickLabChB(\''.$curlabel.'\', this)" />'.$label_titles[$key].'<br />';
        }
    
    
    ?>
    <br />
    <div style="text-align:center;">
        <input type="button" onclick="toggleChBDiv(false);" value="Done" /> 
    </div>
</form>
</div>

<?php } ?>

<form action="admin.php?page=Form_maker_Submits" style="overflow-x: scroll;" method="post" id="admin_form" name="admin_form">
    <input type="hidden" name="option" value="com_formmaker">
    <input type="hidden" name="task" value="submits">
    <input type="hidden" name="asc_or_desc" id="asc_or_desc" value="<?php if(isset($_POST['asc_or_desc'])){ echo esc_html($_POST['asc_or_desc']);} ?>">
    <input type="hidden" name="order_by" id="order_by" value="<?php if(isset($_POST['order_by'])){ echo esc_html($_POST['order_by']); } ?>">
<br />
    <table width="95%">

  <tr>
  <td colspan="11"><div style="text-align:right;font-size:16px;padding:20px; padding-right:50px; width:100%"> 
		<a href="http://web-dorado.com/files/fromFormMaker.php" target="_blank" style="color:red; text-decoration:none;">
		<img src="<?php echo plugins_url( 'images/header.png' , __FILE__ ); ?>" border="0" alt="www.web-dorado.com" width="215"><br>
		Get the full version&nbsp;&nbsp;&nbsp;&nbsp;
		</a>
	</div></td>
   </tr>

        <tr style="line-height:inherit !important;" >
            <td align="left" width="300"> Select a form:             
                <select name="form_id" id="form_id" onchange="if(document.getElementById('startdate'))remove_all();document.admin_form.submit();">
                    <option value="0" selected="selected"> Select a Form </option>
                    <?php 
            $option='com_formmaker';
            
           // $form_id=$mainframe-> getUserStateFromRequest( $option.'form_id', 'form_id','id','cmd' );
            if( $forms)
            for($i=0, $n=count($forms); $i < $n ; $i++)
        
            {
                $form = $forms[$i];
        
        
                if($form_id==$form->id)
                {
                    echo "<option value='".$form->id."' selected='selected'>".$form->title."</option>";
                    $form_title=$form->title;
                }
                else
                    echo "<option value='".$form->id."' >".$form->title."</option>";
            }
        ?>
                    </select>
            </td>
			<?php if(isset($form_id) and $form_id>0):  ?>
			<td class="reports" ><strong>Entries</strong><br /><?php echo $total_entries; ?></td>
			<td class="reports"><strong>Views</strong><br /><?php echo $total_views ?></td>
            <td class="reports"><strong>Conversion Rate</strong><br /><?php  if($total_views) echo round((($total_entries/$total_views)*100),2).'%'; else echo '0%' ?></td>
			<td style="font-size:36px;text-align:center;line-height: initial;">
				<?php echo $form_title ?>
			</td>
			<td style="text-align:right;" width="300">
                Export to
                <input type="button" value="CSV" onclick="window.location='<?php echo admin_url( 'admin-ajax.php?action=formmakergeneretecsv' ); ?>&form_id=<?php echo $form_id; ?>'" />&nbsp;
                <input type="button" value="XML" onclick="window.location='<?php echo admin_url( 'admin-ajax.php?action=formmakergeneretexml' ); ?>&form_id=<?php echo $form_id; ?>'" />
            </td>
			
        </tr>
        
        <tr>

            <td colspan=5>
                <br />
                <input type="hidden" name="hide_label_list" value="<?php  echo $lists['hide_label_list']; ?>"/> 
                <img src="<?php echo plugins_url("images/filter_show.png",__FILE__) ?>" width="40" style="vertical-align:bottom; cursor:pointer" onclick="show_hide_filter()"  title="Search by fields" id="filter_img" />
				<input type="button" onclick="this.form.submit();" value="Go" />	
				<input type="button" onclick="remove_all();this.form.submit();" value="Reset" />
            </td>
			<td align="right">
                <br /><br />
                <?php if(isset($labels)) echo '<input type="button" onclick="toggleChBDiv(true)" value="Add/Remove Columns" />'; ?>
			</td>
        </tr>

		<?php else: echo '<td><br /><br /><br /></td></tr>'; endif; ?>
    </table>
     <?php print_html_nav($pageNav['total'],$pageNav['limit']); 
?>
    <table class="wp-list-table widefat fixed posts"  style="width:95%; table-layout: inherit !important;" >
        <thead>
            <tr>
<th width="3%"><?php echo '#'; ?></th>

               <th scope="col" id="cb" class="manage-column column-cb check-column" style=""><input type="checkbox"></th>
				 <?php
				 

				?>	<th width="4%" scope="col"  id="submitid_fc" class="submitid_fc <?php  if($sort["sortid_by"]=="group_id") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" <?php if(!(strpos($lists['hide_label_list'],'@submitid@')===false)) echo 'style="display:none;"';?>><a href="javascript:ordering('group_id',<?php if($sort["sortid_by"]=="group_id") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>ID</span><span class="sorting-indicator"></span></a></th><?php
				 ?>	<th width="210px" scope="col"  id="submitdate_fc" class="submitdate_fc <?php if($sort["sortid_by"]=="date") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" <?php if(!(strpos($lists['hide_label_list'],'@submitdate@')===false)) echo 'style="display:none;"';?>><a href="javascript:ordering('date',<?php if($sort["sortid_by"]=="date") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>Submit date</span><span class="sorting-indicator"></span></a></th><?php
				 ?>	<th  scope="col"  id="submitterip_fc" class="submitterip_fc <?php if($sort["sortid_by"]=="ip") echo $sort["custom_style"]; else echo $sort["default_style"];  ?>" <?php if(!(strpos($lists['hide_label_list'],'@submitterip@')===false)) echo 'style="display:none;"';?>><a href="javascript:ordering('ip',<?php if($sort["sortid_by"]=="ip") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>Submitter's IP Address</span><span class="sorting-indicator"></span></a></th><?php
				 
				 
				 
	$n=count($rows);
	
	
	for($i=0; $i < count($labels) ; $i++)
	{
		if(strpos($lists['hide_label_list'],'@'.$labels_id[$i].'@')===false)  $styleStr='';
		else $styleStr='display:none;';
		if($sorted_labels_type[$i]=='type_address')		
			switch($label_titles_copy[$i])
			{
			case 'Street Line': $field_title=__('Street Address', 'form_maker'); break;
			case 'Street Line2': $field_title=__('Street Address Line 2', 'form_maker'); break;
			case 'City': $field_title=__('City', 'form_maker'); break;
			case 'State': $field_title=__('State / Province / Region', 'form_maker'); break;
			case 'Postal': $field_title=__('Postal / Zip Code', 'form_maker'); break;
			case 'Country': $field_title=__('Country', 'form_maker'); break;
			default : $field_title=$label_titles_copy[$i]; break;			
			}
		else
			$field_title=$label_titles_copy[$i];
			?>
           
            <th style="<?php  echo $styleStr; ?>" id="<?php  echo $labels_id[$i].'_fc';?>" class="<?php  echo $labels_id[$i].'_fc'; if($sort["sortid_by"]==$labels_id[$i]."_field") echo $sort["custom_style"].'"'; else echo $sort["default_style"].'"'; ?> "><a href="javascript:ordering('<?php echo $labels_id[$i]."_field"; ?>',<?php if($sort["sortid_by"]==$labels_id[$i]."_field") echo $sort["1_or_2"]; else echo "1"; ?>)"><span><?php echo $field_title ?></span><span class="sorting-indicator"></span></a></th>
            
<?php	}
?>
   				 <th style="width:80px">Edit</th>
                <th style="width:80px"><a href="javascript:submit_del('admin.php?page=Form_maker_Submits&task=remov_cheched')">Delete</a></th>
            </tr>
            <tr id="fields_filter" style="display:none">
                <th width="3%"></th>
                <th width="3%"></th>
				<th width="4%" class="submitid_fc" <?php if(!(strpos($lists['hide_label_list'],'@submitid@')===false)) echo 'style="display:none;"';?> ></th>
				<th  width="150" class="submitdate_fc" style="margin:inherit; <?php if(!(strpos($lists['hide_label_list'],'@submitdate@')===false)) echo 'display:none;';?>">
				<table align="center" style="margin:auto"   class="simple_table">
					<tr class="simple_table">
						<td class="simple_table" style="text-align:left">From:</td>
						<td style="text-align:center" class="simple_table"><input class="inputbox" type="text" name="startdate" id="startdate" size="15" maxlength="15" value="<?php echo $lists['startdate'];?>" /></td>
						<td style="text-align:center" class="simple_table"><input type="reset" style="width:22px" class="button" value="..." onclick="return showCalendar('startdate','%Y-%m-%d');" /></td>
					</tr>
					<tr class="simple_table">
						<td style="text-align:left" class="simple_table">To:</td>
						<td style="text-align:center" class="simple_table"><input class="inputbox" type="text" name="enddate" id="enddate" size="15" maxlength="15" value="<?php echo $lists['enddate'];?>" /></td>
						<td style="text-align:center" class="simple_table"><input type="reset" style="width:22px" class="button" value="..." onclick="return showCalendar('enddate','%Y-%m-%d');" /></td>
					</tr>
				</table>
				</th>
				<th width="100"class="submitterip_fc"  <?php if(!(strpos($lists['hide_label_list'],'@submitterip@')===false)) echo 'style="display:none;"';?>>
                 <input type="text" name="ip_search" id="ip_search" value="<?php echo $lists['ip_search'] ?>" onChange="this.form.submit();"/>
				</th>
				<?php				 
                    $n=count($rows);
					$ka_fielderov_search=false;
					
					if($lists['ip_search'] || $lists['startdate'] || $lists['enddate']){
						$ka_fielderov_search=true;
					}
					
                    for($i=0; $i < count($labels) ; $i++)
                    {
                        if(strpos($lists['hide_label_list'],'@'.$labels_id[$i].'@')===false)  
							$styleStr='';
                        else 
							$styleStr='style="display:none;"';
						
						if(!$ka_fielderov_search)
							if($lists[$form_id.'_'.$labels_id[$i].'_search'])
							{
													$ka_fielderov_search=true;
												}
												                        
                            if($sorted_labels_type[$i]!='type_mark_map')
                            echo '<th class="'.$labels_id[$i].'_fc" '.$styleStr.'>'.'<input name="'.$form_id.'_'.$labels_id[$i].'_search" id="'.$form_id.'_'.$labels_id[$i].'_search" type="text" value="'.$lists[$form_id.'_'.$labels_id[$i].'_search'].'"  onChange="this.form.submit();" >'.'</th>';
						else
							echo '<th class="'.$labels_id[$i].'_fc" '.$styleStr.'>'.'</th>';
                    }
                ?>
			<th></th><th></th>
            </tr>
        </thead>
        <?php
    $k = 0;
	$m=count($labels);
	$group_id_s= array();
	$l=0;	
	if(count($rows_ord)>0 and $m)
	for($i=0; $i <count($rows_ord); $i++)
	{
	
		$row =$rows_ord[$i];
		
		if(!in_array($row->group_id, $group_id_s))
		{
		
			array_push($group_id_s, $row->group_id);
			
		}
		
	}	
	for($www=0, $qqq=count($group_id_s); $www < $qqq ; $www++)
	{	
	$i=$group_id_s[$www];
	
		$temp= array();
		for($j=0; $j < $n ; $j++)
		{
			$row = $rows[$j];
			if($row->group_id==$i)
			{
				array_push($temp, $row);
			}
		}
		$f=$temp[0];
		$date=$f->date;
		$ip=$f->ip;
	//	$checked 	= JHTML::_('grid.id', $www, $group_id_s[$www]);
		$link="admin.php?page=Form_maker_Submits&task=edit_submit&id=".$f->group_id;
		?>

        <tr class="<?php echo "row$k"; ?>">

              <td ><?php echo $www+1;?></td>

          <th style="text-align:center" class="check-column"><input type="checkbox" name="post[]" value="<?php echo  $f->group_id; ?>"></th>
		  
<?php

if(strpos($lists['hide_label_list'],'@submitid@')===false)
echo '<td  class="submitid_fc"><a href="'.$link.'" >'.$f->group_id.'</a></td>';
else 
echo '<td  class="submitid_fc" style="display:none;"><a href="'.$link.'" >'.$f->group_id.'</a></td>';

if(strpos($lists['hide_label_list'],'@submitdate@')===false)
echo '<td  class="submitdate_fc"><a href="'.$link.'" >'.$date.'</a></td>';
else 
echo '<td  class="submitdate_fc" style="display:none;"><a href="'.$link.'" >'.$date.'</a></td>'; 

if(strpos($lists['hide_label_list'],'@submitterip@')===false)
echo '<td  class="submitterip_fc"><a href="'.$link.'" >'.$ip.'</a></td>';
else 
echo '<td  class="submitterip_fc" style="display:none;"><a href="'.$link.'" >'.$ip.'</a></td>';



//print_r($temp);
		$ttt=count($temp);
		for($h=0; $h < $m ; $h++)
		{		
			$not_label=true;
			for($g=0; $g < $ttt ; $g++)
			{			
				$t = $temp[$g];
				if(strpos($lists['hide_label_list'],'@'.$labels_id[$h].'@')===false)  $styleStr='';
				else $styleStr='style="display:none;"';
				if($t->element_label==$labels_id[$h])
				{
					
					if(strpos($t->element_value,"***map***"))
					{
						$map_params=explode('***map***',$t->element_value);
						
						$longit	=$map_params[0];
						$latit	=$map_params[1];
						
						echo  '<td align="center" class="'.$labels_id[$h].'_fc" '.$styleStr.'><a class="thickbox-preview"  href="'.admin_url('admin-ajax.php?action=frommapeditinpopup&long='.$longit.'&lat='.$latit).'&TB_iframe=1&tbWidth=630&tbHeight=650" >'.'Show on Map'."</a></td>";
					}
					else
				
					if(strpos($t->element_value,"*@@url@@*"))
					{
						$new_file=str_replace("*@@url@@*",'', str_replace("***br***",'<br>', $t->element_value));
						$new_filename=explode('/', $new_file);
						echo  '<td  class="'.$labels_id[$h].'_fc" '.$styleStr.'><a target="_blank" href="'.$new_file.'">'.$new_filename[count($new_filename)-1]."</td>";
					}
					else
						echo  '<td  class="'.$labels_id[$h].'_fc" '.$styleStr.'><pre style="font-family:inherit">'.str_replace("***br***",'<br>', $t->element_value).'</pre></td>';
						$not_label=false;
				}
			}
			if($not_label)
					echo  '<td  class="'.$labels_id[$h].'_fc" '.$styleStr.'></td>';
		}
?>
		<td><a href="javascript:submit_del('admin.php?page=Form_maker_Submits&task=edit_submit&id=<?php echo $f->group_id; ?>')">Edit</a></td>
        <td><a href="javascript:submit_del('admin.php?page=Form_maker_Submits&task=remove_submit&id=<?php echo $f->group_id; ?>')">Delete</a></td>
        </tr>

        <?php


		$k = 1 - $k;

	}

	?>

    </table>

	
	
        <?php
foreach($sorted_labels_type as $key => $label_type)
{
	if($label_type=="type_checkbox" || $label_type=="type_radio" || $label_type=="type_own_select" || $label_type=="type_country")
	{	
		?>
<br />
<br />

        <strong><?php echo $label_titles_copy[$key]?></strong>
<br />
<br />

    <?php
		$query = "SELECT element_value FROM ".$wpdb->prefix."formmaker_submits ".$where_choices." AND element_label='".$labels_id[$key]."'";
		$choices = $wpdb->get_results($query);	
	$colors=array('#2CBADE','#FE6400');
	$choices_labels=array();
	$choices_count=array();
	$all=count($choices);
	$unanswered=0;	
	foreach($choices as $key => $choice)
	{
		if($choice->element_value=='')
		{
			$unanswered++;
		}
		else
		{
			if(!in_array( $choice->element_value,$choices_labels))
			{
				array_push($choices_labels, $choice->element_value);
				array_push($choices_count, 0);
			}

			$choices_count[array_search($choice->element_value, $choices_labels)]++;
		}
	}
	array_multisort($choices_count,SORT_DESC,$choices_labels);
	?>
	<table width="95%" style="width:95%" class="wp-list-table widefat fixed posts">
		<thead>
			<tr>
				<th width="20%">Choices</th>
				<th>Percentage</th>
				<th width="10%">Count</th>
			</tr>
		</thead>
    <?php 
	foreach($choices_labels as $key => $choices_label)
	{
	?>
		<tr>
			<td><?php echo str_replace("***br***",'<br>', $choices_label)?></td>
			<td><div class="bordered" style="width:<?php echo ($choices_count[$key]/($all-$unanswered))*100; ?>%; height:18px; background-color:<?php echo $colors[$key % 2]; ?>"> </div></td>
			<td><?php echo $choices_count[$key]?></td>
		</tr>
    <?php 
	}
	
	if($unanswered){
	?>
    <tr>
    <td colspan="2" align="right">Unanswered</th>
    <td><strong><?php echo $unanswered;?></strong></th>
	</tr>

	<?php	
	}
	?>
    <tr>
    <td colspan="2" align="right"><strong>Total</strong></th>
    <td><strong><?php echo $all;?></strong></th>
	</tr>

	</table>
	<?php
	}
}
	?>

	
	
    <input type="hidden" name="boxchecked" value="0">

    <input type="hidden" name="filter_order2" value="<?php echo $lists['order']; ?>" />

    <input type="hidden" name="filter_order_Dir2" value="<?php echo $lists['order_Dir']; ?>" />

</form>

<script>
<?php if($ka_fielderov_search){?> 
document.getElementById('fields_filter').style.display='';
	<?php
 }?>
</script>

<?php


}













function html_editSubmit($rows, $labels_id ,$labels_name,$labels_type){
		?>
        
<script language="javascript" type="text/javascript">

function submitbutton(pressbutton) {
	var form = document.adminForm;

	if (pressbutton == 'cancel_submit') 
	{
	submitform( pressbutton );
	return;
	}

	submitform( pressbutton );
}
function submitform(pressbutton)
{
	
	document.getElementById('adminForm').action=document.getElementById('adminForm').action+'&task='+pressbutton;
	document.getElementById('adminForm').submit();
}
</script>        
<table width="90%">
    <tbody><tr>
  <td width="100%"><h2>Edit Submission</h2></td>
  <td align="right"><input type="button" onclick="submitbutton('save_submit')" value="Save" class="button-secondary action"> </td>  
  <td align="right"><input type="button" onclick="submitbutton('appply_submit')" value="Apply" class="button-secondary action"> </td> 
  <td align="right"><input type="button" onclick="submitbutton('cancel')" value="Cancel" class="button-secondary action"> </td> 
  </tr>
  </tbody></table>
<form action="admin.php?page=Form_maker_Submits&id=<?php echo (int) $_GET['id']; ?>" method="post" id="adminForm" name="adminForm">
<table class="admintable">
				<tr>
					<td class="key">
						<label for="ID">ID:	</label>
					</td>
					<td >
                       <?php echo $rows[0]->group_id;?>
					</td>
				</tr>
                
                <tr>
					<td class="key">
						<label for="Date">Date:
						</label>
					</td>
					<td >
                       <?php echo $rows[0]->date;?>
					</td>
				</tr>
                <tr>
					<td class="key">
						<label for="IP">IP:</label>
					</td>
					<td >
                       <?php echo $rows[0]->ip;?>
					</td>
                </tr>
                
<?php 
foreach($labels_id as $key => $label_id)
{
	if($labels_type[$key]!='type_editor'  and  $labels_type[$key]!='type_submit_reset' and $labels_type[$key]!='type_map' and $labels_type[$key]!='type_mark_map' and $labels_type[$key]!='type_captcha' and $labels_type[$key]!='type_recaptcha' and $labels_type[$key]!='type_button')
	{
		$element_value='';
		foreach($rows as $row)
		{
			if($row->element_label==$label_id)
			{		
				$element_value=	$row->element_value;
				break;
			}
		}
		if($labels_type[$key]!='type_checkbox')
		echo '		<tr>
						<td class="key">
							<label for="title">
								'.$labels_name[$key].'
							</label>
						</td>
						<td >
							<input type="text" name="submission_'.$label_id.'" id="submission_'.$label_id.'" value="'.str_replace("*@@url@@*",'',$element_value).'" size="80" />
						</td>
					</tr>
					';
		else
		{
			$choices	= explode('***br***',$element_value);
			$choices 	= array_slice($choices,0, count($choices)-1);   
		echo '		<tr>
						<td class="key" rowspan="'.count($choices).'">
							<label for="title">
								'.$labels_name[$key].'
							</label>
						</td>';
			foreach($choices as $choice_key => $choice)
		echo '
						<td >
							<input type="text" name="submission_'.$label_id.'_'.$choice_key.'" id="submission_'.$label_id.'_'.$choice_key.'" value="'.$choice.'" size="80" />
						</td>
					</tr>
					';
		}
	}
}

?>
 </table>        
<input type="hidden" name="option" value="com_formmaker" />
<input type="hidden" name="id" value="<?php echo $rows[0]->group_id?>" />        
<input type="hidden" name="form_id" value="<?php echo $rows[0]->form_id?>" />        
<input type="hidden" name="date" value="<?php echo $rows[0]->date?>" />        
<input type="hidden" name="ip" value="<?php echo $rows[0]->ip?>" />        
<input type="hidden" name="task" value="save_submit" />        
</form>
        <?php		
       

	
	
}
























?>