<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<!--BEGIN Search Box -->
<form action="<?php echo JRoute::_('index.php?option=com_virtuemart&view=category&search=true&limitstart=0&virtuemart_category_id='.$category_id ); ?>" method="get">
<div class="search<?php echo $moduleclass_sfx ?>">
<?php $output = '<input name="keyword" id="mod_virtuemart_search" maxlength="'.$maxlength.'" alt="'.$button_text.'" class="inputbox'.$moduleclass_sfx.'" type="text" size="'.$width.'" value="'.$text.'"  onblur="if(this.value==\'\') this.value=\''.$text.'\';" onfocus="if(this.value==\''.$text.'\') this.value=\'\';" />'; 
 $image = JURI::base().'templates/shoplab/images/vmgeneral/buttonsearch.png' ;
			if ($button) :
			    if ($imagebutton) :
			        $button = '<input style="vertical-align :middle;height:16px; width:16px;background: none !important; padding-top: 10px; margin-left: -26px;" type="image" value="'.$button_text.'" class="button'.$moduleclass_sfx.'" src="'.$image.'" onclick="this.form.keyword.focus();"/>';
			    else :
			        $button = '<input type="submit" value="'.$button_text.'" class="button'.$moduleclass_sfx.'" onclick="this.form.keyword.focus();"/>';
			    endif;
			endif;
			switch ($button_pos) :
			    case 'top' :
				    $button = $button.'<br />';
				    $output = $button.$output;
				    break;
			    case 'bottom' :
				    $button = '<br />'.$button;
				    $output = $output.$button;
				    break;
			    case 'right' :
				    $output = $output.$button;
				    break;
			    case 'left' :
			    default :
				    $output = $button.$output;
				    break;
			endswitch;
			echo $output;
?>
</div>
		<input type="hidden" name="search" value="true" />
		<input type="hidden" name="limitstart" value="0" />
		<input type="hidden" name="category" value="0" />
		<input type="hidden" name="option" value="com_virtuemart" />
		<input type="hidden" name="view" value="category" />
	  </form>
<!-- End Search Box -->