<!-- *************************************************************************
                              password modal
************************************************************************** -->
<div  class="modal fade" id="passwordModal"
      tabindex="-1" role="dialog"
      aria-labelledby="passwordModal"
      aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="passwordModalTitle">Change Your Password</h5>
        <button type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="changePasswordForm">
          <div class="form-row" style="height:230px;">
          <div class="form-group col-sm-7">
              <label for="adminPassword">New password</label>
              <input type="password" class="form-control mb-4" id="pword" aria-describedby="passwordHelp" placeholder="Enter password">
          </div>
          <div class="form-group col-sm-5">
            <ul id="d1" class="list-group" style="font-size:0.75rem;">
              <li class="list-group-item list-group-item-success">Password Conditions</li>
              <li class="list-group-item password-condition" id="d2">One uppercase letter</li>
              <li class="list-group-item password-condition" id="d3">One lowercase letter</li>
              <li class="list-group-item password-condition" id="d4">One number</li>
              <li class="list-group-item password-condition" id="d5">8-72 characters</li>
            </ul>
          </div>
        </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm mr-auto" data-dismiss="modal">
              Cancel
            </button>
            <button id="pwButton" type="button" class="btn btn-primary btn-sm" disabled>
              Submit password change
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
