<form method="post" action="<?= _WEB_ROOT ?>/home/post_product">
    <div class="mb-3">
        <label for="" class="form-label">Name</label>
        <input type="text" name="name" id="" class="form-control" placeholder="Name">
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Age</label>
        <input type="text" name="age[]" id="" class="form-control" placeholder="age">
    </div>
    <button type="submit">submit</button>
</form>