


<form>
Cím: <input type="text" name="title" maxlength="50"/><br />
<input type="hidden" name="created_by" value="1"/>

<?php
	//$CKEditor = new Yii::app()->ckeditor;
	//echo Yii::app()->ckeditor->textarea("field1", "<p>Initial value.</p>");
	Yii::app()->clientScript->registerScriptFile(YiiBase::getPathOfAlias('ext') . '/ckeditor/ckeditor.js');
?>

<textarea type="textarea" id="editor1" name="editor1"></textarea><br />
<input type="submit" value="Létrehoz" />



</form>

<script type="text/javascript">
	CKEDITOR.replace( 'editor1' );
</script>