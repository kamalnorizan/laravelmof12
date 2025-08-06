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

DataTable.use(Select);
DataTable.use(Buttons);
DataTable.use(FixedColumns);
DataTable.use(FixedHeader);
DataTable.use(Responsive);

new DataTable('#userTbl', {
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
        { data: 'created_at', name: 'created_at' },
        { data: 'action', name: 'action', orderable: false, searchable: false }
    ],
    order: [[0, 'desc']],
    responsive: true,
});
