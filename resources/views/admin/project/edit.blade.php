  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.0/min/dropzone.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.0/dropzone.js"></script>
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Create New Course </h5>
              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">Close</button>
          </div>
          <form method="post" id="form" action="{{route('projects.update', $project->id)}}"
              enctype="multipart/form-data">
              @method('PUT')
              @csrf
              <div class="modal-body">
                  <div class="row">
                      <div class="col-12 mb-3">
                          <label for="inputNanme4" class="form-label">Project Name <span
                                  class="text-danger">*</span></label>
                          <input type="text" name="name" value="{{ $project->name }}" class="form-control" id="name"
                              placeholder="Project Name">
                      </div>


                      <div class="col-6 mb-3">
                          <label for="inputAddress" class="form-label">Assign Project to Staff<span
                                  class="text-danger">*</span></label>
                          <select name="assign_staff_id" id="assign_staff_id" class="form-control">
                              <option value="">Select Staff -- </option>
                              @foreach ($staffs as $staff)
                              <option {{ $staff->id == $project->assign_staff_id ? 'selected' : '' }}
                                  value="{{ $staff->id  }}">{{ $staff->name }}
                              </option>
                              @endforeach
                          </select>
                      </div>
                      <div class="col-6 mb-3">
                          <label for="inputAddress" class="form-label">Project Status <span
                                  class="text-danger">*</span></label>
                          <select name="status" id="status" class="form-control">
                              <option value="">Select Status -- </option>
                              <option {{ $project->status == 1 ? 'selected' : '' }} value="1">
                                  Active
                              </option>
                              <option {{ $project->status == 2 ? 'selected' : '' }} value="2">
                                  Inactive
                              </option>
                              <option {{ $project->status == 3 ? 'selected' : '' }} value="3">Hold
                              </option>
                          </select>
                      </div>
                      <div class="col-12">
                          <label for="inputAddress" class="form-label">Project Description <small
                                  class="text-primary">(optional)</small></label>
                          <textarea name="description" id="description" class="form-control" cols="5"
                              rows="2">{{ $project->description }}</textarea>
                      </div>
                      <div class="col-12 mb-3">
                          <label for="inputAddress" class="form-label">Files <span
                                  class="text-primary">(Optional)</span></label>
                          <div id="kt_dropzonejs_example_1" class="dropzone"></div>
                      </div>
                  </div>

              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary btn-sm">Save</button>
              </div>
          </form>
      </div>
  </div>