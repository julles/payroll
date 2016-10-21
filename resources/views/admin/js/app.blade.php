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
@endif