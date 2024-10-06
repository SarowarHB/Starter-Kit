<template>
    <!-- Modal -->
    <div class="modal fade" id="updatePasswordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">

            <form  v-on:submit.prevent="updatePassword()">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" ><i class="fas fa-edit"></i> Change Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="required">New Password</label>
                            <input v-model="data.password" type="password" class="form-control"  aria-describedby="emailHelp" placeholder="Password" required>
                             <small class="text-danger" v-if="validationErrors.password">{{ validationErrors.password[0] }}</small>
                        </div>
                        <div class="form-group">
                            <label class="required">Confirm Password</label>
                            <input v-model="data.password_confirmation" type="password" class="form-control"  aria-describedby="emailHelp" placeholder="Confirm Password" required>
                            <small class="text-danger" v-if="validationErrors.password_confirmation">{{ validationErrors.password_confirmation[0] }}</small>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="btn btn2-secondary"><i class="fas fa-save"></i> Update </button>
                    </div>
                </div>
            </form>

        </div>
    </div>

</template>

<script>
export default {
    name: "UpdatePasswordComponent",
    data(){
        return {
            modal_id : "#updatePasswordModal",
            data : {
                user_id : 0,
                password : '',
                password_confirmation : ''
            },
             validationErrors: {},
        };
    },
    computed: {
        base_url(){
            return window.BASE_URL;
        }
    },
    mounted() {
        const self = this;
        bus.on('common-update-password', function (user_id){
            self.data.user_id = user_id;
            $(self.modal_id).modal('show');
        })
    },
    methods: {
        updatePassword: function (){
            const self = this;
            const url = self.base_url + '/users/' + self.data.user_id + '/update-password-api';
            loading('show');
            axios.post(url, self.data)
                .then(response => {
                    notify(response.data.message, 'success');
                    $(self.modal_id).modal('hide');
                })
                .catch(error => {
                    const response = error.response;
                    console.log(response.data.errors.password);
                    if (response) {
                        if (response.status === 422)
                            this.validationErrors = error?.response?.data?.errors;
                        else
                            notify(response.data.message, 'error');
                    }
                })
                .finally(() => {
                    loading('hide');
                });
        }
    }
}
</script>

<style scoped>

</style>
