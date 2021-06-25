<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <!-- DANGER MODAL -->
    <div class="modal fade" id="dangerModal" tabindex="-1" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal-danger" role="document">
        <div class="modal-content">

          <div class="modal-header">
            <h4 class="modal-title">Modal title</h4>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>

          <div class="modal-body">
            <p>One fine body…</p>
          </div>

          <div class="modal-footer">
            <button id="modal-danger-close"class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
            <input id='hidden_id' type="hidden" name="hidden_id" value="">
            <input id="modal-danger-save"type="submit" class="btn btn-danger modal-delete-btn" name="modal-delete-btn"value="Delete">
          </div>
        </div>
      </div>
    </div>

    <!-- SUCCESS CONFIRM MODAL -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal-success" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Modal title</h4>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>

          <div class="modal-body">
            <p>One fine body…</p>
          </div>

          <div class="modal-footer">
            <button id="modal-success-close" class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
            <button id="modal-success-save" class="btn btn-success" type="button">Save changes</button>
          </div>

        </div>
      </div>
  </div>

  <!-- EDIT MODAL -->
  <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-info" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <h4 class="modal-title">Modal title</h4>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>

        <div class="modal-body">

        </div>

        <div class="modal-footer">
          <button id="modal-info-close" class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
          <input id="modal-info-save" type="submit" value="Save changes" class="btn btn-info">
        </div>
      </div>
    </div>
</div>
<!-- Bootstrap core JavaScript-->
<script src="../assets/vendor/jquery/jquery.min.js"></script>
<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="../assets/js/sb-admin-2.min.js"></script>
  </body>
</html>
