@extends('layoutsAdmin.app')
@section('contents')

    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Liste des cv</h4>
                </p>
                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Cv</th>
                        <th>Path</th>
                        <th>Status</th>
                        <th>Download</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($liste as $cv)
                      <tr>
                        <td>{{ $cv->file_name }}</td>
                        <td>{{ $cv->file_path }}</td>
                        <td><label class="badge badge-danger">Pending</label></td>
                        <td><a href="{{ asset($cv->file_path) }}" target="_blank" class="btn btn-primary">Download</a></td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
    </div>
@endsection