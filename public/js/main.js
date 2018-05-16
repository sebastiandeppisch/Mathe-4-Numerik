function toggleFields(duration){
	duration = (typeof duration !== 'undefined')? duration: 400;
	for(var i=0;i<parameters.length;i++){
		var parameter = parameters[i];
		var show=false;
		for(var j=0;j<parameter.show.length;j++){
			var condition = parameter.show[j];
			if($("#"+condition.name).val() == condition.value){
				show=true;
			}
		}
		var field=$("#"+parameter.field).parent(".form-group")
		if(show){
			field.fadeIn(duration);
		}else{
			field.fadeOut(duration);
		}
	}
}

$(function(){
	toggleFields(0);
	$(".matrix-input").each(function(){
		$(this).matrix($(this).attr("data-name"));
	});
})

$.fn.matrix = function(name){
	var id=getUniqueId();
	var defaultValues = {
		rows: 3,
		cols: 3,
		data: [
			[0, 0, 0],
			[0, 0, 0],
			[0, 0, 0],
		]
	};
	if($(this).attr("data-init")){
		var data = $(this).attr("data-init");
		data = data.split(';');
		defaultValues.rows=data[0];
		defaultValues.cols=data[1];
		data = data[2].split(",");
		var k=0;
		for(var i=0;i<defaultValues.rows;i++){
			for(var j=0;j<defaultValues.cols;j++){
				if(defaultValues.data[i] == undefined){
					defaultValues.data[i]=[];
				}
				defaultValues.data[i][j]=data[k++];
			}
		}
	}
	function renderTable(){
		var rows = $('#'+id+'-rows').val();
		var cols = $('#'+id+'-cols').val();
		for(var i=0;i<rows;i++){
			for(var j=0;j<cols;j++){
				var value = $("[name=\""+name+'['+i+']['+j+']]"').val();
				if(value === undefined){
					value=0;
				}
				if(defaultValues.data[i] === undefined || defaultValues.data[i][j]=== undefined){
					if(defaultValues.data[i] === undefined){
						defaultValues.data[i] = [];
					}
					defaultValues.data[i][j]=value;
				}
				console.log(defaultValues.data[i][j]);
			}
		}
		var html="";
		for(var i=0;i<rows;i++){
			html+="<tr>";
			for(var j=0;j<cols;j++){
				html+="<td>";
				html+='<input type="text" name="'+name+'['+i+']['+j+']" class="matrix-input-field form-control" value='+defaultValues.data[i][j]+'>';
				html+="</td>";
			}
			html+="</tr>";
		}
		$("#"+id+"-tbody").html(html);
	}


	$(this).html('<table><tbody id="'+id+'-tbody"></tbody></table>');
	$(this).append('Zeilen: <input type="number" id="'+id+'-rows" class="form-control" style="width:70px;">');
	$(this).append('Spalten: <input type="number" id="'+id+'-cols" class="form-control" style="width:70px;">');
	$(this).append('<button id="'+id+'-empty" class="btn btn-info"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>');
	$('#'+id+'-rows').change(function(){
		renderTable();
	}).val(defaultValues.rows);
	$('#'+id+'-cols').change(function(){
		renderTable();
	}).val(defaultValues.cols);
	$('#'+id+'-empty').click(function(){
		defaultValues.data=[];
		renderTable();
		return false;
	})
	renderTable();

}

var uniqueIds=Array();
function getUniqueId(){
	var id = "uniqueid-"+Date.now();
	while(uniqueIds.indexOf(id) !== -1){
		id++;
	}
	uniqueIds.push(id);
	return id;
}


	
