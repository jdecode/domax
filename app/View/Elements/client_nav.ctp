 <div id="ddtopmenubar" class="mattblackmenu">

                        <!-- start top navigation bar -->
                        <ul>
                            <li><?php echo $this->Html->link('Home',array('controller'=>'pages','action'=>'display')); ?></li>
                            <li><?php echo $this->Html->link('Products','#'); ?></li>
                            <li><?php echo $this->Html->link('Services','#',array('rel'=>'ddsubmenu1')); ?></li>
                            <li><?php echo $this->Html->link('Portfolio','#'); ?></li>
                            <li><?php echo $this->Html->link('About Us','#'); ?></li>
                            <li><?php echo $this->Html->link('Contact','#'); ?></li>
                             <li><a  href="#">Support</a></li>
                            <li><?php echo $this->Html->link('File Download',array('controller'=>'users','action'=>'index')); ?></li>
                           
                            <?php if(isset($_SESSION['Auth']['User']['id'])) {?>
                            <li><?php echo $this->Html->link('Change Password',array('controller'=>'users','action'=>'changepassword')); ?></li>
                             <li><?php echo $this->Html->link('Logout',array('controller'=>'users','action'=>'logout'),array('style'=>'background-image: none;')); ?></li>
                            <?php } ?>
                            
                        </ul>
                        <!-- end top navigation bar -->
                    </div>



                    <script type="text/javascript">
                        ddlevelsmenu.setup("ddtopmenubar", "topbar") //ddlevelsmenu.setup("mainmenuid", "topbar|sidebar")
                    </script>

                    <ul id="ddsubmenu1" class="ddsubmenustyle">
                        <li><a href="#">Item 1a</a></li>
                        <li><a href="#">Item 2a</a></li>
                        <li><a href="#">Item 4a</a></li>
                        <li><a href="#">Item Folder 5a</a>

                    </ul>
