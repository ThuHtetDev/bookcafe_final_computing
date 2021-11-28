<template>
<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Create new with Google Account</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" @submit="formSubmit">
                <div class="card-body">
                 <div class="form-group" v-if="errors != null">
                    <div v-for="(error,index) in errors.email" :key="index">
                            <p style="color: red;">{{error}}</p>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="name">Email</label>
                    <input type="email" v-model="email" class="form-control" id="name" placeholder="Enter Google Account Mail" >
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-danger">Create</button>
                </div>
              </form>
            </div>
</template>

<script>
    export default {
            data () {
            return {
                email: '',
                errors: {}
            }
        },
        mounted() {
        },
        methods: {
            formSubmit: function(e){
                e.preventDefault();
                if(this.email != ''){
                    axios.post('/_bookcafe/member/save/social-account',{
                        email : this.email
                    })
                    .then(response => {
                        if(response.data.success == true){
                            swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: "Now This member is available when they login with this mail",
                                showConfirmButton: false,
                                timer: 3000
                            });
                            this.email = '';
                        }else{
                            console.log(response.data.message);
                            this.errors = response.data.message;
                            console.log(this.errors);
                        }
                    
               
                    })
                    .catch(error => {
                        console.log(error)
                    })
                }else{
                    swal.fire('Required', "*Please check required", 'error');
                }
            }
        }
    }
</script>
