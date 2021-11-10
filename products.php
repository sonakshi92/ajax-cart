<?php
require_once("dbconn.php");
session_start();
//print_r($_SESSION);
$product = mysqli_query($conn, "SELECT * FROM products");
if (!empty($product)) { 
    while($product_array= mysqli_fetch_assoc($product)){
?>

<div class="border" id="display">
    <input type="hidden" name="id" id="prod_id" value="<?php echo $product_array["id"]; ?>">
    <div><img src="<?php echo $product_array["image"]; ?>" width="100" height="100"></div>

    <div><strong><?php echo $product_array["name"]; ?></strong></div>

    <div class="text-danger">Price:<?php echo " $ ".$product_array["price"]; ?></div>

    <?php
        $in_session = "0";
        if(!empty($_SESSION["cart_item"])) {
            $session_code_array = array_keys($_SESSION["cart_item"]);
            if(in_array($product_array["id"],$session_code_array)) {
                $in_session = "1";
            }
        }
    ?>
    <div><input type="button" name="add" id="add_<?php echo $product_array['id'];?>" onClick="cart(<?php echo $product_array['id'];?>);" class="btn btn-success addtocart" value="Add to cart" <?php if($in_session != "0") { ?>style="display:none" <?php } ?>></div>

    <div><input type="button" name="added" id="added_<?php echo $product_array['id'];?>"  class="addedtocart"  value="Already Added" <?php if($in_session != "1") { ?>style="display:none" <?php } ?>></div>
    <input type="hidden" name="qnty" id="qnty" value="1">
</div >
<?php } } else{?>
<h1>No Products to display</h1>
<?php } ?>

<script>
function cart(id){
var qnty=$('#qnty').val();
jQuery.ajax({
    url: 'cart.php',
    data:{prod_id:id, qnty:qnty},
    type:'POST',
    success:function(data){
        $("#add_"+id).hide();
        $("#added_"+id).show();
    }
});
}
</script>