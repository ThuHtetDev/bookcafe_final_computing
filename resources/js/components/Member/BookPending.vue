<template>
    <div class="container">
        <div class="row" v-if="pendingLists.length > 0">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                    My Pending List
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
                      <th>Book-Name</th>
                      <th>Registerd At</th>
                      <th>Current Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(book,index) in pendingLists" :key="index">
                            <td>{{book.name}}</td>
                            <td>{{book.created_at}}</td>
                            <td>
                                <span class="right badge badge-warning">Pending</span>
                                <p v-if="book.is_reject == '1'">
                                  <span class="right badge badge-danger">
                                    Rejected By Admin
                                  </span>
                                </p>
                            </td>
                            <td class="project-actions">
                                <router-link :to="{ name: 'BookEdit', params: { id: book.id } }" class="btn btn-primary btn-sm text-white" >
                                  <span style="color: white"> Edit </span>
                                </router-link>
                                <button class="btn btn-danger btn-sm" @click="cancelBook(index,book.id)"> 
                                    Pending Cancel
                                </button>
                            </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <!-- <ul class="pagination pagination-sm m-0 float-right">
                  <li class="page-item"><a class="page-link" href="#">«</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">»</a></li>
                </ul> -->
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <div class="row" v-else>
          <div class="col-12 text-center mt-5">
              {{ trans('common.no_found_any') }}
          </div>
        </div>
    </div>
</template>

<script>
    export default {
         data () {
            return {
                pendingLists: [],
            }
        },
        mounted(){
            this.getPendingList();
        },
        methods: {
            getPendingList: function(){
                this.$Progress.start();
                axios.get('/_bookcafe/member/pending-list').then(response => {
                   this.pendingLists = response.data;
                })
                .catch(error => {
                    console.log(error)
                })
                this.$Progress.finish();
            },
            axiosPost: function(index,bookId){
                axios.post('/_bookcafe/member/pending-list/cancel',{
                        id : bookId
                    })
                    .then(response => {
                        swal.fire('Cancelled', 'You successfully cancel this book', 'success');
                        this.pendingLists.splice(index,1);
                    })
                    .catch(error => {
                        console.log(error)
                })
            },
            cancelBook: function(index,bookId){
                swal.fire({
                    title: 'Are you sure?',
                    text: 'This Book Request will be Cancel',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes Cancel it!',
                    cancelButtonText: 'No, Keep it!',
                    showCloseButton: true,
                    showLoaderOnConfirm: true
                    }).then((result) => {
                    if(result.value) {
                       this.axiosPost(index,bookId);
                    } else {
                        swal.fire('Sill Exist', 'Your Book is still exist', 'info')
                    }
                })
            }
        }
    }
</script>