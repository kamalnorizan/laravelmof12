
import $ from 'jquery';
import Hammer from 'hammerjs';
import Waves from 'node-waves';
import PerfectScrollbar from 'perfect-scrollbar';
import Swal from 'sweetalert2';

window.$ = $;
window.jQuery = $;
window.Hammer = Hammer;
window.PerfectScrollbar = PerfectScrollbar;
window.Swal = Swal;

import './js/bootstrap.js';
import './js/menu.js';
import './js/dropdown-hover.js';
import './js/mega-dropdown.js';
import './js/helpers.js';
import './config.js';
import '../scss/libs/@form-validation/popular.js';
import '../scss/libs/@form-validation/auto-focus.js';
import '../scss/libs/@form-validation/bootstrap5.js';

import './pages-auth.js';

import './main.js';
Waves.init();
