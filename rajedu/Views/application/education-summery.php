 <div class="card">
          <div class="card-body">
            <div class="card-block">
              <div class="timeline">
                <h4>Education Summary</h4>
                <hr>
                <div class="form-body">
                <div class="row">
                  <div class="col-md-12 text-center">
                    <button type="button" class="mr-1 mb-1 btn btn-outline-info btn-min-width"  data-toggle="modal" data-backdrop="false" data-target="#education-section-add"><i class="la la-plus-circle"></i> Add New Qualification</button>
                  </div>
                  
                 
                </div>

              </div>

               
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-4">
             <a href="<?php echo base_url(); ?>/new-application"><button type="submit" class="btn btn-primary center center-btn"><i class="la la-angle-left "></i>Back to information</button></a> 
          </div>
          <div class="col-md-4">
             <a href="<?php echo base_url(); ?>/new-application/experience-details"><button type="submit" class="btn btn-primary center center-btn"> Save and Continue<i class="la la-angle-right "></i></button></a> 
          </div>
          <div class="col-md-2"></div>
        </div>
        <div class="modal fade text-left" id="education-section-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" aria-hidden="true">
          <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-info white">
            <h4 class="modal-title white" id="myModalLabel11">Add Qualification</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
             <form class="form">
              <div class="form-body">
               
               
                <div class="row">

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="companyinput5">Qualification</label>
                      <select id="companyinput5" name="interested" class="form-control">
                        <option value="none" selected="" disabled="">Select Qualification</option>
                        <option value="design">BA</option>
                        <option value="development">BBA</option>
                        <option value="illustration">BCA</option>
                        <option value="branding">MCA</option>
                        <option value="video">MBA</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="companyinput5">Stream</label>
                      <select id="companyinput5" name="interested" class="form-control">
                        <option value="none" selected="" disabled="">Select Stream</option>
                        <option value="design">General</option>
                        <option value="development">Technical</option>
                      </select>
                    </div>
                  </div>

                  

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="companyinput5">Course From</label>
                      <input type="date" class="form-control" name="">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="companyinput5">Course To</label>
                      <input type="date" class="form-control" name="">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="companyinput5">Percentage</label>
                      <input type="text" class="form-control" name="">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="companyinput5">Back Logs</label>
                      <input type="text" class="form-control" name="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="companyinput5">Highest Qualification</label>
                      <select id="companyinput5" name="interested" class="form-control">
                        <option value="none" selected="" disabled="">Select One</option>
                        <option value="design">Yes</option>
                        <option value="development">No</option>
                      </select>
                    </div>
                  </div>


                </div>
              </div>

              <div class="form-actions text-center">
                 <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">
                   Save Now
                </button>
              </div>
            </form>
            </div>
           
          </div>
          </div>
        </div>