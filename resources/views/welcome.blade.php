@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header">
		<h1>Welcome To IPMA Industry Sdn Bhd</h1>
	</div>
	<div class="card-body">
<!-- 		<div class="container">
			<div class="row">
				<div class="col-sm-12 jumbotron">
					test
					<i class="fas fa-user"></i>
					<i class="far fa-user"></i>
					<i class="fab fa-github-square"></i>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div id="accordion">
						<h3>Section 1</h3>
						<div>
							<p>
								Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer
								ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit
								amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut
								odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.
							</p>
						</div>
						<h3>Section 2</h3>
						<div>
							<p>
								Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet
								purus. Vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor
								velit, faucibus interdum tellus libero ac justo. Vivamus non quam. In
								suscipit faucibus urna.
							</p>
						</div>
						<h3>Section 3</h3>
						<div>
							<p>
								Nam enim risus, molestie et, porta ac, aliquam ac, risus. Quisque lobortis.
								Phasellus pellentesque purus in massa. Aenean in pede. Phasellus ac libero
								ac tellus pellentesque semper. Sed ac felis. Sed commodo, magna quis
								lacinia ornare, quam ante aliquam nisi, eu iaculis leo purus venenatis dui.
							</p>
							<ul>
								<li>List item one</li>
								<li>List item two</li>
								<li>List item three</li>
							</ul>
						</div>
						<h3>Section 4</h3>
						<div>
							<p>
								Cras dictum. Pellentesque habitant morbi tristique senectus et netus
								et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in
								faucibus orci luctus et ultrices posuere cubilia Curae; Aenean lacinia
								mauris vel est.
							</p>
							<p>
								Suspendisse eu nisl. Nullam ut libero. Integer dignissim consequat lectus.
								Class aptent taciti sociosqu ad litora torquent per conubia nostra, per
								inceptos himenaeos.
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<p>&nbsp;</p>
		<div class="container">
			<div class="row">
				<form action="" method="GET" autocomplete="off" id="formuser" accept-charset="utf-8">
					<div class="row form-group">
						<label for="asd" class="col-sm-2 col-form-label">Input :</label>
						<div class="col-sm-10">
							<input type="text" name="test" id="asd" class="form-control" placeholder="Inser Only Numbers">
						</div>
					</div>
					<div class="form-group row">
						<label for="editor" class="col-sm-2 col-form-label">Date :</label>
						<div class="col-sm-10">
							<input name="datepicker" id="dtpicker" placeholder="Please Insert Date" class="form-control">
						</div>
					</div>
					<div class="form-group row">
						<label for="editor" class="col-sm-2 col-form-label">Message :</label>
						<div class="col-sm-10">
							<textarea name="messagea" id="idmsg" cols="30" rows="10" class="form-control" placeholder="Your Message"></textarea>
							<div id="output" value=""></div>
						</div>
					</div>
					<div class="form-group row">
						<label for="simple-select2-sm" class="col-sm-2 col-form-label">Example select</label>
						<div class="col-sm-10">
							<select class="form-control" id="simple-select2-sm" name="select21">
								<option value="">Select Option</option>
								<?php for($ei = 1; $ei<60; $ei++): ?>
									<option value="<?=$ei ?>"><?=$ei.chr($ei + 51)?></option>
								<?php endfor ?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="simple-select2" class="col-sm-2 col-form-label">Example multiple select</label>
						<div class="col-sm-10">
							<select multiple class="form-control" id="simple-select2" name="select2[]">
								<option value="">Select Option</option>
								<?php for($eia = 1; $eia<60; $eia++): ?>
									<option value="<?=$eia?>"><?=$eia + 5?></option>
								<?php endfor ?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-12">
							<button type="submit" id="btnSend" class="btn btn-block btn-primary">submit</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="container">
					<div class="col-sm-12">
						<table class="table table-hover" id="example">
							<thead>
								<tr>
									<th>id</th>
									<th>name</th>
									<th>email</th>
									<th>delete</th>
								</tr>
							</thead>
							<?php for($i = 1; $i<60; $i++): ?>
								<tr>
									<td><?=$i?></td>
									<td><?=$i + 1?></td>
									<td><?=$i + 2?></td>
									<td>
										<button  type="submit" name="del" id="delete_product_<?=$i ?>" class="btn btn-danger delete_button" data-id="<?=$i?>" >Delete ID <?=$i?></button>
									</td>
								</tr>
							<?php endfor ?>
						</table>
					</div>
				</div>
			</div>
		</div> -->
	</div>
</div>
@endsection

