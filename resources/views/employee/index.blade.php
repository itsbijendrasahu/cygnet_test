@extends('layouts.app')

@section('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        Employee Listing
                        <button style="float: right; font-weight: 900;" class="btn btn-info btn-sm" type="button"
                            data-toggle="modal" data-target="#CreateEmployeeModal">
                            Create Employee
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered datatable">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Salary</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th width="150" class="text-center">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Employee Modal -->
<div class="modal" id="CreateEmployeeModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Employee Create</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="POST" enctype="multipart/form-data" id="SubmitCreateEmployeeForm" action="javascript:void(0)">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                        <strong>Success!</strong>Employee was added successfully.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="form-group">
                        <label for="salary_id">Salary:</label>
                        <select name="salary_id" id="salary_id" class="form-control">
                            <option value="">Select Salary</option>
                            @foreach($salaries as $salary)
                            <option value="{{$salary->id}}">{{$salary->salary}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Employee Name:</label>
                        <input type="text" class="form-control" name="name" id="name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" name="email" id="email">
                    </div>
                    <div class="form-group">
                        <label for="price">Password:</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>
                    <div class="form-group">
                        <label for="price">Image:</label>
                        <input type="file" class="form-control" name="image" id="image">
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="createEmp">Create</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Employee Modal -->
<div class="modal" id="EditEmployeeModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Employee Edit</h4>
                <button type="button" class="close modelClose" onclick="modal_close()"
                    data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <form method="POST" enctype="multipart/form-data" id="SubmitEditEmployeeForm" action="javascript:void(0)">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                        <strong>Success!</strong>Employee was updated successfully.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="EditEmployeeModalBody">

                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="updateEmp">Update</button>
                    <button type="button" class="btn btn-danger modelClose" onclick="modal_close()"
                        data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Employee Modal -->
<div class="modal" id="DeleteEmployeeModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Employee Delete</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <h4>Are you sure want to delete this Employee?</h4>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="SubmitDeleteEmployeeForm">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    function modal_close(dis) {
       $('#EditEmployeeModal').hide();
    }

    // $('.modelClose').on('click', function(){
    //     $('#EditEmployeeModal').hide();
    // });

    $(document).ready(function() {
        // init datatable.
        var dataTable = $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            pageLength: 5,
            // scrollX: true,
            "order": [[ 0, "desc" ]],
            ajax: '{{ route('get-employees') }}',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'salary.salary', name: 'salary.salary'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'Actions', name: 'Actions',orderable:false,serachable:false,sClass:'text-center'},
            ]
        });

        // Create Employee Ajax request.
        $('#SubmitCreateEmployeeForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('employees.store') }}",
                method: 'post',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success: function(result) {
                    if(result.errors) {
                        $('.alert-danger').html('');
                        $.each(result.errors, function(key, value) {
                            $('.alert-danger').show();
                            $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                        });
                    } else {
                        $('.alert-danger').hide();
                        $('.alert-success').show();
                        $('.datatable').DataTable().ajax.reload();
                        this.reset();
                        setInterval(function(){
                            $('.alert-success').hide();
                            $('#CreateEmployeeModal').modal('hide');
                            // location.reload();
                        }, 2000);
                    }
                }
            });
        });

        // Get single Employee in EditModel
        var id;
        $('body').on('click', '#getEditEmployeeData', function(e) {
            e.preventDefault();
            $('.alert-danger').html('');
            $('.alert-danger').hide();
            id = $(this).data('id');
            $.ajax({
                url: "employees/"+id+"/edit",
                method: 'GET',
                success: function(result) {
                    $('#EditEmployeeModalBody').html(result.html);
                    $('#EditEmployeeModal').show();
                }
            });
        });

        // Update Employee Ajax request.
        $('#SubmitEditEmployeeForm').submit(function(e) {
            e.preventDefault();
            var formDataUpdate = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "employees/"+id,
                method: 'PUT',
                data: {
                    salary_id: $('#editsalary_id').val(),
                    name: $('#editemployee_name').val(),
                    email: $('#editemail').val(),
                    password: $('#editpassword').val(),
                },
                success: function(result) {
                    if(result.errors) {
                        $('.alert-danger').html('');
                        $.each(result.errors, function(key, value) {
                            $('.alert-danger').show();
                            $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                        });
                    } else {
                        $('.alert-danger').hide();
                        $('.alert-success').show();
                        $('.datatable').DataTable().ajax.reload();
                        setInterval(function(){
                            $('.alert-success').hide();
                            $('#EditEmployeeModal').hide();
                        }, 2000);
                    }
                }
            });
        });

        // Delete Employee Ajax request.
        var deleteID;
        $('body').on('click', '#getDeleteId', function(){
            deleteID = $(this).data('id');
        })
        $('#SubmitDeleteEmployeeForm').click(function(e) {
            e.preventDefault();
            var id = deleteID;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "employees/"+id,
                method: 'DELETE',
                success: function(result) {
                    $('.datatable').DataTable().ajax.reload();
                    setInterval(function(){
                        location.reload();
                        $('#DeleteEmployeeModal').hide();
                    }, 1000);
                }
            });
        });
    });
</script>

@endsection
