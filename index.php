<?php
require_once("header.php");
?>
<h2 class="txt-heading">Products</h2>
<section id="display">
	
</section>

<script>
    $(document).ready(function(){
		load_products();
		function load_products(){
			$.ajax({
			url:'products.php',
			type:'post',
			success:function(data){
				$('#display').html(data);
			}
		});
		}
    })
</script>
</body>
</html>