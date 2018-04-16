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
})