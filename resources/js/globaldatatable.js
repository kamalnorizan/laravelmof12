import JSZip from 'jszip';
import pdfMake from 'pdfmake';
import pdfFonts from 'pdfmake/build/vfs_fonts';
import DataTable from 'datatables.net-bs5';
import Buttons from 'datatables.net-buttons-bs5';
import FixedColumns from 'datatables.net-fixedcolumns-bs5';
import FixedHeader from 'datatables.net-fixedheader-bs5';
import Responsive from 'datatables.net-responsive-bs5';
import Select from 'datatables.net-select-bs5';

import 'datatables.net-buttons/js/buttons.html5';
import 'datatables.net-buttons/js/buttons.print';
import 'datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css';

import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';
import 'datatables.net-select-bs5/css/select.bootstrap5.min.css';
import 'datatables.net-select-bs5/css/select.bootstrap5.min.css';
import 'datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css';
import 'datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css';


DataTable.use(Select);
DataTable.use(Buttons);
DataTable.use(FixedColumns);
DataTable.use(FixedHeader);
DataTable.use(Responsive);

pdfMake.vfs = pdfFonts.pdfMake.vfs;
window.JSZip = JSZip;

window.DataTable = DataTable;
window.pdfMake = pdfMake;
