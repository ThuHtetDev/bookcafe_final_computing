<template>
    <div class="container">
        <div class="row" v-if="!isEmpty(booklists)">
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
                      <th>Queue Member List</th>
                      <th>Detail</th>
                    </tr>
                  </thead>
                  <tbody>
                        <tr v-for="(books,index) in booklists" :key="index">
                                <td> For Book Id_{{books[0].book_id}} </td>
                                <td>  {{books.length}} Members {{books.length == '1' ? 'is' : 'are'}} waiting </td>
                                <td class="project-actions">
                                   <router-link :to="{ name: 'RentSortDetail', params: { id: books[0].book_id } }" class="btn btn-primary btn-sm">
                                    <i class="fa fa-info" aria-hidden="true"></i>
                                    Detail
                                    </router-link>
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
                booklists: []
            }
        },
        mounted(){
            this.getBookList();
        },
        methods: {
          isEmpty(obj) {
              for(var prop in obj) {
                  if(obj.hasOwnProperty(prop))
                      return false;
              }
              return true;
          },
          getBookList: function(){
                axios.get('/_bookcafe/admin/check-rent-request').then(response => {
                  console.log(response.data);
                  this.booklists = response.data;
                  console.log(typeof this.booklists);
                })
                .catch(error => {
                    console.log(error)
                })
          },



        }
    }
</script>