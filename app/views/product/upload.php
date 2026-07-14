<div class="row justify-content-center">
  <div class="col-md-8">
    <h2>Upload Product</h2>
    <form method="post" enctype="multipart/form-data">
      <div class="mb-3"><label>Title</label><input name="title" class="form-control" required></div>
      <div class="mb-3"><label>Price</label><input name="price" class="form-control" required></div>
      <div class="mb-3"><label>Description</label><textarea name="description" class="form-control" required></textarea></div>
      <div class="mb-3"><label>File (zip/pdf)</label><input type="file" name="file" class="form-control" required></div>
      <button class="btn btn-primary">Upload</button>
    </form>
  </div>
</div>
