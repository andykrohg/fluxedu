<?php
    require_once 'money/session.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require_once "money/styling.php"; ?>

        <!--fileUpload-->
        <link href="Utilities/kartik-v-bootstrap-fileinput-02a16d8/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css"/>
        <script src="Utilities/kartik-v-bootstrap-fileinput-02a16d8/js/fileinput.min.js"></script>
		
		<!--moment time library-->
		<script src="Utilities/moment/moment.min.js"></script>
		
		<!--bootstrap select-->
		<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.5/css/bootstrap-select.min.css">
		<script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.5/js/bootstrap-select.min.js"></script>

        <script>
            //switches tabs
            function showTab(id) {
                //find the active tab
                var activeTab = $('ul#myTab li.active').find('a').attr('href');
                var error = false;

                //verify the date page
                if (activeTab == '#date') {
                    if (!(form.start.checkValidity() && form.end.checkValidity()))
                        error = true;
					else if (!($('#start').val() < $('#end').val())) {
						error = true;
						$('#dateError').html("Time travel is not possible and not allowed.");
					} else $('#dateError').html("");
                    //verify the address page
                } else if (activeTab == '#address') {
                    if (!(form.line1.checkValidity() && form.city.checkValidity() && form.state.checkValidity() && form.zip.checkValidity()))
                        error = true;
					//verify the rent page	
                } else if (activeTab == '#rent') {
					if (!(form.rent.checkValidity()))
						error = true;
				}
                //if we're good, switch the tab. otherwise, show the errors
                if (!error)
                    $('#myTab a[href="#' + id + '"]').tab('show');
                else
                    $('#form').find(':submit').click();
            }

            function previousTab(id) {
                $('#myTab a[href="#' + id + '"]').tab('show');
            }
            $(document).ready(function () {
                //mirrors address on review page
                $('.address').bind('keypress keyup blur click', function () {
                    if ($('#line2').val().trim() != '')
                        $('#revline1').html('<h3>' + $('#line1').val() + ', ' + $('#line2').val() + '<br><small>' + $('#city').val() + ', ' + $('#state').val() + ' ' + $('#zip').val() + '</small></h3>');
                    else
                        $('#revline1').html('<h3>' + $('#line1').val() + ', ' + $('#city').val() + ', ' + $('#state').val() + ' ' + $('#zip').val() + '</h3>');
                });

                //mirrors rent on review page
                $('#rent').bind('keypress keyup blur mouseup', function () {
                    $('#revrent').html('<h4><small>Rent:</small> $' + $('.rent').val() + '</h4>');
                });

                //reverts to default picture when selected photo is removed
                $('.fileinput-remove').click(function () {
                    $('#revphoto').attr('src', 'images/defaultHouse.png');
                });

                //Verify Form!!
                $('.tabswitch').click(function () {
                    return false;
                });

                //Prevents Enter From Submitting
                $(window).keydown(function (event) {
                    if (event.keyCode == 13) {
                        event.preventDefault();
                        return false;
                    }
                });
				
				//toggles amenity buttons
				$('.amen').click(function() {
					if ($(this).attr('style')=='background-color:#337ab7;color:white')
						$(this).attr('style', 'background-color:white;color:#333');
					else
						$(this).attr('style','background-color:#337ab7;color:white');
				});
            });

            //mirrors photo preview on review page
            function readURL(input) {

                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#revphoto').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#photo").change(function () {
                readURL(this);
            });

            var loadFile = function (event) {
                var revphoto = document.getElementById('revphoto');
                revphoto.src = URL.createObjectURL(event.target.files[0]);
            };

            //mirrors date on review page
            function mirrorDate(id) {
                if (id == 'start')
                    $('#revstart').html('<h4>' + moment($('#start').val(), 'YYYY-MM-DD').format('MMMM Do, YYYY') + '</h4>');
                else
                    $('#revend').html('<h4>' + moment($('#end').val(), 'YYYY-MM-DD').format('MMMM Do, YYYY') + '</h4>');
            }
        </script>
    </head>

    <body>
		<div class="content">
			<?php require_once 'money/navbar.php'; ?>
			<div class="container text-center" style="margin-top: 40px;margin-bottom: 100px;font-family:Asap">
				<form role="form" class="form-horizontal" method="post" action="publish.php" name="form" id="form" enctype="multipart/form-data">
					<div role="tabpanel">
						<!-- Nav tabs -->
						<ul class="nav nav-pills" id="myTab" style="text-align:center;display:inline-block">
							<li class="active tabswitch disabled" id="dateTab" style="width:120px"><a href="#date"><span class="glyphicon glyphicon-calendar"></span> Date</a></li>
							<li class="tabswitch disabled"><a href="#address" style="width:120px"><span class="glyphicon glyphicon-globe"></span> Address</a></li>
							<li class="tabswitch disabled"><a href="#rent" style="width:120px"><span class="glyphicon glyphicon-usd"></span> Rent</a></li>
							<li class="tabswitch disabled"><a href="#amenities" style="width:120px"><span class="glyphicon glyphicon-gift"></span> Amenities</a></li>
							<li class="tabswitch disabled"><a href="#uploadPhoto" style="width:120px"><span class="glyphicon glyphicon-picture"></span> Photo</a></li>
							<li class="tabswitch disabled"><a href="#review"style="width:120px"><span class="glyphicon glyphicon-ok"></span> Verify</a></li>
						</ul>

						<!-- Tab panes -->
						<div class="tab-content">
						
							<!--************Enter dates**************-->
							<div role="tabpanel" class="tab-pane fade in active	" id="date">
								<h1 style="margin-top: 40px;margin-bottom: 40px">Provide a time frame.</h1>
								<div class = "form-group">
									<div class = "row">
										<div class = "col-sm-2"></div>
										<div class = "col-sm-4">
											<label for "start">From:</label>
											<input type="date" required id="start" class ="btn-block" name="start" onchange="mirrorDate('start')">
										</div>
										<div class = "col-sm-4">
											<label for "end">To:</label>
											<input type="date" required class ="btn-block" id="end" name="end" onchange="mirrorDate('end')">
										</div>
										<div class = "col-sm-2"></div>
									</div>
								</div>
								<div id="dateError"></div>
								<button class="btn btn-lg btn-primary" style ="margin-top:50px"type="button" onclick="showTab('address')">Continue</button>
							</div>

							<!--*************Enter Address***********-->
							<div role="tabpanel" class="tab-pane fade" id="address">
								<h1 style="margin-top:40px;margin-bottom:40px">Enter your address.</h1>
								<div class="form-group">
									<div class="col-sm-1"></div>
									<label for="line1" class="control-label col-sm-2">Address Line 1:</label>
									<div class="col-sm-6">
										<input type="text" required class="address form-control" name="line1" id="line1">
									</div>
									<div class="col-sm-3"></div>
								</div>
								<div class="form-group">
									<div class="col-sm-1"></div>
									<label for="line1" class="control-label col-sm-2">Address Line 2:</label>
									<div class="col-sm-6">
										<input type="text" class="address form-control" name="line2" id="line2">
									</div>
									<div class="col-sm-3"></div>
								</div>
								<div class="form-group">
									<div class="col-sm-1"></div>
									<label for="line1" class="control-label col-sm-2">City:</label>
									<div class="col-sm-6">
										<input type="text" required class="address form-control" name="city" id="city">
									</div>
									<div class="col-sm-3"></div>
								</div>
								<div class="form-group">
									<div class="col-sm-1"></div>
									<label for="line1" class="control-label col-sm-2">State:</label>
									<div class="col-sm-6">
										<select id = "state" name="state" class="form-control">
											<option value="AL">Alabama</option>
											<option value="AK">Alaska</option>
											<option value="AZ">Arizona</option>
											<option value="AR">Arkansas</option>
											<option value="CA">California</option>
											<option value="CO">Colorado</option>
											<option value="CT">Connecticut</option>
											<option value="DE">Delaware</option>
											<option value="DC">District Of Columbia</option>
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
									<div class="col-sm-3"></div>
								</div>
								<div class="form-group">
									<div class="col-sm-1"></div>
									<label for="line1" class="control-label col-sm-2">Zip Code:</label>
									<div class="col-sm-6">
										<input type="text" required class="address form-control" name="zip" id="zip" pattern="^\d{5}$" title="5-Digit Zip Code">
									</div>
									<div class="col-sm-3"></div>   
								</div>
								<button type="button" class="btn btn-default" style="margin-top: 40px;margin-right: 40px" onclick="previousTab('date')">Back</button>
								<button type="button" class="btn btn-primary" style="margin-top: 40px" onclick="showTab('rent')">Continue</button>
							</div>

							<!-- *******Enter Rent*********-->
							<div role="tabpanel" class="tab-pane fade" id="rent">
								<h1 style="margin-top:40px;margin-bottom: 40px">What's the rent?</h1>
								<div class="form-group">
									<div class="col-sm-1"></div>
									<label for="rent" class ="control-label col-sm-2">$</label>
									<div class="col-sm-6">
										<input type="number" class="rent form-control" id="rent" name="rent" pattern="^\d$">
									</div>
									<div class="col-sm-3"></div>
								</div>
								<div class="form-group">
									<input type="checkbox" onclick="document.form.rent.disabled=(!document.form.rent.disabled)" id="hide" name="hide">
									<label for="hide">I'd rather not say just yet.</label>
								</div>
								<div class="form-group">
									<input type="checkbox" id="flexible" name="flexible">
									<label for="flexible">I'm open to negotiate.</label>
								</div>
								<button type="button" class="btn btn-default" style="margin-top: 40px;margin-right: 40px" onclick="previousTab('address')">Back</button>
								<button type="button" class="btn btn-primary" style="margin-top: 40px" onclick="showTab('amenities')">Continue</button>
							</div>

							<!--***********Enter Amenities***********-->
							<div role="tabpanel" class="tab-pane fade in" id="amenities">
								<h1 style="margin-top: 40px;margin-bottom: 40px">Tell us about the goods.</h1>
								<button type="button" id="internet" class="btn btn-default amen"><i class="fa fa-wifi fa-2x"></i><br>Internet</button>&nbsp;
								<button type="button" id="cable" class="btn btn-default amen"><i class="fa fa-desktop fa-2x"></i><br>Cable TV</button>&nbsp;
								<button type="button" id="landline" class="btn btn-default amen"><i class="fa fa-phone fa-2x"></i><br>Landline</button>&nbsp;
								<button type="button" id="washer" class="btn btn-default amen"><i class="fa fa-archive fa-2x"></i><br>Washer/Dryer</button>
								<hr style="width:30%">
								<button type="button" id="heating" class="btn btn-default amen"><i class="fa fa-fire fa-2x"></i><br>Heating</button>&nbsp;
								<button type="button" id="ac" class="btn btn-default amen">
									<span class="fa-stack">
										<i class="fa fa-square-o fa-stack-2x"></i>
										<i class="fa fa-refresh fa-stack-1x"></i>
									</span><br>A/C
								</button>&nbsp;
								<button type="button" id="parking" class="btn btn-default amen"><i class="fa fa-car fa-2x"></i><br>Free Parking</button>&nbsp;
								<button type="button" id="furnished" class="btn btn-default amen"><i class="fa fa-bed fa-2x"></i><br>Furnished</button><br>
								<button type="button" class="btn btn-default" style="margin-top: 40px;margin-right: 40px" onclick="previousTab('rent')">Back</button>
								<button type="button" class="btn btn-primary" style="margin-top: 40px" onclick="showTab('uploadPhoto')">Continue</button>
							</div>
							
							<!-- ***********Upload Photo*********** -->
							<div role="tabpanel" class="tab-pane fade" id="uploadPhoto">
								<h1 style="margin-top:40px">Upload a Photo of Your Place</h1>
								<div style="margin-top: 40px">
									<div class="row">
										<div class="col-sm-2"></div>
										<div class="col-sm-8" id="photoContainer">
											<input type="file" class="file file-preview-image" onchange="loadFile(event)"name="photo" 
												id="photo" accept="image/*" data-show-upload="false">
										</div>
										<div class="col-sm-2"></div>
									</div>
								</div>
								<button type="button" class="btn btn-default" style="margin-top: 20px;margin-right: 40px" onclick="previousTab('amenities')">Back</button>
								<button type="button" class="btn btn-primary" style="margin-top: 20px" onclick="showTab('review')">Review Post</button>
							</div> 

							<!--*************Review Post**************-->
							<div role="tabpanel" class="tab-pane fade" id="review">
								<h1 style="margin-top: 40px;margin-bottom: 40px">Here's what your post will look like.</h1>
								<div class="row" style="margin-top: 40px">
									<div class="col-sm-4">
										<img src="images/defaultHouse.png"id="revphoto" alt="photo preview" style="width:350px;height:250px">
									</div>
									<div class="col-sm-8">
										<div id="revline1"></div>
										<div class="row" style="margin-top: 30px">
											<div class="col-sm-6" id="revrent"></div>
											<div class="col-sm-1">
												<h4><small>Term:</small></h4>
											</div>
											<div class="col-sm-5">
												<div style="float:left" id="revstart"></div>
												<div style="float:left"><h4>&nbsp;-&nbsp;</h4></div>
												<div style="float:left" id="revend"></div>
											</div> 
										</div>
										<div title="A link to details on your roommates. You can add this later."><button type="button" class="btn btn-link" disabled><h4 style="margin-top: 40px">Roomies</h4></button></div>
										<div title="A button for a sublettee to contact the host (you)."><button class="btn btn-primary" disabled type="button" style="margin-top: 40px">Contact Host</button></div>
									</div>
								</div>
								<button type="button" class="btn btn-default" style="margin-top: 30px;margin-right: 40px" onclick="previousTab('uploadPhoto')">Back</button>
								<button type="submit" name="submit" style="margin-top: 30px" class="btn btn-primary btn-lg">Publish</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>	
		<?php require_once "money/footer.php"; ?>
    </body>
</html>
