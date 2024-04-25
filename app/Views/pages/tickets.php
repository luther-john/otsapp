<?= $this->extend('template/admin_template') ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tickets Management</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalform">Add Item</button>
            </div>
        </div>
        <div class="row  mb-2">
            <div class="col-12">
                <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>State</th>
                            <th>Severity</th>
                            <th>Description</th>
                            <th>Remarks</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                </table>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modalform">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Ticket</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate>
                    <div class="card-body">
                        <input type="hidden" id="id" name="id" />
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="First Name" placeholder="Enter First Name" required>
                            <div class="valid-feedback">Looks Good!</div>
                            <div class="invalid-feedback">Please enter your First Name</div>

                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="Last Name" placeholder="Enter Last Name" required>
                            <div class="valid-feedback">Looks Good!</div>
                            <div class="invalid-feedback">Please enter a valid code</div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" name="Email" placeholder="Enter Email" required>
                            <div class="valid-feedback">Looks Good!</div>
                            <div class="invalid-feedback">Please enter a email address</div>
                        </div>
                        <div class="form-group">
                            <label for="state">State</label>
                            <input type="text" class="form-control" id="state" name="State" placeholder="Enter State" required>
                            <div class="valid-feedback">Looks Good!</div>
                            <div class="invalid-feedback">Please enter a valid state</div>
                        </div>
                        <div class="form-group">
                            <label for="severity">Severity</label>
                            <input type="text" class="form-control" id="severity" name="Severity" placeholder="Enter State" required>
                            <div class="valid-feedback">Looks Good!</div>
                            <div class="invalid-feedback">Please enter a valid severity</div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control" id="description" name="Description" placeholder="Enter State" required>
                            <div class="valid-feedback">Looks Good!</div>
                            <div class="invalid-feedback">Please enter a valid description</div>
                        </div>
                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <input type="text" class="form-control" id="remarks" name="Remarks" placeholder="Enter State" required>
                            <div class="valid-feedback">Looks Good!</div>
                            <div class="invalid-feedback">Please enter a valid state</div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>



            </div>
            <!-- <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div> -->
        </div>

    </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('javascripts') ?>
<script>
$(function() {
        $('form').submit(function(e) {
            e.preventDefault();

            let formdata = $(this).serializeArray().reduce(function(obj, item) {
                obj[item.first_name] = item.value;
                obj[item.last_name] = item.value;
                return obj;
            }, {});
 
            let jsondata = JSON.stringify(formdata);

            console.log(formdata);
            console.log(jsondata);

            if (this.checkValidity()) {

                if (!formdata.id) {
                    //create
                    $.ajax({
                        url: "<?= base_url('tickets') ?>",
                        type: "POST",
                        data: jsondata,
                        success: function(response) {
                            $(document).Toasts('create', {
                                class: 'bg-success',
                                title: 'SUCCESS',
                                body: JSON.stringify(response.message),
                                autohide: true,
                                delay: 3000
                            });
                            $("#modalform").modal('hide');
                            table.ajax.reload();
                            clearform();
                        },
                        error: function(response) {
                            let parseresponse = JSON.parse(response.responseText);
                            $(document).Toasts('create', {
                                class: 'bg-danger',
                                title: 'ERROR',
                                body: JSON.stringify(parseresponse.message),
                                autohide: true,
                                delay: 3000
                            });
                        },
                    });
                } else {
                    // update
                    $.ajax({
                        url: "<?= base_url('tickets') ?>/" + formdata.id,
                        type: "PUT",
                        data: jsondata,
                        success: function(response) {
                            $(document).Toasts('create', {
                                class: 'bg-success',
                                title: 'SUCCESS',
                                body: JSON.stringify(response.message),
                                autohide: true,
                                delay: 3000
                            });
                            $("#modalform").modal('hide');
                            table.ajax.reload();
                            clearform();
                        },
                        error: function(response) {
                            let parseresponse = JSON.parse(response.responseText);
                            $(document).Toasts('create', {
                                class: 'bg-danger',
                                title: 'ERROR',
                                body: JSON.stringify(parseresponse.message),
                                autohide: true,
                                delay: 3000
                            });
                        },
                    });
                }


            }


        });
    });

    let table = $("#datatable").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        paging: true,
        lengthChange: true,
        lengthMenu: [5, 10, 20, 50],
        searching: true,
        ordering: true,
        autoWidth: false,
        ajax: {
            url: '<?= base_url('tickets/list') ?>',
            type: 'POST',
        },
        columns: [{
            data: 'id',
        }, {
            data: 'first_name',
        }, {
            data: 'last_name',
        },
        {
            data: 'email',
        },
        {
            data: 'state',
        },
        {
            data: 'severity',
        },
        {
            data: 'description',
        },
        {
            data: 'remarks',
        },       
        {
            data: '',
            defaultContent: `
                <td>
                <button type="button" class="btn btn-warning" id="editBtn">Edit</button>
                <button type="button" class="btn btn-danger" id="deleteBtn">Delete</button>
                </td>
                `
        }],
    });

    


$(document).on("click", "#editBtn", function() {
        let row = $(this).parents("tr")[0];
        let id = table.row(row).data().id;

        $.ajax({
            url: "<?= base_url('tickets'); ?>/" + id,
            type: "GET",
            success: function(response) {
                $("#modalform").modal('show');
                $("#id").val(response.id);
                $("#first_name").val(response.first_name);
                $("#last_name").val(response.last_name);
                $("#email").val(response.email);
                $("#state").val(response.state);
                $("#severity").val(response.severity);
                $("#description").val(response.description);
                $("#remarks").val(response.remarks);
            },
            error: function(response) {
                let parseresponse = JSON.parse(response.responseText);
                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: 'ERROR',
                    body: JSON.stringify(parseresponse.message),
                    autohide: true,
                    delay: 3000
                });
            },
        });

    });


    $(document).on("click", "#deleteBtn", function() {
        let row = $(this).parents("tr")[0];
        let id = table.row(row).data().id;

        if (confirm("Are you sure you want to delete this item?")) {
            $.ajax({
                url: "<?= base_url('tickets'); ?>/" + id,
                type: "DELETE",
                success: function(response) {
                    $(document).Toasts('create', {
                        class: 'bg-success',
                        title: 'SUCCESS',
                        body: JSON.stringify(response.message),
                        autohide: true,
                        delay: 3000
                    });
                    table.ajax.reload();
                },
                error: function(response) {
                    let parseresponse = JSON.parse(response.responseText);
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'ERROR',
                        body: JSON.stringify(parseresponse.message),
                        autohide: true,
                        delay: 3000
                    });
                },
            });
        }

    });


    
    $(document).ready(function() {
        'use strict';
        let form = $(".needs-validation");
        form.each(function() {
            $(this).on('submit', function(e) {
                if (this.checkValidity() === false) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                $(this).addClass('was-validated');
            });
        });
    });


    
    
    function clearform() {
        $("#id").val('');
        $("#first_name").val('');
        $("#last_name").val('');
        $("#email").val('');
        $("#state").val('');
        $("#severity").val('');
        $("#description").val('');
        $("#remarks").val('');
    }
</script>
<?= $this->endSection() ?>