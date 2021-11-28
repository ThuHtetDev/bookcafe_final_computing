<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                    Admin List
                </h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Role</th>
                      <th>Joined Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(admin,index) in admins" :key="index">
                      <td>{{admin.id}}</td>
                      <td>{{admin.name}}</td>
                      <td>{{admin.email}}</td>
                      <td><span class="tag tag-success">{{admin.type}}</span></td>
                      <td>{{admin.created_at}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <div class="input-group-append float-left">
                    <router-link to="/users/add-admin" class="btn btn-primary">Register New Admin</router-link>
                </div>
                <ul class="pagination pagination-sm m-0 float-right">
                  <li class="page-item"><a class="page-link" href="#">«</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">»</a></li>
                </ul>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
    </div>
</template>

<script>
    export default {
         data () {
            return {
            admins: [],
            }
        },
        mounted(){
               this.$Progress.start();
                axios.get("/_bookcafe/adminlist")
                .then((response) => {
                    this.admins = response.data.admins
                    this.$Progress.finish();
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    }
</script>