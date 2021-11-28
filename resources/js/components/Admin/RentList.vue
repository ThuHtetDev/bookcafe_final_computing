<template>
     <div class="container">
        <div class="row" v-if="rentList.length > 0">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                    Book List
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
                        <th>Book Id</th>
                        <th>Book Name</th>
                        <th>Rented Member</th>
                        <th>Rented Range</th>
                        <th>In Date</th>
                        <th></th>
                    </tr>
                  </thead>
                  <tbody>
                        <tr v-for="(book,index) in rentList" :key="index">
                                <td> {{book.rentBookISBN}}</td>
                                <td>  {{book.rentBookName}} </td>
                                <td>{{book.rentMember}}</td>
                                <td>From {{book.startDate}} To {{book.returnDate}}</td>
                                <td>
                                    <span :class="book.checkDate ? 'bg-success' : 'bg-danger'">
                                         {{book.checkDate ? 'In Date' : 'Over Date'}}
                                    </span>
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
                rentList: []
            }
        },
        mounted(){
          this.getRentList();
        },
        methods: {
               getRentList: function(){
                this.$Progress.start();
                axios.get('/_bookcafe/admin/rent-list').then(response => {
                   this.rentList = response.data;
                  this.$Progress.finish();
                })
                .catch(error => {
                    console.log(error)
                })
            }
        }
    }
</script>