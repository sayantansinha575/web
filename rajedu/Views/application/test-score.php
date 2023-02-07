 <div class="card">
          <div class="card-body">
            <div class="card-block">
              <div class="timeline">
                <h4>Test Score</h4>
                <hr>
                <div class="form-body">
                <div class="row">
                  <div class="col-md-12 text-center">
                    <button type="button" class="mr-1 mb-1 btn btn-outline-info btn-min-width"  data-toggle="modal" data-backdrop="false" data-target="#test-section-add"><i class="la la-plus-circle"></i> Add New Test</button>
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
             <a href="<?php echo base_url(); ?>/new-application/experience-details"><button type="submit" class="btn btn-primary center center-btn"><i class="la la-angle-left "></i>Back to information</button></a> 
          </div>
          <div class="col-md-4">
             <a href="<?php echo base_url(); ?>/new-application/permanent-address"><button type="submit" class="btn btn-primary center center-btn"> Save and Continue<i class="la la-angle-right "></i></button></a> 
          </div>
          <div class="col-md-2"></div>
        </div>
        <div class="modal fade text-left" id="test-section-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" aria-hidden="true">
          <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-info white">
            <h4 class="modal-title white" id="myModalLabel11">Add New Test</h4>
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
                      <label for="companyinput5">Test Type</label>
                      <select id="companyinput5" name="interested" class="form-control">
                        <option value="none" selected="" disabled="">Select Test</option>
                        <option value="design">IELTS</option>
                        <option value="development">PTE</option>
                        <option value="illustration">TOEFL</option>
                        <option value="branding">ACT</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="companyinput5">Exam Date</label>
                      <input type="date" class="form-control" name="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="companyinput5">Overall Score</label>
                      <input type="input" class="form-control" name="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="companyinput5">Listening</label>
                      <input type="input" class="form-control" name="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="companyinput5">Reading</label>
                      <input type="input" class="form-control" name="">
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