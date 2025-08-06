import JSzip from 'jszip';
import pdfMake from 'pdfmake';

import DataTable from 'datatables.net-bs5';
import Buttons from 'datatables.net-buttons-bs5';
import FixedColumns from 'datatables.net-fixedcolumns-bs5';
import FixedHeader from 'datatables.net-fixedheader-bs5';
import Responsive from 'datatables.net-responsive-bs5';
import Select from 'datatables.net-select-bs5';

import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';
import 'datatables.net-select-bs5/css/select.bootstrap5.min.css';
import Swal from 'sweetalert2';

DataTable.use(Select);
DataTable.use(Buttons);
DataTable.use(FixedColumns);
DataTable.use(FixedHeader);
DataTable.use(Responsive);

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
            $('.is-invalid').removeClass('is-invalid');
            $('.text-danger').text('');
            offcanvas.hide();
            if( $('#id').val()== '' ){
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'User created successfully!'
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'User updated successfully!'
                });
            }
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
    offcanvas.show();
});
