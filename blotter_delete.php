
<!-- STATUS -->
<div class="modal fade" id="updateStatus<?php echo $row['blotter_Id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
       <div class="modal-header bg-light">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fa-solid fa-user-large"></i> Update status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i class="fa-solid fa-circle-xmark"></i></span>
        </button>
      </div>
      <div class="modal-body">
        <form action="process_update.php" method="POST">
          <input type="hidden" class="form-control" value="<?php echo $row['blotter_Id']; ?>" name="blotter_Id">
          <select name="blotter_status" class="form-control" id="" required>
            <option value="0" <?php if($row['blotter_status'] == 0) { echo 'selected'; } ?>>Open</option>
            <option value="1" <?php if($row['blotter_status'] == 1) { echo 'selected'; } ?>>Close</option>
            <option value="2" <?php if($row['blotter_status'] == 2) { echo 'selected'; } ?>>Under Investigation</option>
          </select>
      </div>
      <div class="modal-footer alert-light">
        <button type="button" class="btn bg-secondary" data-dismiss="modal"><i class="fa-solid fa-ban"></i> Cancel</button>
        <button type="submit" class="btn bg-primary" name="update_blotter_status"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
      </div>
        </form>
    </div>
  </div>
</div>






<!-- DELETE -->
<div class="modal fade" id="delete<?php echo $row['blotter_Id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
       <div class="modal-header bg-light">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fa-solid fa-user-large"></i> Delete blotter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i class="fa-solid fa-circle-xmark"></i></span>
        </button>
      </div>
      <div class="modal-body">
        <form action="process_delete.php" method="POST">
          <input type="hidden" class="form-control" value="<?php echo $row['blotter_Id']; ?>" name="blotter_Id">
          <h6 class="text-center">Delete blotter record?</h6>
      </div>
      <div class="modal-footer alert-light">
        <button type="button" class="btn bg-secondary" data-dismiss="modal"><i class="fa-solid fa-ban"></i> Cancel</button>
        <button type="submit" class="btn bg-danger" name="delete_blotter"><i class="fas fa-trash"></i> Delete</button>
      </div>
        </form>
    </div>
  </div>
</div>








