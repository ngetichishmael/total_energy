@if (count($errors) > 0)


   <section id="alerts-closable">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="card">
                   
                        <div class="card-body">
                     
                          <div class="demo-spacing-0">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                              <div class="alert-body">
                              <i data-feather="star"></i>
                       
							  @foreach ($errors->all() as $error)
				{{ $error }}
			@endforeach
                              </div>
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </section>
@endif
