<template>
<div>
 <section :class="showFilter ? 'content-header bgShow' : 'content-header'" style="position: fixed; width: 50%; top: 0; float:right; z-index: 1;" v-if="showBar" >
     <input type="checkbox" id="checkBox" @click="changeFilterDiv"/>
      <span></span>
      <span></span>
      <span></span>
      <div class="container-fluid" v-if="showFilter">
        <div class="row mb-2">
          <div class="col-sm-6">
              <!-- Actual search box -->
              <div class="form-group has-search">
                <span class="fa fa-search form-control-feedback"></span>
                  <input type="text" class="form-control" placeholder="Search" v-model="query" >
                  <ul v-if="results.length > 0">
                        <li v-for="result in results" :key="result.id">
                            <router-link :to="{ name: 'BookDetail', params: { id: result.id } }" class="nav-link">
                              <p>{{result.name}}</p>
                            </router-link>
                        </li>
                  </ul>
              </div>
          </div>
          <div class="col-sm-6">
            <button class="btn btn-success btn-block btn-sm text-white"  @click="getData('all')">All</button>
            <button class="btn btn-success btn-block btn-sm text-white"  @click="getData('available')">Available</button>
            <button class="btn btn-warning btn-block btn-sm text-white"  @click="getData('no_available')">Rent and Queue</button>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
 <div class="container" style="padding-top: 100px;">
  <main class="grid">
    <div v-for="(book,index) in booklists" :key="index">
      <router-link :to="{ name: 'BookDetail', params: { id: book.id } }">
        <article>
          <div class="box" style="text-align:center">
            <div class="ribbon ribbon-top-right">
                <span v-if="book.checkIfBookIsAvailable" class="right badge badge-success">Available</span>
                <span v-else class="right badge badge-warning">{{book.rentList.length > 0 ? checkBookStatus(book.rentList) : '' }}</span>
            </div>
              <img class="img-fluid fit-image" v-bind:src="'/storage/user_'+book.user_id+'/book/front_cover/'+book.front_cover">
                <div class="text mt-4">
                    <h3 style="height: 50px; font-size: 18px; text-decoration: none; " v-if="book.name.length < 200">
                      {{book.name}}
                    </h3>
                    <h3 style="height: 50px; font-size: 18px; text-decoration: none;" v-else>
                        {{book.name.substring(0,150)+".." }}
                    </h3>
                  <!-- <router-link :to="{ name: 'BookDetail', params: { id: book.id } }" class="btn btn-primary btn-block btn-sm text-white" >
                                <i class="fa fa-info" aria-hidden="true"></i>
                                  <span style="color: white"> Detail </span>
                  </router-link> -->
                </div>
              </div>
          </article>
        </router-link>
    </div>
  </main>
</div>
</div>
</template>

<script>
    export default {
         data () {
            return {
                booklists: [],
                showBar: false,
                query: null,
                results: [],
                sort: 'all',
                rentStatus: '',
                showFilter: false
            }
        },
        mounted(){
            this.getBookList();
            window.addEventListener('scroll', this.handleScroll);
        },
        watch: {
          query(after, before) {
            this.searchBooks();
          }
        },
        methods: {
          searchBooks() {
              axios.post('/_bookcafe/books/search', {  keywords: this.query  })
              .then(response => this.results = response.data)
              .catch(error => {});
          },
          changeFilterDiv: function(){
            if(this.showFilter == false){
               this.showFilter = true;
            }else{
              this.showFilter = false;
            }
          },
          getData: function(type){
            this.sort = type;
            this.getBookList();
            this.showFilter = false;
          },
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
            handleScroll(event) {
              this.showBar = false;
              if(window.scrollY > 100){
                this.showBar = true;
              }
            },
            getBookList: function(){
                this.$Progress.start();
                axios.post('/_bookcafe/member/book-list',{
                  sort: this.sort
                }).then(response => {
                  this.booklists = response.data;
                  this.$Progress.finish();
                })
                .catch(error => {
                    console.log(error)
                })
            },
        }
    }
</script>
<style scoped>
.rented{
  background: #ccc;
  color: #fff;
}
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

.has-search .form-control {
    padding-left: 2.375rem;
}

.has-search .form-control-feedback {
    position: absolute;
    z-index: 2;
    display: block;
    width: 2.375rem;
    height: 2.375rem;
    line-height: 2.375rem;
    text-align: center;
    pointer-events: none;
    color: #aaa;
}
.bgShow{
  background: #4f5962;
}
.content-header #checkBox
{
  display: block;
  width: 40px;
  height: 32px;
  position: absolute;
  top: -7px;
  left: -5px;
  
  cursor: pointer;
  
  opacity: 0; /* hide this */
  z-index: 2; /* and place it over the hamburger */
  
  -webkit-touch-callout: none;
}
.content-header span
{
  display: block;
  width: 33px;
  height: 4px;
  margin-bottom: 5px;
  position: relative;
  
  background: #4f5962;
  border-radius: 3px;
  z-index: 1;
  
  transform-origin: 4px 0px;
  
  transition: transform 0.5s cubic-bezier(0.77,0.2,0.05,1.0),
              background 0.5s cubic-bezier(0.77,0.2,0.05,1.0),
              opacity 0.55s ease;
}

.content-header span:first-child
{
  transform-origin: 0% 0%;
}

.content-header span:nth-last-child(2)
{
  transform-origin: 0% 100%;
}

/* 
 * Transform all the slices of hamburger
 * into a crossmark.
 */
.content-header input:checked ~ span
{
  opacity: 1;
  transform: rotate(45deg) translate(-2px, -1px);
  background: #232323;
}

/*
 * But let's hide the middle one.
 */
.content-header input:checked ~ span:nth-last-child(3)
{
  opacity: 0;
  transform: rotate(0deg) scale(0.2, 0.2);
}

/*
 * Ohyeah and the last one should go the other direction
 */
.content-header input:checked ~ span:nth-last-child(2)
{
  transform: rotate(-45deg) translate(0, -1px);
}

.box {
  position: relative;
}
/* common */
.ribbon {
  width: 150px;
  height: 150px;
  overflow: hidden;
  position: absolute;
}
.ribbon::before,
.ribbon::after {
  position: absolute;
  z-index: -1;
  content: '';
  display: block;
  border: 5px solid #2980b9;
}
.ribbon span {
  position: absolute;
  display: block;
  width: 225px;
  padding: 10px 0;
  box-shadow: 0 5px 10px rgba(0,0,0,.1);
  color: #fff;
  font: 700 18px/1 'Lato', sans-serif;
  text-shadow: 0 1px 1px rgba(0,0,0,.2);
  text-transform: uppercase;
  text-align: center;
}


/* top right*/
.ribbon-top-right {
  top: -10px;
  right: -10px;
}
.ribbon-top-right::before,
.ribbon-top-right::after {
  border-top-color: transparent;
  border-right-color: transparent;
}
.ribbon-top-right::before {
  top: 0;
  left: 0;
}
.ribbon-top-right::after {
  bottom: 0;
  right: 0;
}
.ribbon-top-right span {
  left: -25px;
  top: 30px;
  transform: rotate(45deg);
}
</style>