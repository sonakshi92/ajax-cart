<?php
require_once("dbconn.php");
//session_start();
$product = mysqli_query($conn, "SELECT * FROM products");
if (!empty($product)) { 
    while($product_array= mysqli_fetch_array($product)){
?>
<form id="product">
<div class="border" id="display">
    <input type="hidden" name="id" value="<?php echo $product_array["id"]; ?>">
    <div><img src="<?php echo $product_array["image"]; ?>" width="100" height="100"></div>
    <div><strong><?php echo $product_array["name"]; ?></strong></div>
    <div class="text-danger">Price:<?php echo " $ ".$product_array["price"]; ?></div>
    <div><input type="add" name="add" id="add" class="btn btn-success addtocart" onClick="cartAction('add','<?php echo $product_array['id']; ?>')" value="Add to cart"></div>
    <div><input type="button" name="added" id="added" style="display:none" class="addedtocart"  value="Already Added"></div>
</form>
</div >
<?php } } else{?>
<h1>No Products to display</h1>
<?php } ?>

<script>
    $(document).ready(function(){
		$('#add').click(function(){
        alert("added");
            jQuery.ajax({
                url: 'cart.php',
                data:id,
                type:'POST',
                success:function(data){
                    $("#cart").html(data);
                        $("#add").hide();
                        $("#addedtocart").show();
                }
            });
		});
    })
</script>