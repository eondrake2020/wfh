@extends('master')

@section('content')
<h2 class="content-heading">Form Title</h2>
<div class="row">
    <div class="col-md-4">
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">Normal Form</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option">
                        <i class="si si-wrench"></i>
                    </button>
                </div>
            </div>
            <div class="block-content">
                <form action="be_forms_elements_bootstrap.html" method="post" onsubmit="return false;">
                    <div class="form-group">
                        <label for="example-nf-email">Email</label>
                        <input type="email" class="form-control" id="example-nf-email" name="example-nf-email" placeholder="Enter Email..">
                    </div>
                    <div class="form-group">
                        <label for="example-nf-password">Password</label>
                        <input type="password" class="form-control" id="example-nf-password" name="example-nf-password" placeholder="Enter Password..">
                    </div>
                    <div class="form-group">
                        <label for="example-select2">Normal</label>
                        <select class="js-select2 form-control" id="example-select2" name="example-select2" style="width: 100%;" data-placeholder="Choose one..">
                            <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                            <option value="1">HTML</option>
                            <option value="2">CSS</option>
                            <option value="3">JavaScript</option>
                            <option value="4">PHP</option>
                            <option value="5">MySQL</option>
                            <option value="6">Ruby</option>
                            <option value="7">Angular</option>
                            <option value="8">React</option>
                            <option value="9">Vue.js</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Date (format 1)</label>
                        <input type="text" class="js-flatpickr form-control bg-white" id="example-flatpickr-default" name="example-flatpickr-default" placeholder="Y-m-d">
                    </div>
                    <div class="form-group">
                        <label >Bootstrap's Custom File Input</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="example-file-input-custom" name="example-file-input-custom" data-toggle="custom-file-input">
                            <label class="custom-file-label" for="example-file-input-custom">Choose file</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-alt-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">Dynamic Table <small>Full</small></h3>
            </div>
            <div class="block-content block-content-full">
                <!-- DataTables functionality is initialized with .js-dataTable-full class in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
                <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                    <thead>
                        <tr>
                            <th class="text-center"></th>
                            <th>Name</th>
                            <th class="d-none d-sm-table-cell">Email</th>
                            <th class="d-none d-sm-table-cell" style="width: 15%;">Access</th>
                            <th class="text-center" style="width: 15%;">Profile</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">1</td>
                            <td class="font-w600">Justin Hunt</td>
                            <td class="d-none d-sm-table-cell">customer1@example.com</td>
                            <td class="d-none d-sm-table-cell">
                                <span class="badge badge-primary">Personal</span>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="View Customer">
                                    <i class="fa fa-user"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">2</td>
                            <td class="font-w600">Carol White</td>
                            <td class="d-none d-sm-table-cell">customer2@example.com</td>
                            <td class="d-none d-sm-table-cell">
                                <span class="badge badge-info">Business</span>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="View Customer">
                                    <i class="fa fa-user"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">3</td>
                            <td class="font-w600">Melissa Rice</td>
                            <td class="d-none d-sm-table-cell">customer3@example.com</td>
                            <td class="d-none d-sm-table-cell">
                                <span class="badge badge-danger">Disabled</span>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="View Customer">
                                    <i class="fa fa-user"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">4</td>
                            <td class="font-w600">Barbara Scott</td>
                            <td class="d-none d-sm-table-cell">customer4@example.com</td>
                            <td class="d-none d-sm-table-cell">
                                <span class="badge badge-danger">Disabled</span>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="View Customer">
                                    <i class="fa fa-user"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">5</td>
                            <td class="font-w600">Marie Duncan</td>
                            <td class="d-none d-sm-table-cell">customer5@example.com</td>
                            <td class="d-none d-sm-table-cell">
                                <span class="badge badge-success">VIP</span>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="View Customer">
                                    <i class="fa fa-user"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">6</td>
                            <td class="font-w600">Jose Parker</td>
                            <td class="d-none d-sm-table-cell">customer6@example.com</td>
                            <td class="d-none d-sm-table-cell">
                                <span class="badge badge-info">Business</span>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="View Customer">
                                    <i class="fa fa-user"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">7</td>
                            <td class="font-w600">Carol White</td>
                            <td class="d-none d-sm-table-cell">customer7@example.com</td>
                            <td class="d-none d-sm-table-cell">
                                <span class="badge badge-info">Business</span>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="View Customer">
                                    <i class="fa fa-user"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">8</td>
                            <td class="font-w600">Amanda Powell</td>
                            <td class="d-none d-sm-table-cell">customer8@example.com</td>
                            <td class="d-none d-sm-table-cell">
                                <span class="badge badge-warning">Trial</span>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="View Customer">
                                    <i class="fa fa-user"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">9</td>
                            <td class="font-w600">Lisa Jenkins</td>
                            <td class="d-none d-sm-table-cell">customer9@example.com</td>
                            <td class="d-none d-sm-table-cell">
                                <span class="badge badge-info">Business</span>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="View Customer">
                                    <i class="fa fa-user"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">10</td>
                            <td class="font-w600">Amanda Powell</td>
                            <td class="d-none d-sm-table-cell">customer10@example.com</td>
                            <td class="d-none d-sm-table-cell">
                                <span class="badge badge-primary">Personal</span>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="View Customer">
                                    <i class="fa fa-user"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection