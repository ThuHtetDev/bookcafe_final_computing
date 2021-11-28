<template>
    <div>
          <h3 class="card-title" v-if="notFound">
                 <router-link to="/admin/book-list"><i class="fas fa-arrow-left"></i> </router-link>
                 <div style="width: 10px; display: inline-block;"></div>
                 <small>Not Found This Page</small>
          </h3>
        <div v-else>
          <h3 class="card-title">
                 <router-link to="/admin/book-list"><i class="fas fa-arrow-left"></i> </router-link>
                 <div style="width: 10px; display: inline-block;"></div>
                 <small>{{detailBooks.name}}</small>
            </h3>
                <div class="card card-primary card-outline" >
                    <div class="row" v-if="detailBooks.front_cover != null && detailBooks.back_cover != null">
                          <div class="col-lg-3 col-12 text-center" >
                              <div class="inner" @click="showFrontImg()">
                                <img class="img-fluid fit-image" v-bind:src="'/storage/user_'+registeredUser.id+'/book/front_cover/'+detailBooks.front_cover" >
                              </div>
                                <vue-easy-lightbox
                                  :visible="visible"
                                  :imgs="imgs"
                                  :index="index"
                                  @hide="handleHide"
                                ></vue-easy-lightbox>
                          </div>
                           <div class="col-lg-3 col-12 text-center">
                                <div class="inner" @click="showBackImg()">
                                    <img class="img-fluid fit-image" v-bind:src="'/storage/user_'+registeredUser.id+'/book/back_cover/'+detailBooks.back_cover" >
                                </div>
                          </div>
                      </div>
                      <!-- <div class="card-body box-profile" v-if="images.length > 0">
                        <h1>Inner Book Images</h1>
                          <div class="row">
                              <div class="col-lg-3 col-6" v-for="(image,index) in images" :key="index">
                                  <div class="inner">
                                      <img class="img-fluid fit-image" v-bind:src="'/storage/user_'+registeredUser.id+'/book/inner_images/'+image.img_path" >
                                  </div>
                              </div>
                          </div>
                      </div> -->
                        <hr>
                        <h3 class="profile-username text-center">{{detailBooks.name}} 
                           <span :class="!isPublish ? 'right badge badge-warning' : 'right badge badge-success'">{{ !isPublish ? 'Pending' : 'Published'}}</span>
                          </h3> 
                        <p class="text-success text-center" v-if="isPublish">Registerd By {{registeredUser.name}}</p>
                        <p class="text-success text-center" v-if="isPublish">Published By {{publishAdmin}}</p>

                        <ul class="list-group list-group-unbordered mb-3" style="padding: 0px 200px;">
                          <li class="list-group-item">
                            <b>Book ISBN</b> <a class="float-right">{{detailBooks.isbn}}</a>
                          </li>
                          <li class="list-group-item">
                            <b>Book Category</b> <a class="float-right">{{category.name}}</a>
                          </li>
                          <li class="list-group-item">
                            <b>Registered Member</b> <a class="float-right">{{registeredUser.name}}</a>
                          </li>
                          <li class="list-group-item">
                            <b>Description</b> <a class="float-right">{{detailBooks.description}}</a>
                          </li>
                            <li class="list-group-item">
                            <b>This Book is Cancel ?</b> <a class="float-right">{{(detailBooks.is_cancel == '0') ? 'No' : 'Yes, it is cancel'}}</a>
                          </li>
                          <li class="list-group-item">
                            <b>This Book is rejected ?</b> <a class="float-right">{{(detailBooks.is_reject == '0') ? 'No' : 'Yes, it is rejected'}}</a>
                          </li>
                          <li class="list-group-item">
                            <b>Current Status</b> <a class="float-right">{{ !isPublish ? detailBooks.status : 'Published'}}</a>
                          </li>
                          <li class="list-group-item">
                            <b>Book Registerd Date</b> <a class="float-right">{{detailBooks.created_at}}</a>
                          </li>
                          <li class="list-group-item" v-if="isPublish">
                            <b>Book Published Date</b> <a class="float-right" >{{detailBooks.updated_at}}</a>
                          </li>
                        </ul>
                        <button @click="editForm(detailBooks.id)" v-if="!isPublish" class="btn btn-primary btn-block">Publish</button>
                        <button @click="rejectForm(detailBooks.id)" v-if="!isPublish" class="btn btn-danger btn-block">Reject</button>
                      </div>
                      <!-- /.card-body -->
          </div>
        
    </div>
</template>

<script>
import VueEasyLightbox from 'vue-easy-lightbox'
    export default {
        data() {
            return {
                proId : this.$route.params.id,
                detailBooks: [],
                images: [],
                registeredUser: [],
                category : [],
                notFound: false,
                isPublish: false,
                publishAdmin: null,
                  visible: false,
                index: 0,   // default: 0
                imgs: []
            }
        },
        mounted(){
            this.getBookDetail(this.proId);
        },
        methods: {
          showFrontImg (index) {
              this.imgs  = [
                  '/storage/user_'+this.detailBooks.user_id+'/book/front_cover/'+this.detailBooks.front_cover,
              ];
            this.index = index
            this.visible = true
          },
          showBackImg (index) {
              this.imgs  = [
                  '/storage/user_'+this.detailBooks.user_id+'/book/back_cover/'+this.detailBooks.back_cover,
              ];
            this.index = index
            this.visible = true
          },
          handleHide () {
            this.visible = false
          },
            getBookDetail: function(id){
                axios.get('/_bookcafe/detail/'+id).then(response => {
                    if(response.data.message){
                      this.notFound = true;
                    }else{
                      this.notFound = false;
                    }
                    this.detailBooks = response.data.bookDetail;
                    if( this.detailBooks.status == "publish"){
                      this.isPublish = true;
                      this.publishAdmin = response.data.publishAdmin.name
                    }
                    this.images = response.data.bookImages;
                    this.registeredUser = response.data.bookUser;
                    this.category = response.data.bookCategory;
                })
                .catch(error => {
                    console.log(error)
                })
            },
        }
    }
</script>
