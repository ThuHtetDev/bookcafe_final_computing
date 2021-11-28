<template>
    <div class="container">
        <div class="row" v-if="queueLists.length > 0">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                    My Queue Books List
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
                      <th>Rent Date</th>
                      <th>Request Date</th>
                      <th>Notification</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(book,index) in queueLists" :key="index">
                            <td>{{book.about_book.name}}</td>
                            <td>From <b>{{book.start_date}}</b> To <b>{{book.return_date}}</b> </td>
                            <td>{{book.created_at}}</td>
                            <td>{{book.rent_status == 'confirm' ? "Admin Confirmed But wait for request day" : "Please wait for admin confirmation" }}</td>
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
                queueLists: [],
            }
        },
        mounted(){
            this.getQueueList();
        },
        methods: {
            getQueueList: function(){
                this.$Progress.start();
                axios.get('/_bookcafe/member/queue-list').then(response => {
                   this.queueLists = response.data;
                  this.$Progress.finish();
                })
                .catch(error => {
                    console.log(error)
                })
            }
        }
    }
</script>