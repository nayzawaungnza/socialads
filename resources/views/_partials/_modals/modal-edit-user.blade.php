<!-- Edit User Modal -->
<div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple modal-edit-user">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
          <h3 class="mb-2">Edit Teacher Information</h3>
          <p class="text-muted">Updating teacher details will receive a privacy audit.</p>
        </div>
        <form id="editUserForm" class="row g-3" action="{{ route('teachers.update', $teacher->id) }}" method="POST" onsubmit="return false">
          <div class="col-12 col-md-6">
            <label class="form-label" for="modalEditUserFirstName">Name</label>
            <input type="text" id="modalEditUserFirstName" name="name" value="{{ old('name', $teacher->name) }}" class="form-control @error('name') is-invalid @enderror" placeholder="John" />
            @error('name')
                <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
            @enderror
          </div>
          {{-- <div class="col-12 col-md-6">
            <label class="form-label" for="modalEditUserLastName">Last Name</label>
            <input type="text" id="modalEditUserLastName" name="modalEditUserLastName" class="form-control" placeholder="Doe" />
          </div> --}}
          <div class="col-12 col-md-6">
            <label class="form-label" for="modalEditUserName">Username</label>
            <input type="text" id="modalEditUserName" name="username"  class="form-control" placeholder="john.doe.007" />
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label" for="modalEditUserEmail">Email</label>
            <input type="text" id="modalEditUserEmail" value="{{ old('email', $teacher->email) }}" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="example@domain.com" />
          </div>
           <div class="col-12 col-md-6">
            <label class="form-label" for="modalEditUserPhone">Phone Number</label>
            <div class="input-group">
              {{-- <span class="input-group-text">MM (+1)</span> --}}
              <input type="text" id="modalEditUserPhone" name="mobile" value="{{ old('mobile', $teacher->mobile) }}" class="form-control phone-number-mask @error('mobile') is-invalid @enderror" placeholder="09 *** *** ***" />
            </div>
          </div>
          <div class="col-12 col-md-6">
           
                        <label class="form-label" for="multicol-join-date">Join Date <span class="text-danger">*</span></label>
                        <input
                          type="text"
                          name="join_date"
                          value="{{ old('join_date', $teacher->join_date) }}"
                          id="multicol-join-date"
                          class="form-control dob-picker flatpickr-input @error('join_date') is-invalid @enderror"
                          placeholder="YYYY-MM-DD" />
                          @error('join_date')
                            <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                          @enderror
                      
          </div>
         
          <div class="col-12">
            <label for="nrc_state" class="form-label">NRC <span class="text-danger">*</span> </label>
                              <div class="row">
                                  <div class="col-md-3 select2-purple">
                                      <select class="nrc_state form-control @error('nrc_number') is-invalid @enderror select2"  name="nrc_state" data-placeholder="xx" data-dropdown-css-class="" style="width: 100%;" data-attr-url="{{url('admin/nrc/getNrcTownshipByStateId')}}">
                                          <option value="">xx</option>
                                          @foreach ($nrcStates as $state)
                                          <option value="{{ $state->id }}" {{ ($teacher->nrc && $state->code==explode("-",$teacher->nrc)[0])?"selected":"" }}>{{$state->code}}</option>
                                          @endforeach
                                      </select>
                                      @error('nrc_state')
                                        <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                                      @enderror
                                  </div>
                                  <div class="col-md-4 select2-purple">
                                      <select class="nrc_township form-control @error('nrc_number') is-invalid @enderror select2" name="nrc_township" data-placeholder="xxx">
                                          <option value="">xxx</option>
                                          @foreach ($nrcTownships as $township)
                                          <option value="{{ $township->id }}" {{ ($teacher->nrc && $township->code==explode("-",$teacher->nrc)[1])?"selected":"" }}>{{$township->code}}</option>
                                          @endforeach
                                      </select>
                                      @error('nrc_township')
                                        <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                                      @enderror
                                  </div>
                                  <div class="col-md-2 select2-purple">
                                      <select class="nrc_type form-control @error('nrc_number') is-invalid @enderror select2" name="nrc_type" data-placeholder="x">
                                          <option value="">x</option>
                                          @foreach ($nrcTypes as $type)
                                          <option value="{{ $type->id }}" {{ ($teacher->nrc && $type->code==explode("-",$teacher->nrc)[2])?"selected":"" }}>{{$type->code}}</option>
                                          @endforeach
                                      </select>
                                      @error('nrc_type')
                                        <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                                      @enderror
                                  </div>
                                  <div class="col-md-3 select2-purple">
                                      <input type="text" name="nrc_number" class="form-control @error('nrc_number') is-invalid @enderror" id="nrc_number" placeholder="000000" value="{{ old('nrc_number', $teacher->nrc ? explode("-",$teacher->nrc)[3] : '') }}">
                                      
                                  </div>
                                  @error('nrc_number')
                                  <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                                  @enderror
                              </div>
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label" for="modalEditUserStatus">Status</label>
            <select id="modalEditUserStatus" name="is_active" class="select2 form-select" aria-label="Default select example">
              <option selected>Status</option>
              <option value="1" {{ old('is_active', $teacher->is_active) == 1 ? 'selected' : ''}}>Active</option>
              <option value="0" {{ old('is_active', $teacher->is_active) == 0 ? 'selected' : ''}}>Inactive</option>
              
            </select>
          </div>
          
         
          <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--/ Edit User Modal -->
