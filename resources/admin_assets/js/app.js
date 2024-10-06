import './bootstrap';
import './template'
import './helper'

import {createApp} from "vue";
import UpdatePasswordComponent from "./components/common/UpdatePasswordComponent.vue";
var app = createApp();
app.component('common-update-password', UpdatePasswordComponent);
app.mount("#app");
