<template>
<div class="card card-primary">
              <div class="card-header"> 
               <a href="javascript:history.go(-1)"> <i class="fas fa-arrow-left"></i> </a>
                <h3 class="card-title">Edit My Book</h3>
              </div>
            <div class="card card-primary">
              <form role="form" @submit="formSubmit" enctype="multipart/form-data">
                <div class="card-body">
                     <div class="form-group" style="margin-bottom: 100px;">
                      <div class="input-group">
                         <div id="preview" >
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" id="e" @change="onPreviewFrontSelected">
                                <label class="custom-file-label" for="aaa" >Front Cover Upload</label>
                              </div>
                            <!-- <img v-if="image" :src="image" id="lol" /> -->
                            <img :src="front_url == '' ? '/storage/user_'+editBook.user_id+'/book/front_cover/'+editBook.front_cover : front_url" id="frontCover">
                          </div>
                          <!-- <div class="img_container col-4 col-sm-12 col-md-4">
                              <div class="c">
                                  <img class="c-image" style="margin: 0 auto;" v-bind:src="'/storage/user_'+editBook.user_id+'/book/front_cover/'+editBook.front_cover">
                              </div> -->
                              <!-- <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="terms" class="custom-control-input" id="a" :checked="checkFront" @click="checkEdit('front')">
                                <label class="custom-control-label" for="a">I want to edit this image</label>
                              </div> -->
                          <!-- </div> -->
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:100px;">
                      <div class="input-group">
                          <div id="preview">
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" id="backCoverFile" @change="onPreviewBackSelected" >
                                <label class="custom-file-label" for="backCoverFile" >Back Cover Upload</label>
                              </div>
                                <!-- <img :src="back_url" id="backCover"> -->
                                <img :src="back_url == '' ? '/storage/user_'+editBook.user_id+'/book/back_cover/'+editBook.back_cover : back_url" id="backCover">
                          </div>
                          <!-- <div id="preview" :style="!checkBack ? 'opacity: 0.5' : ''">
                              <div class="custom-file">
                                <input type="file" :disabled="!checkBack" class="custom-file-input" id="backCoverFile" @change="onPreviewBackSelected" required>
                                <label class="custom-file-label" for="backCoverFile" >{{!checkBack ? 'Please confirm that you will edit back-cover' : 'Upload New BackCover'}}</label>
                              </div>
                                <img :src="back_url" id="backCover">
                          </div> -->
                           <!-- <div class="img_container">
                              <div class="c">
                                   <img class="c-image" style="margin: 0 auto;" v-bind:src="'/storage/user_'+editBook.user_id+'/book/back_cover/'+editBook.back_cover">
                              </div>
                              <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="terms" class="custom-control-input" id="b" :checked="checkBack" @click="checkEdit('back')">
                                <label class="custom-control-label" for="b">I want to edit this image</label>
                              </div>
                          </div> -->
                      </div>
                  </div>
                  <div class="form-group">
                    <label for="name">Book Name</label>
                    <input type="text" v-model="name" class="form-control" id="name" placeholder="Enter Book Name" required >
                  </div>
                    <div class="form-group ">
                        <label for="type">Which Category You Want To Store?</label>
                        <select name="category" id="" class="form-control" v-model="selectedCat" required>
                            <option v-for="(category,index) in categories" :key="index" :selected="category.name == selectedCat ? true : false" >{{category.name}}</option>
                        </select>
                    </div>
                  <div class="form-group">
                    <label for="desc">Tell us For Your Opinion About This Book</label>
                    <textarea v-model="desc" id="desc" class="form-control" required></textarea>
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Edit</button>
                </div>
              </form>
            </div>
            </div>
</template>

