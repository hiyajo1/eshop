<form action="http://eshop/admin" class="new-item" name="form" method="post" enctype="multipart/form-data">
	<input required type="text" name="name" id="name" placeholder="Name...">
	<input required type="number" id="price" placeholder="Price...">
	<textarea required id="short-desc" placeholder="Description(short)..."></textarea>
	<textarea required id="full-desc" placeholder="Description(full)..."></textarea>
	<select required id="sort-order">
		<option value="0" disabled selected>Sort order</option>
		<option>0</option>
		<option>1</option>
	</select>
	<select required id="is-active">
		<option value="0" disabled selected>Is ACTIVE</option>
		<option>0</option>
		<option>1</option>
	</select>
	<input required type="file" name="img">
	<input type="submit" value="Submit">
</form>