<?php
/**
 * @subpackage        tpl_shoplab
 * @copyright        Copyright (C) 2011 Linelab.org. All rights reserved.
 * @license          GNU General Public License version 3
 */
defined('_JEXEC') or die;
define( 'YOURBASEPATH', dirname(__FILE__) );  
JHtml::_('behavior.framework', true);
$left_width = $this->params->get("leftWidth", "245");
$right_width = $this->params->get("rightWidth", "245");
$temp_width = $this->params->get("templateWidth", "960"); 
$col_mode = "s-c-s";
$licence = "LineLab.org";
if ($left_width==0 and $right_width>0) $col_mode = "x-c-s";
if ($left_width>0 and $right_width==0) $col_mode = "s-c-x";
if ($left_width==0 and $right_width==0) $col_mode = "x-c-x";
$temp_width = 'margin: 0 auto; width: ' . $temp_width . 'px;';
$slide	= $this->params->get('display_slideshow', 0);
$slidecontent		= $this->params->get('slideshow', ''); 
$sitetitle = $this->params->get("sitetitle", "ShopLab Free Joomla Template 2.5 - Linelab.org"); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
<head>
<?php
require(YOURBASEPATH . DS . "tools.php");
?>
<jdoc:include type="head" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/shoplab/css/styles.css" type="text/css" media="screen,projection" />
<script language="javascript" type="text/javascript">	
	window.addEvent('domready', function(){	
	  	var top_panel = document.id('top-panel');
		var sub_panel = document.id('sub-panel');
		var topFx = new Fx.Slide(top_panel);
		if (Cookie.read('top-panel') == '1') {
			topFx.show();
		} else {
			topFx.hide();			
		}
		sub_panel.addEvents({
			'click' : function(){
				if (topFx.open) {
					Cookie.write('top-panel', '0');
				} else {
					Cookie.write('top-panel', '1');
				}
				topFx.toggle();
			}
		});
	});	
</script>

</head>
<body>
<div class="topground"></div>
<div id="main"> 
	<div id="wrapper">
	    <div id="header"><div class="headtop"><div id="top-panel"> 
<div class="currency"><jdoc:include type="modules" name="currency" style="none"/></div><div class="currency2"><jdoc:include type="modules" name="custom" style="none"/></div><div class="clr"></div>
       </div>
        <div id="sub-panel">
<a href="#"><img src="<?php echo $this->baseurl ?>/templates/shoplab/images/carttop.png" alt="" /></a>
</div></div>
	            <div class="logo">	
    	    <a href="http://www.linelab.org/virtuemart-templates/index.php?template=shoplab" id="logo" title="<?php echo $sitetitle ?>" ><img src="<?php echo $this->baseurl ?>/templates/shoplab/images/logo.png" alt="Joomla Templates 2.5" /></a>
	      </div><div class="kosik"><jdoc:include type="modules" name="cartkos" style="none"/></div>
    	   <?php if ($this->countModules('top')) : ?> <div class="supertop"><div class="left"></div><div class="arm"><jdoc:include type="modules" name="top" style="none"/></div><div class="clr"></div></div>     <?php endif; ?> 
  	</div>
	<div id="navigace"><div class="levy">
<img alt="" src="templates/shoplab/images/levy.png" />
</div>   <div class="pravy">
<img alt="virtuemart templates" src="templates/shoplab/images/pravy.png" />
</div>	
		    <jdoc:include type="modules" name="position-1x" style="none"/>
			<jdoc:include type="modules" name="position-0" style="none"/></div>
		<div id="message">
		    <jdoc:include type="message" />
		</div>
		<?php if ($this->countModules('position-150')) : ?>
		    <div id="slide">
            <div class="sli">
		<?php if ($slide == 1) { ?>
	<jdoc:include type="modules" name="position-150" style="none"/>
		    		<?php } else { ?>
		    <img src="<?php echo $this->baseurl ?>/<?php echo $slidecontent; ?>" alt="" /> 
		<?php } ?>  </div> 
</div> 		<?php if ($this->countModules('position-3 or position-4 or position-5')) : ?>
		<div id="main2" class="spacer2<?php echo $main2_width; ?>">
			<jdoc:include type="modules" name="position-3" style="xhtml"/>
			<jdoc:include type="modules" name="position-4" style="xhtml"/>
			<jdoc:include type="modules" name="position-5" style="xhtml"/>
			</div><div class="line4"></div>    	
		<?php endif; ?>  	<?php endif; ?>
        <div id="main-content" class="<?php echo $col_mode; ?>">
            <div id="colmask">
                <div id="colmid">
                    <div id="colright">
                        <div id="col1wrap">
							<div id="col1pad">
                            	<div id="col1">
									<?php if ($this->countModules('position-2')) : ?>
									<?php endif; ?>
<?php  if ($frontpage != 1) {
 if ($menu->getActive() !== $menu->getDefault()) { ?>
<div class="component"><div class="breadcrumbs-pad">
                                        <jdoc:include type="modules" name="position-2" />
                                    </div><jdoc:include type="component" /></div>
             <?php }
                  } else {
                         ?> 
<div class="component"><div class="breadcrumbs-pad">
                                        <jdoc:include type="modules" name="position-2" />
                                    </div><jdoc:include type="component" /></div>
                 <?php 
                     }
                    ?>
									<?php if ($this->countModules('position-8')) : ?>
									<div class="spacer">
										<jdoc:include type="modules" name="position-8" style="xhtml"/>
									</div>
									<?php endif; ?>
	                            </div>
							</div>
                        </div>
						<?php if ($left_width != 0) : ?>
                        <div id="col2">
                        	<jdoc:include type="modules" name="position-7" style="rest"/>
                        </div>
						<?php endif; ?>
						<?php if ($right_width != 0) : ?>
                        <div id="col3">
                        	<jdoc:include type="modules" name="position-6" style="rest"/>
                        </div>
						<?php endif; ?>
                    </div>
                </div>
            </div>
        <?php if ($this->countModules('position-9 or position-10 or position-11')) : ?>
		<div id="main3" class="spacer<?php echo $main3_width; ?>">
			<jdoc:include type="modules" name="position-9" style="xhtml"/>
			<jdoc:include type="modules" name="position-10" style="xhtml"/>
			<jdoc:include type="modules" name="position-11" style="xhtml"/>
</div>
			<?php endif; ?>  	<div id="footer">
		<jdoc:include type="modules" name="footerload" style="none" />
		<div class="copy">
		<!-- Do not remove this line! Read more http://www.linelab.org/download -->
		Copyright&nbsp;&copy; <?php echo date( '2010 - Y' ); ?> <?php echo $sitetitle; ?>. Design by <a target="_blank"  title="VirtueMart Templates" href="http://www.linelab.org"><?php echo $licence; ?></a>
    </div>
    <div id="debug">
	<jdoc:include type="modules" name="debug" style="none" />
	</div>
</div>
        </div>	
	  </div>
						</div> 
   </body>
  </html>
