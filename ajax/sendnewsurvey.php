<?php
# -------------------------------------------------#
#¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤#
#	¤                                            ¤   #
#	¤         Puerto Premium Survey 1.0          ¤   #
#	¤--------------------------------------------¤   #
#	¤              By Khalid Puerto              ¤   #
#	¤--------------------------------------------¤   #
#	¤                                            ¤   #
#	¤  Facebook : fb.com/prof.puertokhalid       ¤   #
#	¤  Instagram : instagram.com/khalidpuerto    ¤   #
#	¤  Site : http://www.puertokhalid.com        ¤   #
#	¤  Whatsapp: +212 654 211 360                ¤   #
#	¤                                            ¤   #
#	¤--------------------------------------------¤   #
#	¤                                            ¤   #
#	¤  Last Update: 29/03/2020                   ¤   #
#	¤                                            ¤   #
#¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤#
# -------------------------------------------------#

if($_SERVER['REQUEST_METHOD'] === 'POST'){
	if(us_level){


		$s_edit_id = isset($_POST['survey_id']) ? sc_sec($_POST['survey_id']) : '';

		if(!fh_access("survey") && !$s_edit_id){
			$alert = ["alert" => $lang['alerts']['permission'], "type" => "error"];
			echo json_encode($alert);
			exit;
		}

		if(($s_edit_id && !db_rows("survies WHERE id = '{$s_edit_id}' && author = '".us_id."'")) && us_level != 6){
			$alert = ["alert" => $lang['alerts']['wrong'], "type" => "error"];
			echo json_encode($alert);
			exit;
		}

		# Survey
		$s_title        = isset($_POST['survey_title']) ? sc_sec($_POST['survey_title'])                    : '';
		$s_url          = isset($_POST['survey_url']) ? sc_sec($_POST['survey_url'])                        : '';
		$s_startdate    = isset($_POST['survey_startdate']) && $_POST['survey_startdate'] ? strtotime(sc_sec($_POST['survey_startdate'])) : 0;
		$s_enddate      = isset($_POST['survey_enddate']) && $_POST['survey_enddate'] ? strtotime(sc_sec($_POST['survey_enddate']))     : 0;
		$s_status       = isset($_POST['survey_status']) ? 1                                                : 0;
		$s_private      = isset($_POST['survey_private']) ? 1                                               : 0;
		$s_byip         = isset($_POST['survey_byip']) ? 1                                                  : 0;
		$s_code         = isset($_POST['survey_code']) ? sc_sec($_POST['survey_code'])                      : sc_pass(time() + 1);
		$s_welcome_head = isset($_POST['survey_welcome_h']) ? sc_sec($_POST['survey_welcome_h'])   : '';
		$s_welcome_text = isset($_POST['survey_welcome_t']) ? sc_sec($_POST['survey_welcome_t'])   : '';
		$s_welcome_btn  = isset($_POST['survey_welcome_b']) ? sc_sec($_POST['survey_welcome_b'])   : '';
		$s_welcome_icon = isset($_POST['survey_welcome_bi']) ? sc_sec($_POST['survey_welcome_bi']) : '';
		$s_thank_head   = isset($_POST['survey_thank_h']) ? sc_sec($_POST['survey_thank_h'])       : '';
		$s_thank_text   = isset($_POST['survey_thank_t']) ? sc_sec($_POST['survey_thank_t'])       : '';
		$s_thank_btn    = isset($_POST['survey_thank_b']) ? sc_sec($_POST['survey_thank_b'])       : '';
		$s_thank_icon   = isset($_POST['survey_thank_bi']) ? sc_sec($_POST['survey_thank_bi'])     : '';

		$s_button_shadow       = isset($_POST['button_shadow']) ? (int)($_POST['button_shadow'])            : 0;
		$s_button_border_size  = isset($_POST['button_border_size']) ? (int)($_POST['button_border_size'])    : 0;
		$s_button_border_style = isset($_POST['button_border_style']) ? sc_sec($_POST['button_border_style']) : '';
		$s_button_border_color = isset($_POST['pg_bg_v']) ? sc_sec($_POST['pg_bg_v'])                         : '';
		$s_bg_gradient         = isset($_POST['bg_gradient']) ? (int)($_POST['bg_gradient'])            : 0;
		$s_bg_color1           = isset($_POST['bg_v1']) ? sc_sec($_POST['bg_v1'])                             : '';
		$s_bg_color2           = isset($_POST['bg_v2']) ? sc_sec($_POST['bg_v2'])                             : '';
		$s_txt_color           = isset($_POST['txt_v']) ? sc_sec($_POST['txt_v'])                             : '';
		$s_survey_bg           = isset($_POST['survey_bg']) ? sc_sec($_POST['survey_bg'])                     : '';
		$s_input_bg           = isset($_POST['input_bg']) ? sc_sec($_POST['input_bg'])                     : '';
		$s_step_bg           = isset($_POST['step_bg']) ? sc_sec($_POST['step_bg'])                     : '';



		# Answers Array
		$answers = isset($_POST['answer']) ? $_POST['answer'] : [];
		$break = true;



		function is_column_in_array($value,$column,$array){
      $rows = array_column( $array,$column);
      if( in_array($value,$rows)){
          return true;
      }
      return false;
    }


		$steps_for     = isset($_POST['step']) ? $_POST['step']         : [];
		$questions_for = isset($_POST['question']) ? $_POST['question'] : [];
		$answers_for   = isset($_POST['answer']) ? $_POST['answer']     : [];

		if(!$s_title || !$s_code){
			$alert = ["alert" => $lang['new']['alert']['error'], "type" => "error"];
		} elseif(empty($steps_for) || empty($questions_for) || empty($answers_for)){
			$err_n = (empty($steps_for) ? 'steps' : (empty($questions_for) ? 'questions' : 'answers'));
			$alert = ["alert" => str_replace('{var}', $err_n, $lang['new']['alert']['error1']), "type" => "error"];
		} else {

			# Initialization
			$break   = false;
			$data_st = [];
			$data_q  = [];
			$data_a  = [];

			foreach ($steps_for as $st_k => $st_v) {
				if(!is_column_in_array($st_v, 'step' ,$questions_for)){
					$alert = ["alert" => $lang['new']['alert']['error2']." {$st_v}!", "type" => "error"];
					$break = true;
					break;
				} else {
					# Step Data
					$st_k = (int)($st_k);
					$data_st[] = [
						"date"   => time(),
						"author" => us_id,
						"sort"   => "{$st_k}",
						"code"   => "{$s_code}"
					];

					foreach ($questions_for as $q_k => $q_v) {
						if($q_v['step'] == $st_v){
							$qq_arr   = fh_get_num($q_k);
							$q_sort   = sc_sec($qq_arr[0]);
							$q_inline = isset($q_v['inline']) ? 1 : 0;
							$q_status = isset($q_v['status']) ? 1 : 0;
							$q_title  = isset($q_v['title']) ? sc_sec($q_v['title']) : '';
							$q_desc   = isset($q_v['desc']) ? sc_sec($q_v['desc']) : '';
							$data_q[] = [
								"title"       => "{$q_title}",
								"description" => "{$q_desc}",
								"step"        => "{$st_k}",
								"status"      => "{$q_status}",
								"inline"      => "{$q_inline}",
								"sort"        => "{$q_sort}"
							];
							if(empty($q_title)){
								$alert = ["alert" => str_replace('{var}', "{$qq_arr[0]} -> step {$qq_arr[1]}", $lang['new']['alert']['error3']), "type" => "error"];
								$break = true;
								break 2;
							} elseif(!is_column_in_array($qq_arr[0], 'question' ,$answers_for) || !is_column_in_array($qq_arr[1], 'step' ,$answers_for)){
								$alert = ["alert" => $lang['new']['alert']['error4']." {$qq_arr[0]} -> step {$qq_arr[1]}!", "type" => "error"];
								$break = true;
								break 2;
							} else {
								foreach ($answers_for as $a_k => $a_v) {
									if($a_v['step'] == $st_v && $a_v['question'] == $q_sort){
										# Answer
										$a_title    = isset($a_v['name'])? sc_sec($a_v['name'])        :'';
										$a_icon     = isset($a_v['icon'])? sc_sec($a_v['icon'])        :'';
										$a_type     = isset($a_v['type'])? sc_sec($a_v['type'])        :'';
										$data_a[] = [
											"title"    => "{$a_title}",
											"step"     => "{$st_v}",
											"question" => "{$q_sort}",
											"type"     => "{$a_type}",
											"icon"     => "{$a_icon}",
											"aid"     => "{$a_k}"
										];
										if(empty($a_title) && $a_type != 'stars'){
											$alert = ["alert" => str_replace('{var}', "{$q_sort} -> step {$st_v}", $lang['new']['alert']['error5']), "type" => "error"];
											$break = true;
											break 3;
										} else {
											$alert = ["alert" => $lang['new']['alert']['success'], "type" => "success"];
										}
									}
								}

							}
						}
					}
				}

			}
			if(!$break){
				#------------------- Survey
				# Survey Data
				$data_u = [
					"title"        => "{$s_title}",
					"status"       => "{$s_status}",
					"private"      => "{$s_private}",
					"byip"         => "{$s_byip}",
					"url"          => "{$s_url}",
					"startdate"    => "{$s_startdate}",
					"enddate"      => "{$s_enddate}",
					"welcome_head" => "{$s_welcome_head}",
					"welcome_text" => "{$s_welcome_text}",
					"welcome_btn"  => "{$s_welcome_btn}",
					"welcome_icon" => "{$s_welcome_icon}",
					"thanks_head"  => "{$s_thank_head}",
					"thanks_text"  => "{$s_thank_text}",
					"thanks_btn"   => "{$s_thank_btn}",
					"thanks_icon"  => "{$s_thank_icon}",
					"button_shadow"  => "{$s_button_shadow}",
					"button_border_size"  => "{$s_button_border_size}",
					"button_border_style"  => "{$s_button_border_style}",
					"button_border_color"  => "{$s_button_border_color}",
					"bg_gradient"  => "{$s_bg_gradient}",
					"bg_color1"  => "{$s_bg_color1}",
					"bg_color2"  => "{$s_bg_color2}",
					"txt_color"  => "{$s_txt_color}",
					"survey_bg"  => "{$s_survey_bg}",
					"input_bg"  => "{$s_input_bg}",
					"step_bg"  => "{$s_step_bg}"
				];

				# Survey Insert
				if(!db_rows("survies WHERE title='{$s_title}' && author = '".us_id."' && code = '{$s_code}'") && !$s_edit_id){
					$data_u['code'] = "{$s_code}";
					$data_u['date'] = time();
					$data_u['author'] = us_id;
					db_insert("survies", $data_u);
				}
				# Survey Update
				if($s_edit_id){
					db_update("survies", $data_u, $s_edit_id);
				}

				# Get Survey Id
				$s_gid = $s_edit_id ? $s_edit_id : db_get("survies", "id", us_id, "author", "ORDER BY id DESC LIMIT 1");


				#------------------- Step
				# Step Insert
				foreach ($data_st as $key => $value) {
					if(!db_rows("steps WHERE survey = '{$s_gid}' && sort = '{$value["sort"]}'")){
						$value["survey"] = "{$s_gid}";
						db_insert("steps", $value);
					}
				}
				#------------------- Question
				# Question Insert
				foreach ($data_q as $key => $value) {
					if(!db_rows("questions WHERE survey = '{$s_gid}' && title = '{$value["title"]}'")){
						if(!$s_edit_id || ($s_edit_id && !db_rows("questions WHERE survey = '{$s_gid}' && step = '{$value["step"]}' && sort = '{$value["sort"]}'"))){
							$value["survey"] = "{$s_gid}";
							$value["code"]   = "{$s_code}";
							$value["author"] = us_id;
							$value["date"]   = time();
							db_insert("questions", $value);
						} else {
							db_update("questions", $value, $s_edit_id, "survey", "&& step = '{$value["step"]}' && sort = '{$value["sort"]}'");
						}
					}
				}

				#------------------- Answers
				# Question Answers
				foreach ($data_a as $key => $value) {
					if(!db_rows("answers WHERE survey = '{$s_gid}' && title = '{$value["title"]}' && question = '{$value["question"]}' && step = '{$value["step"]}'")){
						if(!$s_edit_id || ($s_edit_id && !db_rows("answers WHERE id = '{$value['aid']}'"))){
							$value["survey"] = "{$s_gid}";
							$value["code"]   = "{$s_code}";
							$value["author"] = us_id;
							$value["date"]   = time();
							unset($value['aid']);
							db_insert("answers", $value);
						} else {
							$update_aid = $value['aid'];
							unset($value['aid']);
							db_update("answers", $value, $s_edit_id, "survey", "&& id = '{$update_aid}' && step = '{$value["step"]}' && question = '{$value["question"]}'");
						}
					}
				}
			}
		}



		echo json_encode($alert);

	}
}
