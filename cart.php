<?php
session_start();
echo "<pre>";
print_r($_SESSION);
//session_destroy();
require_once("header.php");
require_once("dbconn.php");
$total = $gTotal = 0;
?>
<h1 class="txt-heading">Products</h1>
<button class="btn btn-warning">Clear Cart</button>
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
	<?php
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
			// print_r($productByCode);
			// echo $productByCode["id"];
			// exit();
			$itemArray = array('id'=>$productByCode["id"],'name'=>$productByCode["name"], 'quantity'=>$qnty, 'price'=>$productByCode["price"],'image'=>$productByCode["image"] );
			
			$x =in_array($productByCode["id"],$_SESSION["cart_item"],TRUE);
			var_dump($x);
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

	
	//$id = $_SESSION['id'];


	
	if (!empty($_SESSION["cart_item"])) { 
		foreach($_SESSION["cart_item"] as $key => $product_array){
	?>
	<tr>
	<td><?php echo $product_array["name"]; ?></td>
	<td><?php echo " $ ".$product_array["price"]; ?></td>
	<td>
		<button class="btn btn-sm btn-danger sub" >-</button>

		<span><input type="text"  class="" name="" id="qty_<?php echo $product_array["id"]; ?>" value="<?php echo $product_array["quantity"];?>" size="2" >

		<button class="btn btn-sm btn-success" onClick="increment_quantity(<?php echo $product_array["id"]; ?>)">+</button></span>
	</td>
	<?php $total = $product_array["price"]*$product_array["quantity"];?>
	<td><?php echo " $ ". $total ?></td>
	<td><button class="btn btn-sm btn-danger"> X</button><span></td>
	<?php $gTotal += $total ?>
	</tr>
	</div>
	
	<?php
			}
	}
	?>
	<tr>
		<?php //$total .= $total;?>
		<td><h3>Cart Total: $ </h3></td> 
		<td><h3><?php echo $gTotal?> </h3></td> 
	</tr>

	</table>
<br><br><br>
	<input type="button" class="btn btn btn-success" id="checkout"  value="Checkout"></td>
	</form>

<script>
function increment_quantity(cart_id) {
    var newQuantity = parseInt($("#qty_"+cart_id).val())+1;
    //$("#qty_"+cart_id).val(newQuantity);
	//$_SESSION["cart_item"][$k]["quantity"] = newQuantity;
	sessionStorage.setItem("['cart_item']['quantity']", "newQuantity");
}

	
</script>
</body>
</html>