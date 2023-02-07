 <div class="card">
  <div class="card-body">
    <div class="card-block">
      <div class="timeline">
        <h4>Mailing Address</h4>
        <hr>
        <form action="<?= site_url('application/update-maling-info') ?>" id="form-maling-adress-info">
          <div class="form-body">
            <div class="row">

              <div class="col-md-6">
                <div class="form-group">
                  <label for="address">Address 1</label>
                  <textarea  rows="5" class="form-control square" name="address" id="address" placeholder="Address 1"><?= empty($details) ? '' : $details['address'] ?></textarea>
                  <div class="error-feedback"></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="address_2">Address 2</label>
                  <textarea  rows="5" class="form-control square" name="address_2" id="address_2" placeholder="Address 2"><?= empty($details) ? '' : $details['address_2'] ?></textarea>
                    <div class="error-feedback"></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="country">Country</label>
                  <select id="country" name="country" class="form-control country-list">
                    <option value=""></option>
                    <?php if (! empty($details) && ! empty($country)): ?>
                      <option value="<?= $country['id'] ?>" selected><?= $country['name'] ?></option>
                    <?php endif ?>
                  </select>
                  <div class="error-feedback"></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="state">State</label>
                  <select id="state" name="state" class="form-control state-list">
                    <?php if (! empty($details) && ! empty($state)): ?>
                      <option value="<?= $state['id'] ?>" selected><?= $state['name'] ?></option>
                    <?php endif ?>
                  </select>
                  <div class="error-feedback"></div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="city">City</label>
                  <select id="city" name="city" class="form-control city-list">
                    <?php if (! empty($details) && ! empty($city)): ?>
                      <option value="<?= $city['id'] ?>" selected><?= $city['name'] ?></option>
                    <?php endif ?>
                  </select>
                  <div class="error-feedback"></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="pin_code">Pincode</label>
                  <input type="text"  class="form-control" placeholder="Pincode" name="pin_code" id="pin_code" value="<?= empty($details) ? '' : $details['pin_code'] ?>">
                  <div class="error-feedback"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?= csrf_field(); ?>
  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-4">
     <a href="<?php echo base_url(); ?>/new-application"><button type="submit" class="btn btn-primary center center-btn"><i class="la la-angle-left "></i>Back to information</button></a>
   </div>
   <div class="col-md-4">
     <input type="hidden" name="id" readonly id="id" value="<?= ! empty($details) ? encrypt($details['id']) : ''; ?>">
     <button type="submit" class="btn btn-primary center center-btn" id="btn-maling-adress-info"> Save and Continue<i class="la la-angle-right "></i></button>
   </div>
   <div class="col-md-2"></div>
 </div>
