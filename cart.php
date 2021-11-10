<?php
session_start();
//echo "<pre>";
//print_r($_SESSION);
//session_destroy();
require_once("header.php");
require_once("dbconn.php");
$total = $gTotal = 0;
if(empty($_POST['prod_id'])){
	$_POST['prod_id']="";
	$_POST['qnty']= "";
}
extract($_POST);
$id = $_POST['prod_id'];
$qnty = $_POST['qnty'];
if($id != ''){
	if(!empty($qnty)) {
		$query = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
		$productByCode = mysqli_fetch_assoc($query);
		$itemArray = array('id'=>$productByCode["id"],'name'=>$productByCode["name"], 'quantity'=>$qnty, 'price'=>$productByCode["price"],'image'=>$productByCode["image"] );
		if(!empty($_SESSION["cart_item"])) {
			if(array_key_exists($productByCode["id"],$_SESSION["cart_item"])) {
				foreach($_SESSION["cart_item"] as $k => $v) {
						if($productByCode["id"] == $k)
							$_SESSION["cart_item"][$k]["quantity"] = $_POST["qnty"];
				}
			} else {
				$_SESSION["cart_item"][$productByCode["id"]] = $itemArray;
			}
		} else {
			$_SESSION["cart_item"][$productByCode["id"]] = $itemArray; // created session 1st time whensite is open
		}
	}
}
if (!empty($_SESSION["cart_item"])) { 
?>

<h1 class="txt-heading">Products</h1>
<button class="btn btn-warning" onClick="cartAction('empty','');">Clear Cart</button>
<form id="cart" >
<table class="table table-striped">
	<thead>
	<tr>
		<th>Product</th>
		<th>Price</th>
		<th>Quantity</th>
		<th>Total</th>
		<th>Action</th>
	</tr>
	</thead>
	<tbody>
	<?php
		foreach($_SESSION["cart_item"] as $key => $product_array){
	?>
	<tr>
	<td><?php echo $product_array["name"]; ?></td>
	<td>$ <?php echo $product_array["price"]; ?></td>
		<input type="hidden" class="iprice" value="<?php echo $product_array["price"]; ?>">
	<td>
		<input type="button" class="btn btn-sm btn-danger sub" value="-" onClick="dec(<?php echo $product_array["id"]; ?>)"><span><input type="number"  class="iquantity" id="qty_<?php echo $product_array["id"]; ?>" value="<?php echo $product_array["quantity"];?>" size="2" onchange="subTotal()"><input type="button" class="btn btn-sm btn-success" value="+" onClick="inc(<?php echo $product_array["id"]; ?>)"></span>
	</td>
	<?php $total = $product_array["price"]*$product_array["quantity"];?>
	<td class="itotal"><?php echo " $ ". $total ?></td>
	<td><input type="button" class="btn btn-sm btn-danger" onClick="cartAction('remove', '<?php echo $product_array["id"];?>')" value="X"></td>
	<?php $gTotal += $total ?>
	</tr>
	</div>
	<?php } ?>
	<tr>
		<?php //$total .= $total;?>
		<td><h3>Cart Total: $ </h3></td> 
		<td><h3><span id="cTotal"><?php echo $gTotal?></span> </h3></td> 
	</tr>
	</tbody>
	</table>
	<input type="button" class="btn btn btn-success" id="checkout"  value="Checkout"></td>
	<?php }else{
			echo "<div class='container'><h2>Your Cart is Empty</h2>  <a href='index.php'>Click to Add Products</a></div>";
			} ?>
<br><br><br>

<script>
function inc(cart_id) {
    var newQuantity = parseInt($("#qty_"+cart_id).val())+1;
    $("#qty_"+cart_id).val(newQuantity);
	subTotal();
	
}
function dec(cart_id) {
    var newQuantity = parseInt($("#qty_"+cart_id).val())-1;
    $("#qty_"+cart_id).val(newQuantity);
	subTotal();
}

var iprice=document.getElementsByClassName('iprice');
var iquantity=document.getElementsByClassName('iquantity');
var itotal=document.getElementsByClassName('itotal');
var cTotal=document.getElementById('cTotal');
var ct=0; 
function subTotal(){
	ct=0;
	for ( i = 0; i < iprice.length; i++) {
		itotal[i].innerText = (iprice[i].value)*(iquantity[i].value);
		ct = ct + (iprice[i].value)*(iquantity[i].value);
	}
	cTotal.innerText = ct;
}


function cartAction(action, product_id) {
	var queryString = "";
	if(action != "") {
		switch(action) {
			case "remove":
				queryString = 'action='+action+'&code='+ product_id;
			break;
			case "empty":
				queryString = 'action='+action;
			break;
		}	 
	}
	jQuery.ajax({
        url: "checkout.php",
        data:queryString,
        type: "POST",
        success:function(data){
			//if(action == "empty" )
			window.location.reload();
		},
		error:function (){}
        });
}
</script>
</body>
</html>