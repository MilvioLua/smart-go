( function ( $ ) {
    'use strict';

//- New Step

$(".pt-new-step").livequery("click", function(){
	var cnt = ($(".pt-new-step-content").length ? $(".pt-new-step-content").length+1 : 1 );
	var ths = $(this);
	ths.find('span').html('<i class="fas fa-spinner fa-spin"></i> '+lang['loading']+'');
	ths.after('<span class="pt-link-loading" style="width: '+$(this).width()+'px;height: '+$(this).height()+'px;"></span>');
	if(cnt > maxsteps){
		alert("maximum steps are "+maxsteps);
		setTimeout(function () {
			ths.find('span').html('<i class="far fa-plus-square"></i> '+lang["new"]["new_step"]);
			$(".pt-link-loading").remove();
		}, 500);
	} else {
		setTimeout(function () {
			ths.find('span').html('<i class="far fa-plus-square"></i> '+lang["new"]["new_step"]);
			$(".pt-link-loading").remove();
		}, 500);

		ths.before(
			'<div class="pt-new-step-content" data-step="'+cnt+'">'+
				'<h4>Step ('+cnt+'): <a class="pt-add-question-link" data-step="'+cnt+'">'+lang['new']['new_q']+'</a></h4>'+
				'<input type="hidden" name="step['+cnt+']" value="'+cnt+'"/>'+
			'</div>'
		);
		$('.pt-new-step-content[data-step="'+cnt+'"]').hide().fadeIn();
		$(".pt-new-survey-change").append(
			'<div class="pt-survey" data-step="'+cnt+'">'+
			'</div>'
		);
	}
	return false;
});

//- New Question

$(".pt-add-question-link").livequery("click", function(){
	var ths  = $(this);
	var step = ths.data('step');
	var qst  = $(".pt-new-step-content[data-step="+step+"] .pt-new-question-content").length + 1;

	var biggestNumQ = 0;
	if($('div[rel^="boxquestion_"][data-step="'+step+'"]').length){
		$('div[rel^="boxquestion_"][data-step="'+step+'"]').each(function(){
	    var currentNumQ = parseInt($(this).attr('rel').replace('boxquestion_', ''), 10);
	    if(currentNumQ > biggestNumQ) {
	        biggestNumQ = currentNumQ;
	    }
		});
	}

 	qst = biggestNumQ + 1;

	ths.html('<span><i class="fas fa-spinner fa-spin"></i> '+lang['loading']+'</span>');
	ths.after('<span class="pt-link-loading" style="width: 92px;height: 32px;right: 0;left: auto;border-radius: 50px;top: -7px;"></span>');
	if(qst > maxquestions){
		alert("maximum questions are "+maxquestions);
		setTimeout(function () {
			ths.html(lang['new']['new_q']);
			$(".pt-link-loading").remove();
		}, 500);
	} else {

		setTimeout(function () {
			ths.html(lang['new']['new_q']);
			$(".pt-link-loading").remove();
		}, 500);
		$(".pt-new-step-content[data-step="+step+"] h4").after(
			"<div class='pt-new-question-content' rel='boxquestion_"+qst+"' data-question='"+qst+"' data-step='"+step+"'>"+
			"<span class='deleteboxquestion_"+qst+"' data-step='"+step+"'><i class='fas fa-times'></i></span>"+
				"<div class='pt-question-inp'>"+
					"<label>Q"+qst+":</label>"+
					"<input type='hidden' name='question[q"+qst+"s"+step+"][step]' value='"+step+"'/>"+
					"<input type='text' name='question[q"+qst+"s"+step+"][title]' data-change='s"+step+"q"+qst+"' placeholder='"+lang['new']['new_qpl']+"'/>"+
					"<textarea name='question[q"+qst+"s"+step+"][desc]' data-change='s"+step+"q"+qst+"' placeholder='"+lang['new']['new_qde']+"'></textarea>"+
					'<div class="pt-radio-slide">'+
						'<input name="question[q'+qst+'s'+step+'][status]" class="tgl tgl-light" id="cbr'+qst+''+step+'" type="checkbox"/>'+
						'<label class="tgl-btn" for="cbr'+qst+''+step+'"></label> '+lang['new']['new_qre']+
					'</div>'+
					'<div class="pt-radio-slide">'+
						'<input name="question[q'+qst+'s'+step+'][inline]" class="tgl tgl-light" id="cbi'+qst+''+step+'" type="checkbox"/>'+
						'<label class="tgl-btn" for="cbi'+qst+''+step+'"></label> '+lang['new']['new_qln']+
					'</div>'+
				"</div>"+
				"<div class='pt-new-answers-content' data-question='"+qst+"' data-step='"+step+"'>"+
					"<b>"+lang['new']['new_a']+"</b>"+
					"<select class='pt-select'>"+
						"<option value='input' data-type='input'>"+lang['new']['new_as1']+"</option>"+
						"<option value='textarea' data-type='text'>"+lang['new']['new_as2']+"</option>"+
						"<option value='checkbox' data-type='checkbox'>"+lang['new']['new_as3']+"</option>"+
						"<option value='radio' data-type='radio'>"+lang['new']['new_as4']+"</option>"+
						"<option value='stars' data-type='stars'>"+lang['new']['new_as5']+"</option>"+
						"<option value='date' data-type='input'>"+lang['new']['new_as6']+"</option>"+
						"<option value='phone' data-type='input'>"+lang['new']['new_as7']+"</option>"+
						"<option value='country' data-type='input'>"+lang['new']['new_as8']+"</option>"+
						"<option value='email' data-type='input'>"+lang['new']['new_as9']+"</option>"+
					"</select>"+
					'<div class="pt-radio-slide">'+
						'<input name="answer_with_icon" class="tgl tgl-light" id="cbic'+qst+''+step+'" type="checkbox"/>'+
						'<label class="tgl-btn" for="cbic'+qst+''+step+'"></label> <b>'+lang['new']['new_asi']+'</b>'+
					'</div>'+
					"<a class='pt-add-answer-link' data-question='"+qst+"' data-step='"+step+"'>"+lang['new']['new_abtn']+"</a>"+
				"</div>"+
				"<div class='pt-new-answer-content'>"+
				"</div>"+
			"</div>"
		);

		$(".pt-new-question-content[data-question='"+qst+"'][data-step='"+step+"']").hide().fadeIn();

		$(".pt-survey[data-step="+step+"]").append(
			"<h3 data-link='s"+step+"q"+qst+"_title' rel='boxquestion_"+qst+"_appnd' data-step='"+step+"'></h3>"+
			"<p data-link='s"+step+"q"+qst+"_desc' rel='boxquestion_"+qst+"_appnd' data-step='"+step+"'></p>"
		);
	}

	return false;
});


//- New Answer


$(".pt-add-answer-link").livequery("click", function(){
	var qts           = $(this).data('question');
	var step          = $(this).data('step');
	var html          = "",
	    appnd         = "";

	var slct          = $(".pt-new-answers-content[data-question="+qts+"][data-step="+step+"] .pt-select");

	var answers_content = $(".pt-new-question-content[data-question="+qts+"][data-step="+step+"] .pt-new-answer-content");

	var biggestNum = 0;
	if($('div[class^="boxanswer_"]').length){
		$('div[class^="boxanswer_"]').each(function(){
	    var currentNum = parseInt($(this).attr('class').replace('boxanswer_', ''), 10);
	    if(currentNum > biggestNum) {
	        biggestNum = currentNum;
	    }
		});
	}


	var answers_count = $(".pt-new-question-content[data-question="+qts+"][data-step="+step+"] .pt-count-answers").length  + 1;
	var anid          = biggestNum + 1;

	var optn          = slct.find("option[value='"+slct.val()+"']").data('type');
	var icn           = $('[name="answer_with_icon"][id="cbic'+qts+''+step+'"]').is(":checked");

	var c_rad = $('.form-group[rel=rs'+step+'q'+qts+']').length;
	var c_che = $('.form-group[rel=cs'+step+'q'+qts+']').length;


	var ths = $(this);
	ths.html('<span style="font-size: 10px;"><i class="fas fa-spinner fa-spin"></i> '+lang['loading']+'</span>');
	ths.after('<span class="pt-link-loading" style="width: 78px;height: 32px;right: 11px;left: auto;top: 10px;border-radius: 50px;"></span>');

	if(answers_count > maxanswers){
		alert("maximum questions are "+maxanswers);
		setTimeout(function () {
			ths.html(lang['new']['new_abtn']);
			$(".pt-link-loading").remove();
		}, 500);
	} else {

	appnd += (slct.val() == "checkbox" || slct.val() == "radio" ? '' : "<div class='boxanswer_"+anid+"_appnd' rel='boxquestion_"+qts+"_appnd' data-step='"+step+"'>" );
	html += "<div class='boxanswer_"+anid+"'>";
	html += "<span class='deleteboxanswer_"+anid+"'><i class='fas fa-times'></i></span>";
	html += "<input type='hidden' name='answer["+anid+"][step]' value='"+step+"'>";
	html += "<input type='hidden' name='answer["+anid+"][question]' value='"+qts+"'>";
	html += "<input type='hidden' name='answer["+anid+"][type]' value='"+slct.val()+"'>";
	if(slct.val() == "input" || slct.val() == "email" || slct.val() == "date"){
		var inp_t = (slct.val() == "email" ? "email" : "text" );
		if(icn){
				html += "<div class='row'>"+
									"<div class='col'>"+
										"<input type='"+inp_t+"' name='answer["+anid+"][name]' placeholder='"+lang['new']['new_aspl']+"' class='pt-count-answers'>"+
									"</div>"+
									"<div class='col-4'>"+
										"<input type='text' name='answer["+anid+"][icon]' class='my' placeholder='"+lang['new']['new_asi']+"'><span class='changeicon'></span>"+
										"<script>$('.my').iconpicker({placement: 'bottom'}); $('.my').on('iconpickerSelected', function(event){ $(this).next('.changeicon').html('<i class=\"'+event.iconpickerValue+'\"></i>'); $('span[role=\"'+$(this).attr('name')+'\"]').html('<i class=\"'+$( this ).val()+'\"></i>');});</script>"+
									"</div>"+
								"</div>";

						appnd += '<div class="pt-survey-answers"><div class="pt-form-i">';
						appnd += "<span class='pt-icon' role='answer["+anid+"][icon]'><i class='far fa-user'></i></span><input type='text' role='answer["+anid+"][name]' placeholder='"+lang['new']['new_aspl']+"'>";
						appnd += "</div></div>";
		} else {
				html += "<input type='"+inp_t+"' name='answer["+anid+"][name]' placeholder='"+lang['new']['new_aspl']+"' class='pt-count-answers'>";

				appnd += '<div class="pt-survey-answers">';
				appnd += "<input type='text' role='answer["+anid+"][name]' placeholder='"+lang['new']['new_aspl']+"'>";
				appnd += "</div>";
		}

	} else if(slct.val() == "radio"){
		html += "<div class='pt-checkbox-add'>"+
							'<div class="form-group">'+
      					'<input type="radio" name="answer['+anid+'][names]" id="radio'+ anid +'" class="choice pt-count-answers">'+
      					'<label for="radio'+ anid +'"><input type="text" name="answer['+anid+'][name]" rel="aa'+anid+'" placeholder="'+lang['new']['new_asck']+'"></label>'+
    					'</div>'+
						"</div>";

		appnd += (!c_rad ? '<div class="pt-survey-answers pt-choice-tc" rel="boxquestion_'+qts+'_appnd" data-step="'+step+'">' : '' )+
      					'<div class="form-group boxanswer_'+anid+'_appnd" rel="rs'+step+'q'+qts+'">'+
      					'<input type="radio" name="answerss['+anid+'][name]" id="sradio'+ anid +'" class="choice">'+
	      					'<label for="sradio'+ anid +'" rel="aa'+anid+'">'+lang['new']['new_asck']+'</label>'+
    					'</div>'+
    					(!c_rad ? '</div>' : '' );

	} else if(slct.val() == "checkbox"){
		html += "<div class='pt-checkbox-add'>"+
							'<div class="form-group">'+
							'<input type="checkbox" name="answer['+anid+'][names]" id="checkbox'+ anid +'" class="choice pt-count-answers">'+
							'<label for="checkbox'+ anid +'"><input type="text" name="answer['+anid+'][name]" rel="aa'+anid+'" placeholder="'+lang['new']['new_asck']+'"></label>'+
    					'</div>'+
						"</div>";

			appnd += (!c_che ? '<div class="pt-survey-answers pt-choice-tc" rel="boxquestion_'+qts+'_appnd" data-step="'+step+'">' : '' )+
      					'<div class="form-group boxanswer_'+anid+'_appnd" rel="cs'+step+'q'+qts+'">'+
      					'<input type="checkbox" name="answerss['+anid+'][name]" id="sradio'+ anid +'" class="choice">'+
	      					'<label for="sradio'+ anid +'" rel="aa'+anid+'">'+lang['new']['new_asck']+'</label>'+
    					'</div>'+
    					(!c_che ? '</div>' : '' );

	} else if(slct.val() == "stars"){
		html += $.rating_inp();
		appnd += '<div class="pt-survey-answers">';
		appnd += $.rating_inp();
		appnd += "</div>";

	} else if(slct.val() == "textarea"){
		html += "<textarea name='answer["+anid+"][name]' placeholder='"+lang['new']['new_aspl']+"' class='pt-count-answers'></textarea>";
		appnd += '<div class="pt-survey-answers">';
		appnd += "<textarea role='answer["+anid+"][name]' placeholder='"+lang['new']['new_aspl']+"'></textarea>";
		appnd += "</div>";
	} else if(slct.val() == "date"){
		html += "<input type='text' name='answer["+anid+"][name]' placeholder='"+lang['new']['new_aspl']+"' class='pt-count-answers'>";
	} else if(slct.val() == "phone"){
		html += "<input type='phone' name='answer["+anid+"][name]' placeholder='"+lang['new']['new_aspl']+"' class='pt-count-answers'>";

		appnd += '<div class="pt-survey-answers"><div class="pt-form-i pt-form-phone">';
		appnd += '<span class="pt-icon"><i class="fas fa-phone-alt"></i></span>';
		appnd += '<select class="selectpicker"><option data-icon="flag-icon flag-icon-ma" value="MA"> (+212)</option></select>';
		appnd += '<input type="phone" role="answer['+anid+'][name]" placeholder="000-00-0000">';
		appnd += "</div></div><script>$('.selectpicker').selectpicker();</script>";
	} else if(slct.val() == "country"){
		html += "<input type='text' name='answer["+anid+"][name]' placeholder='"+lang['new']['new_aspl']+"' class='pt-count-answers'>";

		appnd += '<div class="pt-survey-answers"><div class="pt-form-i pt-countries"><span class="pt-icon"><i class="flag-icon flag-icon-ma"></i></span>';
		appnd += '<select class="selectpicker" role="answer['+anid+'][name]"></select>';
		appnd += "</div></div><script>$('.selectpicker').selectpicker();</script>";
	}
	appnd += (slct.val() == "checkbox" || slct.val() == "radio" ? '' : "</div>" );
	html += "</div>";

	$(".pt-new-question-content[data-question="+qts+"][data-step="+step+"] .pt-new-answer-content").append( html );
	if(c_rad && slct.val() == "radio") {
		$(".pt-survey[data-step="+step+"] .form-group[rel=rs"+step+"q"+qts+"]").parent().append( appnd );
	} else {
		if(c_che && slct.val() == "checkbox") {
			$(".pt-survey[data-step="+step+"] .form-group[rel=cs"+step+"q"+qts+"]").parent().append( appnd );
		} else {
			$(".pt-survey[data-step="+step+"] p[data-link=s"+step+"q"+qts+"_desc]").after( appnd );
		}
	}


	setTimeout(function () {
		ths.html(lang['new']['new_abtn']);
		$(".pt-link-loading").remove();
	}, 500);


		if(slct.val()){
			slct.find('option').attr("disabled","disabled");
			slct.find('option[data-type="'+optn+'"]').removeAttr('disabled');
		}

	}

	return false;
});



//- Delete

$('[class^="deleteboxanswer_"]').livequery("click", function(){
	var ths = $(this),
	     id = $(this).attr('class').replace('deleteboxanswer_','');
	if(confirm("Are you sure you want to delete this answer?")){

		if($(".pt-editsurveypage").length){
			$.get(path+"/ajax.php?pg=delete&request=answer&id="+id, function(data){
				ths.parent().fadeOut().remove();
				$('.'+ths.attr('class').replace('delete','')+'_appnd').fadeOut().remove();
				console.log("delete"+data);
			});

		} else {
			$(this).parent().fadeOut().remove();
			$('.'+$(this).attr('class').replace('delete','')+'_appnd').fadeOut().remove();
		}
	}
});

$('[class^="deleteboxquestion_"]').livequery("click", function(){
	var ths = $(this),
	     id = $(this).data('qid');
	if(confirm("Are you sure you want to delete this question?")){
		if($(".pt-editsurveypage").length){
			$.get(path+"/ajax.php?pg=delete&request=question&id="+id, function(data){
				ths.parent().fadeOut().remove();
				$('[rel='+ths.attr('class').replace('delete','')+'_appnd][data-step="'+ths.attr('data-step')+'"]').fadeOut().remove();
				console.log("delete"+data);
			});

		} else {
			$(this).parent().fadeOut().remove();
			$('[rel='+$(this).attr('class').replace('delete','')+'_appnd][data-step="'+$(this).attr('data-step')+'"]').fadeOut().remove();
		}

	}
});






//- Change for viewing


$( ".pt-question-inp input" ).livequery("change keyup", function() {
	var link = $(this).data('change');
	$("h3[data-link="+link+"_title]").html($( this ).val().replace(/<[^>]+>/g, ''));
});

$( ".pt-question-inp textarea" ).livequery("change keyup", function() {
	$("p[data-link="+$(this).data('change')+"_desc]").html($( this ).val().replace(/<[^>]+>/g, ''));
});

$( ".pt-new-answer-content input" ).livequery("change keyup", function() {
	$(".pt-survey-answers input[role='"+$(this).attr('name')+"']").attr('placeholder', $( this ).val().replace(/<[^>]+>/g, ''));
	$(".pt-survey-answers select[role='"+$(this).attr('name')+"']").attr('placeholder', $( this ).val().replace(/<[^>]+>/g, ''));
	$("label[rel='"+$(this).attr('rel')+"']").text($( this ).val().replace(/<[^>]+>/g, ''));
});

$('.pt-new-survey-change button').livequery('click', function(event){
	event.preventDefault();
  return false;
});


$( "input[name=survey_welcome_b]" ).livequery("change keyup", function() {
	$(".survey_welcome_b").html($( this ).val().replace(/<[^>]+>/g, ''));
});

$('input[name=survey_welcome_bi]').on('iconpickerSelected', function(event){
	$("[rel=survey_welcome_bi]").attr("class", event.iconpickerValue);
});


$( "input[name=survey_thank_b]" ).livequery("change keyup", function() {
	$(".survey_thank_b").html($( this ).val().replace(/<[^>]+>/g, ''));
});

$('input[name=survey_thank_bi]').on('iconpickerSelected', function(event){
	$("[rel=survey_thank_bi]").attr("class", event.iconpickerValue);
});


$.rating_inp = function(){
	return '<div class="rating"><input type="radio" name="rating" id="rating-5"><label for="rating-5"></label><input type="radio" name="rating" id="rating-4"><label for="rating-4"></label><input type="radio" name="rating" id="rating-3"><label for="rating-3"></label><input type="radio" name="rating" id="rating-2"><label for="rating-2"></label><input type="radio" name="rating" id="rating-1"><label for="rating-1"></label><div class="emoji-wrapper"><div class="emoji"><svg class="rating-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><circle cx="256" cy="256" r="256" fill="#ffd93b"/><path d="M512 256c0 141.44-114.64 256-256 256-80.48 0-152.32-37.12-199.28-95.28 43.92 35.52 99.84 56.72 160.72 56.72 141.36 0 256-114.56 256-256 0-60.88-21.2-116.8-56.72-160.72C474.8 103.68 512 175.52 512 256z" fill="#f4c534"/><ellipse transform="scale(-1) rotate(31.21 715.433 -595.455)" cx="166.318" cy="199.829" rx="56.146" ry="56.13" fill="#fff"/><ellipse transform="rotate(-148.804 180.87 175.82)" cx="180.871" cy="175.822" rx="28.048" ry="28.08" fill="#3e4347"/><ellipse transform="rotate(-113.778 194.434 165.995)" cx="194.433" cy="165.993" rx="8.016" ry="5.296" fill="#5a5f63"/><ellipse transform="scale(-1) rotate(31.21 715.397 -1237.664)" cx="345.695" cy="199.819" rx="56.146" ry="56.13" fill="#fff"/><ellipse transform="rotate(-148.804 360.25 175.837)" cx="360.252" cy="175.84" rx="28.048" ry="28.08" fill="#3e4347"/><ellipse transform="scale(-1) rotate(66.227 254.508 -573.138)" cx="373.794" cy="165.987" rx="8.016" ry="5.296" fill="#5a5f63"/><path d="M370.56 344.4c0 7.696-6.224 13.92-13.92 13.92H155.36c-7.616 0-13.92-6.224-13.92-13.92s6.304-13.92 13.92-13.92h201.296c7.696.016 13.904 6.224 13.904 13.92z" fill="#3e4347"/></svg><svg class="rating-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><circle cx="256" cy="256" r="256" fill="#ffd93b"/><path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534"/><path d="M328.4 428a92.8 92.8 0 0 0-145-.1 6.8 6.8 0 0 1-12-5.8 86.6 86.6 0 0 1 84.5-69 86.6 86.6 0 0 1 84.7 69.8c1.3 6.9-7.7 10.6-12.2 5.1z" fill="#3e4347"/><path d="M269.2 222.3c5.3 62.8 52 113.9 104.8 113.9 52.3 0 90.8-51.1 85.6-113.9-2-25-10.8-47.9-23.7-66.7-4.1-6.1-12.2-8-18.5-4.2a111.8 111.8 0 0 1-60.1 16.2c-22.8 0-42.1-5.6-57.8-14.8-6.8-4-15.4-1.5-18.9 5.4-9 18.2-13.2 40.3-11.4 64.1z" fill="#f4c534"/><path d="M357 189.5c25.8 0 47-7.1 63.7-18.7 10 14.6 17 32.1 18.7 51.6 4 49.6-26.1 89.7-67.5 89.7-41.6 0-78.4-40.1-82.5-89.7A95 95 0 0 1 298 174c16 9.7 35.6 15.5 59 15.5z" fill="#fff"/><path d="M396.2 246.1a38.5 38.5 0 0 1-38.7 38.6 38.5 38.5 0 0 1-38.6-38.6 38.6 38.6 0 1 1 77.3 0z" fill="#3e4347"/><path d="M380.4 241.1c-3.2 3.2-9.9 1.7-14.9-3.2-4.8-4.8-6.2-11.5-3-14.7 3.3-3.4 10-2 14.9 2.9 4.9 5 6.4 11.7 3 15z" fill="#fff"/><path d="M242.8 222.3c-5.3 62.8-52 113.9-104.8 113.9-52.3 0-90.8-51.1-85.6-113.9 2-25 10.8-47.9 23.7-66.7 4.1-6.1 12.2-8 18.5-4.2 16.2 10.1 36.2 16.2 60.1 16.2 22.8 0 42.1-5.6 57.8-14.8 6.8-4 15.4-1.5 18.9 5.4 9 18.2 13.2 40.3 11.4 64.1z" fill="#f4c534"/><path d="M155 189.5c-25.8 0-47-7.1-63.7-18.7-10 14.6-17 32.1-18.7 51.6-4 49.6 26.1 89.7 67.5 89.7 41.6 0 78.4-40.1 82.5-89.7A95 95 0 0 0 214 174c-16 9.7-35.6 15.5-59 15.5z" fill="#fff"/><path d="M115.8 246.1a38.5 38.5 0 0 0 38.7 38.6 38.5 38.5 0 0 0 38.6-38.6 38.6 38.6 0 1 0-77.3 0z" fill="#3e4347"/><path d="M131.6 241.1c3.2 3.2 9.9 1.7 14.9-3.2 4.8-4.8 6.2-11.5 3-14.7-3.3-3.4-10-2-14.9 2.9-4.9 5-6.4 11.7-3 15z" fill="#fff"/></svg><svg class="rating-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><circle cx="256" cy="256" r="256" fill="#ffd93b"/><path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534"/><path d="M336.6 403.2c-6.5 8-16 10-25.5 5.2a117.6 117.6 0 0 0-110.2 0c-9.4 4.9-19 3.3-25.6-4.6-6.5-7.7-4.7-21.1 8.4-28 45.1-24 99.5-24 144.6 0 13 7 14.8 19.7 8.3 27.4z" fill="#3e4347"/><path d="M276.6 244.3a79.3 79.3 0 1 1 158.8 0 79.5 79.5 0 1 1-158.8 0z" fill="#fff"/><circle cx="340" cy="260.4" r="36.2" fill="#3e4347"/><g fill="#fff"><ellipse transform="rotate(-135 326.4 246.6)" cx="326.4" cy="246.6" rx="6.5" ry="10"/><path d="M231.9 244.3a79.3 79.3 0 1 0-158.8 0 79.5 79.5 0 1 0 158.8 0z"/></g><circle cx="168.5" cy="260.4" r="36.2" fill="#3e4347"/><ellipse transform="rotate(-135 182.1 246.7)" cx="182.1" cy="246.7" rx="10" ry="6.5" fill="#fff"/></svg><svg class="rating-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><circle cx="256" cy="256" r="256" fill="#ffd93b"/><path d="M407.7 352.8a163.9 163.9 0 0 1-303.5 0c-2.3-5.5 1.5-12 7.5-13.2a780.8 780.8 0 0 1 288.4 0c6 1.2 9.9 7.7 7.6 13.2z" fill="#3e4347"/><path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534"/><g fill="#fff"><path d="M115.3 339c18.2 29.6 75.1 32.8 143.1 32.8 67.1 0 124.2-3.2 143.2-31.6l-1.5-.6a780.6 780.6 0 0 0-284.8-.6z"/><ellipse cx="356.4" cy="205.3" rx="81.1" ry="81"/></g><ellipse cx="356.4" cy="205.3" rx="44.2" ry="44.2" fill="#3e4347"/><g fill="#fff"><ellipse transform="scale(-1) rotate(45 454 -906)" cx="375.3" cy="188.1" rx="12" ry="8.1"/><ellipse cx="155.6" cy="205.3" rx="81.1" ry="81"/></g><ellipse cx="155.6" cy="205.3" rx="44.2" ry="44.2" fill="#3e4347"/><ellipse transform="scale(-1) rotate(45 454 -421.3)" cx="174.5" cy="188" rx="12" ry="8.1" fill="#fff"/></svg><svg class="rating-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><circle cx="256" cy="256" r="256" fill="#ffd93b"/><path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534"/><path d="M232.3 201.3c0 49.2-74.3 94.2-74.3 94.2s-74.4-45-74.4-94.2a38 38 0 0 1 74.4-11.1 38 38 0 0 1 74.3 11.1z" fill="#e24b4b"/><path d="M96.1 173.3a37.7 37.7 0 0 0-12.4 28c0 49.2 74.3 94.2 74.3 94.2C80.2 229.8 95.6 175.2 96 173.3z" fill="#d03f3f"/><path d="M215.2 200c-3.6 3-9.8 1-13.8-4.1-4.2-5.2-4.6-11.5-1.2-14.1 3.6-2.8 9.7-.7 13.9 4.4 4 5.2 4.6 11.4 1.1 13.8z" fill="#fff"/><path d="M428.4 201.3c0 49.2-74.4 94.2-74.4 94.2s-74.3-45-74.3-94.2a38 38 0 0 1 74.4-11.1 38 38 0 0 1 74.3 11.1z" fill="#e24b4b"/><path d="M292.2 173.3a37.7 37.7 0 0 0-12.4 28c0 49.2 74.3 94.2 74.3 94.2-77.8-65.7-62.4-120.3-61.9-122.2z" fill="#d03f3f"/><path d="M411.3 200c-3.6 3-9.8 1-13.8-4.1-4.2-5.2-4.6-11.5-1.2-14.1 3.6-2.8 9.7-.7 13.9 4.4 4 5.2 4.6 11.4 1.1 13.8z" fill="#fff"/><path d="M381.7 374.1c-30.2 35.9-75.3 64.4-125.7 64.4s-95.4-28.5-125.8-64.2a17.6 17.6 0 0 1 16.5-28.7 627.7 627.7 0 0 0 218.7-.1c16.2-2.7 27 16.1 16.3 28.6z" fill="#3e4347"/><path d="M256 438.5c25.7 0 50-7.5 71.7-19.5-9-33.7-40.7-43.3-62.6-31.7-29.7 15.8-62.8-4.7-75.6 34.3 20.3 10.4 42.8 17 66.5 17z" fill="#e24b4b"/></svg><svg class="rating-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><g fill="#ffd93b"><circle cx="256" cy="256" r="256"/><path d="M512 256A256 256 0 0 1 56.8 416.7a256 256 0 0 0 360-360c58 47 95.2 118.8 95.2 199.3z"/></g><path d="M512 99.4v165.1c0 11-8.9 19.9-19.7 19.9h-187c-13 0-23.5-10.5-23.5-23.5v-21.3c0-12.9-8.9-24.8-21.6-26.7-16.2-2.5-30 10-30 25.5V261c0 13-10.5 23.5-23.5 23.5h-187A19.7 19.7 0 0 1 0 264.7V99.4c0-10.9 8.8-19.7 19.7-19.7h472.6c10.8 0 19.7 8.7 19.7 19.7z" fill="#e9eff4"/><path d="M204.6 138v88.2a23 23 0 0 1-23 23H58.2a23 23 0 0 1-23-23v-88.3a23 23 0 0 1 23-23h123.4a23 23 0 0 1 23 23z" fill="#45cbea"/><path d="M476.9 138v88.2a23 23 0 0 1-23 23H330.3a23 23 0 0 1-23-23v-88.3a23 23 0 0 1 23-23h123.4a23 23 0 0 1 23 23z" fill="#e84d88"/><g fill="#38c0dc"><path d="M95.2 114.9l-60 60v15.2l75.2-75.2zM123.3 114.9L35.1 203v23.2c0 1.8.3 3.7.7 5.4l116.8-116.7h-29.3z"/></g><g fill="#d23f77"><path d="M373.3 114.9l-66 66V196l81.3-81.2zM401.5 114.9l-94.1 94v17.3c0 3.5.8 6.8 2.2 9.8l121.1-121.1h-29.2z"/></g><path d="M329.5 395.2c0 44.7-33 81-73.4 81-40.7 0-73.5-36.3-73.5-81s32.8-81 73.5-81c40.5 0 73.4 36.3 73.4 81z" fill="#3e4347"/><path d="M256 476.2a70 70 0 0 0 53.3-25.5 34.6 34.6 0 0 0-58-25 34.4 34.4 0 0 0-47.8 26 69.9 69.9 0 0 0 52.6 24.5z" fill="#e24b4b"/><path d="M290.3 434.8c-1 3.4-5.8 5.2-11 3.9s-8.4-5.1-7.4-8.7c.8-3.3 5.7-5 10.7-3.8 5.1 1.4 8.5 5.3 7.7 8.6z" fill="#fff" opacity=".2"/></svg></div></div></div>';
}



} ( jQuery ) )
