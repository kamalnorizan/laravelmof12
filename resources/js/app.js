
import $ from 'jquery';
import select2 from  'select2/dist/js/select2.full.min.js';
import 'select2/dist/css/select2.min.css';
import 'select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.min.css';
select2();

window.$ = $;
window.jQuery = $;

import Hammer from 'hammerjs';
import Waves from 'node-waves';
import PerfectScrollbar from 'perfect-scrollbar';
import Swal from 'sweetalert2';



window.Hammer = Hammer;
window.PerfectScrollbar = PerfectScrollbar;
window.Swal = Swal;



import './js/bootstrap.js';
import './js/menu.js';
import './js/dropdown-hover.js';
import './js/mega-dropdown.js';
import './js/helpers.js';
import './config.js';

import './main.js';


Waves.init();

$(document).ready(function () {
    $('.logout-button').on('click', function (e) {
        e.preventDefault();
        $('#logout-form').submit();
    });
});
