@extends('layouts.template')
@section('content')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>


 <div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading"><font face="Kristen ITC" size="5">Transaksi Pembelian</font></div>
					<div class="panel-body">

					@include('layouts._flash') 
					
				<form action="{{route('pembelian.store')}}" method="post"> 
				{{csrf_field()}}
				
				 <table class="table table-striped">
					 <thead>
								<tr>
									<th><font face="Comic Sans MS">No</font></th>
									<th><font face="Comic Sans MS">Jenis Barang</font></th>
									<th><font face="Comic Sans MS">Merk Barang</font></th>
									<th><font face="Comic Sans MS">Jumlah</font></th>
									<th><font face="Comic Sans MS">Harga</font></th>
									<th><font face="Comic Sans MS">Total</font></th>
									<th><font face="Comic Sans MS">Supplier</font></th>
									<th><font face="Comic Sans MS">Delete</font></th>
								</tr>
					</thead>
					<div style="display: none;">
						<select class="form-control jb" required>
							<option>Pilih</option>
							@foreach($b as $data)
							<option value="{{$data->id}}">{{$data->jenis}}</option>
							@endforeach
						</select>

						<select class="form-control supp" required>
							<option>Pilih</option>
							@foreach($d as $data)
							<option value="{{$data->id}}">{{$data->nama_supplier}}</option>
							@endforeach
						</select>
					</div>
					
					<tbody class="neworderbody">
					<?php $no=1 ?>
					
					</tbody>
					</table>
					
					
					<table>
					<tr>
					<td><input type="button" class="btn btn-primary add" value="Tambahkan Item Baru" id="add"></td>
					</tr>

					<tr>
					<td colspan="6"><h4>Total: Rp. <b class="totalsel">0</b></h4></td>
					</tr>

					
					<br>
					
					<td>
					<br>
					<div align="left"><button type="submit" class="btn btn-success">Simpan</button></div>
					</td>
					</table>

						</div>
					</div>
				</div>
				</form>
				</div>

				
				

 <div class="box box-default">
            <div class="box-header">Detail Transaksi</div>
		 <div class="box-body">
		
					
      		<table class="table table-striped">
			
					<thead>
						<tr>
							<th><font face="Gothic UI Semibold" size="3">No</font></th>
							<th><font face="Gothic UI Semibold" size="3">Tanggal Pembelian</font></th>
							<th><font face="Gothic UI Semibold" size="3">Total Harga</font></th>
							<th colspan="2"><font face="Gothic UI Semibold">Action</font></th>
							
						</tr>
					</thead>

					<tbody>
					<?php $no=1 ?>

					@foreach($pembelian as $data)
						<tr>
							<td>{{$no++}}</td>
							<td>{{$data->tgl_pembelian}}</td>
							<td>{{$data->total }}</td>
							<td>
								
								<form action="{{route('pembelian.destroy', $data->id)}}" method="post">
									<input type="hidden" name="_method" value="DELETE">
									<input type="hidden" name="_token">
									<input type="submit" class="btn btn-danger" value="Hapus">
									{{csrf_field()}}
								</form>
							</td>

						</tr>
						
					@endforeach
					</tbody>
					

				</table>
					{{ $pembelian->links() }}
				</div></div>
				

				

@endsection

@section('js')
<script type="text/javascript">
	function totalAmount(){
		var t = 0;
		$('.total').each(function(i,e){
			var amt = $(this).val()-0;
			t += amt;
		});
		$('.totalsel').html(t);
	}
		$('.add').click(function() {
			var jenis = $('.jb').html();
			var supplier = $('.supp').html();
			var n = ($('.neworderbody tr').length - 0) + 1;
			var index = ($('.neworderbody tr').length - 0) + 1;
			var tr = '<tr><td class="no">' + n + '</td>' + 
				'<td><select class="form-control jb" name="jb[]" id="jenis'+ index +'">' + jenis + '</select></td>' +
				'<td><select class="form-control nb" name="nb[]" id="merk'+ index +'"></select></td>' +
				'<td><input type="text" class="jumlah form-control" name="jumlah[]"></td>' +
				'<td><input type="text" class="harga form-control" name="harga[]" id="harga1'+index+'" readonly></td>' +
				'<td><input type="text" class="total form-control" name="total[]" readonly></td>' +
				'<td><select class="form-control supp" name="supp[]" id="supplier'+ index +'">' + supplier + '</select></td>' +
				'<td><input type="button" class="btn btn-danger delete" value="x"></td></tr>';
			$('.neworderbody').append(tr);
			
			$('#jenis'+index).change(function () {
				var i =$(this).val();
				$.ajax({ 
					dataType:"text",
		        	url: "filter/jenis/"+ i,
		        	success: function(data){
		              $('#merk'+n).html(data);

		              
		        	},
		        });	
			});

			$('#merk'+index).change(function () {
				var i = $(this).val();
				$.ajax({ 
					dataType: "text",
		        	url: "filter/harga1/"+ i,
		        	success: function(data){
		              $('#harga1'+index).val(data);
		        	},
		        });	
			});

			$('#supplier'+index).change(function () {
				var i = $(this).val();
				$.ajax({ 
					dataType: "text",
		        	url: "filter/supplier/"+ i,
		        	success: function(data){
		              $('#supplier'+n).html(data);
		        	},
		        });	
			});
			
		});
			 

		$('.neworderbody').delegate('.delete', 'click', function () {
			$(this).parent().parent().remove();
			totalAmount();
		});

		$('.neworderbody').delegate('.nb', 'change', function () {
			var tr = $(this).parent().parent();
			var harga = tr.find('.nb option:selected').attr('harga1');
			tr.find('.harga').val(harga);
			
			var jml = tr.find('.jumlah').val() - 0;
			var harga = tr.find('.harga').val() - 0;
		
			var totalsel = (jml * harga);
			tr.find('.total').val(totalsel);
			totalAmount();
		});

		$('.neworderbody').delegate('.jumlah', 'keyup', function () {
			var tr = $(this).parent().parent();
			var jml = tr.find('.jumlah').val() - 0;
			var harga = tr.find('.harga').val() - 0;
			var totalsel = (jml * harga);
			tr.find('.total').val(totalsel);
			totalAmount();
		});
		
        $('#hideshow').on('click', function(event) {  
			 $('#content').removeClass('hidden');
			$('#content').addClass('show'); 
             $('#content').toggle('show');
        });

   


</script>


@endsection