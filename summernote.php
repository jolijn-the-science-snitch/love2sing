<?php
require 'header.php';
?>

<!-- include summernote css/js-->
<link href="summernote.css" rel="stylesheet">
<script src="summernote.js"></script>


<script>
$(document).ready(function() {
  $('.summernote').summernote();
});
    
</script>
<div id="summernote">Hello Summernote</div>
<?php
require 'footer.php';
?>