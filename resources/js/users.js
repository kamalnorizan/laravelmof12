import JSZip from 'jszip';
import pdfMake from 'pdfmake';
import pdfFonts from 'pdfmake/build/vfs_fonts';

import DataTable from 'datatables.net-bs5';
import Select from 'datatables.net-select-bs5';
import Buttons from 'datatables.net-buttons-bs5';
import Responsive from 'datatables.net-responsive-bs5';
import FixedColumns from 'datatables.net-fixedcolumns-bs5';
import FixedHeader from 'datatables.net-fixedheader-bs5';
import RowGroup from 'datatables.net-rowgroup-bs5';

import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';
import 'datatables.net-select-bs5/css/select.bootstrap5.min.css';

// Register plugins
DataTable.use(Select);
DataTable.use(Buttons);
DataTable.use(Responsive);
DataTable.use(FixedColumns);
DataTable.use(FixedHeader);
DataTable.use(RowGroup);

// Set PDF export
pdfMake.vfs = pdfFonts.pdfMake.vfs;
window.JSZip = JSZip;

const offcanvasEl = document.getElementById('userOffCanvas');
const offcanvas = bootstrap.Offcanvas.getOrCreateInstance(offcanvasEl);

const initFilters = () => {
    // Avoid double init if this runs more than once
    $('#rolesFilter, #permissionsFilter').each(function () {
        if (!$(this).data('select2')) {
            $(this).select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: 'Select',
                allowClear: true
            });
        }
    });
};

$(function () {
    // Quick sanity checks in console (optional)
    console.log('jQuery?', !!window.jQuery, $.fn.jquery);
    console.log('Has select2?', typeof $.fn.select2 === 'function');

    initFilters();
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
});

new DataTable('#userTbl', {
    dom: 'Bfrtip',
    responsive: true,
    select: true,
    serverSide: true,
    buttons: ['copy', 'excel', 'pdf', 'print'],
    ajax: {
        url: '/users/ajaxloadusers',
        method: 'POST',
        data: function (d) {
            d._token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            d.roles = $('#rolesFilter').val();
            d.permissions = $('#permissionsFilter').val();
            return d;
        },
    },
    columns: [
        { data: 'id', title: 'ID' },
        { data: 'name', title: 'Name' },
        { data: 'email', title: 'Email' },
        { data: 'role', title: 'Role/Permission' },
        { data: 'action', title: 'Actions', orderable: false, searchable: false }
    ],
});

$('#createNewUserBtn').click(function (e) {
    e.preventDefault();
    $('#userOffCanvas .offcanvas-title').text('Create User');
    $('#userForm').attr('action', '/users');
    $('#userForm')[0].reset();
    offcanvas.show();
});

$(document).on('click', '.edit', function () {
    const userId = $(this).data('id');
    const url = `/users/${userId}/edit`;
    $('#userForm')[0].reset();
    $.ajax({
        url: url,
        method: 'GET',
        success: function (data) {
            $('#userOffCanvas .offcanvas-title').text('Edit User');
            $('#userForm').attr('action', `/users/${userId}`);
            $('#name').val(data.user.name);
            $('#email').val(data.user.email);
            $('#method').val('PUT');

            data.user.roles.forEach(r => $(`#role_${r.name.replace(/\s+/g, '_')}`).prop('checked', true));
            data.user.permissions.forEach(p => $(`#permission_${p.name.replace(/\s+/g, '_')}`).prop('checked', true));

            offcanvas.show();
        },
        error: function (error) {
            console.error('Error fetching user data:', error);
        }
    });

    offcanvas.show();

});

$(document).on('click', '.delete', function () {
    const userId = $(this).data('id');
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/users/${userId}`,
                method: 'DELETE',
                data: {
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                success: function () {
                    Swal.fire(
                        'Deleted!',
                        'User has been deleted.',
                        'success'
                    );
                    $('#userTbl').DataTable().ajax.reload();
                },
                error: function (error) {
                    console.error('Error deleting user:', error);
                    Swal.fire(
                        'Error!',
                        'There was an error deleting the user.',
                        'error'
                    );
                }
            });
        }
    });
});

$(document).on('click', '#saveUserBtn', function () {
    $('.is-invalid').removeClass('is-invalid');
    $('.text-danger').text('');
    const form = $('#userForm');
    const url = form.attr('action');
    const method = $('#method').val() === 'PUT' ? 'PUT' : 'POST';
    const formData = new FormData(form[0]);

    formData.append('_method', method);

    $.ajax({
        url: url,
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            offcanvas.hide();
            $('#userForm')[0].reset();
            Swal.fire(
                'Success!',
                'User has been saved successfully.',
                'success'
            );
            $('#userTbl').DataTable().ajax.reload();
        },
        error: function (error) {
            var errors = error.responseJSON.errors;
            $.each(errors, function (key, value) {
                $('#' + key).addClass('is-invalid');
                $('#' + key).next('.invalid-feedback').remove();
                $('#' + key).closest('.form-group').find('.text-danger').text(value[0]);
            });
        }
    });
});

$('#rolesFilter, #permissionsFilter').change(function (e) {
    e.preventDefault();

    const selectedRoles = $('#rolesFilter').val();
    const selectedPermissions = $('#permissionsFilter').val();

    $('#userTbl').DataTable().ajax.reload();
});

