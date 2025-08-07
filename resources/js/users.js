import Swal from 'sweetalert2';

const offcanvasEl = document.getElementById('userOffcanvas');
const offcanvas = bootstrap.Offcanvas.getOrCreateInstance(offcanvasEl);

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

const userTable = new DataTable('#userTbl', {
    processing: true,
    serverSide: true,
    dom: 'lBfrtip',
    buttons: [
        {
            extend: 'copyHtml5',
            text: '<i class="bi bi-clipboard"></i> Copy',
            className: 'btn btn-secondary'
        },
        {
            extend: 'excelHtml5',
            text: '<i class="bi bi-file-earmark-excel"></i> Excel',
            className: 'btn btn-success',
            action: function (e, dt, node, config) {
                var self = this;
                let oldStart = dt.settings()[0]._iDisplayStart;
                dt.one('preXhr', function (e, s, data) {
                    data.start = 0;
                    data.length = 2147483647;
                    dt.one('preDraw', function (e, settings, data) {
                        $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, node, config);
                        dt.ajax.reload();
                        dt.one('preXhr', function (e, s, data) {
                            data.start = oldStart;
                            data.length = dt.settings()[0]._iDisplayLength;
                        });
                    });
                });
                dt.ajax.reload();
            },
        },
        {
            extend: 'csvHtml5',
            text: '<i class="bi bi-file-earmark-csv"></i> CSV',
            className: 'btn btn-info'
        },
        {
            extend: 'pdfHtml5',
            text: '<i class="bi bi-file-earmark-pdf"></i> PDF',
            className: 'btn btn-danger'
        },
        {
            extend: 'print',
            text: '<i class="bi bi-printer"></i> Print',
            className: 'btn btn-primary',
            action: function (e, dt, node, config) {
               var location = '/invoices?' + $.param(dt.ajax.params());
               window.open(location, '_blank');
            }
        }
    ],
    ajax: {
        url: '/users/ajaxloadusers',
        type: 'POST',
        dataType: 'json',
        data: function (d) {
            d._token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        }
    },
    columns: [
        { data: 'id', name: 'id' },
        { data: 'name', name: 'name' },
        { data: 'email', name: 'email' },
        { data: 'rolepermissions' },
        { data: 'action', name: 'action', orderable: false, searchable: false }
    ],
    order: [[0, 'desc']],
    responsive: true,
});

$(document).on("click", ".edit", function (e) {
    e.preventDefault();
    $('#saveUserBtn').text('Update User');
    $('.offcanvas-title').text('Edit User');
    var userId = $(this).data("id");
    $('#userForm')[0].reset();
    $.ajax({
        url: '/users/' + userId + '/edit',
        type: 'GET',
        success: function (data) {
            $('#userForm').attr('action', '/users/' + userId);
            $('#name').val(data.user.name);
            $('#email').val(data.user.email);
            $('#id').val(data.user.uuid);
            $('#method').val('PUT');

            data.user.roles.forEach(r => $('#role_' + r.name).prop('checked', true));
            data.user.permissions.forEach(p => $('#permission_' + p.name.replace(/ /g, '_')).prop('checked', true));
            offcanvas.show();
        },
        error: function (xhr) {
            console.error(xhr.responseText);
        }
    });
});

$(document).on("click", "#saveUserBtn", function (e) {
    e.preventDefault();
    $('.is-invalid').removeClass('is-invalid');
    $('.text-danger').text('');

    const form = $('#userForm');
    const url = form.attr('action');
    const method = $('#method').val() == 'PUT' ? 'PUT' : 'POST';
    const formData = new FormData(form[0]);
    formData.append('_method', method);

    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
            userTable.ajax.reload();
            $('#userForm')[0].reset();
            $('#method').val('POST');
            $('#userForm').attr('action', '/users');
            offcanvas.hide();
            // if( $('#id').val()== '' ){
            //     Swal.fire({
            //         icon: 'success',
            //         title: 'Success',
            //         text: 'User created successfully!'
            //     });
            // } else {
            //     Swal.fire({
            //         icon: 'success',
            //         title: 'Success',
            //         text: 'User updated successfully!'
            //     });
            // }

            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: $('#id').val() == '' ? 'User created successfully!' : 'User updated successfully!'
            });
            $('#id').val('');
        },
        error: function (error) {
            const errors = error.responseJSON.errors;

            $.each(errors, function (indexInArray, valueOfElement) {
                const input = $('#' + indexInArray);
                input.addClass('is-invalid');
                input.closest('.form-group').find('.text-danger').text(valueOfElement[0]);
            });
        }
    });
});

$(document).on("click", "#createNewUserBtn", function (e) {
    e.preventDefault();
    $('.offcanvas-title').text('Create User');
    $('#userForm').attr('action', '/users');
    $('#userForm')[0].reset();
    $('#saveUserBtn').text('Create User');
    offcanvas.show();
});
