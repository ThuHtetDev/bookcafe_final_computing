<template>
    <div class="container">
        <div class="row">
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
                      <th>Book ISBN</th>
                      <th>Book Name</th>
                      <th>Member Name</th>
                      <th>Return Date</th>
                      <th>In Date?</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                        <tr v-for="(book,index) in booklists" :key="index">
                                <td> {{book.book.isbn}}</td>
                                <td>  {{book.book.name}}</td>
                                <td>{{book.user.name}}</td>
                                <td>{{ book.return_date }}</td>
                                <td v-if="book.real_return_date != null">{{ book.real_return_date.replace(/-/g, "") > book.return_date.replace(/-/g, "") ? 'Over Date' : 'In date' }}</td>
                                <td class="project-actions" v-if="book.return_approve == '0'">
                                   <button @click="approveBook(book.id)" class="btn btn-success btn-sm">Approval</button>
                                </td>
                                <td v-else>
                                  Approved
                                </td>
                        </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
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
                booklists: [],
            }
        },
        mounted(){
            this.$Progress.start();
            this.getBookList();
            this.$Progress.finish();
        },
        methods: {
            getBookList: function(){
                axios.get('/_bookcafe/admin/return-list').then(response => {
                    this.booklists = response.data;
                    this.$Progress.finish();
                })
                .catch(error => {
                    console.log(error)
                })
            },
            approveBook: function(returnBookId){
                axios.post('/_bookcafe/admin/return-approval',{
                  id : returnBookId
                }).then(response => {
                  if(response.data.success == true){
                      swal.fire('Approval Done', 'You have approved for this book', 'success');
                      this.$Progress.start();
                      this.getBookList();
                      this.$Progress.finish();
                  }
                })
                .catch(error => {
                    console.log(error)
                })
            }
        }
    }
</script>