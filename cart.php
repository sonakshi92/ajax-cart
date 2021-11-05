<?php
require_once("header.php");
require_once("dbconn.php");
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
    extract($_POST);
	$product = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
	if (!empty($product)) { 
		while($product_array= mysqli_fetch_array($product)){
	?>
	<tr>
	<td><?php echo $product_array["name"]; ?></td>
	<td><?php echo " $ ".$product_array["price"]; ?></td>
	<td>
		<button class="btn btn-sm btn-danger minus">-</button><span>
		<input type="text"  class="" name="" id="qty" value="1" size="2"> <button class="btn btn-sm btn-success">+</button></span>
	</td>
	<td><?php echo " $ ".$product_array["price"]; ?></td>
	<td><button class="btn btn-sm btn-danger"> X</button><span></td>
	</tr>
	</div>
	
	<?php
			}
	}
	?>
	</table>
<br><br><br>
	<h3>Cart Total: $ </h3> 
	<input type="button" id="checkout"  value="Checkout"></td>
	</form>

<script>
	
</script>
</body>
</html>