import _ from 'lodash';
window._ = _;

try {
    window.$ = window.jQuery = require('jquery');
    window.Popper = require('@popperjs/core');
    window.bootstrap = require('bootstrap');

} catch (e) {}


import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true;

window.axios.defaults.headers.common['CSRF-TOKEN'] = getToken();

window.BASE_URL = getBaseUrl();
window.API_URL = getApiUrl();
window.APP_URL = getAppUrl();
window.PUBLIC_URL = getPublicUrl();


function getToken()
{
    return document.getElementsByName("csrf-token")[0].getAttribute('value');
}

function getBaseUrl()
{
    return document.getElementsByName("base-url")[0].getAttribute('value');
}
function getApiUrl()
{
    let baseUrl = getBaseUrl();

    return `${baseUrl.replace("app.", "")}/api/${import.meta.env.VITE_API_VERSION}`;
}

function getAppUrl()
{
    let baseUrl = getBaseUrl();

    return baseUrl.replace("://", "://app.");
}

function getPublicUrl()
{
    let baseUrl = getBaseUrl();

    return baseUrl.replace("app.", "");
}
