<template>
<div class="container">
  <main class="grid">
    <div v-for="(book,index) in booklists" :key="index">
    <article>
      <div style="text-align:center">
        <img class="img-fluid fit-image" v-bind:src="'/storage/user_'+book.user_id+'/book/front_cover/'+book.front_cover">
        <div class="text mt-4">
          <h3 style="height: 50px; font-size: 20px;" v-if="book.name.length < 200">
            {{book.name}}
          </h3>
          <h3 style="height: 50px; font-size: 20px;" v-else>
              {{book.name.substring(0,150)+".." }}
          </h3>
          <!-- <span v-if="book.rentList.length > 0" class="right badge badge-warning">
              {{ifExist(book.rentList)}}
          </span>
          <span v-else class="right badge badge-success">Available</span> -->
          <span v-if="book.checkIfBookIsAvailable" class="right badge badge-success">Available</span>
          <span v-else class="right badge badge-warning">{{book.rentList.length > 0 ? checkBookStatus(book.rentList) : '' }}</span>
          <p> {{book.category.name}}</p>
          <p style="height: 40px;"> {{book.description.substring(0,20)+".." }} </p>
          <router-link :to="{ name: 'AdminBookDetail', params: { id: book.id } }" class="btn btn-primary btn-block btn-sm text-white" >
                        <i class="fa fa-info" aria-hidden="true"></i>
                          <span style="color: white"> Detail </span>
          </router-link>
        </div>
      </div>
    </article>
    </div>
  </main>
    <!-- <div class="text-center mt-5 mb-5">
          <button class="btn btn-primary btn-sm text-white text-center" @click="getLoad" v-if="rTime != allCount" >Load More</button>
    </div> -->
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
            this.getBookList();
        },
        methods: {
          checkBookStatus: function(items){
               var length = items.length;
                for(var i = 0; i < length; i++){
                  if(items[i].return_approve == '0'){
                      if(items[i].rent_status == 'confirm'){
                        return 'In Rent';
                      }else if(items[i].rent_status == 'queue'){
                        return 'In Queue';
                      }else{
                        return 'Not Available';
                      }
                  }
                }
          },
            getBookList: function(){
                axios.get('/_bookcafe/admin/book-list/').then(response => {
                  this.booklists = response.data;
                })
                .catch(error => {
                    console.log(error)
                })
            },
            // getLoad: function(){
            //    this.rTime += 3;
            //    axios.get('/_bookcafe/admin/book-list/'+ this.rTime).then(response => {
            //       this.booklists = response.data;
            //     })
            //     .catch(error => {
            //         console.log(error)
            //     })
            // },
            // getAllLoad: function(){
            //     axios.get('/_bookcafe/admin/book-list/1').then(response => {
            //       this.allCount = response.data.length;
            //     })
            //     .catch(error => {
            //         console.log(error)
            //     })
            // }
        }
    }
</script>

<style scoped>
.fit-image{
  text-align: center;
  width: 300px;
  height: 300px;
}
.grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  grid-gap: 20px;
  align-items: stretch;
}

.grid > article {
  border: 1px solid #ccc;
  box-shadow: 2px 2px 6px 0px rgba(0, 0, 0, 0.3);
}

.grid > article img {
  max-width: 100%;
}

.grid .text {
  padding: 20px;
}

</style>