@section('js')
		$('#example').DataTable({
			// paging: false,
			"lengthMenu": [ [10, -1], [10, "All"] ],
			// responsive: true
		});

	// $(document).on('keyup', '#asd', function () {
	// // $("input").keyup(function() {
	// 	tch(this);
	// });

	$('#formuser').bootstrapValidator({

		fields: {
			test: {
				validators: {
					notEmpty: {
						message: 'This cannot be empty!'
					},
					integer: {
						message: 'The value is not an integer'
					}
				}
			},
			datepicker: {
				validators: {
					notEmpty: {
						message: 'Please insert date. '
					},
					date: {
						format: 'YYYY-MM-DD',
						message: 'The value is not a valid date. '
					}
				}
			},
			messagea: {
				validators: {
					notEmpty: {
						message: 'Please insert your message. '
					},
					callback: {
						message: 'The bio must be less than 200 characters long',
						callback: function(value, validator, $field) {
							// Get the plain text without HTML
							var div  = $('<div/>').html(value).get(0),
							text = div.textContent || div.innerText;

							return text.length <= 200;
						},
					}
				}
			},
			select21: {
				validators: {
					notEmpty: {
						message: 'Please choose an option. '
					}
				}
			},
			'select2[]': {
				validators: {
					notEmpty: {
						message: 'Please choose 2 or more but less than 7 option. '
					},
					choice: {
						min: 2,
						max: 7,
						message: 'Please choose between 2 and 7 option. '
					}
				}
			}

		}
	})
//	.find('[name="messagea"]')
//	.ckeditor()
//	.editor
//	// To use the 'change' event, use CKEditor 4.2 or later
//	.on('change', function(e) {
//		// Revalidate the bio field
//		$('#formuser').bootstrapValidator('revalidateField', 'messagea');
//		// console.log('asd');
//	});

	// https://eonasdan.github.io/bootstrap-datetimepicker/Events/ for dp.change and dp.show
	$('#dtpicker').on('dp.change dp.show', function(e) {
		$('#formuser').bootstrapValidator('revalidateField', 'datepicker');
	})

/////////////////////////////////////////////////////////////////////////////////////////
// ajax post submit data CRUD
	// Bind to the submit event of our form
	$("#btnSend").click(function (event){

		// Prevent default posting of form - put here to work in case of errors
		event.preventDefault();

		// Get from elements values from the FORM! (id, class or name)
		var values = $('#formuser').serialize();
		// console.log(values);

		$.ajax({
			url: "ajax.php",
			type: "POST",
			data: values,
			success: function (response) {
				// you will get response from your php page (what you echo or print)
				// alert(response);
				swal({
						title: 'Success Insert!',
						text: 'Your data has been inserted.',
						html: 'You can use <b>bold text</b>, ' +
								'<a href="//github.com">links</a> ' +
								response,
						type: 'success',
					});
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(textStatus, errorThrown);
			}
		});
	})

/////////////////////////////////////////////////////////////////////////////////////////
// ajax post delete row
	// readProducts(); /* it will load products when document loads */

	$(document).on('click', '.delete_button', function(e){
		
		var productId = $(this).data('id');
		SwalDelete(productId);
		e.preventDefault();
	});

	// function readProducts(){
		// $('#load-products').load('read.php');
	// }

	function SwalDelete(productId){
		swal({
			title: 'Are you sure?',
			text: "It will be deleted permanently!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!',
			showLoaderOnConfirm: true,

			preConfirm: function() {
				return new Promise(function(resolve) {
					$.ajax({
						url: 'delete.php',
						type: 'POST',
						data: 'delete=' + productId,
						dataType: 'json'
					})
					.done(function(response){
						swal('Deleted!', response.message, response.status);
						$('#delete_product_' + productId).parent().parent().remove();
					})
					.fail(function(){
						swal('Oops...', 'Something went wrong with ajax !', 'error');
					})
				});
			},
			allowOutsideClick: false			  
		})
		.then((result) => {
			if (result.dismiss === swal.DismissReason.cancel) {
				swal('Cancelled', 'Your data is safe from delete', 'info')
			}
		});
	}

/////////////////////////////////////////////////////////////////////////////////////////

	$('#simple-select2').select2({
		// theme: 'bootstrap4',
		placeholder: "Select an option",
		width: '100%',
		// allowClear: true
	});

	$('#simple-select2-sm').select2({
		// theme: 'bootstrap4',
		// containerCssClass: ':all:',
		placeholder: "Select an option",
		width: '100%',
		// allowClear: true
	});

/////////////////////////////////////////////////////////////////////////////////////////
	$('#dtpicker').datetimepicker({
		// format: 'dddd, YYYY-MM-DD h:mm A'
		format: 'YYYY-MM-DD'
	});

/////////////////////////////////////////////////////////////////////////////////////////
	$( "#accordion" ).accordion();
@endsection