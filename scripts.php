
<!-- Latest compiled and minified jQuery Library -->
<script src="<?=path?>/js/jquery-3.4.1.min.js"></script>

<!-- Bootstrap JS v4.4.1 -->
<script src="<?=path?>/js/popper.min.js"></script>
<script src="<?=path?>/js/bootstrap.min.js"></script>

<!-- Livequery plugin -->
<script src="<?=path?>/js/jquery.livequery.js"></script>

<!-- Font Awseome JS -->
<script src="<?=path?>/js/all.min.js"></script>

<!-- jConfirm plugin -->
<script src="<?=path?>/js/jquery-confirm.min.js"></script>

<!-- Datepicker plugin -->
<script src="<?=path?>/js/datepicker.min.js"></script>
<script src="<?=path?>/js/datepicker.en.js"></script>

<!-- Iconpicker plugin -->
<script src="<?=path?>/js/fontawesome-iconpicker.min.js"></script>

<!-- Mask plugin -->
<script type="text/javascript" src="<?=path?>/js/jquery.mask.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="<?=path?>/js/bootstrap-select.min.js"></script>

<!--sceditor -->
<script src="<?=path?>/js/minified/sceditor.min.js"></script>
<script src="<?=path?>/js/minified/formats/bbcode.js"></script>
<script src="<?=path?>/js/minified/icons/material.js"></script>

<!--Scroll -->
<script src="<?=path?>/js/jquery.scrollbar.js"></script>

<!--Charts -->
<script src="<?=path?>/js/Chart.min.js"></script>

<!--Upload -->
<script src="<?=path?>/js/jquery.uploader.js"></script>

<!--Color Picker -->
<script src="<?=path?>/js/spectrum.js"></script>

<script src="<?=path?>/js/select2.min.js"></script>

<script>
	var path         = '<?=path?>';
	var lang         = <?=json_encode($lang)?>;
	var maxsteps     = <?=surveys_steps?>;
	var maxquestions = <?=surveys_questions?>;
	var maxanswers   = <?=surveys_answers?>;
	var nophoto   = '<?=nophoto?>';
</script>

<script src="<?=path?>/js/question.js"></script>
<script src="<?=path?>/js/custom.js"></script>
