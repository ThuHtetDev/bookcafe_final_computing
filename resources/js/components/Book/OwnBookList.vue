<template>
    <div class="container">
        <div class="row" v-if="books.length > 0">
          <div class="container">
              <div class="card-group vgr-cards">
                <div class="card" v-for="book in books" :key="book.id">
                  <div class="card-img-body">
                  <img class="card-img" v-bind:src="'/storage/user_'+book.user_id+'/book/front_cover/'+book.front_cover" alt="Card image cap">
                  </div>
                  <div class="card-body">
                    <router-link :to="{ name: 'BookDetail', params: { id: book.id } }" class="">
                       <h4 class="card-title">{{book.name}}</h4>
                    </router-link>
                    <p class="card-text">
                      {{book.description.substring(0,18)+".." }}
                    </p>
                    <p>
                       <span :class="book.status == 'pending' ? 'right badge badge-warning' : 'right badge badge-success'">
                         {{book.status == 'pending' ? 'Pending' : 'Published'}}
                       </span>
                    </p>
                    <p>
                      Registered Date -{{book.created_at}}
                    </p>
                     <p v-if="book.status == 'pending' && book.is_cancel == '1'">
                       <span class="right badge badge-danger">
                         Pending Cancel By You
                       </span>
                    </p>
                    <p v-if="book.is_reject == '1'">
                       <span class="right badge badge-danger">
                         Rejected By Admin
                       </span>
                    </p>
                    <p v-if="book.status == 'pending' && book.is_cancel == '0' && book.is_reject == '0'">
                        <router-link :to="{ name: 'BookEdit', params: { id: book.id } }" class="btn btn-primary btn-sm text-white" >
                          <span style="color: white"> Edit </span>
                        </router-link>
                        <button class="btn btn-danger btn-sm" @click="cancelBook(index,book.id)"> 
                            Pending Cancel
                        </button>
                    </p>
                     <p v-if="book.status == 'publish' && book.is_cancel == '0'">
                        <button class="btn btn-danger btn-sm" @click="removedBook(index,book.id)"> 
                            Take Back My Book
                        </button>
                    </p>
                  </div>
                </div>
              </div>
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
            books: {},
            bookData : []
            }
        },
        mounted(){
              this.$Progress.start();
              this.getResults();
        },
        methods :{
          getResults(){
              axios.get("/_bookcafe/my-book-list")
                .then((response) => {
                    this.books = response.data;
                    this.bookData  = response.data.data;
                    this.$Progress.finish();
              })
                .catch((error) => {
                    console.log(error);
              });
          },
          axiosPost: function(index,bookId){
                axios.post('/_bookcafe/member/pending-list/cancel',{
                        id : bookId
                    })
                    .then(response => {
                        swal.fire('Cancelled', 'You successfully cancel this book', 'success');
                        this.getResults();
                    })
                    .catch(error => {
                        console.log(error)
                })
            },
            removePost: function(index,bookId){
                axios.post('/_bookcafe/member/published-book/remove',{
                        id : bookId
                    })
                    .then(response => {
                      if(response.data.success == true){
                        swal.fire('Removed', 'Thank You For Previous Moment', 'success');
                        this.bookData.splice(index,1);
                      }
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
                    }
                })
            },
            removedBook: function(index,bookId){
                swal.fire({
                    title: 'Are you sure?',
                    text: 'This Book will be Forever Removed',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    showCloseButton: true,
                    showLoaderOnConfirm: true
                    }).then((result) => {
                    if(result.value) {
                       this.removePost(index,bookId);
                    } 
                })
            },
        }
    }
</script>
<style scoped>
.rejected{
  background: red;
  color: #fff;
}
.card {
  border: none;
  height: 200px;
}
.card-img {
  border-radius: 0;
  height: 200px;
}
.vgr-cards .card {
  display: flex;
  flex-flow: wrap;
  flex: 100%;
  margin-bottom: 40px;
}
.vgr-cards .card:nth-child(even) .card-img-body {
  order: 2;
}
.vgr-cards .card:nth-child(even) .card-body {
  padding-left: 0;
  padding-right: 1.25rem;
}
@media (max-width: 576px) {
  .vgr-cards .card {
    display: block;
  }
}
.vgr-cards .card-img-body {
  flex: 1;
  overflow: hidden;
  position: relative;
}
@media (max-width: 576px) {
  .vgr-cards .card-img-body {
    width: 100%;
    height: 200px;
    margin-bottom: 20px;
  }
}
.vgr-cards .card-img {
  width: 100%;
  height: auto;
  position: absolute;
  margin-left: 50%;
  transform: translateX(-50%);
}
@media (max-width: 1140px) {
  .vgr-cards .card-img {
    margin: 0;
    transform: none;
    width: 100%;
    height: auto;
  }
}
.vgr-cards .card-body {
  flex: 2;
  padding: 0 0 0 1.25rem;
}
@media (max-width: 576px) {
  .vgr-cards .card-body {
    padding: 0;
  }
}

</style>