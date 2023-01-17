<div class="color-bg"></div>
</body>
</html>

<div class="modal fade" id="change-password-modal" tabindex="-1" role="dialog" aria-labelledby="change-password-modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Change Password</h5>
            </div>
            <div class="modal-body">
                <form action="" id="form-change-password">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" name="password" class="form-control">
                            <label class="form-label">Password</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" name="confirm_pwd" class="form-control">
                            <label class="form-label">Confirm Password</label>
                        </div>
                    </div>
                    <?= csrf_field(); ?>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-raised bg-blue-grey waves-effect mr-2" data-dismiss="modal">Close</button>
                <button class="btn bg-black waves-effect waves-light btn-change-password" type="submit">Save</button>
            </div>
        </div>
    </div>
</div>
