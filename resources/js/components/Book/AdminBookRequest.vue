<template>
    <div class="container">
        <div class="row" v-if="books.length > 0">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                    Member Book Request
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
                      <th>ISBN</th>
                      <th>Book-Name</th>
                      <th>Description</th>
                      <th>Category</th>
                      <th>Current Status</th>
                      <th>Registerd At</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(book,index) in books" :key="index">
                      
                            <td>{{ book.isbn }} </td>
                            <td>{{book.name}}</td>
                            <td>{{book.description.substring(0,15)+".." }}</td>
                            <td>{{book.category.name}}</td>
                            <td>
                                <span class="tag tag-warning">Pending</span>
                            </td>
                            <td>{{book.created_at}}</td>
                            <td class="project-actions text-right">
                                    <router-link :to="{ name: 'BookRequestDetail', params: { id: book.id } }" class="btn btn-primary btn-sm">
                                    <i class="fas fa-folder">
                                    </i>
                                    Preview For Publish
                                    </router-link>
                            </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
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
              books: [],
            }
        },
        mounted(){
               this.$Progress.start();
                axios.get("/_bookcafe/member/request")
                .then((response) => {
                   this.books = response.data;
                    this.$Progress.finish();
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    }
</script>