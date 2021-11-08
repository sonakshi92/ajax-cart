<?php
require_once("dbconn.php");
//session_start();
$product = mysqli_query($conn, "SELECT * FROM products");
if (!empty($product)) { 
    while($product_array= mysqli_fetch_array($product)){
?>
<script>
    
</script>
<form id="product">
<div class="border" id="display">
    <input type="hidden" name="id" id="prod_id" value="<?php echo $product_array["id"]; ?>">
    <div><img src="<?php echo $product_array["image"]; ?>" width="100" height="100"></div>
    <div><strong><?php echo $product_array["name"]; ?></strong></div>
    <div class="text-danger">Price:<?php echo " $ ".$product_array["price"]; ?></div>
    <div><input type="button" name="add" id="add_<?php echo $product_array['id'];?>" onClick="cart(<?php echo $product_array['id'];?>);" class="btn btn-success addtocart" value="Add to cart"></div>
    <div><input type="button" name="added" id="added_<?php echo $product_array['id'];?>" style="display:none" class="addedtocart"  value="Already Added"></div>
    <input type="hidden" name="qnty" id="qnty" value="1">
</form>
</div >
<?php } } else{?>
<h1>No Products to display</h1>
<?php } ?>

<script>
    //$(document).ready(function(){
		//$('#add').click(function(){
            function cart(id){
            //var id = $('#prod_id').val();
           // alert(id); return false;
           var qnty=$('#qnty').val();
            jQuery.ajax({
                url: 'cart.php',
                data:{prod_id:id, qnty:qnty},
                type:'POST',
                success:function(data){
                   //$("#cart").html(data);
                    $("#add_"+id).hide();
                    $("#added_"+id).show();
                }
            });
           
		}
           
 //   });
</script>