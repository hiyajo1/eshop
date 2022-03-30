<form action="http://eshop/admin" class="edit-order" id="order" method="post" enctype="multipart/form-data">
	<div class="order-num" style="height: 20px;">Order <?= $order['ID'] ?></div>
	<select required id="status-id">
		<option value="0" disabled selected>Status ID</option>
		<option>0</option>
		<option>1</option>
	</select>
	<input required type="text" id="name" placeholder="Name...">
	<input required type="email" id="email" placeholder="Email...">
	<input required type="text" id="phone" placeholder="Phone number...">
	<textarea required type="text" id="comment" placeholder="Comment"></textarea>
	<input type="submit" value="Submit">
</form>