<style type="text/css" media="screen">
<!--/*--><![CDATA[/*><!--*/
<?php if (strlen($this->wrapperWidth) && strlen($this->wrapperMargins)):
	echo $this->wrapperSelector ?> { <?php if (strlen($this->wrapperWidth)):
	?>width: <?php echo $this->wrapperWidth; ?>;<?php endif; ?> <?php if (strlen($this->wrapperMargins)):
	?>margin: <?php echo $this->wrapperMargins; ?>;<?php endif; ?> }
<?php endif; ?>
<?php if (strlen($this->headerHeight)):
	echo $this->headerSelector ?> { height: <?php echo $this->headerHeight; ?>; }
<?php endif; ?>
<?php echo $this->leftSelector ?> { <?php if (strlen($this->mainMarginLeft)):
	?>width: <?php echo $this->mainMarginLeft; endif; ?>; }
<?php echo $this->rightSelector ?> { <?php if (strlen($this->mainMarginRight)):
	?>width: <?php echo $this->mainMarginRight; endif; ?>; }
<?php echo $this->mainSelector ?> { <?php if (strlen($this->mainMarginLeft)):
	?>margin-left: <?php echo $this->mainMarginLeft; ?>;<?php endif; ?> <?php if (strlen($this->mainMarginRight)): ?>margin-right: <?php echo $this->mainMarginRight; ?>;<?php endif; ?> }
<?php if (strlen($this->footerHeight)):
	echo $this->footerSelector ?> { height: <?php echo $this->footerHeight; ?>; }
<?php endif; ?>
/*]]>*/-->
</style>