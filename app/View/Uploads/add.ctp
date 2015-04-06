
<style>
	.AudioRemove span{display: inline-block;}
</style>
<script>
	$(document).ready(function() {
		//alert("Asd");
		/* $("#UploadAdminAddForm").submit(function(){
		 if($('#UploadDropDown').val()==''){
		 $('#errror').html('<div class="message" id="flashMessage">Select drop down firstly.</div>');
		 return false;
		 } else{
		 return true;
		 }      
		 });*/
		$('#UploadDropDown').change(function() {
			var action_id = $('#UploadDropDown').val();

			$.ajax({
				type: 'POST',
				data: 'action_id=' + action_id,
				url: '<?php echo $this->base ?>/uploads/ajax',
				success: function(resp) {
					$("#response").html(resp);
				}
			});


		});
	});

	$(document).ready(function() {

		var MaxInputsAudio = 8; //maximum input boxes allowed
		var InputsWrapper = $("#AudioWrapper input"); //Input boxes wrapper ID
		var AddButton = "#AddMoreAudio"; //Add button ID

		var x = InputsWrapper.length; //initlal text box count
		var FieldCount = 1; //to keep track of text box added

		$(AddButton).click(function(e) //on add input button click
		{
			e.preventDefault();
			InputsWrapper = $("#AudioWrapper input");
			x = InputsWrapper.length;
			console.log(x + '  ' + MaxInputsAudio);
			if (x < MaxInputsAudio) //max input box allowed
			{
				FieldCount++; //text box added increment
				//add input box
				$(InputsWrapper).parents('#AudioWrapper').append('<div class="AudioRemove" style ="float:left;margin-top:20px;width:100%;"><span><div class="input file"><input id="audio" onclick="openKCFinder(this)"  type="file" name="data[Upload][filename][]"/></div></span>\n\
	<span><button href="#" style="margin-top:-4px;" class="removeclassAudio btn btn-sm btn-danger fa fa-minus alerts-color"></button>\n\
</span></div>');
				x++; //text box increment
			}
			return false;
		});

		$("body").on("click", ".removeclassAudio", function(e) { //user click on remove text
			console.log(x);
			if (x > 1) {
				$(this).parents('.AudioRemove').remove(); //remove text box
				x--; //decrement textbox
			}
			return false;
		})

	});
	
	$(document).ready(function(){
	$('.draft').click(function(){
	if($(this).is(':checked')){
		$('.d-d').hide();
	$('.drop').show();
		}else{
	$('.d-d').show();
	$('.drop').hide();
	}
		
		
	
	});
	$('.drop').hide();
	});

</script>
<?php
//pr($_folders);
$options=array(0=>"Upload");
foreach($_folders as $_folder){
	foreach($_folder as $data){
		//pr($data);
		$options[$data['id']]=$data['Name'];
	}
	
}
//pr($options);
   ?>

<div class="col-lg-8 form-main">
	<div class="form-panel">
		<h4 class="mb"><i class="fa fa-angle-right"></i>Add Upload</h4>
		<?php echo $this->Form->create('Upload', array("class" => "form-horizontal style-form", "id" => "UploadAdminAddForm", "enctype" => "multipart/form-data")); ?>
		<div class="form-group save-as-draft ">
			<div class="row">
			<div class="col-md-3"><label class="control-label">Save as draft</label></div>
			<div class="col-md-9"><?php echo $this->Form->input('checkbox', array('label' => false, 'type' => 'checkbox', 'class'=> 'draft')); ?></div>
			</div>
			<div class="row drop">
				<div class="col-md-3"><label class="control-label">Choose Folder:</label></div>
				<div class ="col-md-9">
			<?php echo $this->Form->input('folder_id][', array('label' => false, 'type' => 'select', 'id' => '', 'options' => $options)); ?>	
			</div>
			</div>
			
		</div>
		



		<div class="form-group d-d">
			<label class="col-sm-3 col-sm-3 control-label">Drop Down</label>
			<div class="col-sm-9">
		<?php echo $this->Form->input('drop_down', array('label' => '', 'type' => 'select', 'id' => 'UploadDropDown', 'options' => array('' => '--select--','1' => 'Customer', '2' => 'File No', '3' => 'PanCard', '4' => 'Bussiness Name', '5' => 'staff', '6' => 'Admin'))); ?>
			</div>
		</div>

		<div class="form-group">
			<div id="response" class=""></div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 col-sm-3 control-label">File</label>
			<div class="col-sm-9">


<div class="input-group input-group-md">	<!--<span class="input-group-addon"><a class="help-box" rel="popover" data-placement="top" data-original-title="" data-content=""><i class=" icon-music"></i></a></span>-->

                    <div id="AudioWrapper">
                        <!--<div class="AudioRemove" style="position:relative;clear:both;"><div style="float: left; width: 100%;"><input id="audio" onclick="openKCFinder(this)" class="form-control" type="text" name="audio[]"/></div></div>-->
                        <div class="AudioRemove" style="position:relative;clear:both;">
							<div style="float: left; width: 100%;">
								<span><?php echo $this->Form->input('filename][', array('label' => false, 'type' => 'file', 'id' => 'audio', 'onclick' => 'openKCFinder(this);')); ?></span>


								<span>	<button href="#" class="removeclassAudio btn btn-danger btn-sm fa fa-minus alerts-color"></button></span>
							</div>

							<!--<div style="float: left; position: absolute; left: -31px;top:35px;"><button href="#" class="removeclassAudio btn btn-danger btn-sm fa fa-minus alerts-color"></button></div>-->
						</div>
					</div>

                </div><button style="float:right;margin-top: 15px;margin-right:20px;" href="#" id="AddMoreAudio" class=" btn btn-sm btn-primary fa fa-plus margin-top-8">Add</button>

			</div>

		</div>
	</div>
	<style>
		.form-group.save-as-draft {
			display: inline-block;
			width: 100%;
			float: left;
			box-sizing: border-box;
			padding: 10px 0;


		}
		.checkbox{
			margin-top:0px;
			margin-left:15px;
		}
		.col-lg-8.form-main {
			background-color: #FFF;
			margin: 0 20px;
			padding:20px;

		}
		.form-panel {
			background: transparent;
			margin: 10px;
			padding: 10px;
			box-shadow: none;
			text-align: left;
		}
		.drop{
			margin-top : 10px;
		}
	</style>

	<div class="form-group">
		<label class="col-sm-2 col-md-2 control-label">Description</label>
		<div class="col-sm-9">
			<?php echo $this->Form->input('description', array('label' => '')); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-3"><?php echo $this->Html->link('Back', array("controller" => "uploads", "action" => "inbox", 'admin' => false), array("class" => "btn btn-theme")); ?></div>
		<div class="col-sm-3"><?php echo $this->Form->input('submit', array("type" => "submit", "label" => false, "class" => "btn btn-theme")); ?></div>
	</div>


	<?php echo $this->Form->end(); ?>
</div>
</div>

<!--$(InputsWrapper).parents('#AudioWrapper').append('<div class="AudioRemove" style="position:relative;clear:both;"><div style="float:left;margin-top:40px;font-size:10px; width: 100%;"><input id="audio" onclick="openKCFinder(this)"  type="file" name="data[Upload][filename][]"/>\n\
	<button href="#" class="removeclassAudio btn btn-sm btn-danger fa fa-minus alerts-color"></button>\n\
</div></div>');-->