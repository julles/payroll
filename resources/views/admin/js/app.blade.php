@if(request()->segment(2) == 'pegawai')
		<script type="text/javascript">
			$(document).ready(function(){
				$("#department_id").on('change',function(){
					$.ajax({
						type : 'get',
						url : '{{ Admin::urlBackendAction("jabatan") }}',
						data : {
							id : $(this).val(),
						},
						success : function(data){
							$("#position_id").html("");
							result = "<option value = ''>Pilih Jabatan</option>";
							$.each(data.result , function(key , val){
								result += "<option value = '"+key+"'>"+val+"</option>";
							});
							$("#position_id").html(result);
						},
					});
				});
			});
		</script>
@elseif(request()->segment(2)=='data-pegawai-cuti')
<script type="text/javascript">
	$(function(){
		$( "#from,#to" ).datepicker({
	      //changeMonth: true,
	      //changeYear: true,
	      dateFormat: "yy-mm-dd",
	      //yearRange: '1945:{{ date("Y") }}',
	      minDate : '{{ date("Y-m-d") }}',
	    });	
	});

</script>
@endif


<script type="text/javascript">
	  $( function() {
	    $( "#datepicker,#datepicker2" ).datepicker({
	      changeMonth: true,
	      changeYear: true,
	      dateFormat: "yy-mm-dd",
	      yearRange: '1945:{{ date("Y") }}',
	    });
	  } );

</script>