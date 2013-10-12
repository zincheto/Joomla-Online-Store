<?php
/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @subpackage
 * @author Max Milbers, Eugen Stranz
 * @author RolandD,
 * @todo handle child products
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default.php 3934 2011-08-23 22:59:12Z electrocity $
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );

// addon for joomla modal Box
JHTML::_ ( 'behavior.modal' );
// JHTML::_('behavior.tooltip');
$url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id='.$this->product->virtuemart_product_id.'&virtuemart_category_id='.$this->product->virtuemart_category_id.'&tmpl=component');
$document = &JFactory::getDocument();
$document->addScriptDeclaration("
	jQuery(document).ready(function($) {
		$('a.ask-a-question').click( function(){
			$.facebox({
				iframe: '".$url."',
				rev: 'iframe|550|550'
			});
			return false ;
		});
	/*	$('.additional-images a').mouseover(function() {
			var himg = this.href ;
			var extension=himg.substring(himg.lastIndexOf('.')+1);
			if (extension =='png' || extension =='jpg' || extension =='gif') {
				$('.main-image img').attr('src',himg );
			}
			console.log(extension)
		});*/
	});
");
/* Let's see if we found the product */
if (empty ( $this->product )) {
	echo JText::_ ( 'COM_VIRTUEMART_PRODUCT_NOT_FOUND' );
	echo '<br /><br />  ' . $this->continue_link_html;
	return;
}

?>
<div class="productdetails-view">
<?php // Product Navigation
	if (VmConfig::get ( 'product_navigation', 1 )) { ?>
		<div class="product-neighbours">
		<?php
		if (! empty ( $this->product->neighbours ['previous'][0] )) {
			$prev_link = JRoute::_ ( 'index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours ['previous'][0] ['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id );
			echo JHTML::_ ( 'link', $prev_link, $this->product->neighbours ['previous'][0]
			['product_name'], array ('class' => 'previous-page' ) );
		}
		if (! empty ( $this->product->neighbours ['next'][0] )) {
			$next_link = JRoute::_ ( 'index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours ['next'][0] ['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id );
			echo JHTML::_ ( 'link', $next_link, $this->product->neighbours ['next'][0] ['product_name'], array ('class' => 'next-page' ) );
		}
		?>
		<div class="clear"></div>
		</div>
	<?php } // Product Navigation END ?>
	<?php // PDF - Print - Email Icon
    if (VmConfig::get('show_emailfriend') || VmConfig::get('show_printicon') || VmConfig::get('pdf_button_enable')) { ?>
	 <div class="icons">
	    <?php
	    //$link = (JVM_VERSION===1) ? 'index2.php' : 'index.php';
	    $link = 'index.php?tmpl=component&option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->virtuemart_product_id;
	    $MailLink = 'index.php?option=com_virtuemart&view=productdetails&task=recommend&virtuemart_product_id=' . $this->product->virtuemart_product_id . '&virtuemart_category_id=' . $this->product->virtuemart_category_id . '&tmpl=component';

	    if (VmConfig::get('pdf_icon', 1) == '1') {
		echo $this->linkIcon($link . '&format=pdf', 'COM_VIRTUEMART_PDF', 'pdf_button', 'pdf_button_enable', false);
	    }
	    echo $this->linkIcon($link . '&print=1', 'COM_VIRTUEMART_PRINT', 'printButton', 'show_printicon');
	    echo $this->linkIcon($MailLink, 'COM_VIRTUEMART_EMAIL', 'emailButton', 'show_emailfriend');
	    ?>
    	<div class="clear"></div>
        </div>
	<?php

	} // PDF - Print - Email Icon END  ?>
		<?php // Product Edit Link
	echo $this->edit_link;
	// Product Edit Link END ?>

		<div class="detailobrazek">
		<?php // Product Main Image
		if (!empty($this->product->images[0])) { ?>
			<div class="main-image">
			<?php echo $this->product->images[0]->displayMediaFull('class="medium-image" id="medium-image"',true,'class="modal"',true,true); ?>  
			</div>
		<?php } // Product Main Image END ?>
	<?php
// Showing The Additional Images
// if(!empty($this->product->images) && count($this->product->images)>1) {
if (!empty($this->product->images)) {
    ?>
    <div class="additional-images">
	<?php
	// List all Images
	if (count($this->product->images) > 0) {
	    foreach ($this->product->images as $image) {
		echo '<div class="floatleft" style="padding:5px">' . $image->displayMediaThumb('class="product-image"', true, 'class="modal"', true, true) . '</div>'; //'class="modal"'
	    }
	}
	?>
        <div class="clear"></div>
    </div>
<?php
} // Showing The Additional Images END ?>
</div>
		<div class="popisdetail">
		<?php // Product Title   ?>
    <h1><?php echo $this->product->product_name ?></h1>
    <?php // Product Title END   ?>
<?php // afterDisplayTitle Event
    echo $this->product->event->afterDisplayTitle ?>
    
			<?php // Product Short Description
	if (!empty($this->product->product_s_desc)) { ?>
	<div class="product-short-description">
		<?php /** @todo Test if content plugins modify the product description */
		echo $this->product->product_s_desc; ?>
	</div>
	<?php } // Product Short Description END ?>
		
			<div class="spacer-buy-area">
<?php
		if ($this->showRating) {
		    $maxrating = VmConfig::get('vm_maximum_rating_scale', 5);

		    if (empty($this->rating)) {
			?>
		<span class="vote"><?php echo JText::_('COM_VIRTUEMART_RATING') . ' ' . JText::_('COM_VIRTUEMART_UNRATED') ?></span> <br />
			    <?php
			} else {
			    $ratingwidth = ( $this->rating->rating * 100 ) / $maxrating; //I don't use round as percetntage with works perfect, as for me
			    ?>
			<span class="vote">
	<?php echo JText::_('COM_VIRTUEMART_RATING') . ' ' . round($this->rating->rating, 2) . '/' . $maxrating; ?><br />
			    <span title=" <?php echo (JText::_("COM_VIRTUEMART_RATING_TITLE") . $this->rating->rating . '/' . $maxrating) ?>" class="vmicon ratingbox" style="display:inline-block;">
				<span class="stars-orange" style="width:<?php echo $ratingwidth.'%'; ?>">
				</span>
			    </span>
			</span>
			<?php
		    }
		}
		if (is_array($this->productDisplayShipments)) {
		    foreach ($this->productDisplayShipments as $productDisplayShipment) {
			echo $productDisplayShipment . '<br />';
		    }
		}
		if (is_array($this->productDisplayPayments)) {
		    foreach ($this->productDisplayPayments as $productDisplayPayment) {
			echo $productDisplayPayment . '<br />';
		    }
		}
		// Product Price
		if ($this->show_prices and (empty($this->product->images[0]) or $this->product->images[0]->file_is_downloadable == 0)) {
		    echo $this->loadTemplate('showprices');
		}
		?>
				<?php // Add To Cart Button
				if (!VmConfig::get('use_as_catalog',0)) { ?>
				<div class="addtocart-area">
					<form method="post" class="product" action="index.php" id="addtocartproduct<?php echo $this->product->virtuemart_product_id ?>">  
									<?php // Product custom_fields
	if (!empty($this->product->customfieldsCart)) {  ?>
	<div class="product-fields">
		<?php foreach ($this->product->customfieldsCart as $field)
		{ ?><div class="product-field product-field-type-<?php echo $field->field_type ?>">
			<span class="product-fields-title" ><strong><?php echo  JText::_($field->custom_title) ?></strong></span>
			<?php echo JHTML::tooltip($field->custom_tip,  JText::_($field->custom_title), 'tooltip.png'); ?>
			<div class="field-display"><span class="product-field-display"><?php echo $field->display ?></span></div>
			<span class="product-field-desc"><?php echo $field->custom_field_desc ?></span>
			</div><br />
			<?php
		}
		?>
	</div>
	<?php }  ?>
		<div class="addtocart-bar">
			<?php // Display the quantity box ?>
			<!-- <label for="quantity<?php echo $this->product->virtuemart_product_id;?>" class="quantity_box"><?php echo JText::_('COM_VIRTUEMART_CART_QUANTITY'); ?>: </label> -->
			<div class="quantity-controls-add">
				<input type="button" class="quantity-controls quantity-plus" />
				</div><div class="quantity-box">
				<input type="text" class="quantity-input" name="quantity[]" value="1" />
			</div><div class="quantity-controls-remove">
				<input type="button" class="quantity-controls quantity-minus" />
			</div>
			<?php // Display the quantity box END ?>
			<?php // Add the button
			$button_lbl = JText::_('COM_VIRTUEMART_CART_ADD_TO');
			$button_cls = ''; //$button_cls = 'addtocart_button';
			if (VmConfig::get('check_stock') == '1' && !$this->product->product_in_stock) {
				$button_lbl = JText::_('COM_VIRTUEMART_CART_NOTIFY');
				$button_cls = 'notify-button';
			} ?>
			<?php // Display the add to cart button ?>
			<span class="addtocart-button">
				<input type="submit" name="addtocart"  class="addtocart-button" value="<?php echo $button_lbl ?>" title="<?php echo $button_lbl ?>" />
			</span>
		<div class="clear"></div>
		</div>
		<?php // Display the add to cart button END ?>
		<input type="hidden" class="pname" value="<?php echo $this->product->product_name ?>">
		<input type="hidden" name="option" value="com_virtuemart" />
		<input type="hidden" name="view" value="cart" />
		<noscript><input type="hidden" name="task" value="add" /></noscript>
		<input type="hidden" name="virtuemart_product_id[]" value="<?php echo $this->product->virtuemart_product_id ?>" />
		<?php /** @todo Handle the manufacturer view */ ?>
		<input type="hidden" name="virtuemart_manufacturer_id" value="<?php echo $this->product->virtuemart_manufacturer_id ?>" />
		<input type="hidden" name="virtuemart_category_id[]" value="<?php echo $this->product->virtuemart_category_id ?>" />
	</form>
				<div class="clear"></div>
				</div>
			<?php }  // Add To Cart Button END ?>
<?php
// Ask a question about this product
if (VmConfig::get('ask_question', 1) == '1') {
    ?>
    		<div class="ask-a-question">
    		    <a class="ask-a-question" href="<?php echo $url ?>" ><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ENQUIRY_LBL') ?></a>
    		</div>
		<?php }
		?>  
			</div>
			<?php // Availability Image
				/* TO DO add width and height to the image */
				if (!empty($this->product->product_availability)) { ?>
				<div class="availability">
					<?php echo JHTML::image(JURI::root().VmConfig::get('assets_general_path').'images/availability/'.$this->product->product_availability, $this->product->product_availability, array('class' => 'availability')); ?>
				</div>
				<?php } ?>
								<?php // Manufacturer of the Product
				if(VmConfig::get('show_manufacturer', 1) && !empty($this->product->virtuemart_manufacturer_id)) { ?>
				<div class="manufacturer">
				<?php
					$link = JRoute::_('index.php?option=com_virtuemart&view=manufacturer&virtuemart_manufacturer_id='.$this->product->virtuemart_manufacturer_id.'&tmpl=component');
					$text = $this->product->mf_name;
					/* Avoid JavaScript on PDF Output */
					if (strtolower(JRequest::getWord('output')) == "pdf"){
						echo JHTML::_('link', $link, $text);
					} else { ?>
						<span class="bold"><?php echo JText::_('COM_VIRTUEMART_PRODUCT_DETAILS_MANUFACTURER_LBL') ?></span> <a class="modal" rel="{handler: 'iframe', size: {x: 700, y: 550}}" href="<?php echo $link ?>"><?php echo $text ?></a>
				<?php } ?>
				</div>
				<?php } ?>	
		</div>
	<div class="clear"></div>
	<?php // Product Description
	if (!empty($this->product->product_desc)) { ?>
	<div class="product-description">
		<?php /** @todo Test if content plugins modify the product description */ ?>
		<h4><?php echo JText::_('COM_VIRTUEMART_PRODUCT_DESC_TITLE') ?></h4>
		<?php echo $this->product->product_desc; ?>
	</div>
	<?php } // Product Description END 
if (!empty($this->product->customfieldsSorted['normal'])) {
	$this->position = 'normal';
	echo $this->loadTemplate('customfields');
    } // Product custom_fields END
    // Product Packaging
    $product_packaging = '';
    if ($this->product->packaging || $this->product->box) {
	?>
<div class="product-packaging">
<?php
	    if ($this->product->packaging) {
		$product_packaging .= JText::_('COM_VIRTUEMART_PRODUCT_PACKAGING1') . $this->product->packaging;
		if ($this->product->box)
		    $product_packaging .= '<br />';
	    }
	    if ($this->product->box)
		$product_packaging .= JText::_('COM_VIRTUEMART_PRODUCT_PACKAGING2') . $this->product->box;
	    echo str_replace("{unit}", $this->product->product_unit ? $this->product->product_unit : JText::_('COM_VIRTUEMART_PRODUCT_FORM_UNIT_DEFAULT'), $product_packaging);
	    ?>
        </div>
    <?php } // Product Packaging END
    ?>  
<div class="clear"></div>	
    <?php
    if (!empty($this->product->customfieldsRelatedProducts)) {
	echo $this->loadTemplate('relatedproducts');
    } // Product customfieldsRelatedProducts END
    ?>
<div class="clear"></div>	
	<?php // Show child categories
	if ( VmConfig::get('showCategory',1) ) {
		if ($this->category->haschildren) {
			$iCol = 1;
			$iCategory = 1;
			$categories_per_row = VmConfig::get ( 'categories_per_row', 3 );
			$category_cellwidth = ' width'.floor ( 100 / $categories_per_row );
			$verticalseparator = " vertical-separator"; ?>
      	<div class="product-related-categories">
 	<h4><?php echo JText::_('COM_VIRTUEMART_RELATED_CATEGORIES') ?></h4>  
		<div class="category-view">
			<?php // Start the Output
			if(!empty($this->category->children)){
			foreach ( $this->category->children as $category ) {
			// Show the horizontal seperator
			if ($iCol == 1 && $iCategory > $categories_per_row) { ?>
				<div class="horizontal-separator"></div>
			<?php }
			// this is an indicator wether a row needs to be opened or not
			if ($iCol == 1) { ?>
			<div class="row">
			<?php }
			// Show the vertical seperator
			if ($iCategory == $categories_per_row or $iCategory % $categories_per_row == 0) {
				$show_vertical_separator = ' ';
			} else {
				$show_vertical_separator = $verticalseparator;
			}
			// Category Link
			$caturl = JRoute::_ ( 'index.php?option=com_virtuemart&view=category&virtuemart_category_id=' . $category->virtuemart_category_id );
				// Show Category ?>
				<div class="category floatleft<?php echo $category_cellwidth . $show_vertical_separator ?>">
					<div class="spacer">
						<h2>
							<a href="<?php echo $caturl ?>" title="<?php echo $category->category_name ?>">
							<?php echo $category->category_name ?>
							<br />
							<?php // if ($category->ids) {
								echo $category->images[0]->displayMediaThumb("",false);
							//} ?>
							</a>
						</h2>
					</div>
				</div>
			<?php
			$iCategory ++;
			// Do we need to close the current row now?
			if ($iCol == $categories_per_row) { ?>
			<div class="clear"></div>
			</div>
			<?php
			$iCol = 1;
			} else {
				$iCol ++;
			}
		}
		}
		// Do we need a final closing row tag?
		if ($iCol != 1) { ?>
			<div class="clear"></div>
			</div></div> 
		<?php } ?>
		</div>
	<?php }
	} ?>
	<?php
echo $this->loadTemplate('reviews');
?>
</div>