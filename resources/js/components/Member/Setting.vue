<template>
<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Change Your Own Password</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
                <div class="card-body">
                  <div class="form-group row">
                    <label for="inputPassword1" class="col-sm-2 col-form-label">Old Password</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="inputPassword1" v-model="oldPass" placeholder="Old Password">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword2" class="col-sm-2 col-form-label">New Password</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="inputPassword2"  v-model="newPass" placeholder="New Password">
                    </div>
                  </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Confirm Password</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="inputPassword3"  v-model="confirmPass" placeholder="Confirm Password">
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button @click="savePassword" class="btn btn-primary btn-block">Change password</button>
                </div>
                <!-- /.card-footer -->
            </div>
</template>

<script>
    export default {
            data () {
            return {
                oldPass: null,
                newPass: null,
                confirmPass: null,
                errors: []
            }
        },
        mounted(){
        },
        methods: {
            savePassword:function(){
                if(this.oldPass != null && this.newPass != null && this.confirmPass != null){
                    if(this.newPass != this.confirmPass ){
                        swal.fire('Type Again', 'New Password Does not Match', 'info');
                    }else{
                         this.checkPassword();
                         this.oldPass = '';
                         this.newPass = '';
                         this.confirmPass = '';

                    }
                }else{
                    swal.fire('Required', 'Please Fill blanked', 'info');
                }
            },
            checkPassword(){
                this.$Progress.start();
                 let data = {
                  old_pass: this.oldPass,
                  new_pass : this.newPass,
                  confirm_pass: this.confirmPass
                }
                axios.post("/_bookcafe/change-password",data)
                .then((response) => {
                    if(response.data.success == 'true'){
                        swal.fire('Password Changed', 'Your Password is now changed', 'success');
                    }else{
                        swal.fire('Password Wrong', 'Old password is wrong', 'error');
                    }
                    this.$Progress.finish();
                })
                .catch((error) => {
                    console.log(error);
                });
            },

        }
    }
</script>
<style scoped>
#preview {
 background: grey;
 width: 600px;
 height: 600px;
}
</style>