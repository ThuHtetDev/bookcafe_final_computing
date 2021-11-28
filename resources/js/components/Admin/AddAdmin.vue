<template>
    <div class="container">
   <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">
                 <router-link to="/users/adminlist"><i class="fas fa-arrow-left"></i> </router-link>
                 <div style="width: 10px; display: inline-block;"></div>
                 <small>Register New Admin</small>
                </h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="quickForm" novalidate="novalidate" @submit.prevent="saveUser">
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="name" v-model="name" class="form-control" id="name" placeholder="Enter name">
                  </div>
                  <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" v-model="email" class="form-control" id="email" placeholder="Enter email">
                  </div>
               <div class="form-group ">
                    <label for="type">Role</label>
                        <select name="type" id="" @change="onChangeRes($event)" class="form-control">
                            <option value="admin">Admin</option>
                            <option value="superadmin">Superadmin</option>
                        </select>
                </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" v-model="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                  </div>
                  <div class="form-group mb-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="terms" class="custom-control-input" id="exampleCheck1">
                      <label class="custom-control-label" for="exampleCheck1">I agree to the <a href="#">terms of service</a>.</label>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Register</button>
                </div>
              </form>
            </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                name: '',
                email: '',
                role: 'admin',
                password: ''
            }
        },
        mounted() {
        },
        methods: {
            onChangeRes(event) {
                this.role = event.target.value;
            },
            saveUser: function(){
                let datas = {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    type: this.role
                };
                axios.post("/_bookcafe/admin/save",datas)
                .then((response) => {
                if(response.data.success == true){
                    swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: response.data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    this.name = '';
                    this.email = '';
                    this.password = '';
                    this.role = 'admin';
                    this.$router.push('/users/adminlist');
                }else{
                    swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: response.data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
                })
                .catch((error) => {
                        console.log(error);
                });
            }
        }
    }
</script>
