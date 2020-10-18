( function ( $ ) {
    'use strict';

//####################################
//#####                          #####
//#####      1) General          #####
//#####                          #####
//####################################

//- Droped menu

$.puerto_droped = function( prtclick, prtlist = "ul.pt-drop" ){
	$(prtclick).livequery('click', function(){
		var ul = $(this).parent();
		if( ul.find(prtlist).hasClass('open') ){
			ul.find(prtlist).removeClass('open');
			$(this).removeClass('active');
			if(prtclick == ".pl-mobile-menu") $('body').removeClass('active');
		} else {
			$("ul.pt-drop").parent().find(".active").removeClass('active');
			$("ul.pt-drop").removeClass('open');
			ul.find(prtlist).addClass('open');
			$(this).addClass('active');
			if(prtclick == ".pl-mobile-menu") $('body').addClass('active');
		}
		return false;
	});
	$("html, body").livequery('click', function(){
		$("ul.pt-drop").parent().find(".active").removeClass('active');
		$("ul.pt-drop").removeClass('open');
		if(prtclick == ".pl-mobile-menu") $('body').removeClass('active');
	});
}

$.puerto_droped(".pt-options-link");
$.puerto_droped(".pt-user");
$.puerto_droped(".pt-mobile-menu");


//- Textarea auto resize

$("textarea").on('change drop keydown cut paste', function() {
  $(this).height('auto');
  $(this).css({'overflow':'hidden'});
	$(this).height($(this).prop('scrollHeight'));
});

$(".pt-countries select").livequery("change", function(){
	$(".pt-countries").find('.pt-icon i').attr('class', 'flag-icon flag-icon-'+$(this).val().toLowerCase().replace(/<[^>]+>/g, ''));
});

//- Datepicker

$('#datepicker, .datepicker-here, [id^=datepicker]').datepicker({ language:'en', timepicker: true, timeFormat:"hh:ii aa" });
if($('#datepicker, .datepicker-here, [id^=datepicker]').val()){
	$('#datepicker, .datepicker-here, [id^=datepicker]').each(function(){
		var ths_d = $(this);
		var ths_dv = $(this).val();
		setTimeout(function () {
			ths_d.val(ths_dv);
		}, 3010);
	});
}


//- Phone Mask
$('[type=phone]').mask('000-000-0000');
$('[type=email]').mask("A", {
	translation: {
		"A": { pattern: /[\w@\-.+]/, recursive: true }
	}
});

//- Puerto Conferm

$.puerto_confirm = function( tit, aler, col) {
	$.confirm({
			icon: ( col == 'green' ? 'far fa-laugh-wink' : 'far fa-surprise'),
			theme: 'modern',
			closeIcon: true,
			animation: 'scale',
			type: col,
			title: tit,
			content: aler,
			buttons: false
	});
}


//- Scroll Bar

$(document).ready(function(){
  $('.pt-scroll').scrollbar();
});


$("img").on("error", function () {
  $(this).attr("src", nophoto);
});


//####################################
//#####                          #####
//#####     2) New Survey        #####
//#####                          #####
//####################################


//- Wysibb Editor
if($("#wysibb-editor").length){
	var textarea = document.getElementById('wysibb-editor');
	sceditor.create(textarea, {
		format: 'bbcode',
		style: path+'/js/minified/themes/content/default.min.css',
		emoticonsRoot: path+'/js/minified/',
		height: 400,
		toolbarExclude: 'indent,outdent,email,date,time,ltr,rtl,print,subscript,superscript,table,code,quote,emoticon',
		icons: 'material',
	});
	var body = sceditor.instance(textarea).getBody();
	sceditor.instance(textarea).keyUp(function(e) {
		$('.textarea-welcome').html($(body).html());
	});
}

if($("#wysibb-editor1").length){
	var textarea1 = document.getElementById('wysibb-editor1');
	sceditor.create(textarea1, {
		format: 'bbcode',
		style: path+'/js/minified/themes/content/default.min.css',
		emoticonsRoot: path+'/js/minified/',
		height: 400,
		toolbarExclude: 'indent,outdent,email,date,time,ltr,rtl,print,subscript,superscript,table,code,quote,emoticon',
		icons: 'material',
	});
	var body1 = sceditor.instance(textarea1).getBody();
	sceditor.instance(textarea1).keyUp(function(e) {
		$('.textarea-thank').html($(body1).html());
	});
}

if($("#wysibb-editor3").length){
	var textarea3 = document.getElementById('wysibb-editor3');
	sceditor.create(textarea3, {
		format: 'bbcode',
		style: path+'/js/minified/themes/content/default.min.css',
		emoticonsRoot: path+'/js/minified/',
		height: 400,
		toolbarExclude: 'indent,outdent,email,date,time,ltr,rtl,print,subscript,superscript,table,code,quote,emoticon',
		icons: 'material',
	});
}


$(".sendtoemail").on("click", function(){
	$('[name=id]').val($(this).attr('rel'));
});

$(".pt-sendsurveyemail").on("submit", function(){
	$.post(path+"/ajax.php?pg=sendsurveyemail", $(this).serialize(), function(puerto){
		if(puerto.type == 'success'){
			$.puerto_confirm("Success!", puerto.alert, "green");
		} else {
			$.puerto_confirm("Error!", puerto.alert, "red");
		}
		console.log(puerto);
	}, 'json');
	return false;
});

//- Icon Picker

if($('.my').length){
 $('.my').iconpicker({placement: 'bottom'});
}

if($('.pt-editsurveypage').length){
	$('.my').on('iconpickerSelected', function(event){
 	 	$(this).next('.changeicon').html('<i class="'+event.iconpickerValue+'"></i>');
 	 	$('span[role="'+$(this).attr('name')+'"]').html('<i class="'+$( this ).val().replace(/<[^>]+>/g, '')+'"></i>');
  });
}

//- Send New Survey
$("#sendnewsurvey").livequery("submit", function(){
	var ths = $(this);
	$.post(path+"/ajax.php?pg=sendnewsurvey", ths.serialize(), function(puerto){
		if(puerto.type == 'success'){
			$.puerto_confirm("Success!", puerto.alert, "green");
			setTimeout(function () { $(location).attr('href', path+"/index.php"); }, 2000);
		} else {
			$.puerto_confirm("Error!", puerto.alert, "red");
		}

	}, 'json');
	return false;
});


//- Design Color Picker

var ptLinkSp = $(".pt-link .fancy-button span");

$("#colorpicker-popup, .colorpicker-popup").spectrum({
    color: $(this).val(),
		showInput: true,
    allowEmpty:true,
		preferredFormat: "hex",
		change: function(rr){
		},
		move: function(color) {
			if($(this).attr('name') == 'button_border_color'){
				ptLinkSp.css("border-color", color.toHexString());
				$("[name=pg_bg_v]").val(color.toHexString());
			}

			if($(this).attr('name') == 'bg_color1'){
				if($("[name=bg_gradient]:checked").val() == 0){
					var clr2 = ($("[name=bg_v2]").val()?$("[name=bg_v2]").val():'#00e2fa');
					ptLinkSp.css("background", "linear-gradient(to right, "+color.toHexString()+" 0%, "+clr2+" 80%, "+clr2+" 100%)");
					$(".bg-sty").html("<style>.fancy-button:before {background: linear-gradient(to right, "+color.toHexString()+" 0%, "+clr2+" 80%, "+clr2+" 100%)}</style>");
				} else {
					ptLinkSp.css("background", color.toHexString());
					$(".bg-sty").html("<style>.fancy-button:before {background: "+color.toHexString()+"}</style>");
				}
				$("[name=bg_v1]").val(color.toHexString());
			}
			if($(this).attr('name') == 'bg_color2'){
				if($("[name=bg_gradient]:checked").val() == 0){
					var clr1 = ($("[name=bg_v1]").val()?$("[name=bg_v1]").val():'#52A0FD');
					ptLinkSp.css("background", "linear-gradient(to right, "+clr1+" 0%, "+color.toHexString()+" 80%, "+color.toHexString()+" 100%)");
					$(".bg-sty").html("<style>.fancy-button:before {background: linear-gradient(to right, "+clr1+" 0%, "+color.toHexString()+" 80%, "+color.toHexString()+" 100%)}</style>");
				} else {
					ptLinkSp.css("background", color.toHexString());
					$(".bg-sty").html("<style>.fancy-button:before {background: "+color.toHexString()+"}</style>");
				}
				$("[name=bg_v2]").val(color.toHexString());
			}

			if($(this).attr('name') == 'txt_color'){
				$("[name=txt_v]").val(color.toHexString());
				ptLinkSp.css("color", color.toHexString());
			}

			if($(this).attr('name') == 'survey_bg'){
				$("[name=sbg_v]").val(color.toHexString());
				$(".pt-surveybg").css("background", color.toHexString());
			}

			if($(this).attr('name') == 'input_bg'){
				$("[name=inpbg_v]").val(color.toHexString());
				$("[rel=inp]").html("input[type=text]:not(textarea), input[type=password]:not(textarea), input[type=phone]:not(textarea), input[type=email]:not(textarea), input[type=number]:not(textarea), select:not(textarea), textarea:not(textarea), .bootstrap-select .btn:not(textarea) { border-bottom-color: "+color.toHexString()+" }");

			}

			if($(this).attr('name') == 'step_bg'){
				$("[name=stbg_v]").val(color.toHexString());
				$("[rel=stp]").html(".pt-surveybg .pt-dots a.active, .pt-surveybg .pt-dots.pt-lines a span,.pt-surveybg .bootstrap-select .dropdown-menu.innerli.selected.active a {background: "+color.toHexString()+"}.pt-surveybg .pt-dots.pt-lines a span:before {border-left-color: "+color.toHexString()+"}.pt-surveybg .choice[type=checkbox]:checked + label:before {background-color: "+color.toHexString()+"}.pt-surveybg .choice:checked + label:before {border-color: "+color.toHexString()+";box-shadow: 0 0 0 4px "+color.toHexString()+" inset;}.pt-surveybg .pt-survey a {color:"+color.toHexString()+"}");
			}

		}
});


//- Design Change
$("[name=button_shadow]").on("change", function(){
	if($(this).val() == 1){
		$(".pt-link .fancy-button").addClass("noshadow");
	} else {
		$(".pt-link .fancy-button").removeClass("noshadow");
	}
});
$("[name=button_border_size]").on("change", function(){
	$(".pt-link .fancy-button span").css("border-width", $(this).val().replace(/<[^>]+>/g, ''));
});
$("[name=button_border_style]").on("change", function(){
	$(".pt-link .fancy-button span").css("border-style", $(this).val().replace(/<[^>]+>/g, ''));
});
$("[name=button_border_color], [name=pg_bg_v], [name=sp-input]").on("change", function(){
	$(".pt-link .fancy-button span").css("border-color", $(this).val().replace(/<[^>]+>/g, ''));
});
$("[name=bg_gradient]").on("change", function(){
	$("[name=bg_gradient]").removeAttr("checked");
	$(this).attr("checked", "checked");
	var clr1 = ($("[name=bg_v1]").val()?$("[name=bg_v1]").val().replace(/<[^>]+>/g, ''):'#52A0FD');
	var clr2 = ($("[name=bg_v2]").val()?$("[name=bg_v2]").val().replace(/<[^>]+>/g, ''):'#00e2fa');
	if($("[name=bg_gradient]:checked").val() == 0){
		ptLinkSp.css("background", "linear-gradient(to right, "+clr1+" 0%, "+clr2+" 80%, "+clr2+" 100%)");
		ptLinkSp.after().css("background", "linear-gradient(to right, "+clr1+" 0%, "+clr2+" 80%, "+clr2+" 100%)");
		$(".bg-sty").html("<style>.fancy-button:before {background: linear-gradient(to right, "+clr1+" 0%, "+clr2+" 80%, "+clr2+" 100%)}</style>");
	} else {
		ptLinkSp.css("background", clr1);
		ptLinkSp.after().css("background", clr1);
		$(".bg-sty").html("<style>.fancy-button:before {background: "+clr1+"}</style>");
	}

});



//####################################
//#####                          #####
//#####    3)  Survey Page       #####
//#####                          #####
//####################################

$("input[id^=rating]").livequery('change', function() {
	var rel = $(this).attr('rel');
	$("input[name='"+rel+"']").val($(this).val().replace(/<[^>]+>/g, ''));
});

$(".choice").livequery('change', function() {
	var vl  = $(this).val();
	var id  = $(this).attr('id').replace('a', '');
	var rel = $(this).attr('rel');
	var ar = [];
	var arr = ($("input[name='"+rel+"']").length ? $("input[name='"+rel+"']").val().replace(/<[^>]+>/g, '').split(',') : [] );

  if($(this).is(":checked")) {
		if($(this).attr('type') == 'checkbox'){
			arr.push(id);
			$("input[name='"+rel+"']").val(arr);
		} else {
			$("input[name='"+rel+"']").val(id);
		}
  } else {
		var fii = arr.filter(function(value, index, arrs){ return value != id;});
		$("input[name='"+rel+"']").val(fii);
	}
});


//- Steps Nav

var trigger = $('#survey-send-answers'),
	 container = $('#step-content');

$("form button[type=submit]").livequery('click', function() {
   $("button[type=submit]").removeAttr("clicked");
   $(this).attr("clicked", "true");
});

trigger.livequery('submit', function(){
 var $this  = $(this).find('button[clicked=true]'),
	 	 behave = $this.data('behave'),
	 	 target = $this.data('target'),
		 step   = $this.data('step'),
		 survey = $this.data('survey'),
		 url    = $this.data('url');

		 container.append('<div class="pt-survey-loading"><span><i class="fas fa-spinner fa-spin"></i> Loading...</span></div>');
		 $(window).trigger('click');

		 if(step == "undefined" || survey == "undefined"){
				$(".pt-survey-loading span").prepend("<strong class='error'><i class='fas fa-times'></i> Something wrong! <i>Please try again!</i></strong>");
				setTimeout(function () {
					 $(".pt-survey-loading").remove();
				}, 1500);
		 }

		 if( step == 'end' ){
			 $(location).attr('href', (url ? url : path+"/index.php"));
		 } else {

			 $.post(path+"/ajax.php?pg=send-survey-answers", $(this).serialize(), function(puerto){

				if(puerto.type == 'error' && behave == 'next'){
					setTimeout(function () {
						 $(".pt-survey-loading span").prepend("<strong class='error'><i class='fas fa-times'></i> Error! <i>"+puerto.alert+"</i></strong>");
				 }, 200);

				} else {
					setTimeout(function () {
						 container.load(path+'/'+target + '.php?id='+step+'&s='+survey, function() {
							 $('.selectpicker').selectpicker("refresh");
							 $('#datepicker, .datepicker-here, [id^=datepicker]').datepicker({ language:'en', timepicker: true, timeFormat:"hh:ii aa" });
							 $('.datepicker-inline').hide();
						 }).fadeIn('1000');

					}, 100);
				}

				setTimeout(function () {
					 $(".pt-survey-loading").remove();
				}, 1500);

			}, 'json');
		}

 return false;
});

//- Dots

$(".step-link").livequery('click', function(){
	var step = $(this).data('step'),
			link = $('.pt-dots').find('a[rel='+step+']'),
			span = link.find('span');
	link.addClass('active');
	$('.pt-dots a span').removeClass('show');
	span.addClass('show');
});


//####################################
//#####                          #####
//#####      4) Index Page       #####
//#####                          #####
//####################################


$(".js-example-tokenizer").select2({
    tags: true,
    tokenSeparators: [',', ' ']
})

//- Update Status

$(".pt-status input").on('change', function() {
	$.get(path+"/ajax.php?pg=changesurveystatus&id="+ $(this).val(),function(puerto){console.log(puerto);});
});

$(".pt-userstatus input").on('change', function() {
	$.get(path+"/ajax.php?pg=changeuserstatus&id="+ $(this).val(),function(puerto){console.log(puerto);});
});

//- Delete Survey
$(".pt-delete-survey").on('click', function() {
	if(confirm("Are you sure you want to delete this survey?")){
		var pr = $(this).parent().parent().parent().parent();
		$.get(path+"/ajax.php?pg=delete&request=survey&id="+ $(this).attr("rel"),function(puerto){
			console.log(puerto);
			pr.fadeOut();
		});
	}
	return false;
});

//- Delete User
$(".pt-delete-user").on('click', function() {
	if(confirm("Are you sure you want to delete this user?")){
		var pr = $(this).parent().parent().parent().parent();
		$.get(path+"/ajax.php?pg=delete&request=user&id="+ $(this).attr("rel"),function(puerto){
			console.log(puerto);
			pr.fadeOut();
		});
	}
	return false;
});

//- Lang

$(".pt-lang a").on('click', function() {
	$.post(path+"/ajax.php?pg=lang", {id:$(this).attr('rel')}, function(puerto){ location.reload(); console.log(puerto);});
});


//####################################
//#####                          #####
//#####    5) Responses Page     #####
//#####                          #####
//####################################

//- responses

$(".pt-response").on("click", function(){
	var ths = $(this);
	var response = ths.data('response');
	$.get(path+"/ajax.php?pg=respense&id="+response, function(puerto){
		if(puerto.type == 'success'){
			$(".pt-response-m").html(puerto.html);
			$('#exampleModal').modal('show');
		} else {
			$.puerto_confirm("Error!", puerto.alert, "red");
		}
	}, 'json');
});


//####################################
//#####                          #####
//#####     5) Rapport Page      #####
//#####                          #####
//####################################

$(".showchart, .showpie, .showresults").on("click", function(){
	var id = $(this).parent().parent().next('.pt-content').data('answer');
	var ths = $(this);
	$.get(path+"/ajax.php?pg=rapport-stats&id="+id, function(puerto) {
		var as = JSON.parse(puerto);

		if(as.type == 'error'){
			$.puerto_confirm("Error!", as.alert, "red");
		} else {

			if(ths.attr('class') == 'showresults'){
				$(".pt-results").remove();
				var aa='';
				var i;
				for (i = 0; i < as.data.length; ++i) {
					aa += '<div class="r"><b>#'+(parseInt(i)+parseInt(1))+'/</b> &nbsp;'+as.data[i]+'</div>';
				}
				ths.parent().parent().parent().find('.pt-content').first().after('<div class="pt-results">'+aa+'</div>');
			}

			if(as.chartshow){
				$(".pt-chart-bar").remove();
				ths.parent().parent().parent().find('.pt-content').after('<div class="pt-chart-bar"><canvas id="bar-chart-horizontal" width="800" height="450"></canvas></div>');
				var DataLabels = as.labels;
				var DataClrs = as.colors;
				var DataCnt = as.data;

				if(ths.attr('class') == 'showchart'){
					new Chart(document.getElementById("bar-chart-horizontal"), {
					    type: 'horizontalBar',
					    data: {
					      labels: DataLabels,
					      datasets: [
					        {
					          label: "Partisipate of",
					          backgroundColor: DataClrs,
					          data: DataCnt
					        }
					      ]
					    },
					    options: {
					      legend: { display: false },
								scales: {
					        xAxes: [{
				            ticks: { beginAtZero: true }
					        }]
						    }
					    },
					});
				} else {
					new Chart(document.getElementById("bar-chart-horizontal"), {
				    type: 'doughnut',
				    data: {
				      labels: DataLabels,
				      datasets: [
				        {
				          label: "Partisipate of",
				          backgroundColor: DataClrs,
				          data: DataCnt
				        }
				      ]
				    }
					});
				}
			}

		}

	});

	return false;
});


$('.exportEx').on("click", function(e){
	var ths = $(this);
	var id = $(this).parent().parent().next('.pt-content').data('answer');
	var ths = $(this);

	var excel_data = '';
	$.get(path+"/ajax.php?pg=rapport-stats&id="+id, function(puerto) {
		var as = JSON.parse(puerto);
		if(as.type == 'error'){
			$.puerto_confirm("Error!", as.alert, "red");
		} else {
			var i;
			for (i = 0; i < as.data.length; ++i) {
				excel_data += as.data[i]+'|';
			}
			console.log(excel_data);
			console.log(puerto);
			$.puerto_confirm("Suceess!", "The file is ready to download.", "green");
	    window.location = path+"/ajax.php?pg=exexcel&request=" + excel_data;
		}
	});

	e.preventDefault();
});


//- Rapport Stats

$.barChart = function(ChartID, DataLabelss, DataCnts, DataClrs, DataTitle){
	new Chart(document.getElementById(ChartID), {
	    type: 'bar',
	    data: {
	      labels: DataLabelss,
	      datasets: [
	        {
	          label: DataTitle,
	          backgroundColor: DataClrs,
	          data: DataCnts
	        }
	      ]
	    },
	    options: {
	      legend: { display: false },
	      title: {
	        display: true,
	        text: DataTitle
	      }
	    }
	});
}

$.lineChart = function(DataLabelss, DataCnts, DataTitle){
	new Chart(document.getElementById("line-chart"), {
		type: 'line',
		data: {
			labels: DataLabelss,
			datasets: [{
					data: DataCnts,
					label: false,
					borderColor: "#5f90fa",
					backgroundColor: 'rgba(95, 144, 250, 0.65)'
				}
			]
		},
		options: {
			legend: {
					display: false
			},
			title: {
				display: true,
				text: DataTitle
			},
			scales: {
					xAxes: [{
							ticks: {
									autoSkip: false,
									maxRotation: 40,
									minRotation: 40
							}
					}]
			}
	}
	});
}


if($(".pt-surveystats").length){
	var ids = $(".pt-surveystats").attr('rel');
	$.get(path+"/ajax.php?pg=surveystats&request=daily&id="+ids, function(puerto) {
		var ass = JSON.parse(puerto);
		var DataLabelss = ass.labels;
		var DataCnts = ass.data;
		var DataTitle = ass.title;
		$.lineChart(DataLabelss,DataCnts,DataTitle);
	});
}

$(".pt-surveystatslinks a").on("click", function(){
	var t = $(this).attr('href').replace('#','');
	var ids = $(this).attr('rel');
	$.get(path+"/ajax.php?pg=surveystats&request="+t+"&id="+ids, function(puerto) {
		var ass = JSON.parse(puerto);
		var DataLabelss = ass.labels;
		var DataCnts = ass.data;
		var DataTitle = ass.title;
		$.lineChart(DataLabelss,DataCnts,DataTitle);
	});
	return false;
});


//####################################
//#####                          #####
//#####      6) Login Page       #####
//#####                          #####
//####################################

//- Sign in & up

$( ".clickme" ).on("click",function() {
  $( ".pt-signin" ).animate({ opacity: 0, left: "50%" }, 200).css("z-index","0");
	$( ".pt-signup" ).animate({ opacity: 1, left: "0%" }, 550).css("z-index","1");
	return false;
});

$( ".clickme2" ).on("click",function() {
  $( ".pt-signup" ).animate({ opacity: 0, left: "-50%" }, 200).css("z-index","0");
	$( ".pt-signin" ).animate({ opacity: 1, left: "0%" }, 550).css("z-index","1");
	return false;
});

$("#pt-send-signup").on("submit", function(){
	var ths = $(this);
	var btn  = ths.find('button[type=submit]');
	var btxt = btn.html();

	btn.prop('disabled', true).html('<i class="fas fa-spinner fa-pulse fa-fw"></i> Loading..');

	$.post(path+"/ajax.php?pg=register", $(this).serialize(), function(puerto){
		ths.find("button").before(puerto.alert);
		if(puerto.type == "danger"){
			setTimeout(function () {
				$(".alert").fadeOut('slow').remove();
				btn.html(btxt).prop('disabled', false);
			}, 3000);
		} else {
			setTimeout(function () {
				$(".alert").fadeOut('slow').remove();
				$( ".pt-signup" ).animate({ opacity: 0, left: "-50%" }, 200).css("z-index","0");
				$( ".pt-signin" ).animate({ opacity: 1, left: "0%" }, 550).css("z-index","1");
				$("[name=sign_name]").val($("[name=reg_name]").val());
				$("[name=sign_pass]").val($("[name=reg_pass]").val());
				btn.html(btxt);
			}, 3000);
		}
	}, 'json');
	return false;
});


$("#pt-send-signin").on("submit", function(){
	var ths = $(this);
	var btn  = ths.find('button[type=submit]');
	var btxt = btn.html();

	btn.prop('disabled', true).html('<i class="fas fa-spinner fa-pulse fa-fw"></i> Loading..');

	$.post(path+"/ajax.php?pg=login", $(this).serialize(), function(puerto){
		ths.find(".pt-login-footer .form-row").before(puerto.alert);
		if(puerto.type == "danger"){
			setTimeout(function () {
				$(".alert").fadeOut('slow').remove();
				btn.html(btxt).prop('disabled', false);
			}, 3000);
		} else {
			setTimeout(function () {
				$(".alert").fadeOut('slow').remove();
				$(location).attr('href', path+"/index.php");
			}, 3000);
		}
		console.log(puerto);
	}, 'json');
	return false;
});

/** Logout **/
$('.pt-logout').on('click', function(){
	if(confirm(lang['alerts']['logout'])){
		$.post(path+"/ajax.php?pg=logout", {type: 1}, function(puerto){
			$(location).attr('href', path+'/index.php');
		});
	}
});



//####################################
//#####                          #####
//#####     6) User Details      #####
//#####                          #####
//####################################


$('#chooseFile').bind('change', function () {
  var filename = $("#chooseFile").val();
  if (/^\s*$/.test(filename)) {
    $(".file-upload").removeClass('active');
    $("#noFile").text("No file chosen...");
  }
  else {
    $(".file-upload").addClass('active');
    $("#noFile").text(filename.replace("C:\\fakepath\\", ""));
  }
});


//- Image Upload

$('#dropZone').imageUploader({
  fileField: '#chooseFile',
  urlField: '#url',
  hideFileField: false,
  hideUrlField: false,
  url: path+'/ajax.php?pg=imageupload',
  thumbnails: {
    div: '#thumbnails',
    crop: 'zoom',
    width: 150,
    height: 150
  },
  afterUpload: function (data) { console.log('after upload', data); $("[name=reg_photo]").val(data); },
  onFileAdded: function(file)        { console.log(file); },
  onFilesSelected: function()        { console.log('file selected'); },
  onUrlSelected: function()          { console.log('url selected'); },
  onDragStart: function(event)       { console.log(event); },
  onDragEnd: function(event)         { console.log(event); },
  onDragEnter: function(event)       { console.log(event); },
  onDragLeave: function(event)       { console.log(event); },
  onDragOver: function(event)        { console.log(event); },
  onDrop: function(event)            { console.log(event); },
  onUploadProgress: function(event)  { console.log(event); },
  beforeUpload: function()           { console.log('before upload'); $("#thumbnails").html(""); return true; },
  error: function(msg) { alert(msg); },
});

//- Send User Details

$(".pt-senduserdetails").on("submit", function(){
	$.post(path+"/ajax.php?pg=senduserdetails", $(this).serialize(), function(puerto) {
		if(puerto.type == 'success'){
			$.puerto_confirm("Success!", puerto.alert, "green");
		} else {
			$.puerto_confirm("Error!", puerto.alert, "red");
		}
	}, 'json');
	return false;
});




//####################################
//#####                          #####
//#####        6) Admin          #####
//#####                          #####
//####################################



if($(".pt-adminstats").length){
	$.get(path+"/ajax.php?pg=adminstats&request=daily", function(puerto) {
		var ass = JSON.parse(puerto);
		var DataLabelss = ass.labels;
		var DataCnts = ass.data;
		var DataTitle = ass.title;
		$.lineChart(DataLabelss,DataCnts,DataTitle);

	});

	$.get(path+"/ajax.php?pg=adminstatsbars&request=daily", function(puerto) {
		var ass = JSON.parse(puerto);
		var DataLabelss = ass.labels;
		var DataCnts = ass.data;
		var DataTitle = ass.title;
		var DataClrs = ass.colors;

		$.barChart("bar-chart", DataLabelss, DataCnts, DataClrs, DataTitle);

	});


	$(".pt-adminlines a").on("click", function(){
		var t = $(this).attr('href').replace('#','');
		var ids = $(this).attr('rel');
		$.get(path+"/ajax.php?pg=adminstats&request="+t, function(puerto) {
			var ass = JSON.parse(puerto);
			var DataLabelss = ass.labels;
			var DataCnts = ass.data;
			var DataTitle = ass.title;

			$.lineChart(DataLabelss,DataCnts, DataTitle);
		});
		return false;
	});


	$(".pt-adminbars a").on("click", function(){
		var t = $(this).attr('href').replace('#','');
		var ids = $(this).attr('rel');
		$.get(path+"/ajax.php?pg=adminstatsbars&request="+t, function(puerto) {
			var ass = JSON.parse(puerto);
			var DataLabelss = ass.labels;
			var DataCnts = ass.data;
			var DataTitle = ass.title;
			var DataClrs = ass.colors;

			$.barChart("bar-chart", DataLabelss, DataCnts, DataClrs, DataTitle);

		});
		return false;
	});
}

$(".pt-sendsettings").on("submit", function(){
	$.post(path+"/ajax.php?pg=sendsettings", $(this).serialize(), function(puerto){
		if(puerto.type == 'success'){
			$.puerto_confirm("Success!", puerto.alert, "green");
		} else {
			$.puerto_confirm("Error!", puerto.alert, "red");
		}
	}, 'json');
	return false;
});

$(".pt-sendplans").on("submit", function(){
	$.post(path+"/ajax.php?pg=sendplans", $(this).serialize(), function(puerto){
		if(puerto.type == 'success'){
			$.puerto_confirm("Success!", puerto.alert, "green");
		} else {
			$.puerto_confirm("Error!", puerto.alert, "red");
		}
	}, 'json');
	return false;
});

} ( jQuery ) )
