@extends('admin.layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span>Title</h4>
  <div class="row justify-content-center">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header d-flex justify-content-between">
              <h5 class="">Title</h5>
              <a href="#" class="btn btn-success">Add New </a>
            </div>
              <div class="card-body">
                <table class="table">
                  <thead class="table-dark">
                    <tr>
                      <th>ID</th>
                      <th>Parent</th>
                      <th>Name</th>
                      <th>Description</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody class="table-border-bottom-0">
                      <tr id="">
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>1</strong></td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>
                          111
                        </td>
                      </tr>
                  </tbody>
                </table>
                
              </div>
          </div> <!-- end card-box -->
      </div>
  </div>
</div>
@endsection