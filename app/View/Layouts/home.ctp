<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>

            <?php echo $title_for_layout; ?>
        </title>
        <?php
        echo $this->Html->meta('icon');
        echo $this->Html->script(array('ddlevelsmenu'));
        echo $this->Html->css(array('fontstyle', 'ddlevelsmenu-base', 'ddlevelsmenu-topbar', 'ddlevelsmenu-sidebar'));

        echo $scripts_for_layout;
        ?>
    </head>
    <body>
        <div id="container">
            <div id="body_space">
                <div id="header">
                    <div style="float:left; padding-left:10px;">
                        <?php echo $this->Html->link($this->Html->image('CA_LOGO1.jpg',array('width'=>'144','height'=>'108')),array('controller'=>'pages','action'=>'display'),array('escape'=>false)); ?>
                    </div>
                    <div id="logo-block">
                        <!-- type your logo and small slogan here -->
                        <p id="logo">Him Soft Solution India <span class="logoblue"></span></p>
                        <p id="slogan">Client Documents Management System</p>
                        <!-- end logo and small slogan -->
                    </div>

                 <!--   <?php echo $this->Html->image('dna.png', array('width' => '160')); ?> -->
                    <div class="cls"></div>
                    <?php echo $this->element('client_nav'); ?>
                </div>
                <div id="clouds">
                </div>

            </div>
        </div>
        <div id="page">
            <div id="page-padding">
                <!-- start content -->	    
                <div id="content">
                    <?php echo $this->Session->flash();
                    echo $content_for_layout; ?>
                </div>
                <!-- end content -->
                <?php echo $this->element('right_nav'); ?>
            </div>

            <div id="footer">
                <div id="footer-pad">
                    <div class="line"></div>
                    <!-- footer and copyright notice -->
                    <p>This site is &copy; Copyright website name 2011, All rights reserved.  Design by <a href="http://www.himsoftsolution.com">Him Soft Solution </a>.</p>
                    <!-- end footer and copyright notice -->
                </div>
            </div>
        </div>
    </body>
    <?php // echo $this->Session->flash(); 
    //		 echo $content_for_layout;  echo $this->element('sql_dump'); ?>
</html>