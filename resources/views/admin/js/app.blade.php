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
@elseif(request()->segment(2)=='approval-sakit-izin-alpha')
<script type="text/javascript">
	function getPegawai()
	{
		$("#employee_id").hide();
		$.ajax({
			type : 'get',
			url : '{{ Admin::urlBackendAction("pegawai") }}',
			data : {
				date : $("#datepicker").val(),
			},
			success : function(data){
				$("#employee_id").html("");
				$("#employee_id").append(data.result);
				$("#employee_id").show();
			
			},
			beforeSend: function(){
				$("#employee_id").hide();
			},
		});
	}
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

	    $(".select2").select2();

	  } );

</script>