<script>
    export default {
        data () {
            return {
                proId : this.$route.params.id,
                name: '',
                selectedCat: '',
                desc: '',
                editBook: [],
                categories: [],
                checkFront: false,
                checkBack: false,

                frontImgEdit: false,
                backImgEdit: false,
                front_url: '',
                front_file: null,
                back_url: '',
                back_file: null,
                selectedFiles : [],
                categories : [],
                front_img: '',
                back_img: '',
                test: null,
            }
        },
            mounted(){
          this.front_img = $("#frontCover").cropme({
              container: {
                width: 600,
                height: 500
              },
              viewport: {
                width: 210,
                height: 320,
                border: {
                  enable: true,
                  width: 5,
                  color: '#007bff'
                }
              }
            });
          this.back_img = $("#backCover").cropme({
              container: {
                width: 600,
                height: 500
              },
              viewport: {
                width: 210,
                height: 320,
                border: {
                  enable: true,
                  width: 5,
                  color: '#007bff'
                }
              }
            });
        },
        created(){
          this.editData(this.proId);
        },
        methods: {
          checkEdit(type){
            if(type == 'front'){
              if(this.checkFront == false){
                this.checkFront = true;
              }else{
                this.checkFront = false;
              }
            }else{
              if(this.checkBack == false){
                this.checkBack = true;
              }else{
                this.checkBack = false;
              }
            }
          },
           handle(e){
              var f = e.target.files[0];
              let reader = new FileReader();
              let that = this;
              reader.onload = function (e) {
                that.image = e.target.result;
              }
              reader.readAsDataURL(f);
          },
            onFileSelected(e){
                let getFiles = e.target.files;
                if(!getFiles.length){
                    return false;
                }
                for(let i=0; i< getFiles.length; i++){
                    this.selectedFiles.push(getFiles[i]);
                }
            },
            onPreviewFrontSelected(e){
              this.front_file = e.target.files[0];
              this.front_url = URL.createObjectURL(this.front_file);
            },
            onPreviewBackSelected(e){
              this.back_file = e.target.files[0];
              this.back_url = URL.createObjectURL( this.back_file);
            },
            getSubmitForm: function(imageData){
                const data = new FormData();
                const json_data = JSON.stringify({
                    name: this.name,
                    category: this.selectedCat,
                    desc: this.desc,
                    id: this.proId
                });
                data.append('data',json_data);
                for(var key in imageData){
                  data.append(key, imageData[key]);
                }
                 swal.fire({
                    title: 'Are you sure?',
                    text: 'If you want to check edited image again, press No',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Edit',
                    cancelButtonText: 'No, I want to check again',
                    showCloseButton: true,
                    showLoaderOnConfirm: true
                    }).then((result) => {
                    if(result.value) {
                      this.$Progress.start();
                          axios.post('/_bookcafe/request/book/edit',data)
                          .then(response => {
                          swal.fire({
                                  position: 'top-end',
                                  icon: 'success',
                                  title: response.data.message,
                                  showConfirmButton: false,
                                  timer: 3000
                          });
                          this.name = '';
                          this.category = '';
                          this.desc = '';
                          this.$router.push('/my-book-list');
                          this.$Progress.finish();
                          })
                          .catch(error => {
                              console.log(error)
                          })
                    }
                })
            
            },
          editData: function(editId){
              this.$Progress.start();
              axios.post('/_bookcafe/member/book/edit',{
                id : editId
              }).then(response => {
                this.editBook = response.data.editBook;
                this.name = this.editBook.name;
                this.desc = this.editBook.description;
                this.selectedCat = this.editBook.category.name;
                this.categories = response.data.categories;
                this.$Progress.finish();
              })
              .catch(error => {
                  console.log(error)
              })
          },
              resizeImage: function(base64Str, maxWidth = 100, maxHeight = 100, callBack){
              let img = new Image()
              img.src = base64Str
              img.onload = () => {
                let canvas = document.createElement('canvas')
                const MAX_WIDTH = maxWidth
                const MAX_HEIGHT = maxHeight
                let width = img.width
                let height = img.height

                if (width > height) {
                  if (width > MAX_WIDTH) {
                    height *= MAX_WIDTH / width
                    width = MAX_WIDTH
                  }
                } else {
                  if (height > MAX_HEIGHT) {
                    width *= MAX_HEIGHT / height
                    height = MAX_HEIGHT
                  }
                }
                canvas.width = width
                canvas.height = height
                let ctx = canvas.getContext('2d')
                ctx.drawImage(img, 0, 0, width, height)
                callBack(canvas.toDataURL());
              }
            },
           formSubmit: function(e){
                e.preventDefault();
                var that = this;
                    that.front_img.cropme('crop').then( function(frontImg) {
                        that.back_img.cropme('crop').then( function(backImg) {
                         that.resizeImage(frontImg, 100, 100, function(frontImg02){
                          that.resizeImage(backImg, 100, 100, function(backImg02){
                            // getSubmitFormForEdit
                            that.getSubmitForm({
                              front_file : frontImg,
                              back_file : backImg,
                              front_small : frontImg02,
                              back_small : backImg02
                            });
                            // end
                          });
                         });
                         return ;
                        });
                    });
                return ;
            },
        
        }
  }
</script>
<style scoped>
#preview {
 background: grey;
 width: 600px;
 height: 600px;
 margin: 0 auto;
}

.img_container img {
  background-color: rgba(16,46,72,0.6); 
    background-blend-mode: multiply;
}

.img_container{
  padding: 1rem;
  margin: 0 auto;
}

.c {
  position: relative;
  width: 90%;
  max-width: 400px;
  margin: auto;
  overflow: hidden;
}

.c .c-overlay {
  background: rgba(00,45,114,0.8);
  position: absolute;
  width: 100%;
  left: 0;
  top: 0;
  bottom: 0;
  right: 0;
  opacity: 0;
  -webkit-transition: all 0.4s ease-in-out 0s;
  -moz-transition: all 0.4s ease-in-out 0s;
  transition: all 0.4s ease-in-out 0s;
}

.c:hover .c-overlay{
  opacity: 1;
  cursor: pointer;
}

.c-image{
  width: 100%;
}

.c-details {
  position: absolute;
  text-align: center;
  width: 100%;
  top: 50%;
}

.c-details .c-title{
  color: #fff;
  font-weight: 500;
  letter-spacing: 0.15em;
  margin-bottom: 0.5em;
  text-transform: uppercase;
}
.c:hover .c-title {
  -webkit-transform: translate3d(-1rem, 0, 0);
          transform: translate3d(-1rem, 0, 0);
}

.c .c-title {
  display: inline-block;
  position: relative;
  transition: all 300ms ease-out;
  will-change: transform;
}



</style>