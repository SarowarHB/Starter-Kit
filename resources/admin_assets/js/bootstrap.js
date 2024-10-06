import _ from 'lodash';
window._ = _;

import mitt from 'mitt'
window.bus = mitt();

import.meta.glob([
    '../../images/**',
]);

import axios from 'axios';
import moment from "moment";
window.moment = moment;

import Swal from "sweetalert2";
window.Swal = Swal;

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.BASE_URL = getBaseUrl();
window.axios.defaults.headers.common['CSRF-TOKEN'] = getToken();

function getToken()
{
    return document.getElementsByName("csrf-token")[0].getAttribute('content');
}

function getBaseUrl()
{
    return document.getElementsByName("base-url")[0].getAttribute('content');
}



